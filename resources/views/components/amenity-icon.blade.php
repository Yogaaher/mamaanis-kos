@props(['amenity', 'class' => 'w-4 h-4 text-[#006c49] shrink-0'])

@php
    $name = strtolower(trim($amenity));
@endphp

@if(Str::contains($name, 'mandi') || Str::contains($name, 'toilet') || Str::contains($name, 'bath'))
    <!-- Kamar Mandi Dalam -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 10h16m-16 0v8a2 2 0 002 2h12a2 2 0 002-2v-8m-16 0V6a2 2 0 012-2h2m10 2v4M8 6V4"/>
    </svg>
@elseif(Str::contains($name, 'ac') || Str::contains($name, 'sejuk') || Str::contains($name, 'dingin'))
    <!-- AC Sejuk -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <rect x="2" y="4" width="20" height="9" rx="2" stroke-linecap="round" stroke-linejoin="round"/>
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9h4m6 0h.01M6 16c1 1.5 2 1.5 3 0s2-1.5 3 0m0 0c1 1.5 2 1.5 3 0s2-1.5 3 0M8 20c1 1 2 1 3 0s2-1 3 0"/>
    </svg>
@elseif(Str::contains($name, 'wifi') || Str::contains($name, 'internet') || Str::contains($name, 'cepat'))
    <!-- WiFi Cepat -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.284 16.284A3 3 0 0012 17a3 3 0 003.716-.716M5.456 13.456a6.5 6.5 0 0113.088 0M2.628 10.628a10.5 10.5 0 0118.744 0M12 20h.01"/>
    </svg>
@elseif(Str::contains($name, 'kasur') || Str::contains($name, 'bed') || Str::contains($name, 'springbed') || Str::contains($name, 'bantal'))
    <!-- Kasur Springbed & Bantal -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v11m0-4h18m0 4V7m0 0a2 2 0 00-2-2H5a2 2 0 00-2 2m18 0v4H3V7m4 0h4v2H7V7z"/>
    </svg>
@elseif(Str::contains($name, 'lemari') || Str::contains($name, 'pakaian') || Str::contains($name, 'wardrobe') || Str::contains($name, 'closet'))
    <!-- Lemari Pakaian -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 4a2 2 0 012-2h10a2 2 0 012 2v16a2 2 0 01-2 2H7a2 2 0 01-2-2V4zm7-2v20M9 11h.01M15 11h.01M5 18h14"/>
    </svg>
@elseif(Str::contains($name, 'meja') || Str::contains($name, 'kursi') || Str::contains($name, 'kerja') || Str::contains($name, 'belajar'))
    <!-- Meja & Kursi -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 19v-6a2 2 0 012-2h12a2 2 0 012 2v6M4 11V6a2 2 0 012-2h4a2 2 0 012 2v5M8 19v-4m8 4v-4"/>
    </svg>
@elseif(Str::contains($name, 'listrik') || Str::contains($name, 'token') || Str::contains($name, 'pln'))
    <!-- Listrik Token -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
    </svg>
@elseif(Str::contains($name, 'air') || Str::contains($name, 'bersih') || Str::contains($name, 'water'))
    <!-- Air Bersih -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/>
    </svg>
@else
    <!-- Default Checkmark Icon -->
    <svg class="{{ $class }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
    </svg>
@endif
