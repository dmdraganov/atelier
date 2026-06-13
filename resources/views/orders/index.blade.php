<x-layouts.app title="Мои заказы">
    <section class="flex items-center justify-between gap-5 py-6 max-[920px]:flex-col max-[920px]:items-start">
        <div>
            <p class="section-kicker m-0">Кабинет</p>
            <h1 class="section-title mt-3">Мои заказы</h1>
            <p class="section-copy mt-4">Все сохранённые брифы, текущие статусы и стоимость после проверки ателье.</p>
        </div>
        <a class="btn btn-primary min-h-12 px-5" href="{{ route('orders.create') }}">Новый бриф</a>
    </section>

    <div class="atelier-card hidden overflow-hidden md:block">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Номер</th>
                    <th>Модель</th>
                    <th>Услуга</th>
                    <th>Материал</th>
                    <th>Статус</th>
                    <th>Стоимость</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td class="font-black text-[#3d1028]">{{ $order->order_number }}</td>
                        <td>{{ $order->clothingModel?->name ?? 'Не требуется' }}</td>
                        <td>{{ $order->tailoringService?->name ?? 'Не указана' }}</td>
                        <td>{{ $order->material?->name ?? 'Не требуется' }}</td>
                        <td><x-status-badge :status="$order->status" /></td>
                        <td class="font-black text-[#3d1028]"><x-price :value="$order->final_price ?? $order->preliminary_price" /></td>
                        <td class="text-right"><a class="btn btn-secondary min-h-10" href="{{ route('orders.show', $order) }}">Открыть</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7">Заказов пока нет.</td></tr>
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
                    <div class="flex justify-between gap-3"><dt class="text-[#8a6875]">Модель</dt><dd class="m-0 text-right font-bold">{{ $order->clothingModel?->name ?? 'Не требуется' }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-[#8a6875]">Услуга</dt><dd class="m-0 text-right font-bold">{{ $order->tailoringService?->name ?? 'Не указана' }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-[#8a6875]">Материал</dt><dd class="m-0 text-right font-bold">{{ $order->material?->name ?? 'Не требуется' }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-[#8a6875]">Стоимость</dt><dd class="m-0 text-right font-bold"><x-price :value="$order->final_price ?? $order->preliminary_price" /></dd></div>
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
