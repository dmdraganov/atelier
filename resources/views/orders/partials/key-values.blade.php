@if (filled($items))
    <dl class="my-5 grid gap-2.5">
        @foreach ($items as $key => $value)
            <div class="flex justify-between gap-4 border-b border-slate-200 pb-2.5"><dt class="text-slate-500">{{ $key }}</dt><dd class="m-0 text-right font-semibold">{{ $value }}</dd></div>
        @endforeach
    </dl>
@else
    <p class="leading-relaxed text-slate-600">Данные не указаны.</p>
@endif
