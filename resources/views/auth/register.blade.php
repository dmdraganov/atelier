<x-layouts.app title="Регистрация">
    <section class="grid min-h-[calc(100vh-220px)] grid-cols-[minmax(0,.85fr)_minmax(380px,.6fr)] items-center gap-12 py-8 max-[880px]:grid-cols-1">
        <div class="max-w-[620px]">
            <h1 class="m-0 text-[clamp(38px,5vw,68px)] font-semibold leading-[.98]">Регистрация клиента</h1>
            <p class="mt-5 text-lg leading-8 text-slate-600">Создайте аккаунт, чтобы оформить заказ на индивидуальный пошив и вернуться к нему позже.</p>
        </div>
        <form class="grid w-full gap-4 rounded-lg border border-slate-200 bg-white p-6 shadow-xl shadow-slate-950/[.06]" method="post" action="{{ route('register') }}">
            @csrf
            <h2 class="mb-2 mt-0 text-2xl font-semibold">Данные аккаунта</h2>
            <label class="grid gap-2 text-sm font-semibold text-slate-700">
                <span>Имя</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="name" value="{{ old('name') }}" required autofocus>
            </label>
            <label class="grid gap-2 text-sm font-semibold text-slate-700">
                <span>Email</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="email" type="email" value="{{ old('email') }}" required>
            </label>
            <label class="grid gap-2 text-sm font-semibold text-slate-700">
                <span>Телефон</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="phone" value="{{ old('phone') }}">
            </label>
            <label class="grid gap-2 text-sm font-semibold text-slate-700">
                <span>Пароль</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="password" type="password" required>
            </label>
            <label class="grid gap-2 text-sm font-semibold text-slate-700">
                <span>Повторите пароль</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-base text-slate-950 outline-none transition focus:border-amber-600 focus:ring-4 focus:ring-amber-100" name="password_confirmation" type="password" required>
            </label>
            <button class="inline-flex min-h-12 cursor-pointer items-center justify-center rounded-lg border border-slate-950 bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800" type="submit">Создать аккаунт</button>
            <p class="text-sm text-slate-500">Уже есть аккаунт? <a class="text-inherit underline" href="{{ route('login') }}">Войдите</a>.</p>
        </form>
    </section>
</x-layouts.app>
