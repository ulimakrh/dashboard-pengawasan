<!DOCTYPE html>
<html>
<head>
    <title>Tambah Satker</title>
</head>

<body style="font-family: Arial; background:#0f172a; color:white; padding:20px;">

    <h2 style="margin-bottom:20px;">Tambah Entitas Baru</h2>

    <!-- CARD -->
    <div style="
        max-width:500px;
        background:#1e293b;
        padding:25px;
        border-radius:12px;
        box-shadow:0 4px 12px rgba(0,0,0,0.4);
    ">

        <form method="POST" action="/satker">
            @csrf

            <!-- TIPE -->
            <label>Tipe Entitas</label><br>
            <select name="tipe_entitas" style="
                width:100%;
                padding:10px;
                margin-bottom:15px;
                border-radius:6px;
                border:none;
            ">
                <option value="Perwakilan LN">Perwakilan RI di Luar Negeri</option>
                <option value="Biro">Biro (Dalam Negeri)</option>
                <option value="Direktorat">Direktorat (Dalam Negeri)</option>
                <option value="Sekretariat">Sekretariat (Dalam Negeri)</option>
            </select>

            <!-- NAMA -->
            <label>Nama Perwakilan / Satker</label><br>
            <input type="text" name="nama_entitas"
                placeholder="Contoh: KBRI Seoul"
                style="
                    width:100%;
                    padding:10px;
                    margin-bottom:15px;
                    border-radius:6px;
                    border:none;
                ">

            <!-- LOKASI -->
            <label>Negara / Wilayah</label><br>
            <input type="text" name="lokasi"
                placeholder="Contoh: Korea Selatan"
                style="
                    width:100%;
                    padding:10px;
                    margin-bottom:20px;
                    border-radius:6px;
                    border:none;
                ">

            <!-- BUTTON -->
            <div style="display:flex; justify-content:flex-end; gap:10px;">

                <a href="/satker" style="
                    padding:10px 15px;
                    background:#475569;
                    color:white;
                    text-decoration:none;
                    border-radius:6px;
                ">
                    Batal
                </a>

                <button type="submit" style="
                    padding:10px 15px;
                    background:#3b82f6;
                    color:white;
                    border:none;
                    border-radius:6px;
                ">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</body>
</html>