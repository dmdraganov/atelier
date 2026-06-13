<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Atelier' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="m-0 font-sans antialiased selection:bg-[#f3dbe0] selection:text-[#3d1028]">
    <div class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-30 border-b border-[#e3d4da]/80 bg-[#fffdfb]/92 backdrop-blur-xl">
            <div class="atelier-container flex min-h-[76px] items-center justify-between gap-6 py-3 max-[980px]:min-h-0 max-[980px]:flex-col max-[980px]:items-start">
                <a class="group inline-flex items-center gap-3 text-lg font-black text-[#3d1028] no-underline" href="{{ route('home') }}">
                    <span class="grid size-11 place-items-center rounded-lg bg-[#5a1839] font-serif text-xl font-semibold text-white shadow-lg shadow-[#5a1839]/20">A</span>
                    <span class="leading-none">
                        Atelier
                        <span class="block text-xs font-bold uppercase tracking-[.08em] text-[#8a6875]">custom tailoring</span>
                    </span>
                </a>
                <nav class="flex flex-wrap items-center justify-end gap-1.5 max-[980px]:justify-start">
                    <a class="nav-link" href="{{ route('home') }}#services">Услуги</a>
                    <a class="nav-link" href="{{ route('catalog.index') }}">Каталог</a>
                    <a class="nav-link" href="{{ route('home') }}#process">Как заказать</a>
                    @auth
                        @if (auth()->user()->role === \App\Enums\UserRole::Master)
                            <a class="nav-link" href="{{ route('master.orders.index') }}">Назначенные заказы</a>
                        @elseif (auth()->user()->role === \App\Enums\UserRole::Admin)
                            <a class="nav-link" href="/admin">Админ-панель</a>
                        @else
                            <a class="nav-link" href="{{ route('orders.index') }}">Мои заказы</a>
                        @endif
                        <a class="nav-link" href="{{ route('profile.edit') }}">Профиль</a>
                        <form class="m-0" method="post" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-secondary" type="submit">Выйти</button>
                        </form>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">Войти</a>
                        <a class="btn btn-primary" href="{{ route('register') }}">Записаться</a>
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

        <footer class="bg-[#3d1028] text-white">
            <div class="atelier-container grid grid-cols-[1.1fr_.7fr_.7fr_.8fr] gap-8 py-12 max-[920px]:grid-cols-2 max-[640px]:grid-cols-1">
                <div>
                    <a class="inline-flex items-center gap-3 text-white no-underline" href="{{ route('home') }}">
                        <span class="grid size-11 place-items-center rounded-lg bg-white font-serif text-xl font-semibold text-[#5a1839]">A</span>
                        <span class="text-xl font-black">Atelier</span>
                    </a>
                    <p class="mt-5 max-w-[320px] text-sm leading-7 text-white/72">Индивидуальный пошив, посадка и доработка одежды с вниманием к ткани, силуэту и деталям.</p>
                </div>
                <div>
                    <h2 class="m-0 text-sm font-black uppercase tracking-[.1em] text-[#e9bd73]">Услуги</h2>
                    <div class="mt-4 grid gap-3 text-sm text-white/76">
                        @foreach ($footerServices as $service)
                            <a class="text-inherit no-underline hover:text-white" href="{{ route('home') }}#services">{{ $service->name }}</a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <h2 class="m-0 text-sm font-black uppercase tracking-[.1em] text-[#e9bd73]">Разделы</h2>
                    <div class="mt-4 grid gap-3 text-sm text-white/76">
                        <a class="text-inherit no-underline hover:text-white" href="{{ route('catalog.index') }}">Каталог</a>
                        @auth
                            @if (auth()->user()->role === \App\Enums\UserRole::Customer)
                                <a class="text-inherit no-underline hover:text-white" href="{{ route('orders.create') }}">Оформить заказ</a>
                                <a class="text-inherit no-underline hover:text-white" href="{{ route('orders.index') }}">Мои заказы</a>
                            @endif
                            <a class="text-inherit no-underline hover:text-white" href="{{ route('profile.edit') }}">Профиль</a>
                        @else
                            <a class="text-inherit no-underline hover:text-white" href="{{ route('login') }}">Вход</a>
                            <a class="text-inherit no-underline hover:text-white" href="{{ route('register') }}">Регистрация</a>
                        @endauth
                    </div>
                </div>
                <div>
                    <h2 class="m-0 text-sm font-black uppercase tracking-[.1em] text-[#e9bd73]">Консультация</h2>
                    <p class="mt-4 text-sm leading-7 text-white/76">Оставьте заказ с моделью, материалом, мерками и референсами. Стоимость уточняется после просмотра деталей.</p>
                    <a class="btn btn-accent mt-2" href="{{ route('catalog.index') }}">Выбрать модель</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
