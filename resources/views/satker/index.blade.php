@extends('layouts.app')

@section('title', 'Dashboard Satker')

@section('content')
<div class="relative z-10">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-white uppercase">Dashboard Pengawasan</h1>
            <p class="text-slate-400 text-[10px] mt-1 tracking-wide uppercase">Manajemen Daftar Perwakilan & Satuan Kerja</p>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            @if(auth()->user()->isItwil())
            <form action="{{ route('satker.claim') }}" method="POST" class="relative flex-1 md:flex-none flex gap-2">
                @csrf
                <div class="relative w-full md:w-56">
                    <select name="satker_id" required class="w-full bg-[#1b2537] border border-slate-700 rounded-lg pl-3 pr-8 text-[11px] text-white outline-none focus:border-blue-500 transition appearance-none h-10 shadow-inner">
                        <option value="" disabled selected>Unit Kerja</option>
                        @foreach($unassignedSatkers as $us)
                            <option value="{{ $us->id }}" class="bg-[#1e293b]">{{ $us->nama_entitas }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-slate-500">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 rounded-lg text-[10px] font-extrabold shadow-lg shadow-blue-900/40 transition-all active:scale-95 shrink-0 h-10 uppercase tracking-widest">
                    Set
                </button>
            </form>
            @endif

            @if(auth()->user()->isSuperAdmin())
            <a href="{{ route('users.index') }}" 
                class="bg-purple-600 hover:bg-purple-500 text-white px-5 rounded-lg text-[10px] font-extrabold shadow-lg shadow-purple-900/40 transition-all active:scale-95 flex items-center gap-2 shrink-0 h-10 uppercase tracking-widest">
                Kelola User
            </a>
            <button type="button" onclick="document.getElementById('modalTambahUser').classList.remove('hidden')" 
                class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 rounded-lg text-[10px] font-extrabold shadow-lg shadow-indigo-900/40 transition-all active:scale-95 flex items-center gap-2 shrink-0 h-10 uppercase tracking-widest">
                <span class="text-lg">+</span> Tambah User
            </button>
            <button type="button" onclick="document.getElementById('modalTambah').classList.remove('hidden')" 
                class="bg-blue-600 hover:bg-blue-500 text-white px-5 rounded-lg text-[10px] font-extrabold shadow-lg shadow-blue-900/40 transition-all active:scale-95 flex items-center gap-2 shrink-0 h-10 uppercase tracking-widest">
                <span class="text-lg">+</span> Tambah Entitas
            </button>
            @endif

            <form id="formLogout" action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="button" onclick="document.getElementById('modalLogout').classList.remove('hidden')" class="bg-[#1b2537] hover:bg-[#232d3f] text-slate-300 hover:text-white border border-[#2d3748] px-4 rounded-lg text-[10px] font-extrabold shadow-sm transition-all active:scale-95 flex items-center gap-2 shrink-0 h-10 uppercase tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div class="flex items-center gap-1.5 bg-slate-900/40 p-1 rounded-xl w-fit border border-slate-800/50 backdrop-blur-md">
            @php
                $filters = [
                    '' => 'Semua',
                    'Luar Negeri' => 'Luar Negeri',
                    'Dalam Negeri' => 'Dalam Negeri'
                ];
                $currentTipe = request('tipe', '');
            @endphp

            @foreach($filters as $value => $label)
                <a href="{{ request()->fullUrlWithQuery(['tipe' => $value]) }}" 
                   class="px-4 py-1.5 rounded-lg text-[9px] uppercase tracking-[0.15em] font-bold transition-all {{ $currentTipe == $value ? 'bg-slate-700 text-blue-400 shadow-md ring-1 ring-slate-600' : 'text-slate-500 hover:text-slate-300' }}">
                   {{ $label }}
                </a>
            @endforeach
        </div>

        <form action="/satker" method="GET" class="relative w-full md:w-auto">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                <span class="text-[10px]">🔍</span>
            </div>
            <input type="hidden" name="tipe" value="{{ request('tipe') }}">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." 
                class="w-full md:w-64 bg-white border border-slate-300 rounded-lg pl-8 pr-4 text-[11px] text-slate-900 placeholder:text-slate-500 focus:border-blue-500 outline-none transition-all h-10 shadow-sm">
        </form>
    </div>

    @if(request('search'))
        <div class="mb-8 flex items-center gap-2 animate-fade-in">
            <p class="text-[11px] text-slate-400">
                Menampilkan hasil: <span class="text-blue-400 font-bold">"{{ request('search') }}"</span>
            </p>
            <a href="{{ request()->fullUrlWithQuery(['search' => '']) }}" class="text-[9px] bg-slate-800 hover:bg-red-900/40 text-slate-300 hover:text-red-400 px-2 py-1 rounded transition-all">
                ❌ Reset
            </a>
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($satkers as $s)
            <div class="relative group bg-[#1b2537] rounded-xl border border-[#2d3748] hover:border-blue-500/60 shadow-xl shadow-black/20 hover:shadow-[0_0_30px_rgba(59,130,246,0.25)] hover:-translate-y-2 transition-all duration-300 ease-out flex flex-col overflow-hidden">
                
                <!-- Glowing effect (kept from original) -->
                <div class="absolute -top-12 -right-12 w-24 h-24 bg-blue-500/5 rounded-full blur-3xl group-hover:bg-blue-500/20 transition-all duration-500"></div>

                <!-- Card Header -->
                <div class="px-5 py-4 bg-[#232d3f] border-b border-[#2d3748] relative z-10">
                    <h3 class="text-[15px] font-bold text-slate-100 group-hover:text-blue-400 transition-colors truncate">
                        {{ $s->nama_entitas }}
                    </h3>
                </div>
                
                <!-- Card Body -->
                <div class="p-5 space-y-4 flex-1 relative z-10 flex flex-col">
                    <div class="flex flex-col">
                        <span class="text-[10px] uppercase tracking-wider text-slate-500 font-bold mb-1">Tipe</span>
                        <p class="text-[13px] text-slate-200 font-medium">{{ $s->tipe_entitas }}</p>
                    </div>
                    <div class="flex flex-col flex-1">
                        <span class="text-[10px] uppercase tracking-wider text-slate-500 font-bold mb-1">Lokasi</span>
                        <p class="text-[13px] text-slate-200 font-medium flex items-center gap-1.5">
                            <span class="text-red-500 text-xs grayscale group-hover:grayscale-0 transition-all duration-300">📍</span> {{ $s->lokasi }}
                        </p>
                    </div>

                    <a href="/satker/{{ $s->id }}" 
                       class="block w-full py-2.5 mt-2 text-center bg-[#2d3748] group-hover:bg-blue-600 rounded-lg text-[13px] text-slate-300 group-hover:text-white font-semibold transition-all duration-300">
                       Lihat Detail
                    </a>
                    @if(auth()->user()->isSuperAdmin())
                    <button type="button" onclick="openAssignModal('{{ $s->id }}', '{{ $s->wilayah_id }}')" 
                       class="block w-full py-2 mt-2 text-center border border-blue-500/50 text-blue-400 hover:bg-blue-500 hover:text-white rounded-lg text-[12px] font-semibold transition-all duration-300">
                       Assign Itwil
                    </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-slate-900/20 rounded-[2.5rem] border border-dashed border-slate-800">
                <p class="text-slate-500 text-[10px] italic tracking-[0.3em] uppercase font-bold">Data tidak ditemukan.</p>
            </div>
        @endforelse
    </div>

    <div id="modalTambah" class="hidden fixed inset-0 z-[999] flex items-center justify-center bg-slate-950/90 backdrop-blur-sm p-4">
        <div class="bg-[#1e293b] w-full max-w-md p-8 md:p-10 rounded-[2.5rem] border border-slate-800 shadow-2xl">
            <h3 class="text-xl font-black text-blue-500 mb-8 uppercase tracking-[0.2em]">Tambah Entitas</h3>
            
            <form action="/satker" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Tipe Entitas</label>
                    <div class="relative">
                        <select name="tipe_entitas" id="tipeEntitasSelect" required
                            onchange="this.classList.remove('text-slate-500'); this.classList.add('text-white')"
                            class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-slate-500 outline-none focus:border-blue-500 transition cursor-pointer appearance-none">
                            <option value="" disabled selected>Pilih Tipe Entitas</option>
                            <option value="Luar Negeri" class="text-white bg-[#1e293b]">Luar Negeri</option>
                            <option value="Dalam Negeri" class="text-white bg-[#1e293b]">Dalam Negeri</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Nama Perwakilan / Satker</label>
                    <input type="text" name="nama_entitas" placeholder="Contoh: KJRI Guangzhou" required
                        class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white placeholder:text-slate-600 outline-none focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Negara / Wilayah</label>
                    <input type="text" name="lokasi" placeholder="Contoh: RRC" required
                        class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white placeholder:text-slate-600 outline-none focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Wilayah Pengawasan</label>
                    <div class="relative">
                        <select name="wilayah_id"
                            onchange="this.classList.remove('text-slate-500'); this.classList.add('text-white')"
                            class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-slate-500 outline-none focus:border-blue-500 transition cursor-pointer appearance-none">
                            <option value="" selected>Pilih Itwil (Opsional)</option>
                            <option value="Itwil I" class="text-white bg-[#1e293b]">Itwil I</option>
                            <option value="Itwil II" class="text-white bg-[#1e293b]">Itwil II</option>
                            <option value="Itwil III" class="text-white bg-[#1e293b]">Itwil III</option>
                            <option value="Itwil IV" class="text-white bg-[#1e293b]">Itwil IV</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center gap-6 mt-10">
                    <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" 
                        class="text-[10px] text-slate-400 hover:text-white font-black transition uppercase tracking-widest">Batal</button>
                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-[10px] font-black shadow-lg shadow-blue-900/40 transition-all active:scale-95 uppercase tracking-widest">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Tambah User -->
    <div id="modalTambahUser" class="hidden fixed inset-0 z-[999] flex items-center justify-center bg-slate-950/90 backdrop-blur-sm p-4">
        <div class="bg-[#1e293b] w-full max-w-md p-8 md:p-10 rounded-[2.5rem] border border-slate-800 shadow-2xl">
            <h3 class="text-xl font-black text-indigo-500 mb-8 uppercase tracking-[0.2em]">Tambah User</h3>
            
            <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Jenis Role</label>
                    <div class="relative">
                        <select name="role" required id="roleSelectDashboard"
                            onchange="this.classList.remove('text-slate-500'); this.classList.add('text-white'); document.getElementById('satkerWrapperDashboard').classList.toggle('hidden', this.value !== 'satker'); document.getElementById('itwilWrapperDashboard').classList.toggle('hidden', this.value !== 'itwil');"
                            class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-slate-500 outline-none focus:border-indigo-500 transition cursor-pointer appearance-none">
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="super_admin" class="text-white bg-[#1e293b]">Super Admin</option>
                            <option value="manager" class="text-white bg-[#1e293b]">Manager</option>
                            <option value="itwil" class="text-white bg-[#1e293b]">Itwil</option>
                            <option value="satker" class="text-white bg-[#1e293b]">Satker</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div id="satkerWrapperDashboard" class="hidden">
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Nama Satker</label>
                    <div class="relative">
                        <select name="satker_id"
                            class="select2-searchable w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-indigo-500 transition cursor-pointer">
                            <option value="" disabled selected>Pilih Satker</option>
                            @foreach(\App\Models\Satker::orderBy('nama_entitas')->get() as $satker)
                                <option value="{{ $satker->id }}" class="bg-[#1e293b]">{{ $satker->nama_entitas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="itwilWrapperDashboard" class="hidden">
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Wilayah Itwil</label>
                    <div class="relative">
                        <select name="wilayah_id"
                            class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-indigo-500 transition cursor-pointer appearance-none">
                            <option value="" disabled selected>Pilih Itwil</option>
                            <option value="Itwil I" class="bg-[#1e293b]">Itwil I</option>
                            <option value="Itwil II" class="bg-[#1e293b]">Itwil II</option>
                            <option value="Itwil III" class="bg-[#1e293b]">Itwil III</option>
                            <option value="Itwil IV" class="bg-[#1e293b]">Itwil IV</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Email</label>
                    <input type="email" name="email" placeholder="Email" required
                        class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white placeholder:text-slate-600 outline-none focus:border-indigo-500 transition">
                </div>

                <div>
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Password</label>
                    <input type="password" name="password" placeholder="Password" required minlength="8"
                        class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white placeholder:text-slate-600 outline-none focus:border-indigo-500 transition">
                </div>

                <div class="flex justify-end items-center gap-6 mt-10">
                    <button type="button" onclick="document.getElementById('modalTambahUser').classList.add('hidden')" 
                        class="text-[10px] text-slate-400 hover:text-white font-black transition uppercase tracking-widest">Batal</button>
                    <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl text-[10px] font-black shadow-lg shadow-indigo-900/40 transition-all active:scale-95 uppercase tracking-widest">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div id="modalLogout" class="hidden fixed inset-0 z-[999] flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 transition-opacity">
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

    <!-- Modal Assign Penanggungjawab -->
    <div id="modalAssign" class="hidden fixed inset-0 z-[999] flex items-center justify-center bg-slate-950/90 backdrop-blur-sm p-4">
        <div class="bg-[#1e293b] w-full max-w-md p-8 md:p-10 rounded-[2.5rem] border border-slate-800 shadow-2xl">
            <h3 class="text-xl font-black text-blue-500 mb-8 uppercase tracking-[0.2em]">Assign Wilayah Pengawasan</h3>
            
            <form id="formAssign" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')
                
                <div>
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Inspektorat Wilayah</label>
                    <div class="relative">
                        <select name="wilayah_id" id="assignWilayahSelect" required
                            class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition cursor-pointer appearance-none">
                            <option value="" disabled selected>Pilih Itwil</option>
                            <option value="Itwil I" class="text-white bg-[#1e293b]">Itwil I</option>
                            <option value="Itwil II" class="text-white bg-[#1e293b]">Itwil II</option>
                            <option value="Itwil III" class="text-white bg-[#1e293b]">Itwil III</option>
                            <option value="Itwil IV" class="text-white bg-[#1e293b]">Itwil IV</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center gap-6 mt-10">
                    <button type="button" onclick="document.getElementById('modalAssign').classList.add('hidden')" 
                        class="text-[10px] text-slate-400 hover:text-white font-black transition uppercase tracking-widest">Batal</button>
                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-[10px] font-black shadow-lg shadow-blue-900/40 transition-all active:scale-95 uppercase tracking-widest">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAssignModal(id, currentWilayah) {
        const form = document.getElementById('formAssign');
        const select = document.getElementById('assignWilayahSelect');
        
        form.action = `/satker/${id}/assign`;
        
        if (currentWilayah) {
            select.value = currentWilayah;
        } else {
            select.value = "";
        }
        
        document.getElementById('modalAssign').classList.remove('hidden');
    }
</script>
@endsection