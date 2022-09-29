<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jenisstatus extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID'        => [
                'type'              => 'INT',
                'null'              => false,
                'auto_increment'    => true
            ],
            'Deskripsi' => [
                'type'              => 'VARCHAR',
                'constraint'        => '45',
                'null'              => false,
            ]
        ]);
        $this->forge->addKey('ID', true);
        $this->forge->createTable('jenisstatus');
    }

    public function down()
    {
        $this->forge->dropTable('jenisstatus');
    }
}
