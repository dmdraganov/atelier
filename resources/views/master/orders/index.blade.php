<x-layouts.app title="Назначенные заказы">
    <section class="py-6">
        <p class="section-kicker m-0">Рабочий список</p>
        <h1 class="section-title mt-3">Назначенные заказы</h1>
        <p class="section-copy mt-4">Заказы, переданные вам администратором для работы.</p>
    </section>

    <div class="atelier-card hidden overflow-hidden md:block">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Номер</th>
                    <th>Клиент</th>
                    <th>Модель</th>
                    <th>Услуга</th>
                    <th>Статус</th>
                    <th>Создан</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td class="font-black text-[#3d1028]">{{ $order->order_number }}</td>
                        <td>{{ $order->customer->name }}</td>
                        <td>{{ $order->clothingModel?->name ?? 'Не требуется' }}</td>
                        <td>{{ $order->tailoringService?->name ?? 'Не указана' }}</td>
                        <td><x-status-badge :status="$order->status" /></td>
                        <td>{{ $order->created_at->format('d.m.Y') }}</td>
                        <td class="text-right"><a class="btn btn-secondary min-h-10" href="{{ route('master.orders.show', $order) }}">Открыть</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7">Назначенных заказов нет.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="grid gap-3 md:hidden">
        @forelse ($orders as $order)
            <article class="mobile-record">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="m-0 text-sm font-bold text-[#8a6875]">Заказ</p>
                        <h2 class="m-0 mt-1 text-xl font-black text-[#3d1028]">{{ $order->order_number }}</h2>
                    </div>
                    <x-status-badge :status="$order->status" />
                </div>
                <dl class="my-4 grid gap-2 text-sm">
                    <div class="flex justify-between gap-3"><dt class="text-[#8a6875]">Клиент</dt><dd class="m-0 text-right font-bold">{{ $order->customer->name }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-[#8a6875]">Модель</dt><dd class="m-0 text-right font-bold">{{ $order->clothingModel?->name ?? 'Не требуется' }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-[#8a6875]">Услуга</dt><dd class="m-0 text-right font-bold">{{ $order->tailoringService?->name ?? 'Не указана' }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-[#8a6875]">Создан</dt><dd class="m-0 text-right font-bold">{{ $order->created_at->format('d.m.Y') }}</dd></div>
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
