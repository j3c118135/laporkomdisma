<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelanggaran extends Migration
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
			'tingkat' => [
				'type'           => 'INT',
				'constraint'     => '1',
			],
			'tanggal'       => [
				'type'           => 'DATE',
			],
			'jam'       => [
				'type'           => 'TIME',
			],
			'id_lokasi' => [
				'type'           => 'INT',
				'constraint'     => 10,
				'unsigned'       => true,
			],
			'jenis_pelanggaran' => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
			],
			'keterangan' => [
				'type'           => 'TEXT',
			],
			'id_pelapor'          => [
				'type'           => 'MEDIUMINT',
				'constraint'     => '11',
				'unsigned'       => true,
			],
			'bukti_foto' => [
				'type' 			 => 'varchar',
				'constraint'	 => 255,
				'default'		 => 'default-profile.png'
			],
			'inspektur'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 20,
				'null'			 => TRUE,
			],
			'tgl_verifikasi' => [
				'type'           => 'DATE',
				'null'			 => TRUE,
			],
			'id_sanksi' => [
				'type'           => 'INT',
				'constraint'     => 5,
				'unsigned'       => true,
				'null'			 => TRUE,
			],
			'tgl_surat_bebas' => [
				'type'           => 'DATE',
				'null'			 => TRUE,
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addForeignKey('nim','mahasiswa', 'nim', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('id_lokasi','lokasi', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('jenis_pelanggaran','jenis_pelanggaran', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('id_pelapor','users', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('inspektur','komdisma', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('id_sanksi','sanksi', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('pelanggaran_mahasiswa');
	}

	public function down()
	{
		$this->forge->dropTable('pelanggaran_mahasiswa');
	}
}
