<x-layouts.app title="Вход">
    <section class="grid place-items-start justify-center py-8">
        <form class="grid w-[min(520px,100%)] gap-4 rounded-lg border border-slate-200 bg-white p-6" method="post" action="{{ route('login') }}">
            @csrf
            <h1 class="mb-4 mt-0">Вход</h1>
            <label class="grid gap-2 font-semibold text-slate-700">
                <span>Email</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="email" type="email" value="{{ old('email') }}" required autofocus>
            </label>
            <label class="grid gap-2 font-semibold text-slate-700">
                <span>Пароль</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="password" type="password" required>
            </label>
            <label class="flex items-center gap-2.5 font-medium">
                <input class="w-auto" name="remember" type="checkbox" value="1">
                <span>Запомнить меня</span>
            </label>
            <button class="inline-flex min-h-10 cursor-pointer items-center justify-center rounded-lg border border-slate-900 bg-slate-900 px-4 py-2.5 font-semibold text-white" type="submit">Войти</button>
            <p class="text-sm text-slate-500">Нет аккаунта? <a class="text-inherit underline" href="{{ route('register') }}">Зарегистрируйтесь</a>.</p>
        </form>
    </section>
</x-layouts.app>
