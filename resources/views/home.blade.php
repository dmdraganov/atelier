<x-layouts.app title="Ателье">
    <section class="grid grid-cols-[minmax(0,1.25fr)_minmax(280px,.75fr)] items-stretch gap-8 py-12 pb-10 max-[880px]:grid-cols-1">
        <div>
            <h1 class="m-0 text-[clamp(34px,5vw,64px)] leading-none">Индивидуальный пошив одежды</h1>
            <p class="max-w-[720px] text-lg leading-relaxed text-slate-600">Выберите модель, материал и параметры изделия. Система рассчитает предварительную стоимость, а администратор уточнит финальную цену после просмотра заказа.</p>
            <div class="flex flex-wrap items-center gap-3">
                <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-900 bg-slate-900 px-4 py-2.5 font-semibold text-white no-underline" href="{{ route('catalog.index') }}">Открыть каталог</a>
                @auth
                    @if (auth()->user()->role === \App\Enums\UserRole::Customer)
                        <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-900 bg-transparent px-4 py-2.5 font-semibold text-slate-900 no-underline" href="{{ route('orders.create') }}">Создать заказ</a>
                    @endif
                @else
                    <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-900 bg-transparent px-4 py-2.5 font-semibold text-slate-900 no-underline" href="{{ route('register') }}">Зарегистрироваться</a>
                @endauth
            </div>
        </div>
        <div class="grid gap-3.5 rounded-lg border border-slate-200 bg-white p-5">
            <div class="flex items-baseline justify-between gap-4 border-b border-slate-200 py-4"><span class="text-5xl font-bold">3</span><small>роли в системе</small></div>
            <div class="flex items-baseline justify-between gap-4 border-b border-slate-200 py-4"><span class="text-5xl font-bold">5</span><small>статусов заказа</small></div>
            <div class="flex items-baseline justify-between gap-4 py-4"><span class="text-5xl font-bold">1</span><small>центральный калькулятор</small></div>
        </div>
    </section>

    <section class="py-6">
        <div class="flex items-center justify-between gap-5">
            <h2 class="mb-4 mt-0">Популярные модели</h2>
            <a class="text-inherit no-underline" href="{{ route('catalog.index') }}">Все модели</a>
        </div>
        <div class="grid grid-cols-3 gap-4 max-[880px]:grid-cols-1">
            @foreach ($models as $model)
                @include('catalog.partials.card', ['model' => $model])
            @endforeach
        </div>
    </section>
</x-layouts.app>
