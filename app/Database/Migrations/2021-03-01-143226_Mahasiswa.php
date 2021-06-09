<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mahasiswa extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'nim'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 20,
			],
			'id_akun' => [
				'type'           => 'MEDIUMINT',
				'constraint'     => '11',
				'unsigned'       => true,
			],
			'nama'       => [
				'type'           => 'TEXT',
			],
			'prodi' => [
				'type'           => 'VARCHAR',
				'constraint'	=> 5,
			],
			'foto_ktm' => [
				'type'           => 'VARCHAR',
				'constraint'	=> 255,
				'null'			 => TRUE,
			],
			'foto_simawa' => [
				'type'           => 'VARCHAR',
				'constraint'	=> 255,
				'null'			 => TRUE,
			],
			'foto_datalulusan' => [
				'type'           => 'VARCHAR',
				'constraint'	=> 255,
				'null'			 => TRUE,
			],
			'tgl_sidang' => [
				'type'           => 'DATE',
				'null'			 => TRUE,
			],
			'tgl_bebas_komdis' => [
				'type'           => 'DATE',
				'null'			 => TRUE,
			],
			'komentar' => [
				'type'           => 'TEXT',
				'null'			 => TRUE,
			],
			'kontak' => [
				'type'           => 'VARCHAR',
				'constraint'	=> 15,
				'null'			 => TRUE,
			],
			'foto'				 => [
				'type' 			 => 'varchar',
				'constraint'	 => 255,
				'default'		 => 'default-profile.png'
			],
		]);
		$this->forge->addKey('nim', TRUE);
		$this->forge->addForeignKey('id_akun','users', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('mahasiswa');
	}

	public function down()
	{
		$this->forge->dropTable('mahasiswa');
	}
}
