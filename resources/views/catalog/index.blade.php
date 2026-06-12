<x-layouts.app title="Каталог">
    <section class="grid grid-cols-[minmax(0,1fr)_320px] gap-8 border-b border-slate-200 pb-10 pt-5 max-[880px]:grid-cols-1">
        <div>
            <h1 class="m-0 text-[clamp(40px,6vw,72px)] font-semibold leading-[.96]">Каталог моделей</h1>
            <p class="mt-5 max-w-[680px] text-lg leading-8 text-slate-600">Базовые услуги ателье с ориентировочными сроками и стартовой стоимостью. Выберите модель и переходите к оформлению заказа.</p>
        </div>
        <div class="self-end rounded-lg border border-slate-200 bg-slate-50 p-5">
            <p class="m-0 text-sm font-medium text-slate-500">В каталоге</p>
            <strong class="mt-2 block text-4xl">{{ $models->total() }}</strong>
            <p class="m-0 mt-2 text-sm leading-6 text-slate-600">активных моделей для предварительного расчёта.</p>
        </div>
    </section>

    <div class="my-6 flex flex-wrap gap-2.5">
        @foreach ($categories as $category)
            <span class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600">{{ $category->name }}</span>
        @endforeach
    </div>

    <section class="grid grid-cols-3 gap-5 max-[880px]:grid-cols-1">
        @foreach ($models as $model)
            @include('catalog.partials.card', ['model' => $model])
        @endforeach
    </section>

    <div class="mt-8">
        {{ $models->links() }}
    </div>
</x-layouts.app>
