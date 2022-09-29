<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Statustempatsampah extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID'                => [
                'type'              => 'INT',
                'null'              => false,
                'auto_increment'    => true
            ],
            'TempatSampah_ID'   => [
                'type'              => 'INT',
                'null'              => false,
                'default'           => null
            ],
            'JenisStatus_ID'    => [
                'type'              => 'INT',
                'null'              => false,
                'default'           => '1'
            ],
            'WaktuAmbil TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ]);
        $this->forge->addKey('ID', true);
		$this->forge->addForeignKey('TempatSampah_ID', 'tempatsampah', 'ID');
		$this->forge->addForeignKey('JenisStatus_ID', 'jenisstatus', 'ID');
		$this->forge->createTable('statustempatsampah');
    }

    public function down()
    {
		$this->forge->dropTable('statustempatsampah');
    }
}
