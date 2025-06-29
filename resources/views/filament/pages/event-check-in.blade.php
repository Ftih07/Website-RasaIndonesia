<x-filament::page>
    {{-- This is a Filament Blade component that provides the basic layout and styling for a Filament page. --}}
    <div>
        <div class="max-w-4xl mx-auto">
            <!-- Header Section: Provides a title and description for the check-in page. -->
            <div class="mb-8 text-center">
                {{-- Icon for the header, styled with Tailwind CSS for a circular background. --}}
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                    {{-- SVG icon representing a QR code or scanner. --}}
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                </div>
                {{-- Page title. --}}
                <h1 class="text-3xl font-bold text-gray-900 mb-2">QR Code Check-In</h1>
                {{-- Page description. --}}
                <p class="text-gray-600">Scan participant QR codes for event check-in</p>
            </div>

            {{-- Main content area, structured in a two-column grid for larger screens. --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Scanner Section: Contains the camera feed and controls for QR scanning. -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-semibold text-gray-900">Camera Scanner</h2>
                        {{-- Scanner status indicator (e.g., Initializing, Active, Stopped). --}}
                        <div class="flex items-center space-x-2">
                            <div id="scanner-status" class="flex items-center">
                                <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                                <span class="text-sm text-gray-500">Initializing...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Scanner Container: Where the camera feed will be displayed. -->
                    <div class="relative">
                        {{-- This div is where the html5-qrcode library will render the camera stream. --}}
                        <div id="reader" class="border-2 border-dashed border-gray-300 rounded-lg overflow-hidden bg-gray-50"></div>

                        <!-- Scanner Controls: Buttons to start/stop the scanner and select camera. -->
                        <div class="mt-4 flex flex-wrap gap-2">
                            {{-- Button to start the QR code scanner. --}}
                            <button id="start-scanner" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h1m4 0h1m-6-8h8a2 2 0 012 2v8a2 2 0 01-2 2H8a2 2 0 01-2-2v-8a2 2 0 012-2z"></path>
                                </svg>
                                Start Scanner
                            </button>

                            {{-- Button to stop the QR code scanner (initially disabled). --}}
                            <button id="stop-scanner" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h6v4H9z"></path>
                                </svg>
                                Stop Scanner
                            </button>

                            {{-- Dropdown to select available cameras. --}}
                            <select id="camera-select" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Camera</option>
                            </select>
                        </div>
                    </div>

                    <!-- Manual QR Input: Allows staff to type in a QR code if scanning is not possible. -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Manual QR Code Entry</h3>
                        <div class="flex space-x-2">
                            {{-- Input field for manual QR code entry. --}}
                            <input
                                type="text"
                                id="manual-qr-input"
                                placeholder="Enter QR code manually..."
                                class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            {{-- Button to trigger manual check-in. --}}
                            <button
                                id="manual-check-btn"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Check In
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Results Section: Displays the outcome of the last check-in attempt. -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Check-In Results</h2>

                    <!-- Result Display: Shows details of the scanned participant or an error message. -->
                    <div id="result-container" class="space-y-4">
                        {{-- Initial placeholder message before any scan. --}}
                        <div class="text-center py-8 text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <p>Scan a QR code to see participant details</p>
                        </div>
                    </div>

                    <!-- Statistics: Shows counts of successful and failed check-ins for the session. -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Session Statistics</h3>
                        <div class="grid grid-cols-2 gap-4">
                            {{-- Displays the count of successful check-ins. --}}
                            <div class="bg-green-50 p-3 rounded-md">
                                <div class="text-2xl font-bold text-green-600" id="success-count">0</div>
                                <div class="text-sm text-green-800">Successful Check-ins</div>
                            </div>
                            {{-- Displays the count of failed check-in attempts. --}}
                            <div class="bg-red-50 p-3 rounded-md">
                                <div class="text-2xl font-bold text-red-600" id="error-count">0</div>
                                <div class="text-sm text-red-800">Failed Attempts</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Check-ins Section: Displays a list of the most recent check-in activities. -->
            <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Check-ins</h2>
                <div id="recent-checkins" class="space-y-3">
                    {{-- Placeholder message when no recent check-ins exist. --}}
                    <p class="text-gray-500 text-center py-4">No check-ins yet</p>
                </div>
            </div>
        </div>

        <!-- Loading Overlay: A full-screen overlay to indicate processing. -->
        <div id="loading-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
                {{-- Spinning loader icon. --}}
                <svg class="animate-spin w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Processing check-in...</span>
            </div>
        </div>
    </div>
</x-filament::page>

{{-- Pushes JavaScript code to the 'scripts' stack, which is typically rendered at the end of the HTML body. --}}
@push('scripts')
<!-- Scripts -->
{{-- External library for QR code scanning using HTML5. --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
{{-- External library for making HTTP requests (e.g., to your Laravel API). --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    // Defines a JavaScript class to manage all QR code check-in logic.
    class QRCheckInManager {
        constructor() {
            // Properties to hold scanner instance, scanning state, and statistics.
            this.scanner = null;
            this.isScanning = false;
            this.isProcessing = false; // Flag to prevent rapid duplicate processing
            this.successCount = 0;
            this.errorCount = 0;
            this.recentCheckins = []; // Array to store recent check-in results
            this.maxRecentCheckins = 10; // Maximum number of recent check-ins to display

            // Initialize DOM elements, event listeners, load cameras, and start scanner on load.
            this.initializeElements();
            this.bindEvents();
            this.loadCameras();
            this.startScanner(); // Automatically try to start scanner on page load
        }

        // Caches references to important DOM elements for easier access.
        initializeElements() {
            this.elements = {
                reader: document.getElementById('reader'), // Div where scanner video will appear
                result: document.getElementById('result-container'), // Div to display last check-in result
                startBtn: document.getElementById('start-scanner'), // Button to start scanner
                stopBtn: document.getElementById('stop-scanner'), // Button to stop scanner
                cameraSelect: document.getElementById('camera-select'), // Dropdown for camera selection
                manualInput: document.getElementById('manual-qr-input'), // Input for manual QR code entry
                manualBtn: document.getElementById('manual-check-btn'), // Button for manual check-in
                scannerStatus: document.getElementById('scanner-status'), // Element to show scanner status
                successCount: document.getElementById('success-count'), // Element to display successful check-in count
                errorCount: document.getElementById('error-count'), // Element to display failed check-in count
                recentCheckins: document.getElementById('recent-checkins'), // Div to display recent check-ins list
                loadingOverlay: document.getElementById('loading-overlay') // Loading overlay element
            };
        }

        // Binds event listeners to interactive elements.
        bindEvents() {
            // Event listeners for scanner control buttons.
            this.elements.startBtn.addEventListener('click', () => this.startScanner());
            this.elements.stopBtn.addEventListener('click', () => this.stopScanner());
            // Event listeners for manual check-in button and input field.
            this.elements.manualBtn.addEventListener('click', () => this.handleManualCheckin());
            this.elements.manualInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') this.handleManualCheckin(); // Trigger check-in on Enter key
            });

            // Auto-trigger manual check-in if input length exceeds a threshold (e.g., for barcode scanners).
            this.elements.manualInput.addEventListener('input', () => {
                if (this.elements.manualInput.value.length > 10) { // Assuming QR codes are typically longer than 10 chars
                    this.handleManualCheckin();
                }
            });

            // Event listener for camera selection change
            this.elements.cameraSelect.addEventListener('change', () => {
                if (this.isScanning) {
                    this.stopScanner();
                    this.startScanner();
                }
            });
        }

        // Asynchronously loads available cameras and populates the camera selection dropdown.
        async loadCameras() {
            try {
                const devices = await Html5Qrcode.getCameras(); // Get list of video input devices
                this.elements.cameraSelect.innerHTML = '<option value="">Select Camera</option>'; // Clear existing options

                // Add each camera as an option in the dropdown.
                devices.forEach((device, index) => {
                    const option = document.createElement('option');
                    option.value = device.id; // Device ID is used to select the camera
                    option.textContent = device.label || `Camera ${index + 1}`; // Display camera label or a generic name
                    this.elements.cameraSelect.appendChild(option);
                });

                // Automatically select the first available camera if any exist.
                if (devices.length > 0) {
                    this.elements.cameraSelect.value = devices[0].id;
                }
            } catch (error) {
                console.error('Error loading cameras:', error);
                this.updateScannerStatus('error', 'No cameras available or permission denied'); // Update status on error
            }
        }

        // Starts the QR code scanner using the selected camera.
        async startScanner() {
            if (this.isScanning) return; // Prevent starting if already scanning

            try {
                // Get the selected camera ID. If none selected, html5-qrcode will try to pick one.
                const cameraId = this.elements.cameraSelect.value || undefined;

                // Initialize Html5QrcodeScanner with the target div and configuration options.
                this.scanner = new Html5QrcodeScanner("reader", {
                    fps: 10, // Frames per second for scanning
                    qrbox: { // Size of the scanning box
                        width: 250,
                        height: 250
                    },
                    aspectRatio: 1.0, // Maintain aspect ratio of the video feed
                    showTorchButtonIfSupported: true, // Show torch button if device supports it
                    showZoomSliderIfSupported: true, // Show zoom slider if device supports it
                    defaultZoomValueIfSupported: 2, // Default zoom level
                }, /* verbose= */ false); // Set to true for more console logs from the library

                // Render the scanner. `render` takes success and error callbacks.
                await this.scanner.render(
                    (decodedText) => this.onScanSuccess(decodedText), // Callback for successful scan
                    (error) => this.onScanError(error) // Callback for scan errors (e.g., no QR code found)
                );

                this.isScanning = true; // Update scanning state
                this.updateScannerStatus('active', 'Scanner active'); // Update UI status
                this.elements.startBtn.disabled = true; // Disable start button
                this.elements.stopBtn.disabled = false; // Enable stop button

            } catch (error) {
                console.error('Error starting scanner:', error);
                this.updateScannerStatus('error', 'Failed to start scanner');
                this.elements.startBtn.disabled = false; // Re-enable start button on failure
                this.elements.stopBtn.disabled = true; // Keep stop button disabled
            }
        }

        // Stops the currently running QR code scanner.
        stopScanner() {
            if (!this.isScanning || !this.scanner) return; // Only stop if scanner is active

            try {
                this.scanner.clear(); // Clears the scanner and stops the camera feed
                this.scanner = null; // Reset scanner instance
                this.isScanning = false; // Update scanning state

                this.updateScannerStatus('inactive', 'Scanner stopped'); // Update UI status
                this.elements.startBtn.disabled = false; // Enable start button
                this.elements.stopBtn.disabled = true; // Disable stop button
            } catch (error) {
                console.error('Error stopping scanner:', error);
                // Even if clear fails, try to update UI state
                this.updateScannerStatus('error', 'Error stopping scanner');
            }
        }

        // Updates the visual status indicator and text for the scanner.
        updateScannerStatus(status, message) {
            const statusElement = this.elements.scannerStatus;
            const indicator = statusElement.querySelector('div'); // The circular indicator
            const text = statusElement.querySelector('span'); // The status text

            // Apply appropriate Tailwind CSS classes based on status.
            indicator.className = 'w-2 h-2 rounded-full mr-2 ' + {
                'active': 'bg-green-400 animate-pulse', // Green pulsating for active
                'inactive': 'bg-gray-400', // Gray for stopped
                'error': 'bg-red-400' // Red for error
            } [status];

            text.textContent = message; // Update status text
        }

        // Callback function executed when a QR code is successfully scanned.
        async onScanSuccess(decodedText) {
            if (this.isProcessing) return; // Prevent re-processing if already busy

            // Set a flag and a timeout to prevent rapid, duplicate scans.
            this.isProcessing = true;
            setTimeout(() => {
                this.isProcessing = false;
            }, 2000); // Wait 2 seconds before allowing another scan

            await this.processCheckin(decodedText); // Process the scanned QR code

            // Clear manual input if the scanned text matches what was typed.
            if (this.elements.manualInput.value === decodedText) {
                this.elements.manualInput.value = '';
            }
        }

        // Callback function for scan errors (e.g., no QR code detected in frame).
        onScanError(error) {
            // Only log significant errors to the console, ignoring common "no QR code found" messages.
            if (!error.includes('No MultiFormat Readers') && !error.includes('QR code not found')) {
                console.warn('Scan error:', error);
            }
        }

        // Handles check-in initiated by manual QR code input.
        async handleManualCheckin() {
            const qrCode = this.elements.manualInput.value.trim(); // Get and trim the input value
            if (!qrCode) {
                this.showToast('Please enter a QR code', 'error'); // Show error if input is empty
                return;
            }

            await this.processCheckin(qrCode); // Process the manual QR code
            this.elements.manualInput.value = ''; // Clear the input field after processing
        }

        // Core function to send the QR code to the API for check-in.
        async processCheckin(qrCode) {
            this.showLoading(true); // Show loading overlay

            try {
                // Make an HTTP GET request to your Laravel API endpoint using Axios.
                // The URL includes the QR code.
                const response = await axios.get(`/api/check-in/${qrCode}`, {
                    timeout: 10000 // Set a timeout for the request (10 seconds)
                });

                const data = response.data.data; // Extract participant data from the API response
                this.handleCheckinSuccess(data, qrCode); // Call success handler

            } catch (error) {
                this.handleCheckinError(error, qrCode); // Call error handler
            } finally {
                this.showLoading(false); // Hide loading overlay regardless of success/failure
            }
        }

        // Handles a successful check-in response from the API.
        handleCheckinSuccess(data, qrCode) {
            this.successCount++; // Increment success counter
            this.elements.successCount.textContent = this.successCount; // Update UI count

            // Construct HTML to display participant details for the last successful check-in.
            const resultHtml = `
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="text-lg font-medium text-green-900 mb-2">✅ Check-in Successful!</h3>
                                    <div class="space-y-1 text-sm text-green-800">
                                        <p><strong>Name:</strong> ${this.escapeHtml(data.name)}</p>
                                        <p><strong>Email:</strong> ${this.escapeHtml(data.email)}</p>
                                        <p><strong>Company:</strong> ${this.escapeHtml(data.company_name)}</p>
                                        <p><strong>Package:</strong> ${this.escapeHtml(data.participant_type)}</p>
                                        <p><strong>Status:</strong> <span class="font-semibold">${this.escapeHtml(data.status)}</span></p>
                                        <p><strong>Time:</strong> ${new Date().toLocaleString()}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

            this.elements.result.innerHTML = resultHtml; // Update the main result display
            this.addToRecentCheckins(data, 'success'); // Add to the list of recent check-ins
            this.showToast('Check-in successful!', 'success'); // Show a temporary success message

            this.playNotificationSound('success'); // Play a success sound
        }

        // Handles an error response from the API (e.g., participant not found).
        handleCheckinError(error, qrCode) {
            this.errorCount++; // Increment error counter
            this.elements.errorCount.textContent = this.errorCount; // Update UI count

            // Get the error message from the API response or a generic network error.
            const errorMessage = error.response?.data?.message || 'Network error occurred';
            const statusCode = error.response?.status || 'Unknown'; // Get HTTP status code

            // Construct HTML to display the error message and details.
            const resultHtml = `
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="text-lg font-medium text-red-900 mb-2">❌ Check-in Failed</h3>
                                    <div class="space-y-1 text-sm text-red-800">
                                        <p><strong>Error:</strong> ${this.escapeHtml(errorMessage)}</p>
                                        <p><strong>QR Code:</strong> ${this.escapeHtml(qrCode)}</p>
                                        <p><strong>Status Code:</strong> ${statusCode}</p>
                                        <p><strong>Time:</strong> ${new Date().toLocaleString()}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

            this.elements.result.innerHTML = resultHtml; // Update the main result display
            this.addToRecentCheckins({ // Add to recent check-ins list with error details
                qr_code: qrCode,
                error: errorMessage
            }, 'error');
            this.showToast(errorMessage, 'error'); // Show a temporary error message

            this.playNotificationSound('error'); // Play an error sound
        }

        // Adds a check-in result (success or error) to the recent check-ins list.
        addToRecentCheckins(data, type) {
            const checkin = {
                ...data, // Spread all properties from the data object
                type, // 'success' or 'error'
                timestamp: new Date().toLocaleString() // Current time of check-in
            };

            this.recentCheckins.unshift(checkin); // Add to the beginning of the array
            // Keep the list limited to `maxRecentCheckins`.
            if (this.recentCheckins.length > this.maxRecentCheckins) {
                this.recentCheckins.pop(); // Remove the oldest item if limit exceeded
            }

            this.updateRecentCheckinsList(); // Refresh the displayed list
        }

        // Renders the list of recent check-ins in the UI.
        updateRecentCheckinsList() {
            if (this.recentCheckins.length === 0) {
                // Display a placeholder if no check-ins yet.
                this.elements.recentCheckins.innerHTML = '<p class="text-gray-500 text-center py-4">No check-ins yet</p>';
                return;
            }

            // Map each recent check-in object to an HTML string.
            const html = this.recentCheckins.map(checkin => {
                // Determine background and text colors based on check-in type.
                const bgColor = checkin.type === 'success' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200';
                const textColor = checkin.type === 'success' ? 'text-green-800' : 'text-red-800';
                const icon = checkin.type === 'success' ? '✅' : '❌'; // Emoji icon

                // Return HTML for a single recent check-in item.
                return `
                                <div class="flex items-center justify-between p-3 ${bgColor} border rounded-md">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-lg">${icon}</span>
                                        <div>
                                            <p class="font-medium ${textColor}">
                                                ${this.escapeHtml(checkin.name || 'Unknown Participant')}
                                            </p>
                                            <p class="text-sm ${textColor} opacity-75">
                                                ${this.escapeHtml(checkin.company_name || checkin.error || 'N/A')}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs ${textColor} opacity-75">${checkin.timestamp}</p>
                                    </div>
                                </div>
                            `;
            }).join(''); // Join all HTML strings into one.

            this.elements.recentCheckins.innerHTML = html; // Update the DOM.
        }

        // Shows or hides the full-screen loading overlay.
        showLoading(show) {
            if (show) {
                this.elements.loadingOverlay.classList.remove('hidden'); // Show overlay
            } else {
                this.elements.loadingOverlay.classList.add('hidden'); // Hide overlay
            }
        }

        // Displays a temporary toast notification at the top right of the screen.
        showToast(message, type) {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-4 py-2 rounded-md text-white z-50 ${
                        type === 'success' ? 'bg-green-500' : 'bg-red-500' // Green for success, red for error
                    }`;
            toast.textContent = message;

            document.body.appendChild(toast); // Add toast to the body

            // Remove the toast after 3 seconds.
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        // Plays a notification sound based on the check-in type.
        playNotificationSound(type) {
            try {
                const audio = new Audio();
                // For success, assuming an asset exists. For error, using a base64 encoded simple beep sound.
                audio.src = type === 'success' ?
                    '/assets/success.mp3' : // Path to your success sound file
                    'data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+Du'; // Simple beep sound for error
                audio.volume = 0.3; // Set volume
                audio.play().catch(() => {}); // Play sound, catch and ignore potential errors (e.g., user gesture required)
            } catch (error) {
                // Ignore any errors related to audio playback (e.g., unsupported format)
            }
        }

        // Helper function to escape HTML entities in text, preventing XSS.
        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    }

    // Initialize the QR Check-in Manager when the DOM is fully loaded.
    document.addEventListener('DOMContentLoaded', () => {
        new QRCheckInManager();
    });
</script>
@endpush