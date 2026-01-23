<?php

namespace App\Admin\Users\Controllers\Auth;

use App\Http\Controllers\Admin\Controller;
use App\Admin\Users\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
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
        $request->authenticate();

        $request->session()->regenerate();

        // --- LÓGICA DE REDIRECCIÓN PERSONALIZADA ---

        // 1. Si el email es Juan -> Admin Dashboard
        if ($request->user()->email === 'juan@admin.es') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        // 2. Si es cualquier otro -> User Dashboard
        return redirect()->intended(route('user.dashboard', absolute: false));
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
}
