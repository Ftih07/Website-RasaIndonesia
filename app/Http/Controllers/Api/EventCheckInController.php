<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; // Base controller class
use App\Models\ParticipantRegisterProsperityExpo; // Import the Eloquent Model for participants
use Illuminate\Http\JsonResponse; // Import the JsonResponse class for returning JSON responses

// This API controller handles the check-in process for participants at the Prosperity Expo.
// It receives a QR code, attempts to find a matching participant, updates their status,
// and returns a JSON response indicating success or failure.
class EventCheckInController extends Controller
{
    /**
     * Handles the participant check-in process via an API call.
     * This method is typically accessed by a QR code scanner or another external system.
     *
     * @param string $qrCode The unique QR code string provided in the API request URL.
     * @return JsonResponse Returns a JSON response indicating the check-in status.
     */
    public function check(string $qrCode): JsonResponse
    {
        // 1. Attempt to find a participant in the database based on the provided QR code.
        // The `where('qr_code', $qrCode)` part filters the records by the 'qr_code' column.
        // `first()` retrieves the first matching record or `null` if no record is found.
        $participant = ParticipantRegisterProsperityExpo::where('qr_code', $qrCode)->first();

        // 2. Check if a participant was found.
        if (! $participant) {
            // If no participant is found with the given QR code, return an error JSON response.
            // 'status' => 'error' indicates a failure.
            // 'message' provides a user-friendly explanation.
            // 404 is the HTTP status code for "Not Found".
            return response()->json([
                'status' => 'error',
                'message' => 'Participant not found',
            ], 404);
        }

        // 3. If the participant is found, update their status to 'present'.
        // The `update()` method is used to change the 'status' column in the database.
        $participant->update([
            'status' => 'present',
        ]);

        // 4. Return a success JSON response.
        // 'status' => 'success' indicates the operation was successful.
        // 'message' confirms the participant was found and marked as present.
        // 'data' includes the updated participant's information, which can be useful for the calling system.
        return response()->json([
            'status' => 'success',
            'message' => 'Participant found and marked as present',
            'data' => $participant, // Return the participant data for confirmation
        ]);
    }
}
