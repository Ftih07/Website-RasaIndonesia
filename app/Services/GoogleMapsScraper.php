<?php

namespace App\Services;

use App\Models\ReviewScrapper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Str;

class GoogleMapsScraper
{
    public function scrapeFromUrl(string $mapsUrl): ?ReviewScrapper
    {
        try {
            $tempFile = storage_path('app/temp/scraper_' . Str::random(10) . '.js');

            if (!is_dir(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }

            // Create temporary Node.js script
            file_put_contents($tempFile, $this->getScraperScript($mapsUrl));

            // Execute the Node.js script
            $result = Process::run('node ' . $tempFile);

            if ($result->failed()) {
                Log::error('Scraper script failed: ' . $result->errorOutput());
                unlink($tempFile);
                return null;
            }

            // Parse scraped data
            $scrapedData = json_decode($result->output(), true);

            // Log scraped data for debugging
            Log::info('Scraped data: ', ['data' => $scrapedData]);

            // Clean up temp file
            unlink($tempFile);

            if (!$scrapedData || empty($scrapedData['name'])) {
                Log::error('No valid data scraped or missing name field');
                return null;
            }

            // Create record with fallback for name field
            return ReviewScrapper::create([
                'name' => $scrapedData['name'] ?? 'Unnamed Business',
                'address' => $scrapedData['address'] ?? null,
                'phone' => $scrapedData['phone'] ?? null,
                'website' => $scrapedData['website'] ?? null,
                'rating' => $scrapedData['rating'] ?? null,
                'reviews' => $scrapedData['reviews'] ?? null,
                'maps_url' => $mapsUrl,
                'additional_data' => json_encode($scrapedData['additionalData'] ?? []),
            ]);
        } catch (\Exception $e) {
            Log::error('Google Maps scraping error: ' . $e->getMessage());
            return null;
        }
    }

    private function getScraperScript(string $url): string
    {
        return <<<JS
const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch({
    headless: 'false',
    args: ['--no-sandbox', '--disable-setuid-sandbox', '--disable-dev-shm-usage'],
  });
  
  try {
    const page = await browser.newPage();
    
    // Set user agent to appear more like a regular browser
    await page.setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36');
    
    // Set viewport to realistic size
    await page.setViewport({ width: 1366, height: 768 });
    
    console.log("Opening URL...");
    await page.goto('$url', { waitUntil: 'networkidle2', timeout: 60000 });
    console.log("Page loaded");
    
    // Add random delay to simulate human behavior
    await page.waitForTimeout(3000 + Math.floor(Math.random() * 2000));
    
    // Take screenshot for debugging
    await page.screenshot({ path: '/tmp/gmaps-debug.png' });
    
    console.log("Waiting for content...");
    // Wait for main content to load
    await page.waitForSelector('h1, .fontHeadlineSmall', { timeout: 15000 });
    console.log("Content loaded");
    
    // Extract business data with more flexible selectors
    const businessData = await page.evaluate(() => {
      const getTextContent = (selector) => {
        const element = document.querySelector(selector);
        return element ? element.textContent.trim() : null;
      };
      
      // More robust name selection
      const name = getTextContent('h1') || 
                  getTextContent('.fontHeadlineLarge') || 
                  getTextContent('[role="main"] .fontHeadlineSmall') ||
                  "Unknown Business";
      
      // Address can be in different places
      const addressSelectors = [
        'button[data-item-id="address"]',
        '[data-tooltip="Copy address"]',
        '.rogA2c',
        'button[aria-label*="address"]'
      ];
      
      let address = null;
      for (const selector of addressSelectors) {
        const elements = document.querySelectorAll(selector);
        if (elements.length > 0) {
          for (const el of elements) {
            const text = el.textContent.trim();
            if (text && text.length > 5) {
              address = text;
              break;
            }
          }
        }
        if (address) break;
      }
      
      // Phone with more robust selection
      const phoneSelectors = [
        'button[data-item-id^="phone:"]',
        '[data-tooltip="Copy phone number"]',
        'button[aria-label*="phone"]',
        '.rogA2c'
      ];
      
      let phone = null;
      for (const selector of phoneSelectors) {
        const elements = document.querySelectorAll(selector);
        if (elements.length > 0) {
          for (const el of elements) {
            const text = el.textContent.trim();
            if (text && /^[+\d\s\-()]{5,}$/.test(text)) {
              phone = text;
              break;
            }
          }
        }
        if (phone) break;
      }
      
      // Website with more robust selection
      const websiteSelectors = [
        'a[data-item-id="authority"]',
        'a[aria-label*="website"]',
        'a[data-tooltip="Open website"]'
      ];
      
      let website = null;
      for (const selector of websiteSelectors) {
        const element = document.querySelector(selector);
        if (element && element.href) {
          website = element.href;
          break;
        }
      }
      
      // Rating with more flexible selection
      const ratingSelectors = [
        'div[role="img"][aria-label*="stars"]',
        'span[aria-label*="stars"]',
        '.fontBodyMedium span.fontDisplayLarge'
      ];
      
      let rating = null;
      for (const selector of ratingSelectors) {
        const element = document.querySelector(selector);
        if (element) {
          const ariaLabel = element.getAttribute('aria-label');
          const text = ariaLabel || element.textContent;
          if (text) {
            const match = text.match(/(\d+(\.\d+)?)/);
            if (match) {
              rating = match[0];
              break;
            }
          }
        }
      }
      
      // Reviews count
      const reviewsSelectors = [
        'button[jsaction*="pane.rating.moreReviews"]',
        '.fontBodyMedium a[href*="reviews"]',
        'span.fontBodyMedium a[href*="reviews"]'
      ];
      
      let reviews = null;
      for (const selector of reviewsSelectors) {
        const element = document.querySelector(selector);
        if (element) {
          reviews = element.textContent.trim();
          break;
        }
      }
      
      // Additional data
      const additionalData = {};
      
      // Business hours - try multiple selectors
      const hoursSelectors = [
        'div[aria-label^="Hours"] tr',
        'div[aria-label^="Opening hours"] tr',
        'table.eK4R0e tr',
        'table.WgFkxc tr'
      ];
      
      let hoursFound = false;
      for (const selector of hoursSelectors) {
        const hourRows = document.querySelectorAll(selector);
        if (hourRows.length > 0) {
          additionalData.hours = Array.from(hourRows)
            .map(row => row.textContent.trim())
            .filter(text => text);
          hoursFound = true;
          break;
        }
      }
      
      // Categories
      const categorySelectors = [
        'button[jsaction*="pane.rating.category"]',
        'button[jsaction*="categoryContainer"]',
        'span.fontBodyMedium a[jsaction*="category"]'
      ];
      
      let categoriesFound = false;
      for (const selector of categorySelectors) {
        const elements = document.querySelectorAll(selector);
        if (elements.length > 0) {
          additionalData.categories = Array.from(elements)
            .map(el => el.textContent.trim())
            .filter(text => text);
          categoriesFound = true;
          break;
        }
      }
      
      console.log("Extracted data:", { name, address, phone, website, rating, reviews });
      
      return {
        name,
        address,
        phone,
        website,
        rating,
        reviews,
        additionalData
      };
    });
    
    console.log(JSON.stringify(businessData));
  } catch (error) {
    console.error("Scraping error:", error.message);
    process.exit(1);
  } finally {
    await browser.close();
  }
})();
JS;
    }
}

