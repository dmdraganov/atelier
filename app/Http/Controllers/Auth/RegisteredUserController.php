<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:40', 'regex:/^(?:\+7|8)[\s-]?\(?\d{3}\)?[\s-]?\d{3}[\s-]?\d{2}[\s-]?\d{2}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Укажите имя.',
            'name.max' => 'Имя слишком длинное.',
            'email.required' => 'Укажите email.',
            'email.email' => 'Введите корректный email, например name@example.com.',
            'email.max' => 'Email слишком длинный.',
            'email.unique' => 'Пользователь с таким email уже зарегистрирован.',
            'phone.regex' => 'Укажите телефон в формате +7 900 000-00-00.',
            'phone.max' => 'Телефон слишком длинный.',
            'password.required' => 'Введите пароль.',
            'password.min' => 'Пароль должен содержать минимум 8 символов.',
            'password.confirmed' => 'Пароли не совпадают.',
        ]);

        $user = User::query()->create([
            ...$data,
            'role' => UserRole::Customer,
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('orders.create');
    }
}
