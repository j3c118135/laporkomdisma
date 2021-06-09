<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penundaanskorsing extends Migration
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
			'tgl_pengajuan'       => [
				'type'           => 'DATE',
				'null'			 => TRUE,
			],
			'inspektur'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 20,
				'null'			 => TRUE,
			],
			'status' => [
				'type'           => 'INT',
				'constraint'     => 1,
				'default'		 => 0,
			],
			'keterangan' => [
				'type'           => 'TEXT',
			],
			'komentar' => [
				'type'           => 'TEXT',
				'null'			 => TRUE,
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addForeignKey('id_pelanggaran','pelanggaran_mahasiswa', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('inspektur','komdisma', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('penundaan_skorsing');
	}

	public function down()
	{
		$this->forge->dropTable('penundaan_skorsing');
	}
}
