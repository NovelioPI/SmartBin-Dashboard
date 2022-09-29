<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JenisstatusSeeder extends Seeder
{
    public function run()
    {
        $status = [
            [
                'ID'        => 1,
                'Deskripsi' => 'Tidak Terhubung',
            ],
            [
                'ID'        => 2,
                'Deskripsi' => 'Kosong',
            ],
            [
                'ID'        => 3,
                'Deskripsi' => 'Setengah Penuh',
            ],
            [
                'ID'        => 4,
                'Deskripsi' => 'Penuh'
            ],
        ];

        $this->db->table('jenisstatus')->insertBatch($status);
    }
}
