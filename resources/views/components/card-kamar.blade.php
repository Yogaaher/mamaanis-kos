@props(['room', 'layout' => 'horizontal'])

@php
    $formatRupiah = function($num) {
        return 'Rp ' . number_format($num, 0, ',', '.');
    };
    
    // Fallback room array structure in case object is passed
    $roomData = is_array($room) ? $room : $room->toArray();
    $id = $roomData['id'] ?? '';
    $name = $roomData['name'] ?? '';
    $type = $roomData['type'] ?? '';
    $price = $roomData['price'] ?? 0;
    $status = $roomData['status'] ?? 'Tersedia';
    $views = $roomData['views'] ?? 0;
    $image = $roomData['image_url'] ?? ($roomData['image'] ?? 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=800&q=80');
    $amenities = $roomData['amenities'] ?? [];
    $size = $roomData['size'] ?? 20;
    $beds = $roomData['beds'] ?? 1;
    $description = $roomData['description'] ?? '';
    $isBestSeller = $views >= 900;
@endphp

@if($layout === 'vertical')
<!-- Vertical Card Layout (Exact Match for Home Page) -->
<a href="/room/{{ $id }}" class="bg-white border border-gray-100 rounded-2xl sm:rounded-3xl overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col group h-full">
    <!-- Image -->
    <div class="relative w-full aspect-[4/3] overflow-hidden">
        <img
            src="{{ $image }}"
            alt="{{ $name }}"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            onerror="handleImgError(this)"
        />
        <div class="absolute top-3 left-3 sm:top-4 sm:left-4 flex gap-1.5 sm:gap-2">
            @if($isBestSeller)
                <span class="bg-[#006c49] text-white px-2.5 py-0.5 sm:px-3.5 sm:py-1 rounded-lg text-[10px] sm:text-xs font-bold uppercase tracking-wider shadow-xs">
                    Terlaris
                </span>
            @endif
            <x-badge-status :status="$status" />
        </div>
    </div>

    <!-- Content -->
    <div class="p-4 sm:p-6 flex-1 flex flex-col justify-between gap-2.5 sm:gap-3">
        <div>
            <!-- Title & Price (Same Line) -->
            <div class="flex justify-between items-start gap-2 mb-1.5 sm:mb-2">
                <h3 class="font-bold text-base sm:text-lg text-gray-900 group-hover:text-[#006c49] transition-colors leading-snug truncate max-w-[62%] font-display">
                    {{ $name }}
                </h3>
                <span class="text-sm sm:text-base font-bold text-[#006c49] shrink-0 font-display">
                    {{ $formatRupiah($price) }}
                </span>
            </div>

            <!-- Description -->
            <p class="text-xs sm:text-sm text-gray-500 leading-relaxed mb-3 sm:mb-4 line-clamp-2 font-sans">
                {{ $description ?: 'Hunian modern dengan fasilitas lengkap, lokasi strategis dan kenyamanan maksimal.' }}
            </p>
        </div>

        <!-- Specs tags -->
        <div class="flex flex-wrap gap-1.5 sm:gap-2 mt-auto pt-2.5 sm:pt-3 border-t border-gray-100">
            <span class="bg-emerald-50 text-[#006c49] border border-emerald-100 px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider">
                {{ $size }}m²
            </span>
            <span class="bg-emerald-50 text-[#006c49] border border-emerald-100 px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider">
                {{ $beds }} Bed
            </span>
            @if(count($amenities) > 0)
                <span class="bg-emerald-50 text-[#006c49] border border-emerald-100 px-2.5 py-0.5 sm:px-3 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold uppercase tracking-wider truncate max-w-[120px] sm:max-w-[140px]">
                    {{ $amenities[0] }}
                </span>
            @endif
        </div>
    </div>
</a>
@else
<!-- Horizontal Card Layout (Catalog) -->
<div {{ $attributes->merge(['class' => 'bg-white border border-gray-100 rounded-2xl sm:rounded-3xl overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col sm:flex-row min-h-[200px] sm:min-h-[220px] group']) }}>
    <!-- Image -->
    <div class="relative w-full sm:w-64 md:w-72 h-44 sm:h-auto shrink-0 overflow-hidden">
        <img
            src="{{ $image }}"
            alt="{{ $name }}"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            onerror="handleImgError(this)"
        />
        @if($isBestSeller)
            <div class="absolute top-3 left-3 sm:top-4 sm:left-4 bg-[#006c49] text-white px-2.5 py-0.5 sm:px-3.5 sm:py-1 rounded-lg text-[10px] sm:text-xs font-bold uppercase tracking-wider flex items-center gap-1 shadow-xs">
                <span>Terlaris</span>
            </div>
        @endif
    </div>

    <!-- Content -->
    <div class="p-4 sm:p-6 flex-1 flex flex-col justify-between gap-3 sm:gap-4">
        <div>
            <div class="flex justify-between items-start gap-4 mb-2 sm:mb-4">
                <h3 class="font-bold text-lg sm:text-xl text-gray-900 group-hover:text-[#006c49] transition-colors leading-snug font-display">
                    {{ $name }}
                </h3>
            </div>

            <!-- Amenities with accurate vector icons -->
            <div class="flex flex-wrap gap-2 mb-2 sm:mb-4 text-xs sm:text-sm text-gray-600 font-medium font-sans">
                @foreach(array_slice($amenities, 0, 4) as $amenity)
                    <span class="flex items-center gap-1.5 bg-emerald-50/60 border border-emerald-100 px-2.5 py-1 rounded-xl text-[11px] sm:text-xs">
                        <x-amenity-icon :amenity="$amenity" class="w-3.5 h-3.5 text-[#006c49] shrink-0" />
                        <span class="font-semibold text-gray-700">{{ $amenity }}</span>
                    </span>
                @endforeach
            </div>
        </div>

        <div class="pt-3 sm:pt-4 border-t border-gray-100 flex flex-col sm:flex-row sm:items-end justify-between gap-3 sm:gap-4">
            <div>
                <p class="text-[10px] sm:text-xs text-gray-500 font-bold uppercase tracking-wider mb-0.5 font-sans">
                    Harga Per Bulan
                </p>
                <p class="text-xl sm:text-2xl font-black text-[#006c49] font-display">{{ $formatRupiah($price) }}</p>
            </div>
            <div class="flex items-center justify-between sm:justify-end gap-2.5 sm:gap-3 w-full sm:w-auto">
                <x-badge-status :status="$status" />
                <a
                    href="/room/{{ $id }}"
                    class="font-bold text-xs sm:text-sm bg-[#006c49] hover:bg-[#005236] text-white px-4 py-2 sm:px-6 sm:py-2.5 rounded-xl hover:shadow-md transition-all active:scale-95 cursor-pointer text-center font-sans"
                >
                    Lihat Detail
                </a>
            </div>
        </div>
    </div>
</div>
@endif
