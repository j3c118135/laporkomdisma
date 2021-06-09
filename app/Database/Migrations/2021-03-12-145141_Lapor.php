<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lapor extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'MEDIUMINT',
				'constraint'     => '11',
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'id_pelanggaran' => [
				'type'           => 'MEDIUMINT',
				'constraint'     => '11',
				'unsigned'       => true,
			],
			'tanggal'       => [
				'type'           => 'DATE',
				'null'			 => TRUE,
			],
			'id_penerima_lapor'          => [
				'type'           => 'MEDIUMINT',
				'constraint'     => '11',
				'unsigned'       => true,
				'null'			 => TRUE,
			],
			'keterangan' => [
				'type'           => 'TEXT',
				'null'			 => TRUE,
			],
			'status' => [
				'type'           => 'INT',
				'constraint'     => 1,
				'default'		 => 0,
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addForeignKey('id_pelanggaran','pelanggaran_mahasiswa', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('id_penerima_lapor','users', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('lapor_pelanggaran');
	}

	public function down()
	{
		$this->forge->dropTable('lapor_pelanggaran');
	}
}
