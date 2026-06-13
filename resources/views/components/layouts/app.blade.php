<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Ателье' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="m-0 font-sans antialiased selection:bg-teal-200 selection:text-slate-950">
    <div class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
            <div class="atelier-container flex min-h-[76px] items-center justify-between gap-6 py-3 max-[920px]:min-h-0 max-[920px]:flex-col max-[920px]:items-start">
                <a class="group inline-flex items-center gap-3 text-lg font-extrabold text-slate-950 no-underline" href="{{ route('home') }}">
                    <span class="grid size-11 place-items-center rounded-lg bg-slate-950 text-sm font-black text-white shadow-lg shadow-slate-950/15">A</span>
                    <span class="leading-none">
                        Ателье
                        <span class="block text-xs font-semibold text-slate-500">заказы на пошив</span>
                    </span>
                </a>
                <nav class="flex flex-wrap items-center justify-end gap-1.5 max-[920px]:justify-start">
                    <a class="nav-link" href="{{ route('home') }}">Главная</a>
                    <a class="nav-link" href="{{ route('catalog.index') }}">Каталог</a>
                    @auth
                        @if (auth()->user()->role === \App\Enums\UserRole::Master)
                            <a class="nav-link" href="{{ route('master.orders.index') }}">Заказы мастера</a>
                        @elseif (auth()->user()->role === \App\Enums\UserRole::Admin)
                            <a class="nav-link" href="/admin">Админ-панель</a>
                        @else
                            <a class="nav-link" href="{{ route('orders.index') }}">Мои заказы</a>
                        @endif
                        <a class="nav-link" href="{{ route('profile.edit') }}">Профиль</a>
                        <form class="m-0" method="post" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-primary" type="submit">Выйти</button>
                        </form>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">Войти</a>
                        <a class="btn btn-primary" href="{{ route('register') }}">Регистрация</a>
                    @endauth
                </nav>
            </div>
        </header>

        <main class="atelier-container flex-1 py-8 pb-16">
            @if (session('status'))
                <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm font-bold text-emerald-800">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3.5 text-sm text-red-800">
                    <strong>Проверьте данные:</strong>
                    <ul class="mb-0 mt-2 grid gap-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </main>

        <footer class="atelier-container flex justify-between gap-4 border-t border-slate-200 py-8 text-sm text-slate-500 max-[880px]:flex-col max-[880px]:items-start">
            <span class="font-semibold text-slate-700">Учебная информационная система ателье</span>
            <span>Каталог, заказы, профиль и рабочее место мастера</span>
        </footer>
    </div>
</body>
</html>
