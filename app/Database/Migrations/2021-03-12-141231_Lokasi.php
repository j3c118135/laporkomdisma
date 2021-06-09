<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lokasi extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 10,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'nama'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'unique' 		 => TRUE,
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('lokasi');
	}

	public function down()
	{
		$this->forge->dropTable('lokasi');
	}
}
