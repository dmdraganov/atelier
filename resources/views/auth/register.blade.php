<x-layouts.app title="Регистрация">
    <section class="grid place-items-start justify-center py-8">
        <form class="grid w-[min(520px,100%)] gap-4 rounded-lg border border-slate-200 bg-white p-6" method="post" action="{{ route('register') }}">
            @csrf
            <h1 class="mb-4 mt-0">Регистрация клиента</h1>
            <label class="grid gap-2 font-semibold text-slate-700">
                <span>Имя</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="name" value="{{ old('name') }}" required autofocus>
            </label>
            <label class="grid gap-2 font-semibold text-slate-700">
                <span>Email</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="email" type="email" value="{{ old('email') }}" required>
            </label>
            <label class="grid gap-2 font-semibold text-slate-700">
                <span>Телефон</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="phone" value="{{ old('phone') }}">
            </label>
            <label class="grid gap-2 font-semibold text-slate-700">
                <span>Пароль</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="password" type="password" required>
            </label>
            <label class="grid gap-2 font-semibold text-slate-700">
                <span>Повторите пароль</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="password_confirmation" type="password" required>
            </label>
            <button class="inline-flex min-h-10 cursor-pointer items-center justify-center rounded-lg border border-slate-900 bg-slate-900 px-4 py-2.5 font-semibold text-white" type="submit">Создать аккаунт</button>
            <p class="text-sm text-slate-500">Уже есть аккаунт? <a class="text-inherit underline" href="{{ route('login') }}">Войдите</a>.</p>
        </form>
    </section>
</x-layouts.app>
