<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategoripelanggaran extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 5,
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
		$this->forge->createTable('kategori_pelanggaran');
	}

	public function down()
	{
		$this->forge->dropTable('kategori_pelanggaran');
	}
}
