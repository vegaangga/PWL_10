<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'nim' => '2041723013',
                'nama' => 'Vega Anggaresta',
                'kelas' => 'TI-2C',
                'jurusan' => 'JTI',
                'no_handphone' => '083835366321'
            ],
            [
                'nim' => '9999999999',
                'nama' => 'Venope',
                'kelas' => 'TI-2C',
                'jurusan' => 'JTI',
                'no_handphone' => '083835366321'
            ]
            ];

        DB::table('mahasiswa')->insert($data);
    }
}
