<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $satker->nama_entitas }} - Detail</title>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
            border: 2px solid #172033;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
    </style>
</head>
<body class="font-sans bg-slate-900 text-white flex flex-col md:flex-row min-h-screen overflow-x-hidden relative">

    @if(!auth()->user()->isSatker())
    <!-- Mobile Header & Sidebar Toggle -->
    <div class="md:hidden flex items-center justify-between p-4 bg-[#0b1120] border-b border-[#232d3f] sticky top-0 z-40">
        <div class="flex items-center gap-2.5">
            <img src="{{ asset('assets/img/logo_kemlu.png') }}" alt="Logo Kemlu" class="w-7 h-auto drop-shadow-md">
            <h2 class="text-[13px] text-white font-black tracking-widest uppercase">Dashboard Pengawasan</h2>
        </div>
        <button id="sidebarToggle" class="text-slate-400 hover:text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-[#0f172a]/80 backdrop-blur-sm z-40 hidden md:hidden transition-opacity"></div>

    <aside id="sidebar" class="fixed top-0 left-0 h-screen w-[260px] bg-[#0b1120] p-5 border-r border-[#172033] flex flex-col shrink-0 z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
        <div class="flex justify-between items-center mb-8">
            <div class="hidden md:flex items-center gap-3">
                <img src="{{ asset('assets/img/logo_kemlu.png') }}" alt="Logo Kemlu" class="w-8 h-auto drop-shadow-md">
                <h2 class="text-[14px] text-white font-black tracking-widest uppercase mt-0.5">Dashboard Pengawasan</h2>
            </div>
            <h2 class="text-[1.1rem] text-white font-bold tracking-wide md:hidden">Menu</h2>
            <button id="sidebarClose" class="md:hidden text-slate-400 hover:text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="relative mb-6">
            <svg class="w-4 h-4 absolute left-3 top-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" id="searchInput" placeholder="Cari Perwakilan..." class="w-full pl-9 pr-3 py-2.5 bg-[#172033] border border-[#232d3f] rounded-xl text-slate-200 text-xs font-medium outline-none focus:ring-1 focus:ring-blue-500 placeholder-slate-500 transition-colors">
        </div>
        
        <div class="flex-1 overflow-y-auto mb-5 pr-2 custom-scrollbar" id="satkerList">
            @foreach($satkers as $s)
                <a href="/satker/{{ $s->id }}" class="satker-item block px-4 py-3 rounded-xl text-sm font-semibold transition-all no-underline mb-2 {{ $s->id == $satker->id ? 'bg-[#3b82f6] text-white shadow-lg shadow-blue-500/20' : 'text-slate-300 hover:text-white hover:bg-[#1b2537]' }}">
                    {{ $s->nama_entitas }}
                </a>
            @endforeach
        </div>

        <div class="pt-5 border-t border-[#232d3f]">
            <a href="/satker" class="text-slate-400 no-underline text-xs hover:text-white transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>
        </div>
    </aside>
    @endif

    <main id="mainContent" class="w-full md:flex-1 p-6 md:p-8 {{ auth()->user()->isSatker() ? '' : 'md:pl-[290px]' }} transition-all duration-300 min-h-screen">
        <header class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4 mb-8">
            <div class="flex items-start gap-4">
                @if(!auth()->user()->isSatker())
                <button onclick="toggleDesktopSidebar()" class="hidden md:flex mt-1 text-slate-400 hover:text-white bg-[#1b2537] p-2 rounded-lg border border-[#2d3748] focus:outline-none transition-colors shadow-sm cursor-pointer" title="Toggle Sidebar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                @endif
                <div>
                    <h1 class="text-2xl md:text-3xl tracking-tight font-bold text-white">{{ $satker->nama_entitas }}</h1>
                    <p class="text-slate-400 mt-1.5 text-sm font-medium">{{ $satker->tipe_entitas }} &bull; {{ $satker->lokasi }}</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-3 items-center">
                <a href="{{ route('satker.pdf', $satker->id) }}" target="_blank" class="py-2 px-4 bg-emerald-600 hover:bg-emerald-500 text-white no-underline rounded-lg font-semibold transition-colors text-xs flex items-center gap-1.5 shadow-lg shadow-emerald-600/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export PDF
                </a>

                @if(!auth()->user()->isManager())
                <a href="/profile/edit/{{ $satker->id }}" class="py-2 px-4 bg-indigo-600 hover:bg-indigo-500 text-white no-underline rounded-lg font-semibold transition-colors text-xs flex items-center gap-1.5 shadow-lg shadow-indigo-600/20">
                    Edit Profil
                </a>
                @endif

                @if(auth()->user()->isSuperAdmin() || auth()->user()->isItwil())
                <form id="formHapus" action="/satker/{{ $satker->id }}" method="POST" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="document.getElementById('modalHapus').classList.remove('hidden')" class="py-2 px-4 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white border border-red-500/20 rounded-lg font-semibold cursor-pointer transition-all text-xs flex items-center gap-1.5 shadow-sm">
                        Hapus
                    </button>
                </form>
                @endif

                <form id="formLogout" action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="button" onclick="document.getElementById('modalLogout').classList.remove('hidden')" class="py-2 px-4 bg-[#1b2537] hover:bg-[#232d3f] text-slate-300 hover:text-white border border-[#2d3748] rounded-lg font-semibold cursor-pointer transition-colors text-xs flex items-center gap-1.5 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <section class="grid grid-cols-1 xl:grid-cols-[1.2fr_1fr] gap-6 mb-8">
            <div class="bg-[#172033] p-6 rounded-2xl border border-[#232d3f] shadow-xl overflow-hidden">
                <h3 class="text-base text-white mb-5 border-b border-[#2d3748] pb-3 flex items-center gap-2.5 font-bold tracking-wide">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Profil Satuan Kerja
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @if($satker->tipe_entitas !== 'Dalam Negeri')
                    <div class="bg-[#1b2537] p-4 rounded-xl border border-[#2d3748]">
                        <span class="text-slate-500 block text-[10px] uppercase tracking-wider mb-1.5 font-bold">Komposisi Pegawai</span>
                        <p class="text-sm font-semibold mb-0">
                            <span class="text-indigo-400">HS: {{ $satker->jumlah_hs ?? 0 }}</span> &nbsp; 
                            <span class="text-emerald-400">LS: {{ $satker->jumlah_ls ?? 0 }}</span>
                        </p>
                    </div>
                    @endif
                    <div class="bg-[#1b2537] p-4 rounded-xl border border-[#2d3748] {{ $satker->tipe_entitas === 'Dalam Negeri' ? 'sm:col-span-2' : '' }}">
                        <span class="text-slate-500 block text-[10px] uppercase tracking-wider mb-1.5 font-bold">Kontak Utama</span>
                        <p class="text-sm font-semibold mb-0 text-slate-200">{{ $satker->profile->kontak ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-slate-500 block text-[10px] uppercase tracking-wider mb-1 font-bold">
                            {{ $satker->tipe_entitas === 'Dalam Negeri' ? 'Pimpinan' : 'Kepala Perwakilan' }}
                        </span>
                        <p class="m-0 font-semibold text-sm text-slate-200">{{ $satker->profile->kepala_nama ?? '-' }}</p>
                        <small class="text-slate-400 text-xs mt-0.5 block">{{ $satker->profile->kepala_telp ?? '' }}</small>
                    </div>
                    @if($satker->tipe_entitas !== 'Dalam Negeri')
                    <div>
                        <span class="text-slate-500 block text-[10px] uppercase tracking-wider mb-1 font-bold">Head of Chancery (HOC)</span>
                        <p class="m-0 font-semibold text-sm text-slate-200">{{ $satker->profile->hoc_nama ?? '-' }}</p>
                        <small class="text-slate-400 text-xs mt-0.5 block">{{ $satker->profile->hoc_telp ?? '' }}</small>
                    </div>
                    @endif
                    <div>
                        <span class="text-slate-500 block text-[10px] uppercase tracking-wider mb-1 font-bold">Pejabat Pembuat Komitmen (PPK)</span>
                        <p class="m-0 font-semibold text-sm text-slate-200">{{ $satker->profile->ppk_nama ?? '-' }}</p>
                        <small class="text-slate-400 text-xs mt-0.5 block">{{ $satker->profile->ppk_telp ?? '' }}</small>
                    </div>
                    <div>
                        <span class="text-slate-500 block text-[10px] uppercase tracking-wider mb-1 font-bold">
                            {{ $satker->tipe_entitas === 'Dalam Negeri' ? 'Kabag TU & Kepegawaian' : 'BPKRT' }}
                        </span>
                        <p class="m-0 font-semibold text-sm text-slate-200">{{ $satker->profile->bpkrt_nama ?? '-' }}</p>
                        <small class="text-slate-400 text-xs mt-0.5 block">{{ $satker->profile->bpkrt_telp ?? '' }}</small>
                    </div>
                </div>
            </div>

            <div class="bg-[#172033] p-6 rounded-2xl border border-[#232d3f] shadow-xl">
                <h3 class="text-base text-white mb-5 border-b border-[#2d3748] pb-3 flex items-center gap-2.5 font-bold tracking-wide">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Snapshot Pengawasan
                </h3>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-[#1b2537] p-4 rounded-xl border border-[#2d3748]">
                        <span class="text-slate-500 block text-[10px] uppercase tracking-wider mb-2 font-bold">Tahun Audit Terakhir</span>
                        <p class="text-2xl font-bold text-white mb-0">{{ $satker->profile->tahun_audit ?? '-' }}</p>
                    </div>
                    <div class="bg-[#1b2537] p-4 rounded-xl border border-[#2d3748]">
                        <span class="text-slate-500 block text-[10px] uppercase tracking-wider mb-2 font-bold">Status RR / RPR</span>
                        <p class="font-bold text-sm text-slate-200 mb-0 leading-snug">{{ $satker->profile->status_rr ?? '-' }}</p>
                    </div>
                </div>
                
                <div class="bg-[#1b2537] p-4 rounded-xl border border-[#2d3748] mb-4">
                    <span class="text-slate-500 block text-[10px] uppercase tracking-wider mb-1.5 font-bold">Area Risiko Utama</span>
                    <p class="text-red-400 text-sm font-medium leading-relaxed mb-0">
                        {{ $satker->profile->area_resiko ?? 'Belum ada data risiko utama.' }}
                    </p>
                </div>

                <div class="bg-[#1b2537] p-4 rounded-xl border border-[#2d3748]">
                    <span class="text-slate-500 block text-[10px] uppercase tracking-wider mb-1.5 font-bold">Indikasi Temuan Berulang</span>
                    <p class="text-amber-500 text-sm font-bold flex items-center gap-2 mb-0">
                        ⚠️ {{ $satker->profile->temuan ?? 'Tidak Ada' }}
                    </p>
                </div>
            </div>
        </section>

        <section class="bg-[#172033] rounded-2xl border border-[#232d3f] overflow-hidden shadow-xl mt-8">
            <div class="p-5 md:p-6 bg-[#172033]">
                @php
                    $currentStatus = request('status', '');
                    $statusFilters = [
                        '' => ['label' => 'Semua', 'dot' => ''],
                        'Urgent' => ['label' => 'Urgent', 'dot' => '🔴'],
                        'Proses' => ['label' => 'Proses', 'dot' => '🟡'],
                        'Selesai' => ['label' => 'Selesai', 'dot' => '🟢']
                    ];
                @endphp
                <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4">
                    <div class="flex items-center gap-4">
                        <h3 class="text-base font-bold flex items-center gap-2.5 text-white">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h.01M8 10h.01M8 14h.01M8 18h.01"></path></svg>
                            Daftar Isu & Tindak Lanjut
                        </h3>
                        @if(auth()->user()->isSuperAdmin() || auth()->user()->isItwil())
                        <button onclick="document.getElementById('modalIsu').classList.remove('hidden')" class="py-1.5 px-3 bg-indigo-600 hover:bg-indigo-500 text-white border-none rounded-md cursor-pointer font-semibold transition-colors text-xs flex items-center gap-1.5 shadow-lg shadow-indigo-500/20">
                            <span>+</span> Tambah Isu
                        </button>
                        @endif
                    </div>

                    <div class="flex items-center bg-[#232d3f] p-1 rounded-lg border border-[#2d3748]">
                        @foreach($statusFilters as $val => $data)
                            <a href="{{ request()->fullUrlWithQuery(['status' => $val]) }}" 
                               class="px-3 py-1.5 rounded-md text-xs font-semibold transition-all no-underline flex items-center gap-1.5 {{ $currentStatus == $val ? 'bg-slate-600 text-white shadow-sm' : 'text-slate-400 hover:text-white hover:bg-[#2d3748]' }}">
                               @if($data['dot'])
                                    <span class="text-[8px]">{{ $data['dot'] }}</span>
                               @endif
                               {{ $data['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto w-full bg-[#1b2537] custom-scrollbar pb-2">
                <table class="w-full border-collapse min-w-[1000px]">
                    <thead>
                        <tr class="bg-[#202b3d] border-y border-[#2d3748]">
                            <th class="text-left text-slate-300 text-[11px] font-bold tracking-widest uppercase p-4">No</th>
                            <th class="text-left text-slate-300 text-[11px] font-bold tracking-widest uppercase p-4">Kategori</th>
                            <th class="text-left text-slate-300 text-[11px] font-bold tracking-widest uppercase p-4">Deskripsi Isu & Dampak</th>
                            <th class="text-left text-slate-300 text-[11px] font-bold tracking-widest uppercase p-4">Rekam Jejak & Tindak Lanjut Terkini</th>
                            <th class="text-left text-slate-300 text-[11px] font-bold tracking-widest uppercase p-4 whitespace-nowrap">Update Terakhir</th>
                            <th class="text-left text-slate-300 text-[11px] font-bold tracking-widest uppercase p-4 whitespace-nowrap">Status</th>
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->isItwil())
                            <th class="text-center text-slate-300 text-[11px] font-bold tracking-widest uppercase p-4 whitespace-nowrap">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($issues as $index => $issue)
                        <tr class="border-b border-[#2d3748] hover:bg-[#202b3d]/50 transition-colors">
                            <td class="p-4 text-sm text-slate-400 align-top font-medium">
                                {{ $issues->firstItem() + $index }}
                            </td>
                            <td class="p-4 align-top">
                                <span class="bg-[#232d3f] text-slate-300 px-3 py-1.5 rounded-md text-xs font-medium border border-[#2d3748]">
                                    {{ $issue->kategori }}
                                </span>
                            </td>
                            <td class="p-4 align-top min-w-[220px] max-w-[260px]">
                                @php
                                    $desc = preg_replace('/(Risiko:.*)/i', '<span class="text-red-400 text-xs block mt-2">$1</span>', e($issue->deskripsi_isu));
                                @endphp
                                <div class="text-sm text-slate-200 leading-relaxed font-medium">{!! $desc !!}</div>
                            </td>
                            <td class="p-4 align-top min-w-[250px] max-w-[300px]">
                                @if(str_contains(strtolower($issue->tindak_lanjut), 'arahan inspektur'))
                                    @php
                                        $parts = preg_split('/(Arahan Inspektur.*?):/i', $issue->tindak_lanjut, -1, PREG_SPLIT_DELIM_CAPTURE);
                                    @endphp
                                    @if(count($parts) >= 3)
                                        <p class="text-sm text-slate-200 leading-relaxed font-medium mb-3">{{ trim($parts[0]) }}</p>
                                        <div class="bg-red-500/10 border border-red-500/20 rounded-md p-3">
                                            <div class="flex items-start gap-2">
                                                <div class="mt-0.5 text-red-500 text-xs">🔴</div>
                                                <div>
                                                    <span class="text-red-400 text-xs font-bold">{{ trim($parts[1]) }}:</span>
                                                    <p class="text-red-300/80 text-xs mt-1 leading-relaxed">{{ trim($parts[2]) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <p class="text-sm text-slate-200 leading-relaxed font-medium">{{ $issue->tindak_lanjut ?? '-' }}</p>
                                    @endif
                                @else
                                    <p class="text-sm text-slate-200 leading-relaxed font-medium">{{ $issue->tindak_lanjut ?? '-' }}</p>
                                @endif
                            </td>
                            <td class="p-4 align-top min-w-[140px]">
                                <div class="flex flex-col gap-2.5">
                                    <div class="flex items-center gap-2 text-slate-400 text-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span>{{ $issue->updated_at ? $issue->updated_at->format('d M Y') : '-' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-slate-400 text-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span>{{ $issue->update_oleh ?? 'Auditor Tim A' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 align-top">
                                @php
                                    $statusLower = strtolower($issue->status);
                                    $statusClasses = match($statusLower) {
                                        'urgent' => ['text' => 'text-red-500', 'icon' => '🔺'],
                                        'proses' => ['text' => 'text-amber-500', 'icon' => '🕒'],
                                        'selesai' => ['text' => 'text-emerald-500', 'icon' => '🟢'],
                                        default => ['text' => 'text-slate-400', 'icon' => '']
                                    };
                                @endphp
                                <div class="inline-flex items-center gap-1.5">
                                    <span class="text-[11px]">{{ $statusClasses['icon'] }}</span>
                                    <span class="text-xs font-bold tracking-wider {{ $statusClasses['text'] }} uppercase">{{ $issue->status }}</span>
                                </div>
                            </td>
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->isItwil())
                            <td class="p-4 align-top text-center">
                                <button class="text-slate-400 hover:text-white transition-colors bg-transparent border-none cursor-pointer" 
                                    onclick="editIssue(
                                        {{ $issue->id }}, 
                                        '{{ $issue->kategori }}', 
                                        '{{ addslashes($issue->deskripsi_isu) }}', 
                                        '{{ addslashes($issue->tindak_lanjut) }}', 
                                        '{{ $issue->status }}'
                                    )" title="Edit">
                                    <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ (auth()->user()->isSuperAdmin() || auth()->user()->isItwil()) ? '7' : '6' }}" class="text-center p-12 text-slate-400 border-b border-[#2d3748] bg-[#172033]">
                                Belum ada catatan isu untuk entitas ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($issues->total() > 0)
            <div class="p-4 md:p-5 bg-[#172033] flex flex-col sm:flex-row justify-between items-center gap-4 border-t border-[#232d3f]">
                <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-start">
                    <div class="text-slate-400 text-xs flex items-center gap-3">
                        <span><span class="hidden sm:inline">Menampilkan</span> {{ $issues->firstItem() }}-{{ $issues->lastItem() }} <span class="hidden sm:inline">dari {{ $issues->total() }} isu</span></span>
                        
                        <select onchange="window.location.href=this.value" class="bg-[#232d3f] border border-[#2d3748] text-slate-300 text-xs rounded px-2 py-1 outline-none focus:border-indigo-500 transition cursor-pointer">
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 5, 'page' => 1]) }}" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 10, 'page' => 1]) }}" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                            <option value="{{ request()->fullUrlWithQuery(['per_page' => 20, 'page' => 1]) }}" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center gap-1.5 w-full sm:w-auto justify-center sm:justify-end">
                    @if ($issues->onFirstPage())
                        <span class="py-1 px-3 bg-transparent text-slate-500 border border-[#2d3748] rounded cursor-not-allowed text-xs font-semibold">Prev</span>
                    @else
                        <a href="{{ $issues->previousPageUrl() }}" class="py-1 px-3 bg-transparent text-slate-400 border border-[#2d3748] rounded no-underline text-xs hover:bg-[#202b3d] hover:text-white transition-colors font-semibold">Prev</a>
                    @endif

                    <span class="py-1 px-3 bg-indigo-600 text-white rounded text-xs font-bold shadow-md shadow-indigo-500/20">
                        {{ $issues->currentPage() }}
                    </span>

                    @if ($issues->hasMorePages())
                        <a href="{{ $issues->nextPageUrl() }}" class="py-1 px-3 bg-transparent text-slate-400 border border-[#2d3748] rounded no-underline text-xs hover:bg-[#202b3d] hover:text-white transition-colors font-semibold">Next</a>
                    @else
                        <span class="py-1 px-3 bg-transparent text-slate-500 border border-[#2d3748] rounded cursor-not-allowed text-xs font-semibold">Next</span>
                    @endif
                </div>
            </div>
            @endif
        </section>
    </main>

    <div id="modalIsu" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 transition-opacity">
        <div class="bg-[#1e293b] w-full max-w-md p-6 md:p-8 rounded-[2.5rem] border border-slate-800 shadow-2xl">
            <div>
                <h3 class="text-xl font-black text-blue-500 mb-6 uppercase tracking-[0.2em]">Tambah Isu Baru</h3>
                <form method="POST" action="/satker/{{ $satker->id }}/issue" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Kategori Isu</label>
                        <div class="relative">
                            <select name="kategori" class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition cursor-pointer appearance-none" required>
                                <option value="Keuangan">Keuangan</option>
                                <option value="Aset">Aset</option>
                                <option value="SDM">SDM</option>
                                <option value="Operasional">Operasional</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Deskripsi Temuan</label>
                        <textarea name="deskripsi_isu" class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition resize-none" rows="2" required></textarea>
                    </div>

                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Rencana Perbaikan</label>
                        <textarea name="tindak_lanjut" class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition resize-none" rows="2"></textarea>
                    </div>

                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Status Awal</label>
                        <div class="relative">
                            <select name="status" class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition cursor-pointer appearance-none" required>
                                <option value="Urgent">Urgent</option>
                                <option value="Proses" selected>Proses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-6 mt-8">
                        <button type="button" onclick="document.getElementById('modalIsu').classList.add('hidden')" class="text-[10px] text-slate-400 hover:text-white font-black transition uppercase tracking-widest">Batal</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-[10px] font-black shadow-lg shadow-blue-900/40 transition-all active:scale-95 uppercase tracking-widest">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Isu -->
    <div id="modalEditIsu" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 transition-opacity">
        <div class="bg-[#1e293b] w-full max-w-md p-6 md:p-8 rounded-[2.5rem] border border-slate-800 shadow-2xl">
            <div>
                <h3 class="text-xl font-black text-blue-500 mb-6 uppercase tracking-[0.2em]">Edit Isu & Tindak Lanjut</h3>
                <form id="formEditIsu" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')
                    
                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Kategori Isu</label>
                        <div class="relative">
                            <select name="kategori" id="editKategori" class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition cursor-pointer appearance-none" required>
                                <option value="Keuangan">Keuangan</option>
                                <option value="Aset">Aset</option>
                                <option value="SDM">SDM</option>
                                <option value="Operasional">Operasional</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Deskripsi Temuan</label>
                        <textarea name="deskripsi_isu" id="editDeskripsi" class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition resize-none" rows="2" required></textarea>
                    </div>

                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Rencana Perbaikan</label>
                        <textarea name="tindak_lanjut" id="editTindakLanjut" class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition resize-none" rows="2"></textarea>
                    </div>

                    <div>
                        <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Status</label>
                        <div class="relative">
                            <select name="status" id="editStatus" class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition cursor-pointer appearance-none" required>
                                <option value="Urgent">URGENT</option>
                                <option value="Proses">PROSES</option>
                                <option value="Selesai">SELESAI</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-6 mt-8">
                        <button type="button" onclick="document.getElementById('modalEditIsu').classList.add('hidden')" class="text-[10px] text-slate-400 hover:text-white font-black transition uppercase tracking-widest">Batal</button>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-[10px] font-black shadow-lg shadow-blue-900/40 transition-all active:scale-95 uppercase tracking-widest">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div id="modalLogout" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 transition-opacity">
        <div class="bg-[#1e293b] w-full max-w-sm rounded-[2rem] border border-slate-700 shadow-2xl p-8 text-center relative overflow-hidden">
            <div class="relative z-10">
                <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-5 border border-red-500/20 shadow-inner">
                    <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </div>
                
                <h3 class="text-white text-lg font-bold mb-3 tracking-wide">Konfirmasi Logout</h3>
                
                <p class="text-slate-400 text-xs font-medium leading-relaxed mb-8">
                    Apakah Anda yakin ingin keluar dari sistem?
                </p>
                
                <div class="flex justify-center gap-3">
                    <button onclick="document.getElementById('modalLogout').classList.add('hidden')" class="py-2.5 px-6 rounded-xl border border-slate-600 text-slate-300 hover:text-white hover:bg-slate-700 hover:border-slate-500 transition-all text-xs font-bold tracking-wider uppercase">
                        Batal
                    </button>
                    <button onclick="document.getElementById('formLogout').submit()" class="py-2.5 px-6 rounded-xl bg-red-600 hover:bg-red-500 text-white shadow-lg shadow-red-900/40 transition-all text-xs font-bold tracking-wider uppercase">
                        Ya, Logout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modalHapus" class="hidden fixed inset-0 z-[9999] flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 transition-opacity">
        <div class="bg-[#1e293b] w-full max-w-sm rounded-[2rem] border border-slate-700 shadow-2xl p-8 text-center relative overflow-hidden">
            <div class="relative z-10">
                <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-5 border border-red-500/20 shadow-inner">
                    <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                
                <h3 class="text-white text-lg font-bold mb-3 tracking-wide">Konfirmasi Hapus</h3>
                
                <p class="text-slate-400 text-xs font-medium leading-relaxed mb-8">
                    Apakah Anda yakin? Entitas ini akan dihapus dari list dashboard.
                </p>
                
                <div class="flex justify-center gap-3">
                    <button onclick="document.getElementById('modalHapus').classList.add('hidden')" class="py-2.5 px-6 rounded-xl border border-slate-600 text-slate-300 hover:text-white hover:bg-slate-700 hover:border-slate-500 transition-all text-xs font-bold tracking-wider uppercase">
                        Batal
                    </button>
                    <button onclick="document.getElementById('formHapus').submit()" class="py-2.5 px-6 rounded-xl bg-red-600 hover:bg-red-500 text-white shadow-lg shadow-red-900/40 transition-all text-xs font-bold tracking-wider uppercase">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sidebar Toggle Logic
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mainContent = document.getElementById('mainContent');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
            document.body.style.overflow = '';
        }

        function toggleDesktopSidebar() {
            sidebar.classList.toggle('md:translate-x-0');
            sidebar.classList.toggle('md:-translate-x-full');
            mainContent.classList.toggle('md:pl-[290px]');
            mainContent.classList.toggle('md:pl-8');
        }

        sidebarToggle.addEventListener('click', openSidebar);
        sidebarClose.addEventListener('click', closeSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);

        // Sidebar Search Logic
        const searchInput = document.getElementById('searchInput');
        const satkerItems = document.querySelectorAll('.satker-item');

        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            
            satkerItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Edit Issue Modal
        function editIssue(issueId, kategori, deskripsi, tindakLanjut, status) {
            document.getElementById('formEditIsu').action = `/issue/${issueId}`;
            document.getElementById('editKategori').value = kategori;
            document.getElementById('editDeskripsi').value = deskripsi;
            document.getElementById('editTindakLanjut').value = tindakLanjut;
            document.getElementById('editStatus').value = status;
            
            document.getElementById('modalEditIsu').classList.remove('hidden');
        }

        @if(session('success'))
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                background: '#1e293b',
                color: '#ffffff'
            });
        @endif
    </script>
</body>
</html>