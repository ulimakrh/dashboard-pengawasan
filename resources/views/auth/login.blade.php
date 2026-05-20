@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="flex items-center justify-center min-h-[75vh]">
    <div class="relative w-full max-w-[420px]">
        
        <!-- Glowing Ambient Effects -->
        <div class="absolute -top-12 -left-12 w-48 h-48 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-12 -right-12 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl"></div>

        <div class="relative bg-[#111827]/80 backdrop-blur-xl rounded-[2.5rem] border border-slate-800/60 shadow-2xl p-8 sm:p-10 overflow-hidden">
            
            <div class="text-center mb-10">
                <div class="inline-flex p-4 rounded-[1.5rem] bg-white shadow-xl mb-6 relative">
                    <img src="{{ asset('assets/img/logo_kemlu.png') }}" alt="Logo Kemlu" class="h-16 w-auto relative z-10">
                </div>
                <h1 class="text-xl font-black text-white tracking-tight uppercase mb-1">Dashboard Pengawasan</h1>
                <p class="text-[9px] uppercase tracking-[0.25em] text-slate-400 font-bold">Kementerian Luar Negeri RI</p>
            </div>



            <form action="/login" method="POST" class="space-y-6">
                @csrf
                
                @if($errors->any())
                    <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-center mb-2 animate-fade-in">
                        <p class="text-red-400 text-[11px] font-bold">{{ $errors->first() }}</p>
                    </div>
                @endif

                <div>
                    <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold mb-2.5 block">Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-blue-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email" required 
                            class="w-full bg-[#0b1120] border border-slate-700/80 rounded-xl pl-11 pr-4 py-3.5 text-[12px] text-white placeholder:text-slate-600 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all shadow-inner">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2.5">
                        <label class="text-[9px] uppercase tracking-widest text-slate-500 font-bold block">Kata Sandi</label>
                        <a href="javascript:void(0)" onclick="document.getElementById('modalLupaSandi').classList.remove('hidden')" class="text-[9px] text-blue-400 hover:text-blue-300 font-bold uppercase tracking-wider transition-colors">Lupa Sandi?</a>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 group-focus-within:text-blue-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" name="password" placeholder="••••••••" required 
                            class="w-full bg-[#0b1120] border border-slate-700/80 rounded-xl pl-11 pr-11 py-3.5 text-[12px] text-white placeholder:text-slate-600 outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all shadow-inner">
                        <button type="button" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-500 hover:text-slate-300 transition-colors" onclick="const p = this.previousElementSibling; p.type = p.type === 'password' ? 'text' : 'password';">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-500 text-white py-4 rounded-xl text-[11px] font-black shadow-lg shadow-blue-900/40 transition-all active:scale-95 uppercase tracking-widest flex items-center justify-center gap-2 group">
                        Masuk
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</div>

<!-- Modal Lupa Sandi -->
<div id="modalLupaSandi" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/80 backdrop-blur-sm p-4 transition-opacity">
    <div class="bg-[#1e293b] w-full max-w-sm rounded-[2rem] border border-slate-700 shadow-2xl p-8 text-center relative overflow-hidden">
        
        <div class="relative z-10">
            <div class="w-16 h-16 bg-blue-500/10 rounded-full flex items-center justify-center mx-auto mb-5 border border-blue-500/20 shadow-inner">
                <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            
            <h3 class="text-white text-lg font-bold mb-3 tracking-wide">Lupa Kata Sandi?</h3>
            
            <p class="text-slate-400 text-xs font-medium leading-relaxed mb-8">
                Silahkan menghubungi Helpdesk<br>
                <span class="text-slate-200 font-bold mt-1 block">PUSDATIN ext. 5555</span>
            </p>
            
            <button onclick="document.getElementById('modalLupaSandi').classList.add('hidden')" class="py-2.5 px-8 rounded-xl border border-slate-600 text-slate-300 hover:text-white hover:bg-slate-700 hover:border-slate-500 transition-all text-xs font-bold tracking-wider uppercase">
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection