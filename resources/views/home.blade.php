<x-layouts.app title="Atelier — индивидуальный пошив">
    <section class="grid min-h-[calc(100vh-170px)] grid-cols-[minmax(0,.92fr)_minmax(420px,1.08fr)] items-center gap-10 py-6 max-[1080px]:min-h-0 max-[1080px]:grid-cols-1">
        <div class="max-w-[640px]">
            <h1 class="atelier-serif m-0 text-[clamp(44px,6vw,86px)] leading-[.9] text-[#3d1028]">Одежда, сшитая под вашу посадку</h1>
            <p class="mt-6 max-w-[590px] text-[18px] leading-8 text-[#6f5b66]">Создаём изделия по вашим меркам, дорабатываем посадку готовой одежды и помогаем подобрать материал под силуэт, сезон и повод.</p>
            <div class="mt-8 flex flex-wrap items-center gap-3">
                @auth
                    @if (auth()->user()->role === \App\Enums\UserRole::Customer)
                        <a class="btn btn-primary min-h-12 px-5" href="{{ route('orders.create') }}">Оформить заказ</a>
                    @endif
                @else
                    <a class="btn btn-primary min-h-12 px-5" href="{{ route('register') }}">Записаться</a>
                @endauth
                <a class="btn btn-secondary min-h-12 px-5" href="{{ route('catalog.index') }}">Смотреть каталог</a>
            </div>
            <div class="mt-10 grid grid-cols-3 gap-5 border-y border-[#e3d4da] py-6 max-[680px]:grid-cols-1">
                <div class="metric-card">
                    <p class="m-0 text-sm font-bold text-[#8a6875]">Пошив</p>
                    <p class="m-0 mt-1 text-lg font-black text-[#3d1028]">платья, костюмы, рубашки</p>
                </div>
                <div class="metric-card">
                    <p class="m-0 text-sm font-bold text-[#8a6875]">Посадка</p>
                    <p class="m-0 mt-1 text-lg font-black text-[#3d1028]">коррекция по фигуре</p>
                </div>
                <div class="metric-card">
                    <p class="m-0 text-sm font-bold text-[#8a6875]">Материалы</p>
                    <p class="m-0 mt-1 text-lg font-black text-[#3d1028]">подбор ткани и деталей</p>
                </div>
            </div>
        </div>

        <div class="grid min-h-[590px] grid-cols-[1fr_.72fr] gap-4 max-[680px]:min-h-0 max-[680px]:grid-cols-1">
            <div class="atelier-shell overflow-hidden bg-[#f8eef1]">
                @if ($models->first()?->image_path)
                    <img class="h-full min-h-[590px] w-full object-cover max-[680px]:min-h-[360px]" src="{{ asset($models->first()->image_path) }}" alt="{{ $models->first()->name }}">
                @endif
            </div>
            <div class="grid gap-4">
                @foreach ($models->skip(1)->take(2) as $model)
                    <a class="atelier-card group overflow-hidden no-underline" href="{{ route('catalog.show', $model) }}">
                        <div class="grid aspect-[4/3] place-items-center overflow-hidden bg-[#f4e6ea]">
                            @if ($model->image_path)
                                <img class="h-full w-full object-cover transition duration-300 group-hover:opacity-90" src="{{ asset($model->image_path) }}" alt="{{ $model->name }}">
                            @else
                                <span class="atelier-serif text-6xl text-[#b86b7a]">{{ mb_substr($model->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <p class="m-0 text-xs font-black uppercase tracking-[.08em] text-[#b9852f]">{{ $model->category->name }}</p>
                            <h2 class="m-0 mt-1 text-lg font-black text-[#3d1028]">{{ $model->name }}</h2>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section id="services" class="py-16">
        <div class="grid grid-cols-[.7fr_1fr] gap-10 max-[920px]:grid-cols-1">
            <div>
                <p class="section-kicker m-0">Услуги</p>
                <h2 class="section-title mt-3">От идеи до точной посадки</h2>
                <p class="section-copy mt-5">Мы не ограничиваем заказ одной моделью: можно сшить изделие с нуля, адаптировать базовый фасон или доработать готовую вещь.</p>
            </div>
            <div class="atelier-shell p-6">
                @foreach ($tailoringServices as $service)
                    <article class="service-panel grid grid-cols-[220px_1fr] gap-6 max-[640px]:grid-cols-1">
                        <h3 class="m-0 text-xl font-black text-[#3d1028]">{{ $service->name }}</h3>
                        <p class="m-0 leading-7 text-[#6f5b66]">{{ $service->description }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="process" class="grid grid-cols-4 gap-4 border-y border-[#e3d4da] py-14 max-[920px]:grid-cols-2 max-[560px]:grid-cols-1">
        @foreach ([
            ['01', 'Выберите основу', 'Каталог помогает быстро определить фасон и базовую стоимость.'],
            ['02', 'Заполните бриф', 'Укажите материал, мерки, срочность, детали и приложите референсы.'],
            ['03', 'Получите оценку', 'Система покажет предварительную цену, администратор уточнит итог после просмотра.'],
            ['04', 'Следите за заказом', 'В личном кабинете сохраняются статусы, цены и детали заказа.'],
        ] as [$number, $title, $description])
            <article class="atelier-card-subtle p-5">
                <span class="font-serif text-3xl font-semibold text-[#b9852f]">{{ $number }}</span>
                <h3 class="mb-2 mt-4 text-xl font-black text-[#3d1028]">{{ $title }}</h3>
                <p class="m-0 leading-7 text-[#6f5b66]">{{ $description }}</p>
            </article>
        @endforeach
    </section>

    <section class="py-16">
        <div class="mb-7 flex items-end justify-between gap-5 max-[640px]:items-start">
            <div>
                <p class="section-kicker m-0">Каталог</p>
                <h2 class="section-title mt-3">Популярные основы</h2>
                <p class="section-copy mt-3">Модели задают стартовую точку: фасон, сложность, срок и базовую стоимость.</p>
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
