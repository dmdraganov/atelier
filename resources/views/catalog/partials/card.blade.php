<article class="overflow-hidden rounded-lg border border-slate-200 bg-white">
    <div class="grid aspect-[16/10] place-items-center overflow-hidden bg-gradient-to-br from-slate-800 to-amber-700 text-6xl font-bold text-white">
        @if ($model->image_path)
            <img class="h-full w-full object-cover" src="{{ asset($model->image_path) }}" alt="{{ $model->name }}">
        @else
            {{ mb_substr($model->name, 0, 1) }}
        @endif
    </div>
    <div class="p-4">
        <span class="text-sm text-slate-500">{{ $model->category->name }}</span>
        <h3 class="my-2 text-xl">{{ $model->name }}</h3>
        <p class="leading-relaxed text-slate-600">{{ $model->description }}</p>
        <div class="my-4 flex justify-between gap-3">
            <strong>от <x-price :value="$model->base_price" /></strong>
            <span>{{ $model->estimated_days }} дн.</span>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-900 bg-transparent px-4 py-2.5 font-semibold text-slate-900 no-underline" href="{{ route('catalog.show', $model) }}">Подробнее</a>
            @auth
                @if (auth()->user()->role === \App\Enums\UserRole::Customer)
                    <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-900 bg-slate-900 px-4 py-2.5 font-semibold text-white no-underline" href="{{ route('orders.create', ['model' => $model->id]) }}">Заказать</a>
                @endif
            @else
                <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-900 bg-slate-900 px-4 py-2.5 font-semibold text-white no-underline" href="{{ route('login') }}">Войти</a>
            @endauth
        </div>
    </div>
</article>
