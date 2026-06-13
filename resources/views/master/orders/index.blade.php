<x-layouts.app title="Заказы мастера">
    <section class="py-6">
        <span class="eyebrow">Рабочее место мастера</span>
        <h1 class="section-title mt-4">Назначенные заказы</h1>
        <p class="section-copy mt-4">Мастер видит только заказы, назначенные администратором.</p>
    </section>

    <div class="atelier-card hidden overflow-hidden md:block">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Номер</th>
                    <th>Клиент</th>
                    <th>Модель</th>
                    <th>Статус</th>
                    <th>Создан</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td class="font-extrabold text-slate-950">{{ $order->order_number }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ $order->clothingModel->name }}</td>
                        <td><x-status-badge :status="$order->status" /></td>
                        <td>{{ $order->created_at->format('d.m.Y') }}</td>
                        <td class="text-right"><a class="btn btn-secondary min-h-10" href="{{ route('master.orders.show', $order) }}">Открыть</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6">Назначенных заказов нет.</td></tr>
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
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Клиент</dt><dd class="m-0 text-right font-bold">{{ $order->customer->name }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Модель</dt><dd class="m-0 text-right font-bold">{{ $order->clothingModel->name }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-slate-500">Создан</dt><dd class="m-0 text-right font-bold">{{ $order->created_at->format('d.m.Y') }}</dd></div>
                </dl>
                <a class="btn btn-secondary w-full" href="{{ route('master.orders.show', $order) }}">Открыть</a>
            </article>
        @empty
            <div class="mobile-record">Назначенных заказов нет.</div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $orders->links() }}
    </div>
</x-layouts.app>
