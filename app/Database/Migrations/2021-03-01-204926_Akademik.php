<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Akademik extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
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
				'null'			 => TRUE,
			],
			'foto'				 => [
				'type' 			 => 'varchar',
				'constraint'	 => 255,
				'default'		 => 'default-profile.png'
			],
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->addForeignKey('id_akun','users', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('akademik');
	}

	public function down()
	{
		$this->forge->dropTable('akademik');
	}
}
