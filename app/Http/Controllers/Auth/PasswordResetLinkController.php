<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            // Rate limiting - prevent spam
            $key = 'password-reset-'.$request->ip();

            if (RateLimiter::tooManyAttempts($key, 3)) {
                $seconds = RateLimiter::availableIn($key);
                throw ValidationException::withMessages([
                    'email' => ['Too many password reset attempts. Please try again in '.ceil($seconds / 60).' minutes.'],
                ]);
            }

            RateLimiter::hit($key, 300); // 5 minutes

            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status == Password::RESET_LINK_SENT) {
                Log::info('Password reset link sent successfully', [
                    'email' => $request->email,
                    'ip' => $request->ip(),
                ]);

                return back()->with('status', 'We have emailed your password reset link! Please check your email.');
            }

            // Handle different error cases
            $errorMessage = match ($status) {
                Password::INVALID_USER => 'We could not find a user with that email address.',
                Password::RESET_THROTTLED => 'Please wait before retrying.',
                default => 'Unable to send password reset link. Please try again.',
            };

            Log::warning('Password reset link failed to send', [
                'email' => $request->email,
                'status' => $status,
                'ip' => $request->ip(),
            ]);

            throw ValidationException::withMessages([
                'email' => [$errorMessage],
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Password reset error: '.$e->getMessage(), [
                'email' => $request->email,
                'exception' => $e,
                'ip' => $request->ip(),
            ]);

            throw ValidationException::withMessages([
                'email' => ['An error occurred while processing your request. Please try again later.'],
            ]);
        }
    }
}
