<x-layouts.app title="Мои заказы">
    <section class="flex items-center justify-between gap-5 py-6 max-[920px]:flex-col max-[920px]:items-start">
        <div>
            <span class="eyebrow">Личный кабинет</span>
            <h1 class="section-title mt-4">Мои заказы</h1>
            <p class="section-copy mt-4">История заказов, текущие статусы и финальные цены после проверки администратором.</p>
        </div>
        <a class="btn btn-primary min-h-12 px-5" href="{{ route('orders.create') }}">Создать заказ</a>
    </section>

    <div class="atelier-card hidden overflow-hidden md:block">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Номер</th>
                    <th>Модель</th>
                    <th>Материал</th>
                    <th>Статус</th>
                    <th>Стоимость</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td class="font-extrabold text-slate-950">{{ $order->order_number }}</td>
                        <td>{{ $order->clothingModel->name }}</td>
                        <td>{{ $order->material->name }}</td>
                        <td><x-status-badge :status="$order->status" /></td>
                        <td class="font-extrabold text-slate-950"><x-price :value="$order->final_price ?? $order->preliminary_price" /></td>
                        <td class="text-right"><a class="btn btn-secondary min-h-10" href="{{ route('orders.show', $order) }}">Открыть</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6">Заказов пока нет.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="grid gap-3 md:hidden">
        @forelse ($orders as $order)
            <article class="mobile-record">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="m-0 text-sm font-bold text-slate-500">Заказ</p>
                        <h2 class="m-0 mt-1 text-xl font-extrabold">{{ $order->order_number }}</h2>
                    </div>
                    <x-status-badge :status="$order->status" />
                </div>
                <dl class="my-4 grid gap-2 text-sm">
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Модель</dt><dd class="m-0 text-right font-bold">{{ $order->clothingModel->name }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Материал</dt><dd class="m-0 text-right font-bold">{{ $order->material->name }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Стоимость</dt><dd class="m-0 text-right font-bold"><x-price :value="$order->final_price ?? $order->preliminary_price" /></dd></div>
                </dl>
                <a class="btn btn-secondary w-full" href="{{ route('orders.show', $order) }}">Открыть</a>
            </article>
        @empty
            <div class="mobile-record">Заказов пока нет.</div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $orders->links() }}
    </div>
</x-layouts.app>
