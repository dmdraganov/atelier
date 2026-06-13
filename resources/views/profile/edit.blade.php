<x-layouts.app title="Профиль">
    <section class="grid grid-cols-[minmax(0,.8fr)_minmax(360px,.65fr)] gap-10 py-8 max-[920px]:grid-cols-1">
        <div>
            <span class="eyebrow">Профиль</span>
            <h1 class="section-title mt-4">Личные данные</h1>
            <p class="section-copy mt-4">Эти данные используются в заказах и рабочем процессе ателье. Email и роль доступны только для просмотра.</p>
        </div>
        <form class="atelier-card grid w-full gap-4 p-6" method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')
            <label class="field-label">
                <span>Имя</span>
                <input class="field-control" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name">
            </label>
            <label class="field-label">
                <span>Email</span>
                <input class="field-control" value="{{ $user->email }}" disabled>
            </label>
            <label class="field-label">
                <span>Телефон</span>
                <input class="field-control" name="phone" value="{{ old('phone', $user->phone) }}" autocomplete="tel">
            </label>
            <label class="field-label">
                <span>Роль</span>
                <input class="field-control" value="{{ $user->role->label() }}" disabled>
            </label>
            <button class="btn btn-primary min-h-12" type="submit">Сохранить</button>
        </form>
    </section>
</x-layouts.app>
