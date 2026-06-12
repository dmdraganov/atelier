<x-layouts.app title="Ателье">
    <section class="grid min-h-[calc(100vh-136px)] grid-cols-[minmax(0,1.02fr)_minmax(340px,.98fr)] items-center gap-12 py-8 max-[880px]:min-h-0 max-[880px]:grid-cols-1">
        <div class="max-w-[680px]">
            <h1 class="m-0 text-[clamp(42px,6vw,82px)] font-semibold leading-[.94] tracking-normal text-slate-950">Индивидуальный пошив одежды</h1>
            <p class="mt-6 max-w-[620px] text-[18px] leading-8 text-slate-600">Выберите модель, материал и параметры изделия. Мы рассчитаем предварительную стоимость, а администратор уточнит финальную цену после просмотра заказа.</p>
            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a class="inline-flex min-h-12 items-center justify-center rounded-lg border border-slate-950 bg-slate-950 px-5 py-3 text-sm font-semibold text-white no-underline shadow-sm transition hover:bg-slate-800" href="{{ route('catalog.index') }}">Открыть каталог</a>
                @auth
                    @if (auth()->user()->role === \App\Enums\UserRole::Customer)
                        <a class="inline-flex min-h-12 items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-950 no-underline transition hover:border-slate-950" href="{{ route('orders.create') }}">Создать заказ</a>
                    @endif
                @else
                    <a class="inline-flex min-h-12 items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-950 no-underline transition hover:border-slate-950" href="{{ route('register') }}">Зарегистрироваться</a>
                @endauth
            </div>
            <dl class="mt-12 grid max-w-[620px] grid-cols-3 gap-5 border-y border-slate-200 py-6 max-[560px]:grid-cols-1">
                <div>
                    <dt class="text-sm text-slate-500">Формат</dt>
                    <dd class="m-0 mt-1 font-semibold text-slate-950">индивидуальный заказ</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">Стоимость</dt>
                    <dd class="m-0 mt-1 font-semibold text-slate-950">расчёт до отправки</dd>
                </div>
                <div>
                    <dt class="text-sm text-slate-500">Контроль</dt>
                    <dd class="m-0 mt-1 font-semibold text-slate-950">проверка администратором</dd>
                </div>
            </dl>
        </div>
        <div class="relative min-h-[560px] overflow-hidden rounded-lg border border-slate-200 bg-slate-100 max-[880px]:min-h-[420px]">
            <div class="absolute inset-0 grid grid-cols-2 gap-px bg-slate-200">
                @foreach ($models->take(4) as $model)
                    <div class="grid place-items-center overflow-hidden bg-gradient-to-br from-slate-100 to-amber-100">
                        @if ($model->image_path)
                            <img class="h-full w-full object-cover" src="{{ asset($model->image_path) }}" alt="{{ $model->name }}">
                        @else
                            <span class="text-7xl font-semibold text-slate-300">{{ mb_substr($model->name, 0, 1) }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="absolute bottom-5 left-5 right-5 rounded-lg border border-white/70 bg-white/90 p-5 shadow-xl shadow-slate-950/10 backdrop-blur">
                <div class="flex items-start justify-between gap-5 max-[560px]:flex-col">
                    <div>
                        <p class="m-0 text-sm font-medium text-slate-500">Популярная услуга</p>
                        <h2 class="mb-0 mt-1 text-2xl font-semibold text-slate-950">{{ $models->first()?->name ?? 'Классическое платье' }}</h2>
                    </div>
                    <div class="text-right max-[560px]:text-left">
                        <p class="m-0 text-sm text-slate-500">от</p>
                        <strong class="text-2xl"><x-price :value="$models->first()?->base_price ?? 12000" /></strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-y border-slate-200 py-12">
        <div class="grid grid-cols-3 gap-6 max-[880px]:grid-cols-1">
            <div>
                <span class="text-sm font-semibold text-amber-700">01</span>
                <h2 class="mb-2 mt-3 text-xl">Выберите модель</h2>
                <p class="m-0 leading-7 text-slate-600">Каталог задаёт базовую цену, срок и уровень сложности.</p>
            </div>
            <div>
                <span class="text-sm font-semibold text-amber-700">02</span>
                <h2 class="mb-2 mt-3 text-xl">Добавьте параметры</h2>
                <p class="m-0 leading-7 text-slate-600">Материал, срочность, мерки, комментарий и референсы.</p>
            </div>
            <div>
                <span class="text-sm font-semibold text-amber-700">03</span>
                <h2 class="mb-2 mt-3 text-xl">Получите уточнение</h2>
                <p class="m-0 leading-7 text-slate-600">Администратор проверяет заказ и фиксирует финальную цену.</p>
            </div>
        </div>
    </section>

    <section class="py-14">
        <div class="mb-7 flex items-end justify-between gap-5 max-[560px]:items-start">
            <div>
                <h2 class="m-0 text-[clamp(30px,4vw,48px)] font-semibold leading-tight">Популярные модели</h2>
                <p class="mt-3 max-w-[560px] leading-7 text-slate-600">Базовые услуги ателье с ориентировочной стоимостью и сроком пошива.</p>
            </div>
            <a class="inline-flex min-h-11 shrink-0 items-center justify-center rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-950 no-underline transition hover:border-slate-950" href="{{ route('catalog.index') }}">Все модели</a>
        </div>
        <div class="grid grid-cols-3 gap-5 max-[880px]:grid-cols-1">
            @foreach ($models as $model)
                @include('catalog.partials.card', ['model' => $model])
            @endforeach
        </div>
    </section>
</x-layouts.app>
