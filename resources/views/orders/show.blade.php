<x-layouts.app :title="$order->order_number">
    <section class="flex items-center justify-between gap-5 py-6 max-[880px]:flex-col max-[880px]:items-start">
        <div>
            <h1 class="m-0 text-[clamp(34px,5vw,64px)] leading-none">Заказ {{ $order->order_number }}</h1>
            <p class="max-w-[720px] text-lg leading-relaxed text-slate-600">{{ $order->clothingModel->name }} · {{ $order->material->name }}</p>
        </div>
        <x-status-badge :status="$order->status" />
    </section>

    <section class="mb-4 grid grid-cols-3 gap-4 max-[880px]:grid-cols-1">
        <div class="rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="mb-4 mt-0">Стоимость</h2>
            <dl class="my-5 grid gap-2.5">
                <div class="flex justify-between gap-4 border-b border-slate-200 pb-2.5"><dt class="text-slate-500">Предварительно</dt><dd class="m-0 text-right font-semibold"><x-price :value="$order->preliminary_price" /></dd></div>
                <div class="flex justify-between gap-4 border-b border-slate-200 pb-2.5"><dt class="text-slate-500">Финальная цена</dt><dd class="m-0 text-right font-semibold">{{ $order->final_price ? '' : 'Не назначена' }}@if($order->final_price)<x-price :value="$order->final_price" />@endif</dd></div>
                <div class="flex justify-between gap-4 border-b border-slate-200 pb-2.5"><dt class="text-slate-500">Количество</dt><dd class="m-0 text-right font-semibold">{{ $order->quantity }}</dd></div>
                <div class="flex justify-between gap-4 border-b border-slate-200 pb-2.5"><dt class="text-slate-500">Сложность</dt><dd class="m-0 text-right font-semibold">{{ $order->complexity->label() }}</dd></div>
                <div class="flex justify-between gap-4 border-b border-slate-200 pb-2.5"><dt class="text-slate-500">Срочность</dt><dd class="m-0 text-right font-semibold">{{ $order->urgency->label() }}</dd></div>
            </dl>
            @can('cancel', $order)
                <form method="post" action="{{ route('orders.cancel', $order) }}" data-confirm="Отменить заказ?">
                    @csrf
                    @method('patch')
                    <button class="inline-flex min-h-10 cursor-pointer items-center justify-center rounded-lg border border-red-700 bg-red-700 px-4 py-2.5 font-semibold text-white" type="submit">Отменить заказ</button>
                </form>
            @endcan
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="mb-4 mt-0">Мерки</h2>
            @include('orders.partials.key-values', ['items' => $order->measurements])
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="mb-4 mt-0">Параметры</h2>
            @include('orders.partials.key-values', ['items' => $order->parameters])
        </div>
    </section>

    <section class="rounded-lg border border-slate-200 bg-white p-5">
        <h2 class="mb-4 mt-0">Комментарий</h2>
        <p class="leading-relaxed text-slate-600">{{ $order->customer_comment ?: 'Комментарий не указан.' }}</p>
        @if ($order->admin_comment)
            <p class="text-sm text-slate-500">Комментарий администратора: {{ $order->admin_comment }}</p>
        @endif
    </section>

    <section class="mt-4 rounded-lg border border-slate-200 bg-white p-5">
        <h2 class="mb-4 mt-0">Референсы</h2>
        <div class="mb-5 flex flex-wrap gap-2.5">
            @forelse ($order->referenceImages as $image)
                <a class="rounded-full border border-slate-200 bg-white px-3 py-2 text-sm text-slate-600 no-underline" href="{{ Storage::url($image->file_path) }}" target="_blank">{{ $image->original_name }}</a>
            @empty
                <p class="leading-relaxed text-slate-600">Изображения не загружены.</p>
            @endforelse
        </div>
    </section>
</x-layouts.app>
