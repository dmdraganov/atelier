<x-layouts.app title="Каталог">
    <section class="py-6">
        <h1 class="m-0 text-[clamp(34px,5vw,64px)] leading-none">Каталог моделей</h1>
        <p class="max-w-[720px] text-lg leading-relaxed text-slate-600">Базовые услуги ателье с ориентировочными сроками и стартовой стоимостью.</p>
    </section>

    <div class="mb-5 flex flex-wrap gap-2.5">
        @foreach ($categories as $category)
            <span class="rounded-full border border-slate-200 bg-white px-3 py-2 text-sm text-slate-600">{{ $category->name }}</span>
        @endforeach
    </div>

    <section class="grid grid-cols-3 gap-4 max-[880px]:grid-cols-1">
        @foreach ($models as $model)
            @include('catalog.partials.card', ['model' => $model])
        @endforeach
    </section>

    {{ $models->links() }}
</x-layouts.app>
