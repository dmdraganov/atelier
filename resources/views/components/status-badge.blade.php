@props(['status'])

@php
    $classes = match ($status) {
        \App\Enums\OrderStatus::New => 'bg-amber-100 text-amber-800',
        \App\Enums\OrderStatus::Confirmed => 'bg-sky-100 text-sky-800',
        \App\Enums\OrderStatus::InProgress => 'bg-orange-100 text-orange-800',
        \App\Enums\OrderStatus::Fitting => 'bg-violet-100 text-violet-800',
        \App\Enums\OrderStatus::Completed => 'bg-emerald-100 text-emerald-800',
        \App\Enums\OrderStatus::Cancelled => 'bg-red-100 text-red-800',
    };
@endphp

<span class="inline-flex rounded-full px-2.5 py-1.5 text-xs font-bold {{ $classes }}">{{ $status->label() }}</span>
