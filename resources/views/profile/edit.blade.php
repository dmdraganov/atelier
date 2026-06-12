<x-layouts.app title="Профиль">
    <section class="grid place-items-start justify-center py-8">
        <form class="grid w-[min(520px,100%)] gap-4 rounded-lg border border-slate-200 bg-white p-6" method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')
            <h1 class="mb-4 mt-0">Профиль</h1>
            <label class="grid gap-2 font-semibold text-slate-700">
                <span>Имя</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="name" value="{{ old('name', $user->name) }}" required>
            </label>
            <label class="grid gap-2 font-semibold text-slate-700">
                <span>Email</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900 disabled:bg-slate-100" value="{{ $user->email }}" disabled>
            </label>
            <label class="grid gap-2 font-semibold text-slate-700">
                <span>Телефон</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900" name="phone" value="{{ old('phone', $user->phone) }}">
            </label>
            <label class="grid gap-2 font-semibold text-slate-700">
                <span>Роль</span>
                <input class="w-full rounded-lg border border-slate-300 bg-white px-3.5 py-3 text-slate-900 disabled:bg-slate-100" value="{{ $user->role->label() }}" disabled>
            </label>
            <button class="inline-flex min-h-10 cursor-pointer items-center justify-center rounded-lg border border-slate-900 bg-slate-900 px-4 py-2.5 font-semibold text-white" type="submit">Сохранить</button>
        </form>
    </section>
</x-layouts.app>
