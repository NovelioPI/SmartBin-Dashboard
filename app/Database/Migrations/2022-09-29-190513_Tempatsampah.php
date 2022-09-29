<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tempatsampah extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID'        => [
                'type'              => 'INT',
                'null'              => false,
                'auto_increment'    => true
            ],
            'Latitude'  => [
                'type'              => 'DOUBLE',
                'null'              => false,
                'default'           => null
            ],
            'Longitude' => [
                'type'              => 'VARCHAR',
                'constraint'        => 45,
                'null'              => false,
                'default'           => null
            ]
        ]);
        $this->forge->addKey('ID', true);
        $this->forge->createTable('tempatsampah');
    }

    public function down()
    {
		$this->forge->dropTable('tempatsampah');
    }
}
