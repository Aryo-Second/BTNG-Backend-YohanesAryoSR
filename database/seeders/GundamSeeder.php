<?php

namespace Database\Seeders;

use App\Models\Gundam;
use Illuminate\Database\Seeder;

class GundamSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama' => 'HG 1/144 RX-78-2 Gundam [Revive]', 'merk' => 'Bandai', 'ori' => true, 'harga_retail' => 175000],
            ['nama' => 'RG 1/144 Nu Gundam', 'merk' => 'Bandai', 'ori' => true, 'harga_retail' => 650000],
            ['nama' => 'MG 1/100 Strike Freedom Gundam Ver. 2.0', 'merk' => 'Bandai', 'ori' => true, 'harga_retail' => 1100000],
            ['nama' => 'PG Unleashed 1/60 RX-78-2 Gundam', 'merk' => 'Bandai', 'ori' => true, 'harga_retail' => 3800000],
            ['nama' => 'HG 1/144 Gundam Barbatos', 'merk' => 'Bandai', 'ori' => true, 'harga_retail' => 160000],
            ['nama' => 'MG 1/100 Sazabi Ver. Ka', 'merk' => 'Daban', 'ori' => false, 'harga_retail' => 450000],
            ['nama' => 'MG 1/100 Freedom Gundam Ver. 2.0', 'merk' => 'Daban', 'ori' => false, 'harga_retail' => 320000],
            ['nama' => 'SD Gundam EX-Standard Unicorn Gundam', 'merk' => 'Bandai', 'ori' => true, 'harga_retail' => 100000],
        ];

        foreach ($data as $item) {
            Gundam::updateOrCreate(['nama' => $item['nama']], $item);
        }
    }
}