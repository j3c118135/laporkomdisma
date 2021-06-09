<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Suratkelakukanbaik extends Migration
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
			'nim'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 20,
			],
			'tgl_pengajuan'       => [
				'type'           => 'DATE',
				'null'			 => TRUE,
			],
			'keperluan' => [
				'type'           => 'TEXT',
			],
			'inspektur'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 20,
				'null'			 => TRUE,
			],
			'tgl_berakhir'       => [
				'type'           => 'DATE',
				'null'			 => TRUE,
			],
			'status' => [
				'type'           => 'INT',
				'constraint'     => 1,
				'default'		 => 0,
			],
			'komentar' => [
				'type'           => 'TEXT',
				'null'			 => TRUE,
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addForeignKey('nim','mahasiswa', 'nim', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('inspektur','komdisma', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('surat_kelakuan_baik');
	}

	public function down()
	{
		$this->forge->dropTable('surat_kelakuan_baik');
	}
}
