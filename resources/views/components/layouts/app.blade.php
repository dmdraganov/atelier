<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Ателье' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="m-0 bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="flex min-h-screen flex-col">
        <header class="mx-auto flex w-[min(1160px,calc(100%-32px))] items-center justify-between gap-6 py-5 max-[880px]:flex-col max-[880px]:items-start">
            <a class="text-2xl font-bold text-inherit no-underline" href="{{ route('home') }}">Ателье</a>
            <nav class="flex flex-wrap items-center justify-end gap-3.5 text-sm text-slate-600 max-[880px]:justify-start">
                <a class="text-inherit no-underline" href="{{ route('home') }}">Главная</a>
                <a class="text-inherit no-underline" href="{{ route('catalog.index') }}">Каталог</a>
                @auth
                    @if (auth()->user()->role === \App\Enums\UserRole::Master)
                        <a class="text-inherit no-underline" href="{{ route('master.orders.index') }}">Заказы мастера</a>
                    @elseif (auth()->user()->role === \App\Enums\UserRole::Admin)
                        <a class="text-inherit no-underline" href="/admin">Админ-панель</a>
                    @else
                        <a class="text-inherit no-underline" href="{{ route('orders.index') }}">Мои заказы</a>
                    @endif
                    <a class="text-inherit no-underline" href="{{ route('profile.edit') }}">Профиль</a>
                    <form class="m-0" method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="cursor-pointer rounded-lg border border-slate-900 bg-slate-900 px-3 py-2 text-white" type="submit">Выйти</button>
                    </form>
                @else
                    <a class="text-inherit no-underline" href="{{ route('login') }}">Войти</a>
                    <a class="rounded-lg border border-slate-900 bg-slate-900 px-3 py-2 text-white no-underline" href="{{ route('register') }}">Регистрация</a>
                @endauth
            </nav>
        </header>

        <main class="mx-auto w-[min(1160px,calc(100%-32px))] flex-1 py-6 pb-14">
            @if (session('status'))
                <div class="mb-4 rounded-lg bg-emerald-100 px-4 py-3.5 text-emerald-800">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-100 px-4 py-3.5 text-red-800">
                    <strong>Проверьте данные:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>

        <footer class="mx-auto flex w-[min(1160px,calc(100%-32px))] justify-between gap-4 border-t border-slate-200 py-6 text-sm text-slate-500 max-[880px]:flex-col max-[880px]:items-start">
            <span>Учебная информационная система ателье</span>
            <span>Без платежей, доставки и уведомлений</span>
        </footer>
    </div>
</body>
</html>
