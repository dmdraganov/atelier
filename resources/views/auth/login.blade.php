<x-layouts.app title="Вход">
    <section class="grid min-h-[calc(100vh-220px)] grid-cols-[minmax(0,.9fr)_minmax(360px,.55fr)] items-center gap-12 py-8 max-[880px]:grid-cols-1">
        <div class="max-w-[620px]">
            <h1 class="m-0 text-[clamp(38px,5vw,68px)] font-semibold leading-[.98]">Вход в личный кабинет</h1>
            <p class="mt-5 text-lg leading-8 text-slate-600">Клиенты оформляют заказы и отслеживают статусы. Мастера и администраторы попадают в свои рабочие разделы после входа.</p>
        </div>
        <form class="grid w-full gap-4 rounded-lg border border-slate-200 bg-white p-6 shadow-xl shadow-slate-950/[.06]" method="post" action="{{ route('login') }}">
            @csrf
            <h2 class="mb-2 mt-0 text-2xl font-semibold">Вход</h2>
            <label class="grid gap-2 text-sm font-semibold text-slate-700">
                <span>Email</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="email" type="email" value="{{ old('email') }}" required autofocus>
            </label>
            <label class="grid gap-2 text-sm font-semibold text-slate-700">
                <span>Пароль</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="password" type="password" required>
            </label>
            <label class="flex items-center gap-2.5 text-sm font-medium">
                <input class="size-4 rounded border-slate-300 accent-slate-950" name="remember" type="checkbox" value="1">
                <span>Запомнить меня</span>
            </label>
            <button class="inline-flex min-h-12 cursor-pointer items-center justify-center rounded-lg border border-slate-950 bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800" type="submit">Войти</button>
            <p class="text-sm text-slate-500">Нет аккаунта? <a class="text-inherit underline" href="{{ route('register') }}">Зарегистрируйтесь</a>.</p>
        </form>
    </section>
</x-layouts.app>
