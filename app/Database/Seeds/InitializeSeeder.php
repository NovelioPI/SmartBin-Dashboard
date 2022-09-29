<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitializeSeeder extends Seeder
{
    public function run()
    {
        $this->call('JenisstatusSeeder');
    }
}
