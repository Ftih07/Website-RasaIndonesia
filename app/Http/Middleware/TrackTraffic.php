<?php

namespace App\Http\Middleware;

use App\Models\TrafficLog; // Import the TrafficLog Eloquent model.
use Closure;                // Import Closure for handling the next middleware/request.
use Illuminate\Http\Request; // Import the Request object.

/**
 * TrackTraffic
 *
 * This is a custom Laravel Middleware responsible for logging basic
 * website traffic information for every incoming HTTP request.
 * It creates a new entry in the `traffic_logs` table for each visit,
 * capturing the IP address, full URL, and user agent of the request.
 */
class TrackTraffic
{
    /**
     * Handle an incoming request.
     * This method is executed for every HTTP request that passes through this middleware.
     *
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request.
     * @param  \Closure  $next The next middleware or the request handler in the application's pipeline.
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Create a new record in the 'traffic_logs' table.
        // The `create` method uses the `$fillable` property defined in the TrafficLog model
        // to safely assign the data.
        TrafficLog::create([
            // Get the client's IP address from the request.
            'ip_address' => $request->ip(),
            // Get the full URL that was requested (including query parameters).
            'url' => $request->fullUrl(),
            // Get the User-Agent string from the request headers, which contains browser and OS information.
            'user_agent' => $request->userAgent(),
        ]);

        // Pass the request to the next middleware in the pipeline or to the route handler.
        // It's crucial to call `$next($request)` to allow the request to continue processing.
        return $next($request);
    }
}
