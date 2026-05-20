<aside class="w-72 bg-[#1e293b] border-r border-slate-800 flex flex-col shrink-0 sticky top-0 h-screen p-6">
    <div class="mb-8">
        <h2 class="text-xl font-bold text-blue-500 tracking-tight">Itwil III Kemenlu</h2>
    </div>

    <div class="relative mb-6">
        <input type="text" placeholder="Cari Perwakilan..." 
            class="w-full bg-[#0f172a] border border-slate-700 rounded-xl px-4 py-2.5 text-sm outline-none focus:border-blue-500 transition">
    </div>

    <nav class="flex-1 overflow-y-auto space-y-1 pr-2 custom-scrollbar">
        @foreach($satkers as $s)
            @php
                // Logika aktif sederhana (hanya jika di halaman show)
                $isActive = isset($satker) && $satker->id == $s->id;
            @endphp
            <a href="/satker/{{ $s->id }}" 
               class="block px-4 py-3 rounded-xl text-sm transition-all {{ $isActive ? 'bg-blue-600 text-white font-semibold' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                {{ $s->nama_entitas }}
            </a>
        @endforeach
    </nav>

    <div class="mt-auto pt-6 border-t border-slate-800">
        <a href="/satker" class="text-xs text-slate-500 hover:text-slate-300 transition flex items-center gap-2">
            <span>←</span> Kembali ke Dashboard
        </a>
    </div>
</aside>

<style>
    /* Styling scrollbar tipis untuk sidebar */
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
</style>