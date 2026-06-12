<x-layouts.app :title="$model->name">
    <section class="grid grid-cols-[minmax(280px,.9fr)_minmax(0,1.1fr)] items-stretch gap-8 py-7 max-[880px]:grid-cols-1">
        <div class="grid min-h-[420px] place-items-center overflow-hidden rounded-lg bg-gradient-to-br from-slate-800 to-amber-700 text-6xl font-bold text-white">
            @if ($model->image_path)
                <img class="h-full w-full object-cover" src="{{ asset($model->image_path) }}" alt="{{ $model->name }}">
            @else
                {{ mb_substr($model->name, 0, 1) }}
            @endif
        </div>
        <div class="detail-content">
            <span class="text-sm text-slate-500">{{ $model->category->name }}</span>
            <h1 class="my-2.5 text-[clamp(32px,5vw,56px)] leading-none">{{ $model->name }}</h1>
            <p class="text-lg leading-relaxed text-slate-600">{{ $model->description }}</p>
            <dl class="my-5 grid gap-2.5">
                <div class="flex justify-between gap-4 border-b border-slate-200 pb-2.5"><dt class="text-slate-500">Базовая цена</dt><dd class="m-0 text-right font-semibold"><x-price :value="$model->base_price" /></dd></div>
                <div class="flex justify-between gap-4 border-b border-slate-200 pb-2.5"><dt class="text-slate-500">Сложность по умолчанию</dt><dd class="m-0 text-right font-semibold">{{ $model->default_complexity->label() }}</dd></div>
                <div class="flex justify-between gap-4 border-b border-slate-200 pb-2.5"><dt class="text-slate-500">Оценка срока</dt><dd class="m-0 text-right font-semibold">{{ $model->estimated_days }} дн.</dd></div>
            </dl>
            <div class="flex flex-wrap items-center gap-3">
                @auth
                    @if (auth()->user()->role === \App\Enums\UserRole::Customer)
                        <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-900 bg-slate-900 px-4 py-2.5 font-semibold text-white no-underline" href="{{ route('orders.create', ['model' => $model->id]) }}">Создать заказ</a>
                    @endif
                @else
                    <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-900 bg-slate-900 px-4 py-2.5 font-semibold text-white no-underline" href="{{ route('login') }}">Войти для заказа</a>
                @endauth
                <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-900 bg-transparent px-4 py-2.5 font-semibold text-slate-900 no-underline" href="{{ route('catalog.index') }}">Назад в каталог</a>
            </div>
        </div>
    </section>
</x-layouts.app>
