<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Satker;
use Illuminate\Support\Facades\File;

class UnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvPath = database_path('seeders/unit_kerja.csv');
        if (!File::exists($csvPath)) {
            $this->command->error("File unit_kerja.csv tidak ditemukan di database/seeders/");
            return;
        }

        $lines = file($csvPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        // Lewati header (nama_entitas;flag;tipe_entitas)
        array_shift($lines);

        foreach ($lines as $line) {
            $data = explode(';', $line);
            if (count($data) >= 3) {
                $nama_entitas = trim($data[0]);
                $tipe_entitas = trim($data[2]);

                $lokasi = '-';

                if ($tipe_entitas === 'Dalam Negeri') {
                    $lokasi = 'Indonesia';
                } elseif ($tipe_entitas === 'Luar Negeri') {
                    // Ekstrak nama kota/negara dari nama entitas (misal: "KBRI SEOUL" -> "Seoul")
                    // Menggunakan mapping manual untuk beberapa negara utama
                    $mappingNegara = [
                        'SEOUL' => 'Korea Selatan',
                        'TOKYO' => 'Jepang',
                        'BEIJING' => 'Tiongkok',
                        'WASHINGTON DC' => 'Amerika Serikat',
                        'LONDON' => 'Inggris',
                        'PARIS' => 'Prancis',
                        'BERLIN' => 'Jerman',
                        'MOSKOW' => 'Rusia',
                        'CANBERRA' => 'Australia',
                        'KUALA LUMPUR' => 'Malaysia',
                        'SINGAPURA' => 'Singapura',
                        'BANGKOK' => 'Thailand',
                        'NEW DELHI' => 'India',
                        'RIYADH' => 'Arab Saudi',
                        'KAIRO' => 'Mesir',
                        'PRETORIA' => 'Afrika Selatan',
                        'BRASILIA' => 'Brasil',
                        'BUENOS AIRES' => 'Argentina',
                        'MEXICO CITY' => 'Meksiko',
                    ];

                    $parts = explode(' ', $nama_entitas);
                    if (count($parts) > 1) {
                        array_shift($parts); // Hapus kata pertama (KBRI/KJRI/dll)
                        $cityOrCountry = implode(' ', $parts);
                        
                        if (array_key_exists(strtoupper($cityOrCountry), $mappingNegara)) {
                            $lokasi = $mappingNegara[strtoupper($cityOrCountry)];
                        } else {
                            $lokasi = ucwords(strtolower($cityOrCountry));
                        }
                    } else {
                        $lokasi = ucwords(strtolower($nama_entitas));
                    }
                }

                Satker::updateOrCreate(
                    ['nama_entitas' => $nama_entitas],
                    [
                        'tipe_entitas' => $tipe_entitas,
                        'lokasi' => $lokasi,
                        'is_active' => true,
                    ]
                );
            }
        }

        $this->command->info("Data unit kerja berhasil di-import!");
    }
}
