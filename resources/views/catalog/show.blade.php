<x-layouts.app :title="$model->name">
    <section class="grid grid-cols-[minmax(280px,.92fr)_minmax(0,1.08fr)] items-center gap-10 py-8 max-[880px]:grid-cols-1">
        <div class="grid min-h-[520px] place-items-center overflow-hidden rounded-lg border border-slate-200 bg-gradient-to-br from-slate-100 to-amber-100 text-6xl font-semibold text-slate-300 max-[880px]:min-h-[380px]">
            @if ($model->image_path)
                <img class="h-full w-full object-cover" src="{{ asset($model->image_path) }}" alt="{{ $model->name }}">
            @else
                {{ mb_substr($model->name, 0, 1) }}
            @endif
        </div>
        <div>
            <span class="text-sm font-semibold text-amber-700">{{ $model->category->name }}</span>
            <h1 class="my-3 text-[clamp(38px,5vw,64px)] font-semibold leading-[.98]">{{ $model->name }}</h1>
            <p class="text-lg leading-8 text-slate-600">{{ $model->description }}</p>
            <dl class="my-7 grid gap-0 overflow-hidden rounded-lg border border-slate-200">
                <div class="flex justify-between gap-4 border-b border-slate-200 bg-white px-4 py-3.5"><dt class="text-slate-500">Базовая цена</dt><dd class="m-0 text-right font-semibold"><x-price :value="$model->base_price" /></dd></div>
                <div class="flex justify-between gap-4 border-b border-slate-200 bg-white px-4 py-3.5"><dt class="text-slate-500">Сложность по умолчанию</dt><dd class="m-0 text-right font-semibold">{{ $model->default_complexity->label() }}</dd></div>
                <div class="flex justify-between gap-4 bg-white px-4 py-3.5"><dt class="text-slate-500">Оценка срока</dt><dd class="m-0 text-right font-semibold">{{ $model->estimated_days }} дн.</dd></div>
            </dl>
            <div class="flex flex-wrap items-center gap-3">
                @auth
                    @if (auth()->user()->role === \App\Enums\UserRole::Customer)
                        <a class="inline-flex min-h-12 items-center justify-center rounded-lg border border-slate-950 bg-slate-950 px-5 py-3 text-sm font-semibold text-white no-underline transition hover:bg-slate-800" href="{{ route('orders.create', ['model' => $model->id]) }}">Создать заказ</a>
                    @endif
                @else
                    <a class="inline-flex min-h-12 items-center justify-center rounded-lg border border-slate-950 bg-slate-950 px-5 py-3 text-sm font-semibold text-white no-underline transition hover:bg-slate-800" href="{{ route('login') }}">Войти для заказа</a>
                @endauth
                <a class="inline-flex min-h-12 items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-950 no-underline transition hover:border-slate-950" href="{{ route('catalog.index') }}">Назад в каталог</a>
            </div>
        </div>
    </section>
</x-layouts.app>
