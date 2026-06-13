<x-layouts.app :title="$order->order_number">
    <section class="flex items-start justify-between gap-5 border-b border-[#e3d4da] py-6 max-[920px]:flex-col">
        <div>
            <p class="section-kicker m-0">Детали заказа</p>
            <h1 class="section-title mt-3">Заказ {{ $order->order_number }}</h1>
            <p class="section-copy mt-4">{{ $order->clothingModel?->name ?? 'Модель не требуется' }} · {{ $order->tailoringService?->name ?? 'Услуга не указана' }} · {{ $order->material?->name ?? 'Материал не требуется' }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <x-status-badge :status="$order->status" />
            <a class="btn btn-secondary" href="{{ route('orders.index') }}">К списку</a>
        </div>
    </section>

    <section class="mt-6 grid grid-cols-[minmax(0,1fr)_minmax(280px,.72fr)] gap-5 max-[920px]:grid-cols-1">
        <div class="grid gap-5">
            <div class="atelier-card p-5">
                <h2 class="mb-4 mt-0 text-2xl font-black text-[#3d1028]">Комментарий</h2>
                <p class="m-0 leading-7 text-[#6f5b66]">{{ $order->customer_comment ?: 'Комментарий не указан.' }}</p>
                @if ($order->admin_comment)
                    <p class="mt-4 rounded-lg border border-[#d8b37a] bg-[#fff8e9] px-4 py-3 text-sm font-bold leading-6 text-[#6b450f]">Комментарий ателье: {{ $order->admin_comment }}</p>
                @endif
            </div>

            <div class="grid grid-cols-2 gap-5 max-[760px]:grid-cols-1">
                <div class="atelier-card p-5">
                    <h2 class="mb-4 mt-0 text-2xl font-black text-[#3d1028]">Мерки</h2>
                    @include('orders.partials.key-values', ['items' => $order->measurements])
                </div>

                <div class="atelier-card p-5">
                    <h2 class="mb-4 mt-0 text-2xl font-black text-[#3d1028]">Детали брифа</h2>
                    @include('orders.partials.key-values', ['items' => $order->parameters])
                </div>
            </div>

            <div class="atelier-card p-5">
                <h2 class="mb-4 mt-0 text-2xl font-black text-[#3d1028]">Референсы</h2>
                <div class="flex flex-wrap gap-2.5">
                    @forelse ($order->referenceImages as $image)
                        <a class="rounded-full border border-[#e3d4da] bg-[#fffdfb] px-3 py-2 text-sm font-bold text-[#6f5b66] no-underline transition hover:border-[#d8b37a] hover:text-[#5a1839]" href="{{ Storage::url($image->file_path) }}" target="_blank" rel="noreferrer">{{ $image->original_name }}</a>
                    @empty
                        <p class="m-0 leading-relaxed text-[#6f5b66]">Изображения не загружены.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <aside class="grid gap-5">
            <div class="rounded-lg border border-[#3d1028] bg-[#3d1028] p-5 text-white shadow-2xl shadow-[#5a1839]/25">
                <h2 class="mb-4 mt-0 text-2xl font-black">Стоимость</h2>
                <dl class="grid gap-3">
                    <div class="flex justify-between gap-4 border-b border-white/10 pb-3"><dt class="text-white/70">Предварительно</dt><dd class="m-0 text-right font-black"><x-price :value="$order->preliminary_price" /></dd></div>
                    <div class="flex justify-between gap-4 border-b border-white/10 pb-3"><dt class="text-white/70">Финальная цена</dt><dd class="m-0 text-right font-black">@if($order->final_price)<x-price :value="$order->final_price" />@else Не назначена @endif</dd></div>
                    <div class="flex justify-between gap-4 border-b border-white/10 pb-3"><dt class="text-white/70">Услуга</dt><dd class="m-0 text-right font-black">{{ $order->tailoringService?->name ?? 'Не указана' }}</dd></div>
                    <div class="flex justify-between gap-4 border-b border-white/10 pb-3"><dt class="text-white/70">Количество</dt><dd class="m-0 text-right font-black">{{ $order->quantity }}</dd></div>
                    <div class="flex justify-between gap-4 border-b border-white/10 pb-3"><dt class="text-white/70">Конструкция</dt><dd class="m-0 text-right font-black">{{ $order->complexity->label() }}</dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-white/70">Срок</dt><dd class="m-0 text-right font-black">{{ $order->urgency->label() }}</dd></div>
                </dl>
            </div>

            @can('cancel', $order)
                <form class="atelier-card p-5" method="post" action="{{ route('orders.cancel', $order) }}" data-confirm="Отменить заказ?">
                    @csrf
                    @method('patch')
                    <h2 class="mb-2 mt-0 text-xl font-black text-[#3d1028]">Отмена заказа</h2>
                    <p class="mt-0 text-sm leading-6 text-[#6f5b66]">Отменить можно только до начала производства.</p>
                    <button class="btn btn-danger w-full" type="submit">Отменить заказ</button>
                </form>
            @endcan
        </aside>
    </section>
</x-layouts.app>
