@props(['status'])

@php
    $classes = match ($status) {
        \App\Enums\OrderStatus::New => 'border-amber-200 bg-amber-50 text-amber-800',
        \App\Enums\OrderStatus::Confirmed => 'border-sky-200 bg-sky-50 text-sky-800',
        \App\Enums\OrderStatus::InProgress => 'border-orange-200 bg-orange-50 text-orange-800',
        \App\Enums\OrderStatus::Fitting => 'border-violet-200 bg-violet-50 text-violet-800',
        \App\Enums\OrderStatus::Completed => 'border-emerald-200 bg-emerald-50 text-emerald-800',
        \App\Enums\OrderStatus::Cancelled => 'border-red-200 bg-red-50 text-red-800',
    };
@endphp

<span class="inline-flex items-center rounded-full border px-3 py-1.5 text-xs font-extrabold {{ $classes }}">{{ $status->label() }}</span>
