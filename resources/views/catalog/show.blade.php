<x-layouts.app :title="$model->name">
    <section class="grid grid-cols-[minmax(280px,.92fr)_minmax(0,1.08fr)] items-center gap-10 py-8 max-[920px]:grid-cols-1">
        <div class="atelier-card grid min-h-[520px] place-items-center overflow-hidden bg-slate-50 text-6xl font-black text-slate-300 max-[920px]:min-h-[380px]">
            @if ($model->image_path)
                <img class="h-full w-full object-cover" src="{{ asset($model->image_path) }}" alt="{{ $model->name }}">
            @else
                {{ mb_substr($model->name, 0, 1) }}
            @endif
        </div>
        <div>
            <span class="eyebrow">{{ $model->category->name }}</span>
            <h1 class="mt-4 mb-3 text-[clamp(38px,5vw,64px)] font-black leading-[.98] tracking-normal">{{ $model->name }}</h1>
            <p class="section-copy">{{ $model->description }}</p>
            <dl class="my-7 grid overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm shadow-slate-950/[.03]">
                <div class="flex justify-between gap-4 border-b border-slate-200 px-4 py-4"><dt class="font-semibold text-slate-500">Базовая цена</dt><dd class="m-0 text-right font-extrabold"><x-price :value="$model->base_price" /></dd></div>
                <div class="flex justify-between gap-4 border-b border-slate-200 px-4 py-4"><dt class="font-semibold text-slate-500">Сложность по умолчанию</dt><dd class="m-0 text-right font-extrabold">{{ $model->default_complexity->label() }}</dd></div>
                <div class="flex justify-between gap-4 px-4 py-4"><dt class="font-semibold text-slate-500">Оценка срока</dt><dd class="m-0 text-right font-extrabold">{{ $model->estimated_days }} дн.</dd></div>
            </dl>
            <div class="flex flex-wrap items-center gap-3">
                @auth
                    @if (auth()->user()->role === \App\Enums\UserRole::Customer)
                        <a class="btn btn-primary min-h-12 px-5" href="{{ route('orders.create', ['model' => $model->id]) }}">Создать заказ</a>
                    @endif
                @else
                    <a class="btn btn-primary min-h-12 px-5" href="{{ route('login') }}">Войти для заказа</a>
                @endauth
                <a class="btn btn-secondary min-h-12 px-5" href="{{ route('catalog.index') }}">Назад в каталог</a>
            </div>
        </div>
    </section>
</x-layouts.app>
