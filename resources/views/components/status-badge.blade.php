@props(['status'])

@php
    $classes = match ($status) {
        \App\Enums\OrderStatus::New => 'border-[#ead7a8] bg-[#fff8e9] text-[#7a4d12]',
        \App\Enums\OrderStatus::Confirmed => 'border-sky-200 bg-sky-50 text-sky-800',
        \App\Enums\OrderStatus::InProgress => 'border-[#e8b7c1] bg-[#fbedf0] text-[#8f2946]',
        \App\Enums\OrderStatus::Fitting => 'border-[#d7c4e8] bg-[#f5effb] text-[#65417e]',
        \App\Enums\OrderStatus::Completed => 'border-emerald-200 bg-emerald-50 text-emerald-800',
        \App\Enums\OrderStatus::Cancelled => 'border-red-200 bg-red-50 text-red-800',
    };
@endphp

<span class="inline-flex items-center rounded-full border px-3 py-1.5 text-xs font-extrabold {{ $classes }}">{{ $status->label() }}</span>
