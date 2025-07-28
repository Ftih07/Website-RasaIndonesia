<?php

namespace App\Http\Controllers;

use App\Models\ParticipantRegisterProsperityExpo; // Import the Eloquent Model for participants
use Illuminate\Http\Request; // Import the Request class to handle incoming HTTP requests
use Illuminate\Support\Str; // Import Laravel's string manipulation helper (for UUID generation)
use SimpleSoftwareIO\QrCode\Facades\QrCode; // Import the QR Code facade (assuming simple-qrcode package is installed)
use Barryvdh\DomPDF\Facade\Pdf; // Import the PDF facade (assuming barryvdh/laravel-dompdf package is installed)
use Illuminate\Support\Facades\Storage; // Import the Storage facade for file operations

// This class handles all the logic related to participant registration for the Prosperity Expo.
// It manages showing the registration form, processing submissions, generating QR codes and PDFs,
// and handling thank you pages and PDF downloads.
class ProsperityExpoRegistrationController extends Controller
{
    /**
     * Displays the registration form page for the Prosperity Expo.
     * This method is typically accessed via a GET request to a specific route.
     *
     * @return \Illuminate\View\View Returns the 'prosperity-expo.create' Blade view.
     */
    public function create()
    {
        // Loads and returns the Blade view file located at 'resources/views/prosperity-expo/create.blade.php'.
        // This view will contain the HTML form for participants to fill out.
        return view('prosperity-expo.create');
    }

    /**
     * Handles the submission of the registration form.
     * This method processes the data sent from the form, validates it,
     * saves the participant's information to the database, generates a QR code and PDF,
     * and then redirects the user to a thank you page.
     *
     * @param Request $request The incoming HTTP request containing form data.
     * @return \Illuminate\Http\RedirectResponse Redirects to the thank you page.
     */
    public function store(Request $request)
    {
        // 1. Validate the incoming request data.
        // This ensures that all required fields are present and meet specific criteria (e.g., email format, uniqueness).
        $validated = $request->validate([
            'name' => 'required|string', // Name is required and must be a string
            'email' => 'required|email|unique:participant_register_prosperity_expo,email', // Email is required, must be valid email format, and unique in the specified table's 'email' column
            'company_name' => 'required|string',
            'position' => 'required|string',
            'contact' => 'required|string',
            'participant_type' => 'required|string',
            'company_type' => 'required|string',
            'product_description' => 'required|string',
            'company_social_media_username' => 'nullable|string', // Optional string field
            'company_profile' => 'nullable|file|mimes:pdf,doc,docx|max:5120', // Optional file upload, must be PDF/DOC/DOCX, max 5MB (5120 KB)
        ]);

        // 2. Generate a unique identifier (UUID) for the QR code.
        // This ensures each participant has a unique QR code.
        $qrCode = Str::uuid();

        // 3. Handle company profile file upload (if provided).
        $profilePath = null; // Initialize path as null
        if ($request->hasFile('company_profile')) {
            // If a file was uploaded, store it in the 'company_profiles' directory
            // within the 'public' disk (usually storage/app/public).
            // The `store()` method returns the path to the stored file.
            $profilePath = $request->file('company_profile')->store('company_profiles', 'public');
        }

        // 4. Save participant data to the database.
        // The `create()` method uses the validated data and the generated QR code/profile path.
        // The `...$validated` uses the spread operator to unpack all key-value pairs from the $validated array.
        $participant = ParticipantRegisterProsperityExpo::create([
            ...$validated, // All validated fields are automatically assigned
            'company_profile' => $profilePath, // Assign the stored file path
            'qr_code' => $qrCode, // Assign the generated QR code UUID
        ]);

        // 5. Generate QR Code image (PNG format).
        // The QR code content will be the participant's unique UUID.
        $qrImage = QrCode::format('png')->size(300)->generate($participant->qr_code);
        // Define the path where the QR code image will be saved (e.g., storage/app/public/qr-codes/participant-1.png).
        $qrPath = 'qr-codes/participant-' . $participant->id . '.png';
        // Save the generated QR code image to the public disk.
        Storage::disk('public')->put($qrPath, $qrImage);

        // 6. Generate a PDF confirmation document.
        // Load a Blade view ('exports.registration-pdf') to be rendered as PDF.
        // Pass the participant data and the full path to the saved QR image to the view.
        $pdf = Pdf::loadView('exports.registration-pdf', [
            'participant' => $participant,
            'qrPath' => storage_path('app/public/' . $qrPath), // Full path is needed for PDF embedding
        ]);

        // 7. Save the generated PDF file.
        // Define the path where the PDF will be stored (e.g., storage/app/pdfs/registration-1.pdf).
        $filePath = 'pdfs/registration-' . $participant->id . '.pdf';
        // Store the PDF content. By default, this uses the 'local' disk (storage/app).
        Storage::put($filePath, $pdf->output());

        // 8. Redirect the user to the thank you page, passing the QR code for lookup.
        return redirect()->route('prosperity-expo.thankyou', ['qr_code' => $participant->qr_code])
            ->with('show_ticket_modal', true);
    }

    /**
     * Displays a thank you page after successful registration.
     * It fetches the participant's details using the QR code from the URL.
     *
     * @param string $qrCode The unique QR code of the participant.
     * @return \Illuminate\View\View Returns the 'prosperity-expo.thank-you' Blade view with participant data.
     */
    public function thankYou($qrCode)
    {
        // Find the participant record using the provided QR code.
        // `firstOrFail()` will retrieve the first matching record or throw a 404 error if not found.
        $participant = ParticipantRegisterProsperityExpo::where('qr_code', $qrCode)->firstOrFail();
        // Return the thank you view, passing the found participant's data to it.
        return view('prosperity-expo.thank-you', compact('participant'));
    }

    /**
     * Allows downloading the generated PDF confirmation for a participant.
     *
     * @param string $qrCode The unique QR code of the participant.
     * @return \Symfony\Component\HttpFoundation\StreamedResponse Downloads the PDF file.
     */
    public function downloadPdf($qrCode)
    {
        // Find the participant record using the provided QR code.
        $participant = ParticipantRegisterProsperityExpo::where('qr_code', $qrCode)->firstOrFail();
        // Construct the expected file path for the PDF.
        $filePath = 'pdfs/registration-' . $participant->id . '.pdf';

        // Check if the PDF file actually exists in storage.
        if (!Storage::exists($filePath)) {
            // If the file does not exist, abort with a 404 Not Found error.
            abort(404, 'PDF file not found.');
        }

        // If the file exists, initiate a download response.
        // The second argument is the desired filename for the downloaded file.
        return Storage::download($filePath, 'registration-confirmation.pdf');
    }
}
