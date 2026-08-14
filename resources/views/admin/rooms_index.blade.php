@extends('layouts.admin')

@section('title', 'Kelola Kamar | Admin Mama Anis Group')

@section('content')
<main class="p-3.5 sm:p-8 lg:p-10 flex flex-col gap-4 sm:gap-8 rise w-full max-w-full overflow-x-hidden">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-400 font-bold tracking-wide">
                <span>Mama Anis Group</span>
                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-brand">Kelola Kamar</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1 font-display">Semua Unit Kamar</h1>
        </div>
        
        <a 
            href="{{ route('admin.rooms.create') }}" 
            class="px-5 py-2.5 bg-brand hover:bg-brandHover text-white rounded-xl font-bold text-xs shadow-md shadow-brand/20 flex items-center gap-2 transition-all active:scale-95 text-center justify-center"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            <span>Tambah Kamar Baru</span>
        </a>
    </div>

    @if(session('success'))
        <div class="rounded-2xl bg-emerald-50 border border-emerald-200 px-5 py-3.5 font-bold text-emerald-800 text-xs flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table Section -->
    <section class="bg-white rounded-2xl border border-slate-100 shadow-soft overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div class="flex items-center gap-3">
                <h2 class="text-lg font-black text-slate-900 font-display">Daftar Kamar</h2>
                <span class="rounded-full bg-emerald-100 px-3 py-0.5 text-xs font-black text-brand">{{ $rooms->count() }} Unit</span>
            </div>
            
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                <!-- Status Filter Dropdown -->
                <select 
                    id="roomsStatusFilter" 
                    onchange="filterRoomsTable()" 
                    class="px-3 py-2 border border-slate-200 bg-slate-50/70 rounded-xl text-xs font-bold text-slate-700 outline-none focus:border-brand focus:bg-white"
                >
                    <option value="ALL">Semua Status</option>
                    <option value="Tersedia">Tersedia</option>
                    <option value="Terisi">Terisi</option>
                    <option value="Pemeliharaan">Pemeliharaan</option>
                </select>

                <!-- Search Input -->
                <div class="relative flex-1 sm:w-60">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        id="roomsSearchInput"
                        placeholder="Cari kamar..." 
                        oninput="filterRoomsTable()"
                        class="pl-10 pr-4 py-2 border border-slate-200 bg-slate-50/70 rounded-xl text-xs outline-none focus:bg-white focus:border-brand w-full font-medium"
                    />
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-500 font-medium" id="roomsListTable">
                <thead class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Kamar</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Harga / Bulan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Views</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50" id="roomsTableBody">
                    @forelse($rooms as $room)
                        <tr 
                            class="manage-room-row hover:bg-slate-50/50 transition-colors"
                            data-name="{{ strtolower($room->name) }}"
                            data-type="{{ strtolower($room->type) }}"
                            data-status="{{ $room->status }}"
                        >
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $room->image_url }}" alt="" class="h-12 w-16 rounded-xl object-cover border border-slate-100 shrink-0" loading="lazy" onerror="handleImgError(this)">
                                    <div>
                                        <p class="font-black text-slate-900 text-xs">{{ $room->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-medium">{{ $room->location }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase">
                                    {{ $room->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-black text-slate-900 font-display">
                                Rp {{ number_format($room->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <x-badge-status :status="$room->status" />
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-700">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span>{{ number_format($room->views) }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a 
                                        href="{{ route('rooms.show', $room) }}" 
                                        target="_blank"
                                        class="p-2 text-slate-500 hover:text-brand bg-slate-50 hover:bg-emerald-50 rounded-xl transition-colors border border-slate-100"
                                        title="Pratinjau Publik"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                    <a 
                                        href="{{ route('admin.rooms.edit', $room) }}" 
                                        class="p-2 text-slate-500 hover:text-brand bg-slate-50 hover:bg-emerald-50 rounded-xl transition-colors border border-slate-100"
                                        title="Edit Data Unit"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" onsubmit="return confirm('Hapus kamar {{ addslashes($room->name) }} dari katalog publik?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="p-2 text-slate-400 hover:text-red-600 bg-slate-50 hover:bg-red-50 rounded-xl transition-colors border border-slate-100 cursor-pointer"
                                            title="Hapus Unit"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-semibold">
                                Belum ada unit kamar terdaftar. Silakan tambahkan kamar baru.
                            </td>
                        </tr>
                    @endforelse

                    <tr id="noManageMatchRow" class="hidden">
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 font-semibold">
                            Tidak ada kamar yang cocok dengan filter pencarian.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    function filterRoomsTable() {
        const searchVal = (document.getElementById('roomsSearchInput')?.value || '').toLowerCase().trim();
        const statusVal = document.getElementById('roomsStatusFilter')?.value || 'ALL';

        const rows = document.querySelectorAll('#roomsTableBody tr.manage-room-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const type = row.getAttribute('data-type') || '';
            const status = row.getAttribute('data-status') || '';

            const matchSearch = !searchVal || name.includes(searchVal) || type.includes(searchVal);
            const matchStatus = (statusVal === 'ALL') || (status === statusVal);

            if (matchSearch && matchStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const noMatch = document.getElementById('noManageMatchRow');
        if (noMatch) {
            if (visibleCount === 0 && rows.length > 0) {
                noMatch.classList.remove('hidden');
            } else {
                noMatch.classList.add('hidden');
            }
        }
    }
</script>
@endpush
