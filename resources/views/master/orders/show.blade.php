<x-layouts.app :title="$order->order_number">
    <section class="flex items-start justify-between gap-5 border-b border-slate-200 py-6 max-[920px]:flex-col">
        <div>
            <span class="eyebrow">Заказ мастера</span>
            <h1 class="section-title mt-4">Заказ {{ $order->order_number }}</h1>
            <p class="section-copy mt-4">{{ $order->customer->name }} · {{ $order->customer->phone ?: $order->customer->email }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <x-status-badge :status="$order->status" />
            <a class="btn btn-secondary" href="{{ route('master.orders.index') }}">К списку</a>
        </div>
    </section>

    <section class="mt-6 grid grid-cols-[minmax(0,1fr)_minmax(280px,.72fr)] gap-5 max-[920px]:grid-cols-1">
        <div class="grid gap-5">
            <div class="atelier-card p-5">
                <h2 class="mb-4 mt-0 text-2xl font-extrabold">Комментарий клиента</h2>
                <p class="m-0 leading-7 text-slate-600">{{ $order->customer_comment ?: 'Комментарий не указан.' }}</p>
            </div>

            <div class="grid grid-cols-2 gap-5 max-[760px]:grid-cols-1">
                <div class="atelier-card p-5">
                    <h2 class="mb-4 mt-0 text-2xl font-extrabold">Мерки</h2>
                    @include('orders.partials.key-values', ['items' => $order->measurements])
                </div>
                <div class="atelier-card p-5">
                    <h2 class="mb-4 mt-0 text-2xl font-extrabold">Параметры</h2>
                    @include('orders.partials.key-values', ['items' => $order->parameters])
                </div>
            </div>

            <div class="atelier-card p-5">
                <h2 class="mb-4 mt-0 text-2xl font-extrabold">Референсы</h2>
                <div class="flex flex-wrap gap-2.5">
                    @forelse ($order->referenceImages as $image)
                        <a class="rounded-full border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-600 no-underline transition hover:border-teal-300 hover:text-teal-700" href="{{ Storage::url($image->file_path) }}" target="_blank" rel="noreferrer">{{ $image->original_name }}</a>
                    @empty
                        <p class="m-0 leading-relaxed text-slate-600">Изображения не загружены.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <aside class="atelier-card p-5">
            <h2 class="mb-4 mt-0 text-2xl font-extrabold">Изделие</h2>
            <dl class="grid">
                <div class="kv-row"><dt>Модель</dt><dd>{{ $order->clothingModel->name }}</dd></div>
                <div class="kv-row"><dt>Категория</dt><dd>{{ $order->clothingModel->category->name }}</dd></div>
                <div class="kv-row"><dt>Материал</dt><dd>{{ $order->material->name }}</dd></div>
                <div class="kv-row"><dt>Количество</dt><dd>{{ $order->quantity }}</dd></div>
                <div class="kv-row"><dt>Сложность</dt><dd>{{ $order->complexity->label() }}</dd></div>
                <div class="kv-row"><dt>Срочность</dt><dd>{{ $order->urgency->label() }}</dd></div>
            </dl>
        </aside>
    </section>
</x-layouts.app>
