@props(['status'])

@php
    $status = trim($status);
    $classes = match($status) {
        'Tersedia', 'Kosong' => 'bg-emerald-50 text-[#006c49] border border-emerald-100',
        'Terisi', 'Penuh' => 'bg-slate-900 text-white border border-slate-900',
        'Pemeliharaan', 'Maintenance' => 'bg-amber-50 text-amber-700 border border-amber-100',
        default => 'bg-gray-50 text-gray-500 border border-gray-100'
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {$classes}"]) }}>
    {{ strtoupper($status) }}
</span>
