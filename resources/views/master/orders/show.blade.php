<x-layouts.app :title="$order->order_number">
    <section class="flex items-center justify-between gap-5 py-6 max-[880px]:flex-col max-[880px]:items-start">
        <div>
            <h1 class="m-0 text-[clamp(34px,5vw,64px)] leading-none">Заказ {{ $order->order_number }}</h1>
            <p class="max-w-[720px] text-lg leading-relaxed text-slate-600">{{ $order->customer->name }} · {{ $order->customer->phone ?: $order->customer->email }}</p>
        </div>
        <x-status-badge :status="$order->status" />
    </section>

    <section class="mb-4 grid grid-cols-3 gap-4 max-[880px]:grid-cols-1">
        <div class="rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="mb-4 mt-0">Изделие</h2>
            <dl class="my-5 grid gap-2.5">
                <div class="flex justify-between gap-4 border-b border-slate-200 pb-2.5"><dt class="text-slate-500">Модель</dt><dd class="m-0 text-right font-semibold">{{ $order->clothingModel->name }}</dd></div>
                <div class="flex justify-between gap-4 border-b border-slate-200 pb-2.5"><dt class="text-slate-500">Категория</dt><dd class="m-0 text-right font-semibold">{{ $order->clothingModel->category->name }}</dd></div>
                <div class="flex justify-between gap-4 border-b border-slate-200 pb-2.5"><dt class="text-slate-500">Материал</dt><dd class="m-0 text-right font-semibold">{{ $order->material->name }}</dd></div>
                <div class="flex justify-between gap-4 border-b border-slate-200 pb-2.5"><dt class="text-slate-500">Количество</dt><dd class="m-0 text-right font-semibold">{{ $order->quantity }}</dd></div>
            </dl>
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
        <h2 class="mb-4 mt-0">Комментарий клиента</h2>
        <p class="leading-relaxed text-slate-600">{{ $order->customer_comment ?: 'Комментарий не указан.' }}</p>
    </section>
</x-layouts.app>
