@extends('layouts.admin')

@section('title', ($mode === 'edit' ? 'Edit Kamar' : 'Tambah Kamar Baru') . ' | Admin Mama Anis Group')

@section('content')
@php
    $editing = $mode === 'edit';
    $initialGallery = [];
    if (is_array(old('gallery_urls')) && count(old('gallery_urls')) > 0) {
        $oldUrls = old('gallery_urls', []);
        $oldLabels = old('gallery_labels', []);
        foreach ($oldUrls as $k => $u) {
            $initialGallery[] = [
                'url' => $u ?? '',
                'label' => $oldLabels[$k] ?? ('Foto Kamar ' . (count($initialGallery) + 1)),
            ];
        }
    } elseif ($editing) {
        $initialGallery = $room->getGalleryList();
    } else {
        $initialGallery = [
            ['url' => '/images/Kamar no 5.jpg', 'label' => 'Foto Kamar Tidur'],
            ['url' => '/images/Kamar mandi.jpg', 'label' => 'Foto Kamar Mandi Dalam'],
        ];
    }
@endphp
<main class="w-full max-w-full p-3.5 sm:p-8 lg:p-10 flex flex-col gap-4 sm:gap-6 rise overflow-x-hidden">
    <!-- Top Bar Navigation -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4 border-b border-slate-100 pb-4 sm:pb-5">
        <div>
            <a 
                href="{{ route('admin.rooms.index') }}" 
                class="inline-flex items-center gap-2 text-xs font-bold text-slate-700 hover:text-brand bg-white border border-slate-200 hover:border-emerald-300 px-3 py-1.5 rounded-xl shadow-2xs hover:shadow-xs transition-all mb-2.5 active:scale-95 cursor-pointer"
            >
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>← Kembali ke Kelola Kamar</span>
            </a>
            <h1 class="text-xl sm:text-3xl font-black text-slate-900 font-display">
                {{ $editing ? 'Edit Unit: ' . $room->name : 'Tambah Unit Kamar Baru' }}
            </h1>
            <p class="text-[11px] sm:text-xs text-slate-400 mt-0.5 sm:mt-1">
                Kelola data kamar, foto kamar & kamar mandi, fasilitas, serta syarat kapasitas & sewa.
            </p>
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
            <a 
                href="{{ route('admin.rooms.index') }}" 
                class="rounded-xl px-5 py-2.5 font-bold text-xs text-slate-600 hover:bg-slate-100 transition-colors"
            >
                Batal
            </a>
            <button 
                type="submit"
                form="room-form"
                class="rounded-xl bg-brand hover:bg-brandHover px-6 py-2.5 font-bold text-xs text-white shadow-md shadow-brand/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span>{{ $editing ? 'Simpan Perubahan' : 'Terbitkan Kamar' }}</span>
            </button>
        </div>
    </div>

    @if ($errors->any())
        <div class="rounded-2xl bg-red-50 border border-red-200 p-4 text-xs font-semibold text-red-700">
            <p class="font-bold">Mohon periksa formulir berikut:</p>
            <ul class="list-disc pl-5 mt-1 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Layout: Fluid & Responsive Split Columns on Desktop -->
    <form 
        id="room-form"
        method="POST" 
        action="{{ $editing ? route('admin.rooms.update', $room) : route('admin.rooms.store') }}" 
        enctype="multipart/form-data"
        class="grid gap-6 lg:grid-cols-12 items-start"
    >
        @csrf
        @if($editing)
            @method('PUT')
        @endif

        <!-- Main Column (Left - 7 cols on Desktop) -->
        <div class="lg:col-span-7 xl:col-span-8 flex flex-col gap-6">
            <!-- Basic Information Card -->
            <article class="bg-white rounded-2xl border border-slate-100 shadow-soft p-6 sm:p-8 flex flex-col gap-5">
                <h2 class="text-base font-black text-slate-900 font-display border-b border-slate-100 pb-3 flex items-center gap-2">
                    <svg class="w-4.5 h-4.5 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span>Informasi Utama Unit</span>
                </h2>

                <div class="grid gap-5 sm:grid-cols-2">
                    <!-- Room Name -->
                    <div class="sm:col-span-2">
                        <label class="text-xs font-bold text-slate-700 block">Nama Unit Kamar <span class="text-red-500">*</span></label>
                        <input 
                            name="name" 
                            value="{{ old('name', $room->name ?: 'Kamar Kost Mama Anis') }}" 
                            placeholder="Contoh: Kamar Kost Mama Anis (Exclusive Room)" 
                            required 
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold text-slate-900"
                        />
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block">Tipe Kamar <span class="text-red-500">*</span></label>
                        <input 
                            name="type" 
                            value="{{ old('type', $room->type ?: 'Kamar Standard Eksklusif') }}" 
                            placeholder="Contoh: Kamar Standard Eksklusif" 
                            required 
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-medium"
                        />
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block">Lokasi Properti <span class="text-red-500">*</span></label>
                        <input 
                            name="location" 
                            value="{{ old('location', $room->location ?: 'Alam Sutera, Tangerang') }}" 
                            required 
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-medium"
                        />
                    </div>

                    <!-- Description -->
                    <div class="sm:col-span-2">
                        <label class="text-xs font-bold text-slate-700 block">Deskripsi Lengkap Unit <span class="text-red-500">*</span></label>
                        <textarea 
                            name="description" 
                            rows="5" 
                            required 
                            placeholder="Tuliskan gambaran kenyamanan, kebersihan kamar mandi dalam, dan keunggulan kamar ini..."
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-medium leading-relaxed"
                        >{{ old('description', $room->description ?: 'Unit kamar kost Mama Anis dirancang khusus untuk kenyamanan dan privasi 1 orang penghuni. Dilengkapi fasilitas kamar mandi dalam yang bersih dan higienis, AC, kasur berkualitas, lemari pakaian, meja kerja/belajar, dan koneksi internet WiFi stabil. Minimal durasi sewa 1 bulan.') }}</textarea>
                    </div>

                    <!-- Amenities -->
                    <div class="sm:col-span-2">
                        <label class="text-xs font-bold text-slate-700 block">Fasilitas Unit (pisahkan dengan koma)</label>
                        <input 
                            name="amenities_text" 
                            value="{{ old('amenities_text', is_array($room->amenities) ? implode(', ', $room->amenities) : 'Kamar Mandi Dalam, AC Sejuk, WiFi Cepat, Kasur Springbed & Bantal, Lemari Pakaian, Meja & Kursi, Listrik Token, Air Bersih') }}" 
                            placeholder="Kamar Mandi Dalam, AC Sejuk, WiFi Cepat, Kasur Springbed & Bantal, Lemari Pakaian, Meja & Kursi, Listrik Token, Air Bersih" 
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-medium"
                        />
                        <p class="text-[10px] text-slate-400 mt-1">Fasilitas akan ditampilkan sebagai badge di halaman detail kamar publik.</p>
                    </div>
                </div>
            </article>

            <!-- Media & Photos Card: Dynamic Unlimited Gallery Photos -->
            <article class="bg-white rounded-2xl border border-slate-100 shadow-soft p-6 sm:p-8 flex flex-col gap-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4">
                    <div>
                        <div class="flex items-center gap-2.5">
                            <h2 class="text-base font-black text-slate-900 font-display flex items-center gap-2">
                                <svg class="w-4.5 h-4.5 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>Galeri Foto Kamar</span>
                            </h2>
                            <span id="gallery-count-badge" class="bg-emerald-50 text-brand border border-emerald-200 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold">
                                {{ count($initialGallery) }} Foto
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">
                            Tambahkan foto kamar sebanyak yang Anda inginkan. Foto urutan pertama (#1) akan menjadi foto sampul utama.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <!-- Multi-file quick upload -->
                        <input 
                            type="file" 
                            id="multi_photo_picker" 
                            multiple 
                            accept="image/png, image/jpeg, image/jpg, image/webp" 
                            class="hidden" 
                            onchange="handleMultiPhotoSelect(this)"
                        />
                        <button 
                            type="button" 
                            onclick="document.getElementById('multi_photo_picker').click()"
                            class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-brand border border-emerald-200 px-3.5 py-2 text-xs font-bold transition-all cursor-pointer active:scale-95"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            <span>Upload Banyak Sekaligus</span>
                        </button>

                        <button 
                            type="button" 
                            onclick="addGallerySlot()"
                            class="inline-flex items-center gap-1.5 rounded-xl bg-brand hover:bg-brandHover text-white px-3.5 py-2 text-xs font-bold shadow-xs transition-all cursor-pointer active:scale-95"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Tambah Foto</span>
                        </button>
                    </div>
                </div>

                <!-- Dynamic Gallery Slots Container -->
                <div id="gallery-slots-container" class="flex flex-col gap-4">
                    @foreach($initialGallery as $idx => $item)
                        <div class="gallery-slot-card p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col gap-4 transition-all" data-slot-id="{{ $idx }}">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="slot-order-badge inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-extrabold {{ $idx === 0 ? 'bg-brand text-white' : 'bg-slate-200 text-slate-700' }}">
                                        {{ $idx === 0 ? '#1 • Foto Utama (Sampul)' : '#' . ($idx + 1) . ' • Foto Tambahan' }}
                                    </span>
                                </div>
                                <button 
                                    type="button" 
                                    onclick="removeGallerySlot(this)"
                                    class="inline-flex items-center gap-1 text-[11px] font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 border border-red-200/70 px-2.5 py-1 rounded-lg transition-colors cursor-pointer"
                                    title="Hapus foto ini"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-12 items-center">
                                <div class="sm:col-span-7 space-y-3">
                                    <div>
                                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Judul / Keterangan Foto</label>
                                        <input 
                                            type="text"
                                            name="gallery_labels[{{ $idx }}]" 
                                            value="{{ $item['label'] }}" 
                                            placeholder="Contoh: Foto Kamar Tidur / Kamar Mandi / Meja Belajar" 
                                            class="w-full rounded-xl border border-slate-200 px-3.5 py-2 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold text-slate-800 bg-white"
                                        />
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Upload File Gambar (Maks 5MB)</label>
                                        <input 
                                            type="file" 
                                            name="gallery_files[{{ $idx }}]" 
                                            accept="image/png, image/jpeg, image/jpg, image/webp" 
                                            onchange="previewSlotFile(this)"
                                            class="slot-file-input w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-brand/10 file:text-brand hover:file:bg-brand/20 border border-slate-200 rounded-xl p-1 bg-white cursor-pointer"
                                        />
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Atau Gunakan URL Gambar</label>
                                        <input 
                                            type="text"
                                            name="gallery_urls[{{ $idx }}]" 
                                            value="{{ $item['url'] }}" 
                                            placeholder="https://... atau /images/..." 
                                            oninput="previewSlotUrl(this)"
                                            class="slot-url-input w-full rounded-xl border border-slate-200 px-3.5 py-2 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-mono bg-white"
                                        />
                                    </div>
                                </div>

                                <!-- Live Preview -->
                                <div class="sm:col-span-5">
                                    <div class="relative w-full h-40 rounded-xl overflow-hidden border border-slate-200 bg-slate-200 flex items-center justify-center shadow-2xs">
                                        <img 
                                            src="{{ $item['url'] ?: '/images/Kamar no 5.jpg' }}" 
                                            alt="{{ $item['label'] }}"
                                            class="slot-preview-img w-full h-full object-cover"
                                            onerror="handleImgError(this)"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Bottom Add More Photos Button -->
                <button 
                    type="button" 
                    onclick="addGallerySlot()"
                    class="w-full py-3.5 px-4 rounded-2xl border-2 border-dashed border-emerald-300 hover:border-brand bg-emerald-50/40 hover:bg-emerald-50 text-brand font-extrabold text-xs flex items-center justify-center gap-2 transition-all cursor-pointer active:scale-[0.99]"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>+ Tambah Foto Kamar Lainnya (Sepuasnya)</span>
                </button>
            </article>
        </div>

        <!-- Sidebar Column (Right - 5 cols on Desktop) -->
        <div class="lg:col-span-5 xl:col-span-4 flex flex-col gap-6">
            <!-- Pricing & Status Card -->
            <article class="bg-white rounded-2xl border border-slate-100 shadow-soft p-6 sm:p-8 flex flex-col gap-5">
                <h2 class="text-base font-black text-slate-900 font-display border-b border-slate-100 pb-3 flex items-center gap-2">
                    <svg class="w-4.5 h-4.5 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Harga & Status Sewa</span>
                </h2>

                <div class="space-y-4">
                    <!-- Status -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block">Status Ketersediaan Unit <span class="text-red-500">*</span></label>
                        <select 
                            name="status" 
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-black bg-white text-slate-900"
                        >
                            @foreach(['Tersedia', 'Terisi', 'Pemeliharaan'] as $st)
                                <option value="{{ $st }}" @selected(old('status', $room->status ?: 'Tersedia') === $st)>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block">Harga Sewa Bulanan (Rp) <span class="text-red-500">*</span></label>
                        <div class="relative mt-1.5">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-black text-slate-400">Rp</span>
                            <input 
                                name="price" 
                                type="number" 
                                min="0" 
                                step="50000"
                                value="{{ old('price', $room->price ?: 1800000) }}" 
                                placeholder="1800000" 
                                required 
                                class="w-full pl-10 pr-4 py-3 text-xs rounded-xl border border-slate-200 outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-black font-mono text-slate-900 text-sm"
                            />
                        </div>
                    </div>

                    <!-- Min Stay -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block">Minimal Periode Sewa <span class="text-red-500">*</span></label>
                        <input 
                            name="min_stay" 
                            value="{{ old('min_stay', $room->min_stay ?: '1 Bulan') }}" 
                            placeholder="1 Bulan" 
                            required 
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold text-slate-900"
                        />
                    </div>

                    <!-- Max Occupants -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block">Kapasitas Maksimal <span class="text-red-500">*</span></label>
                        <div class="mt-1.5 flex items-center gap-2 p-3 bg-slate-50 border border-slate-200 rounded-xl">
                            <input 
                                name="max_occupants" 
                                type="number" 
                                min="1" 
                                max="10" 
                                value="{{ old('max_occupants', $room->max_occupants ?: 1) }}" 
                                required 
                                class="w-16 bg-white border border-slate-200 rounded-lg px-2 py-1 text-xs font-black font-mono text-slate-900 text-center"
                            />
                            <span class="text-xs font-bold text-slate-600">Orang (Standar 1 Orang)</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Room Physical Specs Card -->
            <article class="bg-white rounded-2xl border border-slate-100 shadow-soft p-6 sm:p-8 flex flex-col gap-5">
                <h2 class="text-base font-black text-slate-900 font-display border-b border-slate-100 pb-3 flex items-center gap-2">
                    <svg class="w-4.5 h-4.5 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Spesifikasi Fisik Unit</span>
                </h2>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Size -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block">Luas Kamar (m²) <span class="text-red-500">*</span></label>
                        <input 
                            name="size" 
                            type="number" 
                            min="1" 
                            value="{{ old('size', $room->size ?: 16) }}" 
                            required 
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold font-mono text-slate-900"
                        />
                    </div>

                    <!-- Beds -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block">Tempat Tidur <span class="text-red-500">*</span></label>
                        <input 
                            name="beds" 
                            type="number" 
                            min="1" 
                            value="{{ old('beds', $room->beds ?: 1) }}" 
                            required 
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold font-mono text-slate-900"
                        />
                    </div>

                    <!-- Rating -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block">Rating (0–5) <span class="text-red-500">*</span></label>
                        <input 
                            name="rating" 
                            type="number" 
                            step="0.1" 
                            min="0" 
                            max="5" 
                            value="{{ old('rating', $room->rating ?: 4.9) }}" 
                            required 
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold font-mono text-slate-900"
                        />
                    </div>

                    <!-- Views -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block">Statistik Views</label>
                        <input 
                            name="views" 
                            type="number" 
                            min="0" 
                            value="{{ old('views', $room->views ?: 0) }}" 
                            class="mt-1.5 w-full rounded-xl border border-slate-200 px-4 py-3 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold font-mono text-slate-900"
                        />
                    </div>
                </div>
            </article>

            <!-- Bottom Action Footer Card -->
            <article class="bg-white rounded-2xl border border-slate-100 shadow-soft p-6 flex items-center justify-between">
                <a 
                    href="{{ route('admin.rooms.index') }}" 
                    class="font-bold text-xs text-slate-500 hover:text-slate-900 transition-colors"
                >
                    Batal & Kembali
                </a>

                <button 
                    type="submit"
                    class="rounded-xl bg-brand hover:bg-brandHover px-6 py-3 font-bold text-xs text-white shadow-md shadow-brand/20 transition-all cursor-pointer flex items-center gap-2 active:scale-95"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ $editing ? 'Simpan Perubahan' : 'Terbitkan Kamar' }}</span>
                </button>
            </article>
        </div>
    </form>
</main>
@endsection

@push('scripts')
<script>
    let nextSlotCounter = {{ count($initialGallery) + 10 }};

    function refreshSlotBadges() {
        const container = document.getElementById('gallery-slots-container');
        if (!container) return;
        const cards = container.querySelectorAll('.gallery-slot-card');
        const countBadge = document.getElementById('gallery-count-badge');
        if (countBadge) {
            countBadge.textContent = cards.length + ' Foto';
        }

        cards.forEach((card, index) => {
            const badge = card.querySelector('.slot-order-badge');
            if (badge) {
                if (index === 0) {
                    badge.className = 'slot-order-badge inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-extrabold bg-brand text-white';
                    badge.textContent = '#1 • Foto Utama (Sampul)';
                } else {
                    badge.className = 'slot-order-badge inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-extrabold bg-slate-200 text-slate-700';
                    badge.textContent = '#' + (index + 1) + ' • Foto Tambahan';
                }
            }
        });
    }

    function addGallerySlot(options = {}) {
        const container = document.getElementById('gallery-slots-container');
        if (!container) return null;

        const slotId = nextSlotCounter++;
        const currentCount = container.querySelectorAll('.gallery-slot-card').length;
        const defaultLabel = options.label || ('Foto Kamar ' + (currentCount + 1));
        const defaultUrl = options.url || '';
        const previewSrc = defaultUrl || window.MAMA_ANIS_PLACEHOLDER || '/images/Kamar no 5.jpg';

        const card = document.createElement('div');
        card.className = 'gallery-slot-card p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col gap-4 transition-all rise';
        card.setAttribute('data-slot-id', slotId);

        card.innerHTML = `
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <span class="slot-order-badge inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-extrabold bg-slate-200 text-slate-700">
                        #${currentCount + 1} • Foto Tambahan
                    </span>
                </div>
                <button 
                    type="button" 
                    onclick="removeGallerySlot(this)"
                    class="inline-flex items-center gap-1 text-[11px] font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 border border-red-200/70 px-2.5 py-1 rounded-lg transition-colors cursor-pointer"
                    title="Hapus foto ini"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span>Hapus</span>
                </button>
            </div>

            <div class="grid gap-4 sm:grid-cols-12 items-center">
                <div class="sm:col-span-7 space-y-3">
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Judul / Keterangan Foto</label>
                        <input 
                            type="text"
                            name="gallery_labels[${slotId}]" 
                            value="" 
                            placeholder="Contoh: Foto Kamar Tidur / Kamar Mandi / Meja Belajar" 
                            class="slot-label-input w-full rounded-xl border border-slate-200 px-3.5 py-2 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold text-slate-800 bg-white"
                        />
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Upload File Gambar (Maks 5MB)</label>
                        <input 
                            type="file" 
                            name="gallery_files[${slotId}]" 
                            accept="image/png, image/jpeg, image/jpg, image/webp" 
                            onchange="previewSlotFile(this)"
                            class="slot-file-input w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-brand/10 file:text-brand hover:file:bg-brand/20 border border-slate-200 rounded-xl p-1 bg-white cursor-pointer"
                        />
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Atau Gunakan URL Gambar</label>
                        <input 
                            type="text"
                            name="gallery_urls[${slotId}]" 
                            value="" 
                            placeholder="https://... atau /images/..." 
                            oninput="previewSlotUrl(this)"
                            class="slot-url-input w-full rounded-xl border border-slate-200 px-3.5 py-2 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-mono bg-white"
                        />
                    </div>
                </div>

                <!-- Live Preview -->
                <div class="sm:col-span-5">
                    <div class="relative w-full h-40 rounded-xl overflow-hidden border border-slate-200 bg-slate-200 flex items-center justify-center shadow-2xs">
                        <img 
                            src="${previewSrc}" 
                            alt="Preview Foto"
                            class="slot-preview-img w-full h-full object-cover"
                            onerror="handleImgError(this)"
                        />
                    </div>
                </div>
            </div>
        `;

        const labelInput = card.querySelector('.slot-label-input');
        if (labelInput) labelInput.value = defaultLabel;

        const urlInput = card.querySelector('.slot-url-input');
        if (urlInput) urlInput.value = defaultUrl;

        container.appendChild(card);

        if (options.file) {
            const fileInput = card.querySelector('.slot-file-input');
            if (fileInput) {
                try {
                    const dt = new DataTransfer();
                    dt.items.add(options.file);
                    fileInput.files = dt.files;
                } catch (e) {}
                previewSlotFile(fileInput, options.file);
            }
        }

        refreshSlotBadges();
        return card;
    }

    function removeGallerySlot(btn) {
        const container = document.getElementById('gallery-slots-container');
        const card = btn.closest('.gallery-slot-card');
        if (!container || !card) return;

        const allCards = container.querySelectorAll('.gallery-slot-card');
        if (allCards.length <= 1) {
            // Reset the last remaining card instead of leaving zero slots
            const fileInput = card.querySelector('.slot-file-input');
            const urlInput = card.querySelector('.slot-url-input');
            const previewImg = card.querySelector('.slot-preview-img');
            if (fileInput) fileInput.value = '';
            if (urlInput) urlInput.value = '';
            if (previewImg) previewImg.src = window.MAMA_ANIS_PLACEHOLDER || '/images/Kamar no 5.jpg';
            return;
        }

        card.remove();
        refreshSlotBadges();
    }

    function compressImageFileToDataUrl(file) {
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const rawDataUrl = e.target.result;
                const img = new Image();
                img.onload = function() {
                    try {
                        const maxDim = 1280;
                        let width = img.width;
                        let height = img.height;
                        if (width > maxDim || height > maxDim) {
                            const ratio = Math.min(maxDim / width, maxDim / height);
                            width = Math.max(1, Math.round(width * ratio));
                            height = Math.max(1, Math.round(height * ratio));
                        }
                        const canvas = document.createElement('canvas');
                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.fillStyle = '#FFFFFF';
                        ctx.fillRect(0, 0, width, height);
                        ctx.drawImage(img, 0, 0, width, height);
                        const compressedDataUrl = canvas.toDataURL('image/jpeg', 0.80);
                        resolve(compressedDataUrl || rawDataUrl);
                    } catch (err) {
                        resolve(rawDataUrl);
                    }
                };
                img.onerror = function() {
                    resolve(rawDataUrl);
                };
                img.src = rawDataUrl;
            };
            reader.readAsDataURL(file);
        });
    }

    function previewSlotFile(input, explicitFile = null) {
        const card = input.closest('.gallery-slot-card');
        if (!card) return;
        const previewImg = card.querySelector('.slot-preview-img');
        const urlInput = card.querySelector('.slot-url-input');
        const file = explicitFile || (input.files && input.files[0]);
        if (file && previewImg) {
            compressImageFileToDataUrl(file).then((dataUrl) => {
                previewImg.removeAttribute('data-error-handled');
                previewImg.src = dataUrl;
                if (urlInput && dataUrl) {
                    urlInput.value = dataUrl;
                    // Clear raw file input after converting to compressed Base64 so Vercel 4.5MB limit is never exceeded
                    try { input.value = ''; } catch (e) {}
                }
            });
        }
    }

    function previewSlotUrl(input) {
        const card = input.closest('.gallery-slot-card');
        if (!card) return;
        const previewImg = card.querySelector('.slot-preview-img');
        const url = input.value ? input.value.trim() : '';
        if (previewImg && url.length > 3) {
            previewImg.removeAttribute('data-error-handled');
            previewImg.src = url;
        }
    }

    function handleMultiPhotoSelect(input) {
        if (!input.files || input.files.length === 0) return;
        const files = Array.from(input.files);

        files.forEach((file) => {
            const rawName = file.name.replace(/\.[^/.]+$/, '').replace(/[-_]+/g, ' ').trim();
            const label = rawName ? ('Foto ' + rawName.charAt(0).toUpperCase() + rawName.slice(1)) : '';
            addGallerySlot({ label: label, file: file });
        });

        input.value = '';
    }
</script>
@endpush
