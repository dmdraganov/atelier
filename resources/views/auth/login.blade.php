<x-layouts.app title="Вход">
    <section class="grid min-h-[calc(100vh-220px)] grid-cols-[minmax(0,.95fr)_minmax(360px,.58fr)] items-center gap-12 py-8 max-[920px]:grid-cols-1">
        <div class="max-w-[640px]">
            <span class="eyebrow">Личный кабинет</span>
            <h1 class="mt-5 mb-0 text-[clamp(38px,5vw,68px)] font-black leading-[.98] tracking-normal">Вход в систему ателье</h1>
            <p class="section-copy mt-5">Клиенты оформляют заказы и отслеживают статусы. Мастера и администраторы попадают в свои рабочие разделы после входа.</p>
        </div>
        <form class="atelier-card grid w-full gap-4 p-6" method="post" action="{{ route('login') }}">
            @csrf
            <h2 class="mb-2 mt-0 text-2xl font-extrabold">Вход</h2>
            <label class="field-label">
                <span>Email</span>
                <input class="field-control" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email">
            </label>
            <label class="field-label">
                <span>Пароль</span>
                <input class="field-control" name="password" type="password" required autocomplete="current-password">
            </label>
            <label class="flex items-center gap-2.5 text-sm font-semibold text-slate-700">
                <input class="size-4 cursor-pointer rounded border-slate-300 accent-teal-700" name="remember" type="checkbox" value="1">
                <span>Запомнить меня</span>
            </label>
            <button class="btn btn-primary min-h-12" type="submit">Войти</button>
            <p class="m-0 text-sm text-slate-500">Нет аккаунта? <a class="font-bold text-teal-700 underline" href="{{ route('register') }}">Зарегистрируйтесь</a>.</p>
        </form>
    </section>
</x-layouts.app>
