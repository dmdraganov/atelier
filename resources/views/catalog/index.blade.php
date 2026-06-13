<x-layouts.app title="Каталог">
    <section class="grid grid-cols-[minmax(0,1fr)_320px] gap-8 border-b border-slate-200 pb-10 pt-5 max-[920px]:grid-cols-1">
        <div>
            <span class="eyebrow">Каталог моделей</span>
            <h1 class="section-title mt-4">Выберите основу для заказа</h1>
            <p class="section-copy mt-5">Базовые услуги ателье с ориентировочными сроками и стартовой стоимостью. После выбора модели можно указать материал, срочность, мерки и референсы.</p>
        </div>
        <div class="atelier-card-subtle self-end p-5">
            <p class="m-0 text-sm font-bold text-slate-500">Активных моделей</p>
            <strong class="mt-2 block text-5xl font-black text-slate-950">{{ $models->total() }}</strong>
            <p class="m-0 mt-2 text-sm leading-6 text-slate-600">каждая доступна для предварительного расчёта.</p>
        </div>
    </section>

    <div class="my-6 flex flex-wrap gap-2.5">
        @foreach ($categories as $category)
            <span class="rounded-full border border-slate-200 bg-white px-3.5 py-2 text-sm font-bold text-slate-600">{{ $category->name }}</span>
        @endforeach
    </div>

    <section class="grid grid-cols-3 gap-5 max-[920px]:grid-cols-1">
        @foreach ($models as $model)
            @include('catalog.partials.card', ['model' => $model])
        @endforeach
    </section>

    <div class="mt-8">
        {{ $models->links() }}
    </div>
</x-layouts.app>
