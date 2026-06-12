<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Ателье' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="m-0 bg-white font-sans text-slate-950 antialiased selection:bg-amber-200 selection:text-slate-950">
    <div class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur">
            <div class="mx-auto flex min-h-[72px] w-[min(1180px,calc(100%-32px))] items-center justify-between gap-6 max-[880px]:min-h-0 max-[880px]:flex-col max-[880px]:items-start max-[880px]:py-4">
            <a class="group inline-flex items-center gap-3 text-lg font-semibold text-inherit no-underline" href="{{ route('home') }}">
                <span class="grid size-10 place-items-center rounded-lg bg-slate-950 text-sm font-bold text-white">A</span>
                <span class="leading-none">Ателье</span>
            </a>
            <nav class="flex flex-wrap items-center justify-end gap-1.5 text-sm font-medium text-slate-600 max-[880px]:justify-start">
                <a class="rounded-lg px-3 py-2 text-inherit no-underline transition hover:bg-slate-100 hover:text-slate-950" href="{{ route('home') }}">Главная</a>
                <a class="rounded-lg px-3 py-2 text-inherit no-underline transition hover:bg-slate-100 hover:text-slate-950" href="{{ route('catalog.index') }}">Каталог</a>
                @auth
                    @if (auth()->user()->role === \App\Enums\UserRole::Master)
                        <a class="rounded-lg px-3 py-2 text-inherit no-underline transition hover:bg-slate-100 hover:text-slate-950" href="{{ route('master.orders.index') }}">Заказы мастера</a>
                    @elseif (auth()->user()->role === \App\Enums\UserRole::Admin)
                        <a class="rounded-lg px-3 py-2 text-inherit no-underline transition hover:bg-slate-100 hover:text-slate-950" href="/admin">Админ-панель</a>
                    @else
                        <a class="rounded-lg px-3 py-2 text-inherit no-underline transition hover:bg-slate-100 hover:text-slate-950" href="{{ route('orders.index') }}">Мои заказы</a>
                    @endif
                    <a class="rounded-lg px-3 py-2 text-inherit no-underline transition hover:bg-slate-100 hover:text-slate-950" href="{{ route('profile.edit') }}">Профиль</a>
                    <form class="m-0" method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="min-h-10 cursor-pointer rounded-lg border border-slate-950 bg-slate-950 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800" type="submit">Выйти</button>
                    </form>
                @else
                    <a class="rounded-lg px-3 py-2 text-inherit no-underline transition hover:bg-slate-100 hover:text-slate-950" href="{{ route('login') }}">Войти</a>
                    <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-950 bg-slate-950 px-4 py-2 text-sm font-semibold text-white no-underline shadow-sm transition hover:bg-slate-800" href="{{ route('register') }}">Регистрация</a>
                @endauth
            </nav>
            </div>
        </header>

        <main class="mx-auto w-[min(1180px,calc(100%-32px))] flex-1 py-8 pb-16">
            @if (session('status'))
                <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm font-medium text-emerald-800">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3.5 text-sm text-red-800">
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

        <footer class="mx-auto flex w-[min(1180px,calc(100%-32px))] justify-between gap-4 border-t border-slate-200 py-8 text-sm text-slate-500 max-[880px]:flex-col max-[880px]:items-start">
            <span>Учебная информационная система ателье</span>
            <span>Без платежей, доставки и уведомлений</span>
        </footer>
    </div>
</body>
</html>
