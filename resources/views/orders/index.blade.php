<x-layouts.app title="Мои заказы">
    <section class="flex items-center justify-between gap-5 py-6 max-[880px]:flex-col max-[880px]:items-start">
        <div>
            <h1 class="m-0 text-[clamp(34px,5vw,64px)] leading-none">Мои заказы</h1>
            <p class="max-w-[720px] text-lg leading-relaxed text-slate-600">История заказов и текущие статусы.</p>
        </div>
        <a class="inline-flex min-h-10 items-center justify-center rounded-lg border border-slate-900 bg-slate-900 px-4 py-2.5 font-semibold text-white no-underline" href="{{ route('orders.create') }}">Создать заказ</a>
    </section>

    <div class="overflow-x-auto rounded-lg border border-slate-200 bg-white">
        <table class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="border-b border-slate-200 px-3.5 py-3.5 text-left align-top text-xs font-semibold text-slate-500 max-[560px]:p-2.5 max-[560px]:text-sm">Номер</th>
                    <th class="border-b border-slate-200 px-3.5 py-3.5 text-left align-top text-xs font-semibold text-slate-500 max-[560px]:p-2.5 max-[560px]:text-sm">Модель</th>
                    <th class="border-b border-slate-200 px-3.5 py-3.5 text-left align-top text-xs font-semibold text-slate-500 max-[560px]:p-2.5 max-[560px]:text-sm">Материал</th>
                    <th class="border-b border-slate-200 px-3.5 py-3.5 text-left align-top text-xs font-semibold text-slate-500 max-[560px]:p-2.5 max-[560px]:text-sm">Статус</th>
                    <th class="border-b border-slate-200 px-3.5 py-3.5 text-left align-top text-xs font-semibold text-slate-500 max-[560px]:p-2.5 max-[560px]:text-sm">Стоимость</th>
                    <th class="border-b border-slate-200 px-3.5 py-3.5 text-left align-top text-xs font-semibold text-slate-500 max-[560px]:p-2.5 max-[560px]:text-sm"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td class="border-b border-slate-200 px-3.5 py-3.5 align-top max-[560px]:p-2.5 max-[560px]:text-sm">{{ $order->order_number }}</td>
                        <td class="border-b border-slate-200 px-3.5 py-3.5 align-top max-[560px]:p-2.5 max-[560px]:text-sm">{{ $order->clothingModel->name }}</td>
                        <td class="border-b border-slate-200 px-3.5 py-3.5 align-top max-[560px]:p-2.5 max-[560px]:text-sm">{{ $order->material->name }}</td>
                        <td class="border-b border-slate-200 px-3.5 py-3.5 align-top max-[560px]:p-2.5 max-[560px]:text-sm"><x-status-badge :status="$order->status" /></td>
                        <td class="border-b border-slate-200 px-3.5 py-3.5 align-top max-[560px]:p-2.5 max-[560px]:text-sm"><x-price :value="$order->final_price ?? $order->preliminary_price" /></td>
                        <td class="border-b border-slate-200 px-3.5 py-3.5 align-top max-[560px]:p-2.5 max-[560px]:text-sm"><a class="text-inherit underline" href="{{ route('orders.show', $order) }}">Открыть</a></td>
                    </tr>
                @empty
                    <tr><td class="border-b border-slate-200 px-3.5 py-3.5 align-top" colspan="6">Заказов пока нет.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $orders->links() }}
</x-layouts.app>
