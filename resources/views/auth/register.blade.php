<x-layouts.app title="Регистрация">
    <section class="grid min-h-[calc(100vh-220px)] grid-cols-[minmax(0,.9fr)_minmax(380px,.62fr)] items-center gap-12 py-8 max-[920px]:grid-cols-1">
        <div class="max-w-[640px]">
            <p class="section-kicker m-0">Новый аккаунт</p>
            <h1 class="atelier-serif mt-4 mb-0 text-[clamp(42px,5vw,72px)] leading-[.92] text-[#3d1028]">Создайте кабинет для заказов</h1>
            <p class="section-copy mt-5">С аккаунтом можно оформить бриф, вернуться к нему позже и отслеживать работу над изделием.</p>
        </div>
        <form class="atelier-card grid w-full gap-4 p-6" method="post" action="{{ route('register') }}">
            @csrf
            <h2 class="mb-2 mt-0 text-2xl font-black text-[#3d1028]">Контактные данные</h2>
            <label class="field-label">
                <span>Имя</span>
                <input class="field-control" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            </label>
            <label class="field-label">
                <span>Email</span>
                <input class="field-control" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
            </label>
            <label class="field-label">
                <span>Телефон</span>
                <input class="field-control" name="phone" value="{{ old('phone') }}" autocomplete="tel" placeholder="+7 900 000-00-00">
            </label>
            <label class="field-label">
                <span>Пароль</span>
                <input class="field-control" name="password" type="password" required autocomplete="new-password">
            </label>
            <label class="field-label">
                <span>Повторите пароль</span>
                <input class="field-control" name="password_confirmation" type="password" required autocomplete="new-password">
            </label>
            <button class="btn btn-primary min-h-12" type="submit">Создать аккаунт</button>
            <p class="m-0 text-sm text-[#6f5b66]">Уже есть аккаунт? <a class="font-black text-[#5a1839] underline" href="{{ route('login') }}">Войдите</a>.</p>
        </form>
    </section>
</x-layouts.app>
