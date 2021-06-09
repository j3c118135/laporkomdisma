<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jadwal extends Migration
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
			],
			'matkul' => [
				'type'           => 'TEXT',
			],
			'jam_mulai'       => [
				'type'           => 'TIME',
			],
			'jam_selesai'       => [
				'type'           => 'TIME',
			],
			'dosen' => [
				'type'           => 'MEDIUMINT',
				'constraint'     => '11',
				'unsigned'       => true,
			],
			'koordinator' => [
				'type'           => 'MEDIUMINT',
				'constraint'     => '11',
				'unsigned'       => true,
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addForeignKey('id_pelanggaran','pelanggaran_mahasiswa', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('dosen','users', 'id', 'CASCADE', 'CASCADE');
		$this->forge->addForeignKey('koordinator','users', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('jadwal_matkul');
	}

	public function down()
	{
		$this->forge->dropTable('jadwal_matkul');
	}
}
