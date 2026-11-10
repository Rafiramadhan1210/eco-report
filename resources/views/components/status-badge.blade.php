@props(['status'])
@php
    $warna = [
        'Baru' => 'bg-sky-50 text-sky-700 ring-sky-200',
        'Diproses' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'Selesai' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'Ditolak' => 'bg-rose-50 text-rose-700 ring-rose-200',
    ][$status] ?? 'bg-slate-50 text-slate-700 ring-slate-200';
@endphp
<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset ' . $warna]) }}>{{ $status }}</span>
