@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="relative z-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight text-white uppercase">Manajemen User</h1>
            <p class="text-slate-400 text-[10px] mt-1 tracking-wide uppercase">Kelola Hak Akses & Pengguna Sistem</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('satker.index') }}" 
                class="bg-[#1b2537] hover:bg-[#232d3f] text-slate-300 hover:text-white border border-[#2d3748] px-4 rounded-lg text-[10px] font-extrabold shadow-sm transition-all active:scale-95 flex items-center gap-2 h-10 uppercase tracking-widest">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <button type="button" onclick="document.getElementById('modalTambahUser').classList.remove('hidden')" 
                class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 rounded-lg text-[10px] font-extrabold shadow-lg shadow-indigo-900/40 transition-all active:scale-95 flex items-center gap-2 h-10 uppercase tracking-widest">
                <span class="text-lg">+</span> Tambah User
            </button>
        </div>
    </div>

    <!-- Table Users -->
    <div class="bg-[#1b2537] rounded-xl border border-[#2d3748] shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#232d3f] border-b border-[#2d3748] text-[10px] uppercase tracking-widest text-slate-400">
                        <th class="py-4 px-6 font-bold text-center">Nama</th>
                        <th class="py-4 px-6 font-bold text-center">Email</th>
                        <th class="py-4 px-6 font-bold text-center">Role</th>
                        <th class="py-4 px-6 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#2d3748]/50">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-800/30 transition-colors">
                        <td class="py-4 px-6 text-sm text-slate-200 font-semibold">{{ $user->name }}</td>
                        <td class="py-4 px-6 text-sm text-slate-400">{{ $user->email }}</td>
                        <td class="py-4 px-6 text-center">
                            @php
                                $roleColors = [
                                    'super_admin' => 'bg-indigo-500/20 text-indigo-400 border-indigo-500/30',
                                    'manager' => 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30',
                                    'itwil' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                                    'satker' => 'bg-amber-500/20 text-amber-400 border-amber-500/30',
                                ];
                                $roleLabels = [
                                    'super_admin' => 'Super Admin',
                                    'manager' => 'Manager',
                                    'itwil' => 'Itwil',
                                    'satker' => 'Satker',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $roleColors[$user->role] ?? 'bg-slate-500/20 text-slate-400 border-slate-500/30' }}">
                                {{ $roleLabels[$user->role] ?? $user->role }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center space-x-2">
                            <button onclick="openEditModal({{ $user->toJson() }})" class="text-blue-400 hover:text-blue-300 transition-colors" title="Edit">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            @if(auth()->id() !== $user->id)
                            <button onclick="openDeleteModal('{{ $user->id }}')" class="text-red-400 hover:text-red-300 transition-colors" title="Hapus">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-10 text-center text-slate-500 text-[10px] italic tracking-[0.3em] uppercase font-bold">Belum ada data user.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
                        <select name="role" required id="roleSelectUser"
                            onchange="this.classList.remove('text-slate-500'); this.classList.add('text-white'); document.getElementById('satkerWrapperUser').classList.toggle('hidden', this.value !== 'satker'); document.getElementById('itwilWrapperUser').classList.toggle('hidden', this.value !== 'itwil');"
                            class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-indigo-500 transition cursor-pointer appearance-none">
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

                <div id="satkerWrapperUser" class="hidden">
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Nama Satker</label>
                    <div class="relative w-full">
                        <select name="satker_id"
                            class="select2-searchable w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-indigo-500 transition cursor-pointer">
                            <option value="" disabled selected>Pilih Satker</option>
                            @foreach($satkers as $satker)
                                <option value="{{ $satker->id }}" class="bg-[#1e293b]">{{ $satker->nama_entitas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="itwilWrapperUser" class="hidden">
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

    <!-- Modal Edit User -->
    <div id="modalEditUser" class="hidden fixed inset-0 z-[999] flex items-center justify-center bg-slate-950/90 backdrop-blur-sm p-4">
        <div class="bg-[#1e293b] w-full max-w-md p-8 md:p-10 rounded-[2.5rem] border border-slate-800 shadow-2xl">
            <h3 class="text-xl font-black text-blue-500 mb-8 uppercase tracking-[0.2em]">Edit User</h3>
            <form id="formEditUser" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Jenis Role</label>
                    <div class="relative">
                        <select name="role" id="edit_role" required
                            onchange="document.getElementById('editSatkerWrapper').classList.toggle('hidden', this.value !== 'satker'); document.getElementById('editItwilWrapper').classList.toggle('hidden', this.value !== 'itwil');"
                            class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition cursor-pointer appearance-none">
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

                <div id="editSatkerWrapper" class="hidden">
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Nama Satker</label>
                    <div class="relative w-full">
                        <select name="satker_id" id="edit_satker_id"
                            class="select2-searchable w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition cursor-pointer">
                            <option value="" disabled selected>Pilih Satker</option>
                            @foreach($satkers as $satker)
                                <option value="{{ $satker->id }}" class="bg-[#1e293b]">{{ $satker->nama_entitas }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="editItwilWrapper" class="hidden">
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Wilayah Itwil</label>
                    <div class="relative">
                        <select name="wilayah_id" id="edit_wilayah_id"
                            class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition cursor-pointer appearance-none">
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
                    <input type="email" name="email" id="edit_email" required
                        class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition">
                </div>
                <div>
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2 block">Password <span class="text-slate-600 lowercase tracking-normal font-normal">(Kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" minlength="8"
                        class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-3 text-[11px] text-white outline-none focus:border-blue-500 transition">
                </div>
                <div class="flex justify-end items-center gap-6 mt-10">
                    <button type="button" onclick="document.getElementById('modalEditUser').classList.add('hidden')" 
                        class="text-[10px] text-slate-400 hover:text-white font-black transition uppercase tracking-widest">Batal</button>
                    <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl text-[10px] font-black shadow-lg shadow-blue-900/40 transition-all active:scale-95 uppercase tracking-widest">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Hapus User -->
    <div id="modalHapusUser" class="hidden fixed inset-0 z-[999] flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 transition-opacity">
        <div class="bg-[#1e293b] w-full max-w-sm rounded-[2rem] border border-slate-700 shadow-2xl p-8 text-center relative overflow-hidden">
            <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-5 border border-red-500/20 shadow-inner">
                <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h3 class="text-white text-lg font-bold mb-3 tracking-wide">Konfirmasi Hapus</h3>
            <p class="text-slate-400 text-xs font-medium leading-relaxed mb-8">
                Apakah Anda yakin ingin menghapus user ini? Data yang dihapus tidak dapat dikembalikan.
            </p>
            <form id="formHapusUser" method="POST">
                @csrf
                @method('DELETE')
                <div class="flex justify-center gap-3">
                    <button type="button" onclick="document.getElementById('modalHapusUser').classList.add('hidden')" class="py-2.5 px-6 rounded-xl border border-slate-600 text-slate-300 hover:text-white hover:bg-slate-700 hover:border-slate-500 transition-all text-xs font-bold tracking-wider uppercase">
                        Batal
                    </button>
                    <button type="submit" class="py-2.5 px-6 rounded-xl bg-red-600 hover:bg-red-500 text-white shadow-lg shadow-red-900/40 transition-all text-xs font-bold tracking-wider uppercase">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(user) {
        document.getElementById('formEditUser').action = `/users/${user.id}`;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;
        document.getElementById('edit_satker_id').value = user.satker_id || '';
        document.getElementById('edit_wilayah_id').value = user.wilayah_id || '';
        
        // Trigger the toggle
        document.getElementById('editSatkerWrapper').classList.toggle('hidden', user.role !== 'satker');
        document.getElementById('editItwilWrapper').classList.toggle('hidden', user.role !== 'itwil');
        
        document.getElementById('modalEditUser').classList.remove('hidden');
    }

    function openDeleteModal(userId) {
        document.getElementById('formHapusUser').action = `/users/${userId}`;
        document.getElementById('modalHapusUser').classList.remove('hidden');
    }
</script>
@endsection
