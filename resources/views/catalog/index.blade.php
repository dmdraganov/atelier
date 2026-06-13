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

    <nav class="my-6 flex flex-wrap gap-2.5" aria-label="Фильтр каталога по категориям">
        <a
            class="rounded-full border px-3.5 py-2 text-sm font-bold no-underline transition hover:border-[#b9852f] hover:text-[#3d1028] {{ $activeCategory ? 'border-[#e3d4da] bg-[#fffdfb] text-[#6f5b66]' : 'border-[#5a1839] bg-[#5a1839] text-white' }}"
            href="{{ route('catalog.index') }}"
        >Все</a>
        @foreach ($categories as $category)
            <a
                class="rounded-full border px-3.5 py-2 text-sm font-bold no-underline transition hover:border-[#b9852f] hover:text-[#3d1028] {{ $activeCategory?->is($category) ? 'border-[#5a1839] bg-[#5a1839] text-white' : 'border-[#e3d4da] bg-[#fffdfb] text-[#6f5b66]' }}"
                href="{{ route('catalog.index', ['category' => $category->slug]) }}"
            >{{ $category->name }}</a>
        @endforeach
    </nav>

    <section class="grid grid-cols-3 gap-5 max-[920px]:grid-cols-1">
        @forelse ($models as $model)
            @include('catalog.partials.card', ['model' => $model])
        @empty
            <div class="atelier-shell col-span-full p-6">
                <p class="m-0 font-bold text-[#3d1028]">В этой категории пока нет активных моделей.</p>
            </div>
        @endforelse
    </section>

    <div class="mt-8">
        {{ $models->links() }}
    </div>
</x-layouts.app>
