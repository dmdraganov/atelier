<x-layouts.app title="Ателье">
    <section class="grid min-h-[calc(100vh-180px)] grid-cols-[minmax(0,1.02fr)_minmax(340px,.98fr)] items-center gap-10 py-6 max-[1080px]:min-h-0 max-[1080px]:grid-cols-1">
        <div class="max-w-[680px] min-w-0">
            <span class="eyebrow">Учебная система ателье</span>
            <h1 class="mt-5 mb-0 max-w-[680px] text-[clamp(36px,4.8vw,64px)] font-black leading-[.98] tracking-normal text-slate-950">Индивидуальный пошив одежды</h1>
            <p class="section-copy mt-6">Выберите модель, материал и параметры изделия. Система покажет предварительную стоимость, сохранит мерки и поможет отслеживать заказ до завершения.</p>
            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a class="btn btn-primary min-h-12 px-5" href="{{ route('catalog.index') }}">Открыть каталог</a>
                @auth
                    @if (auth()->user()->role === \App\Enums\UserRole::Customer)
                        <a class="btn btn-secondary min-h-12 px-5" href="{{ route('orders.create') }}">Создать заказ</a>
                    @endif
                @else
                    <a class="btn btn-secondary min-h-12 px-5" href="{{ route('register') }}">Зарегистрироваться</a>
                @endauth
            </div>
            <dl class="mt-10 grid max-w-[680px] grid-cols-3 gap-5 border-y border-slate-200 py-6 max-[640px]:grid-cols-1">
                <div class="metric-card">
                    <dt class="text-sm font-semibold text-slate-500">Каталог</dt>
                    <dd class="m-0 mt-1 text-lg font-extrabold text-slate-950">{{ $models->count() }} моделей</dd>
                </div>
                <div class="metric-card">
                    <dt class="text-sm font-semibold text-slate-500">Цена</dt>
                    <dd class="m-0 mt-1 text-lg font-extrabold text-slate-950">расчёт до отправки</dd>
                </div>
                <div class="metric-card">
                    <dt class="text-sm font-semibold text-slate-500">Статусы</dt>
                    <dd class="m-0 mt-1 text-lg font-extrabold text-slate-950">история заказов</dd>
                </div>
            </dl>
        </div>

        <div class="atelier-card relative min-h-[560px] overflow-hidden bg-slate-100 max-[920px]:min-h-[420px]">
            <div class="absolute inset-0 grid grid-cols-2 gap-px bg-slate-200">
                @foreach ($models->take(4) as $model)
                    <div class="grid place-items-center overflow-hidden bg-slate-50">
                        @if ($model->image_path)
                            <img class="h-full w-full object-cover" src="{{ asset($model->image_path) }}" alt="{{ $model->name }}">
                        @else
                            <span class="text-7xl font-black text-slate-300">{{ mb_substr($model->name, 0, 1) }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="absolute bottom-5 left-5 right-5 rounded-lg border border-white/80 bg-white/95 p-5 shadow-2xl shadow-slate-950/15 backdrop-blur">
                <div class="flex items-start justify-between gap-5 max-[560px]:flex-col">
                    <div>
                        <p class="m-0 text-sm font-bold text-teal-700">Популярная модель</p>
                        <h2 class="mb-0 mt-1 text-2xl font-extrabold text-slate-950">{{ $models->first()?->name ?? 'Классическое платье' }}</h2>
                    </div>
                    <div class="text-right max-[560px]:text-left">
                        <p class="m-0 text-sm font-semibold text-slate-500">от</p>
                        <strong class="text-2xl"><x-price :value="$models->first()?->base_price ?? 12000" /></strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="grid grid-cols-3 gap-4 border-y border-slate-200 py-12 max-[920px]:grid-cols-1">
        <div class="atelier-card-subtle p-5">
            <span class="text-sm font-extrabold text-teal-700">01</span>
            <h2 class="mb-2 mt-3 text-xl font-extrabold">Выберите модель</h2>
            <p class="m-0 leading-7 text-slate-600">Каталог задаёт базовую цену, срок и уровень сложности для дальнейшего расчёта.</p>
        </div>
        <div class="atelier-card-subtle p-5">
            <span class="text-sm font-extrabold text-teal-700">02</span>
            <h2 class="mb-2 mt-3 text-xl font-extrabold">Добавьте параметры</h2>
            <p class="m-0 leading-7 text-slate-600">Материал, срочность, мерки, комментарий и референсы сохраняются в заказе.</p>
        </div>
        <div class="atelier-card-subtle p-5">
            <span class="text-sm font-extrabold text-teal-700">03</span>
            <h2 class="mb-2 mt-3 text-xl font-extrabold">Следите за статусом</h2>
            <p class="m-0 leading-7 text-slate-600">Администратор уточняет финальную цену, мастер видит назначенные ему заказы.</p>
        </div>
    </section>

    <section class="py-14">
        <div class="mb-7 flex items-end justify-between gap-5 max-[640px]:items-start">
            <div>
                <span class="eyebrow">Каталог</span>
                <h2 class="section-title mt-4">Популярные модели</h2>
                <p class="section-copy mt-3">Базовые услуги ателье с ориентировочной стоимостью и сроком пошива.</p>
            </div>
            <a class="btn btn-secondary shrink-0" href="{{ route('catalog.index') }}">Все модели</a>
        </div>
        <div class="grid grid-cols-3 gap-5 max-[920px]:grid-cols-1">
            @foreach ($models as $model)
                @include('catalog.partials.card', ['model' => $model])
            @endforeach
        </div>
    </section>
</x-layouts.app>
