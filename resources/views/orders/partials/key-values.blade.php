@if (filled($items))
    <dl class="my-5 grid">
        @foreach ($items as $key => $value)
            <div class="kv-row"><dt>{{ $key }}</dt><dd>{{ $value }}</dd></div>
        @endforeach
    </dl>
@else
    <p class="m-0 leading-relaxed text-slate-600">Данные не указаны.</p>
@endif
