<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Satker - {{ $satker->nama_entitas }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1e467a;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1e467a;
            margin: 0 0 5px 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            color: #555;
            font-size: 12px;
            font-weight: bold;
        }
        .section-title {
            background-color: #1e467a;
            color: #fff;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th {
            background-color: #f0f4f8;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            color: #1e467a;
        }
        td {
            padding: 8px 12px;
            vertical-align: top;
        }
        .layout-table {
            border: none;
            margin-bottom: 20px;
        }
        .layout-table .layout-cell {
            border: none;
            padding: 0;
        }
        .layout-table .layout-cell.col-left {
            padding-right: 10px;
            width: 50%;
        }
        .layout-table .layout-cell.col-right {
            padding-left: 10px;
            width: 50%;
        }
        .layout-table table {
            margin-bottom: 0;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            color: #fff;
            text-transform: uppercase;
            display: inline-block;
        }
        .bg-urgent { background-color: #ef4444; }
        .bg-proses { background-color: #f59e0b; }
        .bg-selesai { background-color: #10b981; }
        .bg-default { background-color: #6b7280; }
        
        .footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 30px;
            font-size: 9px;
            color: #777;
            text-align: center;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
        .pagenum:before {
            content: counter(page);
        }
    </style>
</head>
<body>

    <div class="footer">
        Dicetak dari Dashboard Pengawasan Kemlu RI pada {{ date('d F Y') }} | Hal. <span class="pagenum"></span>
    </div>

    <div class="header">
        <h1>{{ $satker->nama_entitas }}</h1>
        <p>{{ $satker->tipe_entitas }} &bull; Lokasi: {{ $satker->lokasi }}</p>
    </div>

    <div class="section-title">A. Profil Perwakilan</div>
    <table class="layout-table">
        <tr>
            <td class="layout-cell col-left">
                <table>
                    <tr><th colspan="2">Informasi Umum</th></tr>
                    @if($satker->tipe_entitas !== 'Dalam Negeri')
                    <tr><td width="40%"><strong>Komposisi Pegawai</strong></td><td>HS: {{ $satker->jumlah_hs ?? 0 }} &bull; LS: {{ $satker->jumlah_ls ?? 0 }}</td></tr>
                    @endif
                    <tr><td width="40%"><strong>Kontak Penting</strong></td><td>{{ $satker->profile?->kontak ?? '-' }}</td></tr>
                </table>
            </td>
            <td class="layout-cell col-right">
                <table>
                    <tr><th colspan="2">Pimpinan & Pejabat</th></tr>
                    <tr><td width="40%"><strong>{{ $satker->tipe_entitas === 'Dalam Negeri' ? 'Pimpinan' : 'Keppri' }}</strong></td><td>{{ $satker->profile?->kepala_nama ?? '-' }}{{ $satker->profile?->kepala_telp ? ' (' . $satker->profile?->kepala_telp . ')' : '' }}</td></tr>
                    @if($satker->tipe_entitas !== 'Dalam Negeri')
                    <tr><td><strong>HOC</strong></td><td>{{ $satker->profile?->hoc_nama ?? '-' }}{{ $satker->profile?->hoc_telp ? ' (' . $satker->profile?->hoc_telp . ')' : '' }}</td></tr>
                    @endif
                    <tr><td><strong>PPK</strong></td><td>{{ $satker->profile?->ppk_nama ?? '-' }}{{ $satker->profile?->ppk_telp ? ' (' . $satker->profile?->ppk_telp . ')' : '' }}</td></tr>
                    <tr><td><strong>{{ $satker->tipe_entitas === 'Dalam Negeri' ? 'Kabag TU & Kepeg.' : 'BPKRT' }}</strong></td><td>{{ $satker->profile?->bpkrt_nama ?? '-' }}{{ $satker->profile?->bpkrt_telp ? ' (' . $satker->profile?->bpkrt_telp . ')' : '' }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="section-title">B. Snapshot Pengawasan</div>
    <table>
        <tr>
            <th width="20%">Tahun Audit Terakhir</th>
            <th width="20%">Status RR / RPR</th>
            <th width="20%">Temuan Berulang</th>
            <th width="40%">Area Risiko Utama</th>
        </tr>
        <tr>
            <td style="text-align: center; font-size: 14px; font-weight: bold;">{{ $satker->profile?->tahun_audit ?? '-' }}</td>
            <td style="text-align: center; font-weight: bold;">{{ $satker->profile?->status_rr ?? '-' }}</td>
            <td style="text-align: center; color: #b45309; font-weight: bold;">{{ $satker->profile?->temuan ?? 'Tidak Ada' }}</td>
            <td>{{ $satker->profile?->area_resiko ?? 'Belum ada data area risiko.' }}</td>
        </tr>
    </table>

    <div class="section-title">C. Daftar Isu & Tindak Lanjut</div>
    @if(count($issues) > 0)
        <table>
            <thead>
                <tr>
                    <th width="4%" style="text-align: center;">No</th>
                    <th width="12%">Kategori</th>
                    <th width="32%">Deskripsi Isu</th>
                    <th width="32%">Tindak Lanjut</th>
                    <th width="10%" style="text-align: center;">Status</th>
                    <th width="10%" style="text-align: center;">Update</th>
                </tr>
            </thead>
            <tbody>
                @foreach($issues->sortByDesc('updated_at') as $issue)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td><strong>{{ $issue->kategori }}</strong></td>
                    <td>{{ $issue->deskripsi_isu }}</td>
                    <td>{{ $issue->tindak_lanjut ?? '-' }}</td>
                    <td style="text-align: center;">
                        @php
                            $status = strtolower($issue->status);
                            $badgeClass = 'bg-default';
                            if($status == 'urgent') $badgeClass = 'bg-urgent';
                            elseif($status == 'proses') $badgeClass = 'bg-proses';
                            elseif($status == 'selesai') $badgeClass = 'bg-selesai';
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $issue->status }}</span>
                    </td>
                    <td style="text-align: center;">{{ $issue->updated_at ? $issue->updated_at->format('d/m/Y') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; padding: 20px; border: 1px dashed #ccc; background: #f9f9f9; color: #777;">
            Belum ada catatan isu untuk entitas ini.
        </p>
    @endif

</body>
</html>
