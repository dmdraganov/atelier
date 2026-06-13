<x-layouts.app :title="$model->name">
    <section class="grid grid-cols-[minmax(280px,.92fr)_minmax(0,1.08fr)] items-center gap-10 py-8 max-[920px]:grid-cols-1">
        <div class="atelier-shell grid min-h-[540px] place-items-center overflow-hidden bg-[#f4e6ea] text-6xl font-black text-[#b86b7a] max-[920px]:min-h-[380px]">
            @if ($model->image_path)
                <img class="h-full w-full object-cover" src="{{ asset($model->image_path) }}" alt="{{ $model->name }}">
            @else
                <span class="atelier-serif">{{ mb_substr($model->name, 0, 1) }}</span>
            @endif
        </div>
        <div>
            <p class="section-kicker m-0">{{ $model->category->name }}</p>
            <h1 class="atelier-serif mt-3 mb-3 text-[clamp(44px,6vw,76px)] leading-[.9] text-[#3d1028]">{{ $model->name }}</h1>
            <p class="section-copy">{{ $model->description }}</p>
            <dl class="my-7 grid overflow-hidden rounded-lg border border-[#e3d4da] bg-[#fffdfb] shadow-sm shadow-[#5a1839]/5">
                <div class="flex justify-between gap-4 border-b border-[#e3d4da] px-4 py-4"><dt class="font-bold text-[#8a6875]">Базовая стоимость</dt><dd class="m-0 text-right font-black"><x-price :value="$model->base_price" /></dd></div>
                <div class="flex justify-between gap-4 border-b border-[#e3d4da] px-4 py-4"><dt class="font-bold text-[#8a6875]">Базовая сложность</dt><dd class="m-0 text-right font-black">{{ $model->default_complexity->label() }}</dd></div>
                <div class="flex justify-between gap-4 px-4 py-4"><dt class="font-bold text-[#8a6875]">Ориентировочный срок</dt><dd class="m-0 text-right font-black">{{ $model->estimated_days }} дн.</dd></div>
            </dl>
            <div class="flex flex-wrap items-center gap-3">
                @auth
                    @if (auth()->user()->role === \App\Enums\UserRole::Customer)
                        <a class="btn btn-primary min-h-12 px-5" href="{{ route('orders.create', ['model' => $model->id]) }}">Оформить заказ</a>
                    @endif
                @else
                    <a class="btn btn-primary min-h-12 px-5" href="{{ route('login') }}">Войти для заказа</a>
                @endauth
                <a class="btn btn-secondary min-h-12 px-5" href="{{ route('catalog.index') }}">Назад в каталог</a>
            </div>
        </div>
    </section>
</x-layouts.app>
