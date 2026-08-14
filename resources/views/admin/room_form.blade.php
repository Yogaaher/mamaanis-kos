@extends('layouts.admin')

@section('title', ($mode === 'edit' ? 'Edit Kamar' : 'Tambah Kamar Baru') . ' | Admin Mama Anis Group')

@section('content')
@php($editing = $mode === 'edit')
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

            <!-- Media & Photos Card: Foto Kamar Utama & Foto Kamar Mandi -->
            <article class="bg-white rounded-2xl border border-slate-100 shadow-soft p-6 sm:p-8 flex flex-col gap-6">
                <h2 class="text-base font-black text-slate-900 font-display border-b border-slate-100 pb-3 flex items-center gap-2">
                    <svg class="w-4.5 h-4.5 text-brand" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Galeri Foto (Foto Kamar & Kamar Mandi)</span>
                </h2>

                <!-- 1. Foto Kamar Utama -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">1. Foto Kamar Utama (Bedroom View)</span>
                            <span class="text-[10px] text-slate-400">Tampilan utama ruangan kamar, tempat tidur, & perabotan.</span>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 items-center">
                        <div class="space-y-3">
                            <div>
                                <label class="text-[11px] font-bold text-slate-600 block mb-1">Upload File Foto Kamar</label>
                                <input 
                                    type="file" 
                                    name="image_file" 
                                    id="image_file_input"
                                    accept="image/png, image/jpeg, image/jpg, image/webp" 
                                    onchange="previewUploadedFile(this, 'preview_image')"
                                    class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-brand/10 file:text-brand hover:file:bg-brand/20 border border-slate-200 rounded-xl p-1 bg-white"
                                />
                            </div>
                            <div>
                                <label class="text-[11px] font-bold text-slate-600 block mb-1">Atau URL Foto Kamar</label>
                                <input 
                                    type="text"
                                    name="image_url" 
                                    id="image_url_input"
                                    value="{{ old('image_url', $room->image_url) }}" 
                                    placeholder="https://images.unsplash.com/photo-..." 
                                    oninput="updateImagePreview(this.value, 'preview_image')"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-mono bg-white"
                                />
                            </div>
                        </div>

                        <!-- Live Preview Kamar -->
                        <div class="relative w-full h-36 rounded-xl overflow-hidden border border-slate-200 bg-slate-200 flex items-center justify-center">
                            <img 
                                id="preview_image"
                                src="{{ old('image_url', $room->image_url ?: '/images/Kamar no 5.jpg') }}" 
                                alt="Foto Kamar"
                                class="w-full h-full object-cover"
                                onerror="handleImgError(this)"
                            />
                        </div>
                    </div>
                </div>

                <!-- 2. Foto Kamar Mandi Dalam -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">2. Foto Kamar Mandi Dalam (Bathroom View)</span>
                            <span class="text-[10px] text-slate-400">Tampilan area mandi, wastafel, & toilet yang bersih.</span>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 items-center">
                        <div class="space-y-3">
                            <div>
                                <label class="text-[11px] font-bold text-slate-600 block mb-1">Upload File Foto Kamar Mandi</label>
                                <input 
                                    type="file" 
                                    name="bathroom_image_file" 
                                    id="bathroom_image_file_input"
                                    accept="image/png, image/jpeg, image/jpg, image/webp" 
                                    onchange="previewUploadedFile(this, 'preview_bathroom_image')"
                                    class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-brand/10 file:text-brand hover:file:bg-brand/20 border border-slate-200 rounded-xl p-1 bg-white"
                                />
                            </div>
                            <div>
                                <label class="text-[11px] font-bold text-slate-600 block mb-1">Atau URL Foto Kamar Mandi</label>
                                <input 
                                    type="text"
                                    name="bathroom_image_url" 
                                    id="bathroom_image_url_input"
                                    value="{{ old('bathroom_image_url', $room->bathroom_image_url) }}" 
                                    placeholder="https://images.unsplash.com/photo-..." 
                                    oninput="updateImagePreview(this.value, 'preview_bathroom_image')"
                                    class="w-full rounded-xl border border-slate-200 px-3.5 py-2.5 text-xs outline-none focus:border-brand focus:ring-2 focus:ring-brand/10 font-mono bg-white"
                                />
                            </div>
                        </div>

                        <!-- Live Preview Kamar Mandi -->
                        <div class="relative w-full h-36 rounded-xl overflow-hidden border border-slate-200 bg-slate-200 flex items-center justify-center">
                            <img 
                                id="preview_bathroom_image"
                                src="{{ old('bathroom_image_url', $room->bathroom_image_url ?: '/images/Kamar mandi.jpg') }}" 
                                alt="Foto Kamar Mandi"
                                class="w-full h-full object-cover"
                                onerror="handleImgError(this)"
                            />
                        </div>
                    </div>
                </div>
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
    function updateImagePreview(url, targetImgId) {
        const previewImg = document.getElementById(targetImgId);
        if (previewImg) {
            if (url && url.trim().length > 5) {
                previewImg.src = url;
            }
        }
    }

    function previewUploadedFile(input, targetImgId) {
        const previewImg = document.getElementById(targetImgId);
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                if (previewImg) previewImg.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
