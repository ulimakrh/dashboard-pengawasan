<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - {{ $satker->nama_entitas }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', Segoe UI, Roboto, Arial, sans-serif; background: #0f172a; color: #f1f5f9; line-height: 1.5; padding: 40px 20px; }
        .container { max-width: 1100px; margin: auto; }
        
        /* Typography */
        h2 { font-size: 1.5rem; font-weight: 600; margin-bottom: 24px; color: #f8fafc; letter-spacing: -0.025em; }
        h3 { font-size: 1.1rem; font-weight: 600; margin-bottom: 20px; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #334155; padding-bottom: 10px; }
        
        /* Layout */
        .grid-container { display: flex; gap: 24px; align-items: flex-start; }
        .card { flex: 1; background: #1e293b; padding: 28px; border-radius: 16px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); border: 1px solid #334155; }
        
        /* Form Elements */
        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 6px; color: #cbd5e1; }
        
        input[type="text"], textarea {
            width: 100%;
            padding: 10px 12px;
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 8px;
            color: #fff;
            font-size: 0.95rem;
            transition: all 0.2s;
            font-family: inherit;
        }
        
        input[type="text"]:focus, textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* Dual Input Row */
        .input-row { display: flex; gap: 8px; margin-bottom: 8px; }
        .input-row input { flex: 1; }
        .input-row .wide { flex: 2; }

        /* Button */
        .btn-submit {
            padding: 12px 24px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .btn-submit:hover { background: #1d4ed8; }
        
        .readonly-field {
            opacity: 0.6;
            cursor: not-allowed !important;
            background-color: #1e293b !important;
        }
        
        @media (max-width: 768px) {
            .grid-container { flex-direction: column; }
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Edit Data &mdash; <span style="color: #3b82f6;">{{ $satker->nama_entitas }}</span></h2>

    <form method="POST" action="/profile/update/{{ $satker->id }}">
    @csrf

    <div class="grid-container">

        <!-- SEKSI KIRI: PROFIL & KONTAK -->
        <div class="card">
            <h3>Profil & Kontak</h3>

            <div class="form-group">
                <label>Kontak Utama (Alamat/Email)</label>
                <input type="text" name="kontak" value="{{ $satker->profile->kontak ?? '' }}" placeholder="e.g. Alamat atau Email Utama">
            </div>

            @if($satker->tipe_entitas !== 'Dalam Negeri')
            <div class="form-group">
                <label>Komposisi Pegawai (HS & LS)</label>
                <div class="input-row">
                    <input type="text" name="jumlah_hs" placeholder="Jumlah Home Staff" value="{{ $satker->jumlah_hs ?? '' }}">
                    <input type="text" name="jumlah_ls" placeholder="Jumlah Local Staff" value="{{ $satker->jumlah_ls ?? '' }}">
                </div>
            </div>
            @endif

            <div class="form-group">
                <label>{{ $satker->tipe_entitas === 'Dalam Negeri' ? 'Pimpinan (Nama & Telp)' : 'Kepala Perwakilan (Nama & Telp)' }}</label>
                <div class="input-row">
                    <input type="text" name="kepala_nama" class="wide" placeholder="Nama Lengkap" value="{{ $satker->profile->kepala_nama ?? '' }}">
                    <input type="text" name="kepala_telp" placeholder="No. HP" value="{{ $satker->profile->kepala_telp ?? '' }}">
                </div>
            </div>

            @if($satker->tipe_entitas !== 'Dalam Negeri')
            <div class="form-group">
                <label>Head of Chancery / HOC (Nama & Telp)</label>
                <div class="input-row">
                    <input type="text" name="hoc_nama" class="wide" placeholder="Nama Lengkap" value="{{ $satker->profile->hoc_nama ?? '' }}">
                    <input type="text" name="hoc_telp" placeholder="No. HP" value="{{ $satker->profile->hoc_telp ?? '' }}">
                </div>
            </div>
            @endif

            <div class="form-group">
                <label>PPK (Nama & Telp)</label>
                <div class="input-row">
                    <input type="text" name="ppk_nama" class="wide" placeholder="Nama Lengkap" value="{{ $satker->profile->ppk_nama ?? '' }}">
                    <input type="text" name="ppk_telp" placeholder="No. HP" value="{{ $satker->profile->ppk_telp ?? '' }}">
                </div>
            </div>

            <div class="form-group">
                <label>{{ $satker->tipe_entitas === 'Dalam Negeri' ? 'Kabag TU & Kepegawaian (Nama & Telp)' : 'BPKRT (Nama & Telp)' }}</label>
                <div class="input-row">
                    <input type="text" name="bpkrt_nama" class="wide" placeholder="Nama Lengkap" value="{{ $satker->profile->bpkrt_nama ?? '' }}">
                    <input type="text" name="bpkrt_telp" placeholder="No. HP" value="{{ $satker->profile->bpkrt_telp ?? '' }}">
                </div>
            </div>
        </div>

        <!-- SEKSI KANAN: SNAPSHOT PENGAWASAN -->
        <div class="card">
            <h3>Snapshot Pengawasan</h3>
            
            @if(auth()->user()->isSatker())
            <div style="background: #334155; padding: 12px; border-radius: 8px; border-left: 4px solid #f59e0b; margin-bottom: 20px;">
                <p style="font-size: 0.8rem; color: #cbd5e1; margin: 0;">
                    <strong style="color: #fcd34d;">Info:</strong> Satker hanya memiliki izin untuk mengedit Profil & Kontak. Data Snapshot Pengawasan hanya dapat diperbarui oleh Super Admin atau Itwil.
                </p>
            </div>
            @endif

            <div class="form-group">
                <label>Tahun Audit Terakhir</label>
                <input type="text" name="tahun_audit" value="{{ $satker->profile->tahun_audit ?? '' }}" placeholder="Contoh: 2023" {!! auth()->user()->isSatker() ? 'readonly class="readonly-field"' : '' !!}>
            </div>

            <div class="form-group">
                <label>Status RR/RPR</label>
                <input type="text" name="status_rr" value="{{ $satker->profile->status_rr ?? '' }}" placeholder="Masukkan status penyelesaian" {!! auth()->user()->isSatker() ? 'readonly class="readonly-field"' : '' !!}>
            </div>

            <div class="form-group">
                <label>Area Risiko Utama</label>
                <textarea name="area_resiko" rows="3" placeholder="Sebutkan area risiko utama" {!! auth()->user()->isSatker() ? 'readonly class="readonly-field"' : '' !!}>{{ $satker->profile->area_resiko ?? '' }}</textarea>
            </div>

            <div class="form-group">
                <label>Indikasi Temuan Berulang</label>
                <textarea name="temuan" rows="3" placeholder="Deskripsi indikasi temuan" {!! auth()->user()->isSatker() ? 'readonly class="readonly-field"' : '' !!}>{{ $satker->profile->temuan ?? '' }}</textarea>
            </div>
            
            {{-- <div style="background: #0f172a; padding: 15px; border-radius: 12px; border-left: 4px solid #3b82f6; margin-top: 10px;">
                <p style="font-size: 0.8rem; color: #94a3b8;">
                    Data di atas akan ditampilkan pada dashboard utama sebagai ringkasan kondisi pengawasan terkini.
                </p>
            </div> --}}
        </div>

    </div>

    <!-- ACTION BUTTON -->
    <div style="margin-top: 30px; text-align: right;">
        <button type="button" onclick="window.history.back()" style="background:transparent; color:#94a3b8; border:none; margin-right:15px; cursor:pointer;">Batal</button>
        <button type="submit" class="btn-submit">
            Simpan Perubahan
        </button>
    </div>

    </form>

</div>

</body>
</html>