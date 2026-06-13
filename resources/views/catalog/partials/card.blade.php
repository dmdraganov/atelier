<article class="atelier-card group overflow-hidden transition hover:border-teal-200 hover:shadow-2xl hover:shadow-slate-950/[.08]">
    <div class="grid aspect-[4/3] place-items-center overflow-hidden bg-slate-50 text-6xl font-black text-slate-300">
        @if ($model->image_path)
            <img class="h-full w-full object-cover transition duration-300 group-hover:opacity-95 motion-reduce:transition-none" src="{{ asset($model->image_path) }}" alt="{{ $model->name }}">
        @else
            {{ mb_substr($model->name, 0, 1) }}
        @endif
    </div>
    <div class="p-5">
        <div class="flex items-start justify-between gap-3">
            <span class="eyebrow">{{ $model->category->name }}</span>
            <span class="shrink-0 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-600">{{ $model->estimated_days }} дн.</span>
        </div>
        <h3 class="my-3 text-xl font-extrabold text-slate-950">{{ $model->name }}</h3>
        <p class="line-clamp-3 min-h-[84px] leading-7 text-slate-600">{{ $model->description }}</p>
        <div class="my-5 flex items-center justify-between gap-3 border-t border-slate-200 pt-4 text-sm">
            <span class="font-semibold text-slate-500">Базовая цена</span>
            <strong class="text-base text-slate-950">от <x-price :value="$model->base_price" /></strong>
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
