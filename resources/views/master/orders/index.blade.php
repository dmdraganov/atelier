<x-layouts.app title="Заказы мастера">
    <section class="py-6">
        <h1 class="m-0 text-[clamp(34px,5vw,64px)] leading-none">Назначенные заказы</h1>
        <p class="max-w-[720px] text-lg leading-relaxed text-slate-600">Мастер видит только заказы, назначенные администратором.</p>
    </section>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white">
        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="border-b border-slate-200 px-3.5 py-3.5 text-left align-top text-xs font-semibold text-slate-500 max-[560px]:p-2.5 max-[560px]:text-sm">Номер</th>
                    <th class="border-b border-slate-200 px-3.5 py-3.5 text-left align-top text-xs font-semibold text-slate-500 max-[560px]:p-2.5 max-[560px]:text-sm">Клиент</th>
                    <th class="border-b border-slate-200 px-3.5 py-3.5 text-left align-top text-xs font-semibold text-slate-500 max-[560px]:p-2.5 max-[560px]:text-sm">Модель</th>
                    <th class="border-b border-slate-200 px-3.5 py-3.5 text-left align-top text-xs font-semibold text-slate-500 max-[560px]:p-2.5 max-[560px]:text-sm">Статус</th>
                    <th class="border-b border-slate-200 px-3.5 py-3.5 text-left align-top text-xs font-semibold text-slate-500 max-[560px]:p-2.5 max-[560px]:text-sm">Создан</th>
                    <th class="border-b border-slate-200 px-3.5 py-3.5 text-left align-top text-xs font-semibold text-slate-500 max-[560px]:p-2.5 max-[560px]:text-sm"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td class="border-b border-slate-200 px-3.5 py-3.5 align-top max-[560px]:p-2.5 max-[560px]:text-sm">{{ $order->order_number }}</td>
                        <td class="border-b border-slate-200 px-3.5 py-3.5 align-top max-[560px]:p-2.5 max-[560px]:text-sm">{{ $order->customer->name }}</td>
                        <td class="border-b border-slate-200 px-3.5 py-3.5 align-top max-[560px]:p-2.5 max-[560px]:text-sm">{{ $order->clothingModel->name }}</td>
                        <td class="border-b border-slate-200 px-3.5 py-3.5 align-top max-[560px]:p-2.5 max-[560px]:text-sm"><x-status-badge :status="$order->status" /></td>
                        <td class="border-b border-slate-200 px-3.5 py-3.5 align-top max-[560px]:p-2.5 max-[560px]:text-sm">{{ $order->created_at->format('d.m.Y') }}</td>
                        <td class="border-b border-slate-200 px-3.5 py-3.5 align-top max-[560px]:p-2.5 max-[560px]:text-sm"><a class="text-inherit underline" href="{{ route('master.orders.show', $order) }}">Открыть</a></td>
                    </tr>
                @empty
                    <tr><td class="border-b border-slate-200 px-3.5 py-3.5 align-top" colspan="6">Назначенных заказов нет.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $orders->links() }}
</x-layouts.app>
