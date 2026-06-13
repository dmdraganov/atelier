<article class="atelier-card group overflow-hidden transition hover:border-[#d8b37a] hover:shadow-2xl hover:shadow-[#5a1839]/10">
    <div class="grid aspect-[4/3] place-items-center overflow-hidden bg-[#f4e6ea] text-6xl font-black text-[#b86b7a]">
        @if ($model->image_path)
            <img class="h-full w-full object-cover transition duration-300 group-hover:opacity-92 motion-reduce:transition-none" src="{{ asset($model->image_path) }}" alt="{{ $model->name }}">
        @else
            <span class="atelier-serif">{{ mb_substr($model->name, 0, 1) }}</span>
        @endif
    </div>
    <div class="p-5">
        <div class="flex items-start justify-between gap-3">
            <span class="section-kicker">{{ $model->category->name }}</span>
            <span class="shrink-0 rounded-full bg-[#f3dbe0] px-3 py-1.5 text-xs font-black text-[#5a1839]">{{ $model->estimated_days }} дн.</span>
        </div>
        <h3 class="atelier-serif my-3 text-3xl leading-none text-[#3d1028]">{{ $model->name }}</h3>
        <p class="line-clamp-3 min-h-[84px] leading-7 text-[#6f5b66]">{{ $model->description }}</p>
        <div class="my-5 flex items-center justify-between gap-3 border-t border-[#e3d4da] pt-4 text-sm">
            <span class="font-bold text-[#8a6875]">Базовая стоимость</span>
            <strong class="text-base text-[#3d1028]">от <x-price :value="$model->base_price" /></strong>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a class="btn btn-secondary" href="{{ route('catalog.show', $model) }}">Подробнее</a>
            @auth
                @if (auth()->user()->role === \App\Enums\UserRole::Customer)
                    <a class="btn btn-primary" href="{{ route('orders.create', ['model' => $model->id]) }}">Заказать</a>
                @endif
            @else
                <a class="btn btn-primary" href="{{ route('login') }}">Войти</a>
            @endauth
        </div>
    </div>
</article>
