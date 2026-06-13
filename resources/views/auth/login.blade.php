<x-layouts.app title="Вход">
    <section class="grid min-h-[calc(100vh-220px)] grid-cols-[minmax(0,.95fr)_minmax(360px,.58fr)] items-center gap-12 py-8 max-[920px]:grid-cols-1">
        <div class="max-w-[640px]">
            <p class="section-kicker m-0">Кабинет Atelier</p>
            <h1 class="atelier-serif mt-4 mb-0 text-[clamp(42px,5vw,72px)] leading-[.92] text-[#3d1028]">Вернитесь к своим заказам</h1>
            <p class="section-copy mt-5">После входа доступны брифы, статусы, детали изделий и сохранённые контактные данные.</p>
        </div>
        <form class="atelier-card grid w-full gap-4 p-6" method="post" action="{{ route('login') }}">
            @csrf
            <h2 class="mb-2 mt-0 text-2xl font-black text-[#3d1028]">Вход</h2>
            <label class="field-label">
                <span>Email</span>
                <input class="field-control" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email">
            </label>
            <label class="field-label">
                <span>Пароль</span>
                <input class="field-control" name="password" type="password" required autocomplete="current-password">
            </label>
            <label class="flex items-center gap-2.5 text-sm font-bold text-[#4c2d3d]">
                <input class="size-4 cursor-pointer rounded border-[#d8c4cc] accent-[#5a1839]" name="remember" type="checkbox" value="1">
                <span>Запомнить меня</span>
            </label>
            <button class="btn btn-primary min-h-12" type="submit">Войти</button>
            <p class="m-0 text-sm text-[#6f5b66]">Нет аккаунта? <a class="font-black text-[#5a1839] underline" href="{{ route('register') }}">Зарегистрируйтесь</a>.</p>
        </form>
    </section>
</x-layouts.app>
