<x-layouts.app :title="$order->order_number">
    <section class="flex items-start justify-between gap-5 border-b border-slate-200 py-6 max-[920px]:flex-col">
        <div>
            <span class="eyebrow">Детали заказа</span>
            <h1 class="section-title mt-4">Заказ {{ $order->order_number }}</h1>
            <p class="section-copy mt-4">{{ $order->clothingModel->name }} · {{ $order->material->name }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <x-status-badge :status="$order->status" />
            <a class="btn btn-secondary" href="{{ route('orders.index') }}">К списку</a>
        </div>
    </section>

    <section class="mt-6 grid grid-cols-[minmax(0,1fr)_minmax(280px,.72fr)] gap-5 max-[920px]:grid-cols-1">
        <div class="grid gap-5">
            <div class="atelier-card p-5">
                <h2 class="mb-4 mt-0 text-2xl font-extrabold">Комментарий</h2>
                <p class="m-0 leading-7 text-slate-600">{{ $order->customer_comment ?: 'Комментарий не указан.' }}</p>
                @if ($order->admin_comment)
                    <p class="mt-4 rounded-lg border border-teal-100 bg-teal-50 px-4 py-3 text-sm font-semibold leading-6 text-teal-900">Комментарий администратора: {{ $order->admin_comment }}</p>
                @endif
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

        <aside class="grid gap-5">
            <div class="rounded-lg border border-slate-900 bg-slate-950 p-5 text-white shadow-2xl shadow-slate-950/20">
                <h2 class="mb-4 mt-0 text-2xl font-extrabold">Стоимость</h2>
                <dl class="grid gap-3">
                    <div class="flex justify-between gap-4 border-b border-white/10 pb-3"><dt class="text-slate-300">Предварительно</dt><dd class="m-0 text-right font-extrabold"><x-price :value="$order->preliminary_price" /></dd></div>
                    <div class="flex justify-between gap-4 border-b border-white/10 pb-3"><dt class="text-slate-300">Финальная цена</dt><dd class="m-0 text-right font-extrabold">@if($order->final_price)<x-price :value="$order->final_price" />@else Не назначена @endif</dd></div>
                    <div class="flex justify-between gap-4 border-b border-white/10 pb-3"><dt class="text-slate-300">Количество</dt><dd class="m-0 text-right font-extrabold">{{ $order->quantity }}</dd></div>
                    <div class="flex justify-between gap-4 border-b border-white/10 pb-3"><dt class="text-slate-300">Сложность</dt><dd class="m-0 text-right font-extrabold">{{ $order->complexity->label() }}</dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-slate-300">Срочность</dt><dd class="m-0 text-right font-extrabold">{{ $order->urgency->label() }}</dd></div>
                </dl>
            </div>

            @can('cancel', $order)
                <form class="atelier-card p-5" method="post" action="{{ route('orders.cancel', $order) }}" data-confirm="Отменить заказ?">
                    @csrf
                    @method('patch')
                    <h2 class="mb-2 mt-0 text-xl font-extrabold">Отмена заказа</h2>
                    <p class="mt-0 text-sm leading-6 text-slate-600">Отменить можно только до начала производства.</p>
                    <button class="btn btn-danger w-full" type="submit">Отменить заказ</button>
                </form>
            @endcan
        </aside>
    </section>
</x-layouts.app>
