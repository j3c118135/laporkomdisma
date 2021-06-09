<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jenispelanggaran extends Migration
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
			'id_kategori' => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
			],
			'nama'       => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
				'unique' 		 => TRUE,

			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addForeignKey('id_kategori','kategori_pelanggaran', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('jenis_pelanggaran');
	}

	public function down()
	{
		$this->forge->dropTable('jenis_pelanggaran');
	}
}
