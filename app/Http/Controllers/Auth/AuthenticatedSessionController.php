<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Неверная почта или пароль.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->to($this->redirectAfterLogin($request));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function redirectAfterLogin(Request $request): string
    {
        /** @var User $user */
        $user = $request->user();
        $intended = $request->session()->pull('url.intended');

        if (is_string($intended) && $this->intendedUrlIsAllowed($request, $intended, $user->role)) {
            return $intended;
        }

        return match ($user->role) {
            UserRole::Customer => route('orders.index'),
            UserRole::Master => route('master.orders.index'),
            UserRole::Admin => url('/admin'),
        };
    }

    private function intendedUrlIsAllowed(Request $request, string $intended, UserRole $role): bool
    {
        $host = parse_url($intended, PHP_URL_HOST);

        if ($host !== null && $host !== $request->getHost()) {
            return false;
        }

        $path = parse_url($intended, PHP_URL_PATH) ?: '/';

        return match ($role) {
            UserRole::Customer => str_starts_with($path, '/orders') || str_starts_with($path, '/profile'),
            UserRole::Master => str_starts_with($path, '/master/orders') || str_starts_with($path, '/profile'),
            UserRole::Admin => str_starts_with($path, '/admin') || str_starts_with($path, '/profile'),
        };
    }
}
