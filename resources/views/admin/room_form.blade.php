@extends('layouts.admin')

@section('title', ($mode === 'edit' ? 'Edit Kamar' : 'Tambah Kamar Baru') . ' | Admin Mama Anis Group')

@section('content')
@php
    $editing = $mode === 'edit';
    $initialGallery = [];
    if (is_array(old('photo_label')) && count(old('photo_label')) > 0) {
        $oldLinks = old('photo_link', []);
        $oldLabels = old('photo_label', []);
        foreach ($oldLabels as $k => $lbl) {
            $initialGallery[] = [
                'url' => $oldLinks[$k] ?? '',
                'label' => $lbl ?: ('Foto Kamar ' . (count($initialGallery) + 1)),
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
<main class="w-full max-w-7xl mx-auto p-3.5 sm:p-8 lg:p-10 flex flex-col gap-5 sm:gap-6 rise overflow-x-hidden">
    <!-- Top Bar Navigation -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-200/80 pb-5">
        <div class="min-w-0">
            <a 
                href="{{ route('admin.rooms.index') }}" 
                class="inline-flex items-center gap-2 text-xs font-bold text-slate-700 hover:text-brand bg-white border border-slate-200 hover:border-emerald-300 px-3.5 py-1.5 rounded-xl shadow-2xs hover:shadow-xs transition-all mb-2.5 active:scale-95 cursor-pointer"
            >
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Kelola Kamar</span>
            </a>
            <h1 class="text-xl sm:text-3xl font-black text-slate-900 font-display tracking-tight">
                {{ $editing ? 'Edit Unit: ' . $room->name : 'Tambah Unit Kamar Baru' }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Kelola informasi unit, galeri foto kamar & kamar mandi, fasilitas, serta harga dan spesifikasi fisik secara proporsional.
            </p>
        </div>

        <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end shrink-0">
            <a 
                href="{{ route('admin.rooms.index') }}" 
                class="h-10 inline-flex items-center justify-center rounded-xl px-4 font-bold text-xs text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition-colors whitespace-nowrap"
            >
                Batal
            </a>
            <button 
                type="submit"
                form="room-form"
                class="h-10 rounded-xl bg-brand hover:bg-brandHover px-5 font-bold text-xs text-white shadow-md shadow-brand/20 transition-all cursor-pointer inline-flex items-center justify-center gap-2 active:scale-95 whitespace-nowrap"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
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

    <!-- Form Layout: Proportional Split Columns on Desktop -->
    <form 
        id="room-form"
        method="POST" 
        action="{{ $editing ? route('admin.rooms.update', $room) : route('admin.rooms.store') }}" 
        enctype="multipart/form-data"
        class="grid gap-6 lg:grid-cols-12 items-start"
    >
        @csrf

        <!-- Main Column (Left - 7 cols on lg, 8 cols on xl) -->
        <div class="lg:col-span-7 xl:col-span-8 flex flex-col gap-6 min-w-0">
            <!-- Basic Information Card -->
            <article class="bg-white rounded-2xl border border-slate-100 shadow-soft p-5 sm:p-7 flex flex-col gap-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                    <h2 class="text-base font-black text-slate-900 font-display flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-emerald-50 text-brand border border-emerald-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </span>
                        <span>Informasi Utama Unit</span>
                    </h2>
                    <span class="text-[11px] font-bold text-slate-400 hidden sm:inline">Identitas & Fasilitas Kamar</span>
                </div>

                <div class="grid gap-4 sm:gap-5 sm:grid-cols-2">
                    <!-- Room Name -->
                    <div class="sm:col-span-2">
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Nama Unit Kamar <span class="text-red-500">*</span></label>
                        <input 
                            name="name" 
                            value="{{ old('name', $room->name ?: 'Kamar Kost Mama Anis') }}" 
                            placeholder="Contoh: Kamar Kost Mama Anis (Pintu 1)" 
                            required 
                            class="w-full h-11 rounded-xl border border-slate-200 bg-slate-50/40 focus:bg-white px-4 text-xs sm:text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold text-slate-900 transition-all"
                        />
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Tipe Kamar <span class="text-red-500">*</span></label>
                        <input 
                            name="type" 
                            list="room-type-suggestions"
                            value="{{ old('type', $room->type ?: 'Kamar Standard Eksklusif') }}" 
                            placeholder="Contoh: Kamar Standard Eksklusif" 
                            required 
                            class="w-full h-11 rounded-xl border border-slate-200 bg-slate-50/40 focus:bg-white px-4 text-xs sm:text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-semibold text-slate-900 transition-all"
                        />
                        <datalist id="room-type-suggestions">
                            <option value="Kamar Standard Eksklusif"></option>
                            <option value="Kamar Deluxe Putri"></option>
                            <option value="Kamar VIP Eksklusif"></option>
                        </datalist>
                    </div>

                    <!-- Location -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Lokasi Properti <span class="text-red-500">*</span></label>
                        <input 
                            name="location" 
                            value="{{ old('location', $room->location ?: 'Alam Sutera, Tangerang') }}" 
                            placeholder="Contoh: Alam Sutera, Tangerang"
                            required 
                            class="w-full h-11 rounded-xl border border-slate-200 bg-slate-50/40 focus:bg-white px-4 text-xs sm:text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-semibold text-slate-900 transition-all"
                        />
                    </div>

                    <!-- Description -->
                    <div class="sm:col-span-2">
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Deskripsi Lengkap Unit <span class="text-red-500">*</span></label>
                        <textarea 
                            name="description" 
                            rows="4" 
                            required 
                            placeholder="Tuliskan gambaran kenyamanan, kebersihan kamar mandi dalam, dan keunggulan kamar ini..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50/40 focus:bg-white p-4 text-xs sm:text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-medium text-slate-800 leading-relaxed transition-all"
                        >{{ old('description', $room->description ?: 'Unit kamar kost Mama Anis dirancang khusus untuk kenyamanan dan privasi 1 orang penghuni. Dilengkapi fasilitas kamar mandi dalam yang bersih dan higienis, AC, kasur berkualitas, lemari pakaian, meja kerja/belajar, dan koneksi internet WiFi stabil. Minimal durasi sewa 1 bulan.') }}</textarea>
                    </div>

                    <!-- Amenities -->
                    <div class="sm:col-span-2">
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Fasilitas Unit <span class="text-slate-400 font-medium">(pisahkan dengan koma)</span></label>
                        <input 
                            name="amenities_text" 
                            value="{{ old('amenities_text', is_array($room->amenities) ? implode(', ', $room->amenities) : 'Kamar Mandi Dalam, AC Sejuk, WiFi Cepat, Kasur Springbed & Bantal, Lemari Pakaian, Meja & Kursi, Listrik Token, Air Bersih') }}" 
                            placeholder="Kamar Mandi Dalam, AC Sejuk, WiFi Cepat, Kasur Springbed & Bantal, Lemari Pakaian, Meja & Kursi, Listrik Token, Air Bersih" 
                            class="w-full h-11 rounded-xl border border-slate-200 bg-slate-50/40 focus:bg-white px-4 text-xs sm:text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-semibold text-slate-800 transition-all"
                        />
                        <p class="text-[11px] text-slate-400 mt-1.5">Fasilitas akan otomatis ditampilkan sebagai lencana (badge) rapi di halaman detail kamar publik.</p>
                    </div>
                </div>
            </article>

            <!-- Media & Photos Card: Dynamic Unlimited Gallery Photos -->
            <article class="bg-white rounded-2xl border border-slate-100 shadow-soft p-5 sm:p-7 flex flex-col gap-5">
                <!-- Header Toolbar: Side-by-side buttons that never stack awkwardly -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <h2 class="text-base font-black text-slate-900 font-display flex items-center gap-2.5">
                                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-brand border border-emerald-100 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </span>
                                <span>Galeri Foto Kamar</span>
                            </h2>
                            <span id="gallery-count-badge" class="bg-emerald-50 text-brand border border-emerald-200 px-2.5 py-0.5 rounded-full text-[11px] font-extrabold whitespace-nowrap">
                                {{ count($initialGallery) }} Foto
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 mt-1.5 leading-relaxed">
                            Foto urutan pertama (<strong class="text-slate-600">#1</strong>) menjadi sampul utama katalog. Anda bebas menambahkan banyak foto sekaligus.
                        </p>
                    </div>

                    <!-- Action Buttons: Strictly side-by-side in one proportional row -->
                    <div class="grid grid-cols-2 sm:flex items-center gap-2.5 shrink-0">
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
                            class="h-10 inline-flex items-center justify-center gap-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-brand border border-emerald-200 px-3.5 text-xs font-bold transition-all cursor-pointer active:scale-95 whitespace-nowrap"
                        >
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            <span>Upload Sekaligus</span>
                        </button>

                        <button 
                            type="button" 
                            onclick="addGallerySlot()"
                            class="h-10 inline-flex items-center justify-center gap-1.5 rounded-xl bg-brand hover:bg-brandHover text-white px-4 text-xs font-bold shadow-xs transition-all cursor-pointer active:scale-95 whitespace-nowrap"
                        >
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span>Tambah Slot Foto</span>
                        </button>
                    </div>
                </div>

                <!-- Dynamic Gallery Slots Container -->
                <div id="gallery-slots-container" class="flex flex-col gap-4">
                    @foreach($initialGallery as $idx => $item)
                        <div class="gallery-slot-card p-4 sm:p-5 rounded-2xl bg-slate-50/80 border border-slate-200/90 flex flex-col gap-4 transition-all" data-slot-id="{{ $idx }}">
                            <div class="flex items-center justify-between gap-2 border-b border-slate-200/60 pb-3">
                                <div class="flex items-center gap-2">
                                    <span class="slot-order-badge inline-flex items-center px-3 py-1 rounded-lg text-[11px] font-extrabold {{ $idx === 0 ? 'bg-brand text-white shadow-2xs' : 'bg-slate-200 text-slate-700' }}">
                                        {{ $idx === 0 ? '#1 • Foto Utama (Sampul)' : '#' . ($idx + 1) . ' • Foto Tambahan' }}
                                    </span>
                                </div>
                                <button 
                                    type="button" 
                                    onclick="removeGallerySlot(this)"
                                    class="inline-flex items-center gap-1.5 text-[11px] font-bold text-red-600 hover:text-red-700 bg-white hover:bg-red-50 border border-red-200 px-3 py-1 rounded-lg transition-colors cursor-pointer"
                                    title="Hapus foto ini"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span>Hapus</span>
                                </button>
                            </div>

                            <div class="grid gap-4 sm:gap-5 sm:grid-cols-12 items-stretch">
                                <!-- Left Inputs (7 cols) -->
                                <div class="sm:col-span-7 flex flex-col justify-between gap-3">
                                    <input type="hidden" name="photo_keep[{{ $idx }}]" value="{{ $editing ? $idx : '' }}" class="slot-keep-input" />
                                    <div>
                                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Judul / Keterangan Foto</label>
                                        <input 
                                            type="text"
                                            name="photo_label[{{ $idx }}]" 
                                            value="{{ $item['label'] }}" 
                                            placeholder="Contoh: Foto Kamar Tidur / Kamar Mandi Dalam" 
                                            class="slot-label-input w-full h-10 rounded-xl border border-slate-200 px-3.5 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold text-slate-800 bg-white"
                                        />
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Upload File Gambar (JPG/PNG/WebP)</label>
                                        <input 
                                            type="file" 
                                            name="gallery_files[{{ $idx }}]"
                                            accept="image/png, image/jpeg, image/jpg, image/webp" 
                                            onchange="previewSlotFile(this)"
                                            class="slot-file-input w-full h-10 text-xs text-slate-500 file:mr-3 file:h-full file:px-3.5 file:rounded-l-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-brand hover:file:bg-emerald-100 border border-slate-200 rounded-xl bg-white cursor-pointer"
                                        />
                                        <p class="slot-status-text text-[10px] text-emerald-600 font-bold mt-1 {{ str_starts_with($item['url'] ?? '', 'data:image/') ? '' : 'hidden' }}">
                                            ✓ Foto tersimpan (pilih file baru jika ingin mengganti)
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Atau Gunakan Link URL Gambar</label>
                                        <input 
                                            type="text"
                                            name="photo_link[{{ $idx }}]" 
                                            value="{{ str_starts_with($item['url'] ?? '', 'data:image/') ? '' : ($item['url'] ?? '') }}" 
                                            placeholder="{{ str_starts_with($item['url'] ?? '', 'data:image/') ? 'Foto upload tersimpan (isi link jika ingin ganti)' : 'https://... atau /images/...' }}" 
                                            oninput="previewSlotUrl(this)"
                                            class="slot-url-input w-full h-10 rounded-xl border border-slate-200 px-3.5 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-mono bg-white text-slate-700"
                                        />
                                    </div>
                                </div>

                                <!-- Right Live Preview (5 cols, stretched proportionally to match left inputs) -->
                                <div class="sm:col-span-5 flex flex-col">
                                    <span class="text-[11px] font-bold text-slate-600 block mb-1">Pratinjau Gambar</span>
                                    <div class="relative w-full h-44 sm:h-full min-h-[168px] flex-1 rounded-xl overflow-hidden border border-slate-200 bg-white flex items-center justify-center shadow-2xs">
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
                    class="w-full h-12 px-4 rounded-2xl border-2 border-dashed border-emerald-300 hover:border-brand bg-emerald-50/40 hover:bg-emerald-50 text-brand font-extrabold text-xs flex items-center justify-center gap-2 transition-all cursor-pointer active:scale-[0.99]"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Slot Foto Kamar Lainnya</span>
                </button>
            </article>
        </div>

        <!-- Sidebar Column (Right - 5 cols on lg, 4 cols on xl, Sticky on Desktop) -->
        <div class="lg:col-span-5 xl:col-span-4 flex flex-col gap-6 lg:sticky lg:top-6 min-w-0">
            <!-- Pricing & Status Card -->
            <article class="bg-white rounded-2xl border border-slate-100 shadow-soft p-5 sm:p-7 flex flex-col gap-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                    <h2 class="text-base font-black text-slate-900 font-display flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-emerald-50 text-brand border border-emerald-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </span>
                        <span>Harga & Status Sewa</span>
                    </h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Status -->
                    <div class="sm:col-span-2">
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Status Ketersediaan Unit <span class="text-red-500">*</span></label>
                        <select 
                            name="status" 
                            class="w-full h-11 rounded-xl border border-slate-200 bg-slate-50/40 focus:bg-white px-4 text-xs sm:text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold text-slate-900 cursor-pointer transition-all"
                        >
                            @foreach(['Tersedia', 'Terisi', 'Pemeliharaan'] as $st)
                                <option value="{{ $st }}" @selected(old('status', $room->status ?: 'Tersedia') === $st)>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="sm:col-span-2">
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Harga Sewa Bulanan <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <span class="absolute left-3.5 text-xs font-black text-brand bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md pointer-events-none">Rp</span>
                            <input 
                                name="price" 
                                type="number" 
                                min="0" 
                                step="50000"
                                value="{{ old('price', $room->price ?: 1800000) }}" 
                                placeholder="1800000" 
                                required 
                                class="w-full h-11 pl-12 pr-16 rounded-xl border border-slate-200 bg-slate-50/40 focus:bg-white outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-black font-mono text-slate-900 text-sm transition-all"
                            />
                            <span class="absolute right-3.5 text-[11px] font-bold text-slate-400 pointer-events-none">/ Bulan</span>
                        </div>
                    </div>

                    <!-- Min Stay -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Minimal Sewa <span class="text-red-500">*</span></label>
                        <input 
                            name="min_stay" 
                            value="{{ old('min_stay', $room->min_stay ?: '1 Bulan') }}" 
                            placeholder="1 Bulan" 
                            required 
                            class="w-full h-11 rounded-xl border border-slate-200 bg-slate-50/40 focus:bg-white px-3.5 text-xs sm:text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold text-slate-900 transition-all"
                        />
                    </div>

                    <!-- Max Occupants (Proportionally aligned with Minimal Sewa!) -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Kapasitas Maks. <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <input 
                                name="max_occupants" 
                                type="number" 
                                min="1" 
                                max="10" 
                                value="{{ old('max_occupants', $room->max_occupants ?: 1) }}" 
                                required 
                                class="w-full h-11 pl-3.5 pr-16 rounded-xl border border-slate-200 bg-slate-50/40 focus:bg-white text-xs sm:text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-black font-mono text-slate-900 transition-all"
                            />
                            <span class="absolute right-3 text-[11px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md pointer-events-none">Orang</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Room Physical Specs Card -->
            <article class="bg-white rounded-2xl border border-slate-100 shadow-soft p-5 sm:p-7 flex flex-col gap-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3.5">
                    <h2 class="text-base font-black text-slate-900 font-display flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-emerald-50 text-brand border border-emerald-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </span>
                        <span>Spesifikasi Fisik Unit</span>
                    </h2>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Size -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Luas Kamar <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <input 
                                name="size" 
                                type="number" 
                                min="1" 
                                value="{{ old('size', $room->size ?: 16) }}" 
                                required 
                                class="w-full h-11 pl-3.5 pr-12 rounded-xl border border-slate-200 bg-slate-50/40 focus:bg-white text-xs sm:text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold font-mono text-slate-900 transition-all"
                            />
                            <span class="absolute right-3 text-[11px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md pointer-events-none">m²</span>
                        </div>
                    </div>

                    <!-- Beds -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Tempat Tidur <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <input 
                                name="beds" 
                                type="number" 
                                min="1" 
                                value="{{ old('beds', $room->beds ?: 1) }}" 
                                required 
                                class="w-full h-11 pl-3.5 pr-14 rounded-xl border border-slate-200 bg-slate-50/40 focus:bg-white text-xs sm:text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold font-mono text-slate-900 transition-all"
                            />
                            <span class="absolute right-3 text-[11px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md pointer-events-none">Kasur</span>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Rating Unit <span class="text-red-500">*</span></label>
                        <div class="relative flex items-center">
                            <input 
                                name="rating" 
                                type="number" 
                                step="0.1" 
                                min="0" 
                                max="5" 
                                value="{{ old('rating', $room->rating ?: 4.9) }}" 
                                required 
                                class="w-full h-11 pl-3.5 pr-14 rounded-xl border border-slate-200 bg-slate-50/40 focus:bg-white text-xs sm:text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold font-mono text-slate-900 transition-all"
                            />
                            <span class="absolute right-3 text-[11px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-1.5 py-0.5 rounded-md pointer-events-none">★ / 5</span>
                        </div>
                    </div>

                    <!-- Views -->
                    <div>
                        <label class="text-xs font-bold text-slate-700 block mb-1.5">Statistik Views</label>
                        <div class="relative flex items-center">
                            <input 
                                name="views" 
                                type="number" 
                                min="0" 
                                value="{{ old('views', $room->views ?: 0) }}" 
                                class="w-full h-11 pl-3.5 pr-14 rounded-xl border border-slate-200 bg-slate-50/40 focus:bg-white text-xs sm:text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold font-mono text-slate-900 transition-all"
                            />
                            <span class="absolute right-3 text-[10px] font-bold text-slate-400 pointer-events-none">Views</span>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Bottom Action Footer Card -->
            <article class="bg-white rounded-2xl border border-slate-100 shadow-soft p-5 flex items-center justify-between gap-3">
                <a 
                    href="{{ route('admin.rooms.index') }}" 
                    class="h-11 px-4 rounded-xl border border-slate-200 hover:bg-slate-50 inline-flex items-center justify-center font-bold text-xs text-slate-600 hover:text-slate-900 transition-colors whitespace-nowrap"
                >
                    Batal & Kembali
                </a>

                <button 
                    type="submit"
                    class="h-11 flex-1 rounded-xl bg-brand hover:bg-brandHover px-5 font-bold text-xs text-white shadow-md shadow-brand/20 transition-all cursor-pointer inline-flex items-center justify-center gap-2 active:scale-95 whitespace-nowrap"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
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
    let pendingCompressions = 0;

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('room-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (pendingCompressions > 0) {
                    e.preventDefault();
                    const waitTimer = setInterval(function() {
                        if (pendingCompressions <= 0) {
                            clearInterval(waitTimer);
                            form.submit();
                        }
                    }, 80);
                }
            });
        }
    });

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
                    badge.className = 'slot-order-badge inline-flex items-center px-3 py-1 rounded-lg text-[11px] font-extrabold bg-brand text-white shadow-2xs';
                    badge.textContent = '#1 • Foto Utama (Sampul)';
                } else {
                    badge.className = 'slot-order-badge inline-flex items-center px-3 py-1 rounded-lg text-[11px] font-extrabold bg-slate-200 text-slate-700';
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
        card.className = 'gallery-slot-card p-4 sm:p-5 rounded-2xl bg-slate-50/80 border border-slate-200/90 flex flex-col gap-4 transition-all rise';
        card.setAttribute('data-slot-id', slotId);

        card.innerHTML = `
            <div class="flex items-center justify-between gap-2 border-b border-slate-200/60 pb-3">
                <div class="flex items-center gap-2">
                    <span class="slot-order-badge inline-flex items-center px-3 py-1 rounded-lg text-[11px] font-extrabold bg-slate-200 text-slate-700">
                        #${currentCount + 1} • Foto Tambahan
                    </span>
                </div>
                <button 
                    type="button" 
                    onclick="removeGallerySlot(this)"
                    class="inline-flex items-center gap-1.5 text-[11px] font-bold text-red-600 hover:text-red-700 bg-white hover:bg-red-50 border border-red-200 px-3 py-1 rounded-lg transition-colors cursor-pointer"
                    title="Hapus foto ini"
                >
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span>Hapus</span>
                </button>
            </div>

            <div class="grid gap-4 sm:gap-5 sm:grid-cols-12 items-stretch">
                <div class="sm:col-span-7 flex flex-col justify-between gap-3">
                    <input type="hidden" name="photo_keep[${slotId}]" value="" class="slot-keep-input" />
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Judul / Keterangan Foto</label>
                        <input 
                            type="text"
                            name="photo_label[${slotId}]" 
                            value="" 
                            placeholder="Contoh: Foto Kamar Tidur / Kamar Mandi Dalam" 
                            class="slot-label-input w-full h-10 rounded-xl border border-slate-200 px-3.5 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-bold text-slate-800 bg-white"
                        />
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Upload File Gambar (JPG/PNG/WebP)</label>
                        <input 
                            type="file" 
                            name="gallery_files[${slotId}]"
                            accept="image/png, image/jpeg, image/jpg, image/webp" 
                            onchange="previewSlotFile(this)"
                            class="slot-file-input w-full h-10 text-xs text-slate-500 file:mr-3 file:h-full file:px-3.5 file:rounded-l-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-brand hover:file:bg-emerald-100 border border-slate-200 rounded-xl bg-white cursor-pointer"
                        />
                        <p class="slot-status-text text-[10px] text-emerald-600 font-bold mt-1 hidden">
                            ✓ Foto siap disimpan
                        </p>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-600 block mb-1">Atau Gunakan Link URL Gambar</label>
                        <input 
                            type="text"
                            name="photo_link[${slotId}]" 
                            value="" 
                            placeholder="https://... atau /images/..." 
                            oninput="previewSlotUrl(this)"
                            class="slot-url-input w-full h-10 rounded-xl border border-slate-200 px-3.5 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-mono bg-white text-slate-700"
                        />
                    </div>
                </div>

                <!-- Live Preview -->
                <div class="sm:col-span-5 flex flex-col">
                    <span class="text-[11px] font-bold text-slate-600 block mb-1">Pratinjau Gambar</span>
                    <div class="relative w-full h-44 sm:h-full min-h-[168px] flex-1 rounded-xl overflow-hidden border border-slate-200 bg-white flex items-center justify-center shadow-2xs">
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
            const fileInput = card.querySelector('.slot-file-input');
            const urlInput = card.querySelector('.slot-url-input');
            const keepInput = card.querySelector('.slot-keep-input');
            const statusText = card.querySelector('.slot-status-text');
            const previewImg = card.querySelector('.slot-preview-img');
            if (fileInput) fileInput.value = '';
            if (urlInput) urlInput.value = '';
            if (keepInput) keepInput.value = '';
            if (statusText) statusText.classList.add('hidden');
            if (previewImg) previewImg.src = window.MAMA_ANIS_PLACEHOLDER || '/images/Kamar no 5.jpg';
            return;
        }

        card.remove();
        refreshSlotBadges();
    }

    function compressImageToFile(file) {
        return new Promise((resolve) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const rawDataUrl = e.target.result;
                const img = new Image();
                img.onload = function() {
                    try {
                        const maxDim = 1024;
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
                        const previewDataUrl = canvas.toDataURL('image/jpeg', 0.78);
                        canvas.toBlob(function(blob) {
                            if (blob) {
                                const cleanName = (file.name || 'room').replace(/[^a-zA-Z0-9_-]/g, '_') + '.jpg';
                                const compressedFile = new File([blob], cleanName, {
                                    type: 'image/jpeg',
                                    lastModified: Date.now()
                                });
                                resolve({ file: compressedFile, previewUrl: previewDataUrl });
                            } else {
                                resolve({ file: file, previewUrl: rawDataUrl });
                            }
                        }, 'image/jpeg', 0.78);
                    } catch (err) {
                        resolve({ file: file, previewUrl: rawDataUrl });
                    }
                };
                img.onerror = function() {
                    resolve({ file: file, previewUrl: rawDataUrl });
                };
                img.src = rawDataUrl;
            };
            reader.readAsDataURL(file);
        });
    }

    function previewSlotFile(input, explicitFile = null) {
        if (input.dataset.compressing === '1') return;
        const card = input.closest('.gallery-slot-card');
        if (!card) return;
        const previewImg = card.querySelector('.slot-preview-img');
        const urlInput = card.querySelector('.slot-url-input');
        const keepInput = card.querySelector('.slot-keep-input');
        const statusText = card.querySelector('.slot-status-text');
        const file = explicitFile || (input.files && input.files[0]);
        if (file && previewImg) {
            pendingCompressions++;
            if (statusText) {
                statusText.textContent = '⏳ Mengompresi foto...';
                statusText.classList.remove('hidden');
            }
            compressImageToFile(file).then((res) => {
                previewImg.removeAttribute('data-error-handled');
                previewImg.src = res.previewUrl;
                try {
                    input.dataset.compressing = '1';
                    const dt = new DataTransfer();
                    dt.items.add(res.file);
                    input.files = dt.files;
                } catch (e) {
                } finally {
                    delete input.dataset.compressing;
                }
                if (urlInput) {
                    urlInput.value = '';
                }
                if (keepInput) {
                    keepInput.value = '';
                }
                if (statusText) {
                    statusText.textContent = '✓ Foto siap diunggah (' + Math.max(1, Math.round(res.file.size / 1024)) + ' KB)';
                    statusText.classList.remove('hidden');
                }
            }).finally(() => {
                pendingCompressions = Math.max(0, pendingCompressions - 1);
            });
        }
    }

    function previewSlotUrl(input) {
        const card = input.closest('.gallery-slot-card');
        if (!card) return;
        const previewImg = card.querySelector('.slot-preview-img');
        const fileInput = card.querySelector('.slot-file-input');
        const keepInput = card.querySelector('.slot-keep-input');
        const statusText = card.querySelector('.slot-status-text');
        const url = input.value ? input.value.trim() : '';
        if (previewImg && url.length > 3) {
            previewImg.removeAttribute('data-error-handled');
            previewImg.src = url;
            if (fileInput) fileInput.value = '';
            if (keepInput) keepInput.value = '';
            if (statusText) statusText.classList.add('hidden');
        }
    }

    function handleMultiPhotoSelect(input) {
        if (!input.files || input.files.length === 0) return;
        const files = Array.from(input.files);
        const container = document.getElementById('gallery-slots-container');

        // Find any un-customized starter slots (only in Create mode where photo_keep is empty and no file uploaded yet)
        const starterCards = [];
        if (container) {
            container.querySelectorAll('.gallery-slot-card').forEach((card) => {
                const keepInput = card.querySelector('.slot-keep-input');
                const fileInput = card.querySelector('.slot-file-input');
                const urlInput = card.querySelector('.slot-url-input');
                const isDefaultUrl = !urlInput || !urlInput.value || urlInput.value === '/images/Kamar no 5.jpg' || urlInput.value === '/images/Kamar mandi.jpg';
                const hasKeep = keepInput && keepInput.value !== '';
                const hasFile = fileInput && fileInput.files && fileInput.files.length > 0;
                if (!hasKeep && !hasFile && isDefaultUrl) {
                    starterCards.push(card);
                }
            });
        }

        files.forEach((file) => {
            const rawName = file.name.replace(/\.[^/.]+$/, '').replace(/[-_]+/g, ' ').trim();
            const label = rawName ? ('Foto ' + rawName.charAt(0).toUpperCase() + rawName.slice(1)) : '';

            if (starterCards.length > 0) {
                const targetCard = starterCards.shift();
                const fileInput = targetCard.querySelector('.slot-file-input');
                const labelInput = targetCard.querySelector('.slot-label-input');
                if (label && labelInput && (!labelInput.value || labelInput.value.startsWith('Foto Kamar'))) {
                    labelInput.value = label;
                }
                if (fileInput) {
                    previewSlotFile(fileInput, file);
                }
            } else {
                addGallerySlot({ label: label, file: file });
            }
        });

        input.value = '';
    }
</script>
@endpush
