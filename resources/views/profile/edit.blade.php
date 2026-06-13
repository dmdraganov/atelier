<x-layouts.app title="Профиль">
    <section class="grid grid-cols-[minmax(0,.82fr)_minmax(360px,.68fr)] gap-10 py-8 max-[920px]:grid-cols-1">
        <div>
            <p class="section-kicker m-0">Аккаунт</p>
            <h1 class="section-title mt-3">Профиль и контакты</h1>
            <p class="section-copy mt-4">Здесь хранятся данные, по которым ателье связывает заказы с вами. Email используется для входа и не редактируется на этой странице.</p>

            <div class="mt-8 grid gap-4">
                @if ($user->role === \App\Enums\UserRole::Customer)
                    <a class="atelier-card flex items-center justify-between gap-4 p-5 text-[#3d1028] no-underline transition hover:border-[#d8b37a]" href="{{ route('orders.index') }}">
                        <span>
                            <strong class="block text-lg">Мои заказы</strong>
                            <span class="mt-1 block text-sm leading-6 text-[#6f5b66]">История, статусы и стоимость ваших заказов.</span>
                        </span>
                        <span class="text-2xl text-[#b9852f]">→</span>
                    </a>
                    <a class="atelier-card flex items-center justify-between gap-4 p-5 text-[#3d1028] no-underline transition hover:border-[#d8b37a]" href="{{ route('orders.create') }}">
                        <span>
                            <strong class="block text-lg">Новый бриф</strong>
                            <span class="mt-1 block text-sm leading-6 text-[#6f5b66]">Описать изделие, приложить референсы и получить оценку.</span>
                        </span>
                        <span class="text-2xl text-[#b9852f]">→</span>
                    </a>
                @elseif ($user->role === \App\Enums\UserRole::Master)
                    <a class="atelier-card flex items-center justify-between gap-4 p-5 text-[#3d1028] no-underline transition hover:border-[#d8b37a]" href="{{ route('master.orders.index') }}">
                        <span>
                            <strong class="block text-lg">Назначенные заказы</strong>
                            <span class="mt-1 block text-sm leading-6 text-[#6f5b66]">Рабочий список изделий, переданных вам администратором.</span>
                        </span>
                        <span class="text-2xl text-[#b9852f]">→</span>
                    </a>
                @elseif ($user->role === \App\Enums\UserRole::Admin)
                    <a class="atelier-card flex items-center justify-between gap-4 p-5 text-[#3d1028] no-underline transition hover:border-[#d8b37a]" href="/admin">
                        <span>
                            <strong class="block text-lg">Админ-панель</strong>
                            <span class="mt-1 block text-sm leading-6 text-[#6f5b66]">Управление заказами, каталогом, материалами и пользователями.</span>
                        </span>
                        <span class="text-2xl text-[#b9852f]">→</span>
                    </a>
                @endif
            </div>
        </div>

        <form class="atelier-card grid w-full gap-4 p-6" method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')
            <h2 class="m-0 text-2xl font-black text-[#3d1028]">Контактные данные</h2>
            <label class="field-label">
                <span>Имя</span>
                <input class="field-control @error('name') field-control-error @enderror" name="name" value="{{ old('name', $user->name) }}" required minlength="2" maxlength="255" autocomplete="name" aria-describedby="name-error">
                @error('name')
                    <span class="field-error" id="name-error">{{ $message }}</span>
                @enderror
            </label>
            <label class="field-label">
                <span>Email для входа</span>
                <input class="field-control" type="email" value="{{ $user->email }}" disabled>
            </label>
            <label class="field-label">
                <span>Телефон</span>
                <input class="field-control @error('phone') field-control-error @enderror" name="phone" type="tel" value="{{ old('phone', $user->phone) }}" autocomplete="tel" inputmode="tel" maxlength="16" pattern="\+7\s[0-9]{3}\s[0-9]{3}-[0-9]{2}-[0-9]{2}" placeholder="+7 900 000-00-00" title="Введите телефон в формате +7 900 000-00-00" aria-describedby="phone-help phone-error">
                <span class="field-help" id="phone-help">Номер помогает администратору быстрее уточнить детали заказа.</span>
                @error('phone')
                    <span class="field-error" id="phone-error">{{ $message }}</span>
                @enderror
            </label>
            <button class="btn btn-primary min-h-12" type="submit">Сохранить изменения</button>
        </form>
    </section>
</x-layouts.app>
