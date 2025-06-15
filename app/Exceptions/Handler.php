<?php

namespace App\Exceptions; // Defines the namespace for the application's custom exception handler.

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler; // Imports Laravel's base exception handler.
use Throwable; // Imports the Throwable interface, which all exceptions implement.
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface; // Imports the interface for HTTP-specific exceptions.

/**
 * Class Handler
 *
 * This class extends Laravel's base exception handler and is responsible for
 * logging exceptions and rendering them into HTTP responses. It allows for
 * customizing how different types of exceptions are handled and displayed
 * to the user.
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * These exceptions will still be rendered to the user as an HTTP response,
     * but their details will not be written to your application's logs (e.g., storage/logs/laravel.log).
     * This is typically used for exceptions that are expected and don't require
     * immediate developer attention (e.g., 404 Not Found, 403 Forbidden).
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        // Example: \Illuminate\Auth\Access\AuthorizationException::class,
        // \Symfony\Component\HttpKernel\Exception\NotFoundHttpException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * When validation fails, Laravel typically "flashes" all input fields back
     * to the session so they can be repopulated in the form. This array lists
     * sensitive input fields (like passwords) that should *never* be flashed
     * back to prevent them from being accidentally exposed in logs or views.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',    // Current password input.
        'password',            // New password input.
        'password_confirmation', // Password confirmation input.
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * This method is where you can register custom handlers for specific
     * exception types. For example, you could define a callback to handle
     * a `ModelNotFoundException` and redirect the user to a specific page.
     * By default, it's empty, relying on the parent class's behavior.
     *
     * @return void
     */
    public function register(): void
    {
        // Example:
        // $this->reportable(function (Throwable $e) {
        //     // Custom reporting logic for a specific exception.
        // });
        // $this->renderable(function (MyCustomException $e, $request) {
        //     return response()->view('errors.my-custom-error', [], 500);
        // });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * This method is called when an exception needs to be converted into
     * an HTTP response that can be sent back to the user's browser.
     * It's the primary place to customize the error pages your application displays.
     *
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request.
     * @param  \Throwable  $exception The exception that occurred.
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        // Handle specific HTTP exceptions (e.g., 404 Not Found, 403 Forbidden).
        // This block checks if the exception implements HttpExceptionInterface,
        // which includes exceptions thrown by Symfony's HttpKernel (used by Laravel).
        if ($exception instanceof HttpExceptionInterface) {
            // Get the HTTP status code from the exception (e.g., 404, 500).
            $statusCode = $exception->getStatusCode();

            // Check if a custom error view exists for the specific status code.
            // For example, if $statusCode is 404, it checks for 'resources/views/errors/404.blade.php'.
            if (view()->exists("errors.{$statusCode}")) {
                // If a custom view exists, render it with the corresponding HTTP status code.
                // This allows you to show custom error pages to your users.
                return response()->view("errors.{$statusCode}", [], $statusCode);
            }
        }

        // If the exception is not an HttpException or a custom view for its status code
        // does not exist, defer to the parent class's rendering logic.
        // The parent handler will typically show Laravel's default error pages
        // or a more detailed debug page in a local environment.
        return parent::render($request, $exception);
    }
}
