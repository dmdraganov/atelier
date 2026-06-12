<article class="group overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm shadow-slate-950/[.03] transition hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-xl hover:shadow-slate-950/[.07]">
    <div class="grid aspect-[4/3] place-items-center overflow-hidden bg-gradient-to-br from-slate-100 to-amber-100 text-6xl font-semibold text-slate-300">
        @if ($model->image_path)
            <img class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]" src="{{ asset($model->image_path) }}" alt="{{ $model->name }}">
        @else
            {{ mb_substr($model->name, 0, 1) }}
        @endif
    </div>
    <div class="p-5">
        <span class="text-sm font-medium text-amber-700">{{ $model->category->name }}</span>
        <h3 class="my-2 text-xl font-semibold text-slate-950">{{ $model->name }}</h3>
        <p class="line-clamp-3 leading-7 text-slate-600">{{ $model->description }}</p>
        <div class="my-5 flex justify-between gap-3 border-t border-slate-200 pt-4 text-sm">
            <strong class="text-base text-slate-950">от <x-price :value="$model->base_price" /></strong>
            <span class="text-slate-500">{{ $model->estimated_days }} дн.</span>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-950 no-underline transition hover:border-slate-950" href="{{ route('catalog.show', $model) }}">Подробнее</a>
            @auth
                @if (auth()->user()->role === \App\Enums\UserRole::Customer)
                    <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-950 bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white no-underline transition hover:bg-slate-800" href="{{ route('orders.create', ['model' => $model->id]) }}">Заказать</a>
                @endif
            @else
                <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-950 bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white no-underline transition hover:bg-slate-800" href="{{ route('login') }}">Войти</a>
            @endauth
        </div>
    </div>
</article>
