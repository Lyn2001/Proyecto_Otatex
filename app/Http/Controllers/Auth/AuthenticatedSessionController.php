<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Cache\RateLimiter;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    protected $maxAttempts = 3; // Número máximo de intentos
    protected $decayMinutes = 1; // Tiempo de espera en minutos

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->incrementLoginAttempts($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);

            $user = Auth::user();

            if ($user) {
                // Verificar el rol_id para redirigir al dashboard adecuado
                if ($user->rol_id === 1 || $user->rol_id === 3) {
                    // Redirigir al dashboard del administrador
                    return redirect()->intended(route('admin.dashboard'));
                } else {
                    // Redirigir al dashboard del usuario
                    return redirect()->intended(route('dashboard'));
                }
            }

            // Handle the case where user is null
            return redirect()->back()->withInput($request->only('email'));
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        return Auth::attempt($request->only('email', 'password'), $request->filled('remember'));
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $this->maxAttempts, $this->decayMinutes
        );
    }

    protected function incrementLoginAttempts(Request $request)
    {
        $this->limiter()->hit(
            $this->throttleKey($request), $this->decayMinutes * 60
        );
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            'email' => [trans('auth.throttle', ['seconds' => $seconds])],
        ])->status(423);
    }

    protected function clearLoginAttempts(Request $request)
    {
        $this->limiter()->clear($this->throttleKey($request));
    }

    protected function throttleKey(Request $request)
    {
        return strtolower($request->input('email')).'|'.$request->ip();
    }

    protected function limiter()
    {
        return app(RateLimiter::class);
    }
}
