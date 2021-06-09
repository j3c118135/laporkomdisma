<?php namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model{
    protected $table      = 'dosen';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'id_akun', 'nama', 'foto'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tb_dosen = $this->db->table('dosen');
    }
        
    public function getAll(){
        $builder = $this->tb_dosen;
        $builder->orderBy('id_akun', 'DESC');
        $query = $builder->get()->getResult();

        return $query;
    }
}