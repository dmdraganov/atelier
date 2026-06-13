<x-layouts.app title="Каталог моделей">
    <section class="grid grid-cols-[minmax(0,1fr)_320px] gap-8 border-b border-[#e3d4da] pb-10 pt-5 max-[920px]:grid-cols-1">
        <div>
            <p class="section-kicker m-0">Каталог</p>
            <h1 class="section-title mt-3">Фасоны для индивидуального заказа</h1>
            <p class="section-copy mt-5">Выберите основу изделия, а в заказе уточните материал, посадку, срочность, мерки и пожелания к деталям.</p>
        </div>
        <div class="atelier-shell self-end p-5">
            <p class="m-0 text-sm font-bold text-[#8a6875]">Доступно для заказа</p>
            <strong class="atelier-serif mt-2 block text-6xl leading-none text-[#5a1839]">{{ $models->total() }}</strong>
            <p class="m-0 mt-2 text-sm leading-6 text-[#6f5b66]">моделей с предварительным расчётом стоимости.</p>
        </div>
    </section>

    <div class="my-6 flex flex-wrap gap-2.5">
        @foreach ($categories as $category)
            <span class="rounded-full border border-[#e3d4da] bg-[#fffdfb] px-3.5 py-2 text-sm font-bold text-[#6f5b66]">{{ $category->name }}</span>
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
