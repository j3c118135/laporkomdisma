<?php namespace App\Models;

use CodeIgniter\Model;

class AkademikModel extends Model{
    protected $table      = 'akademik';
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
        $this->tb_akademik = $this->db->table('akademik');
    }
        
    public function getAll(){
        $builder = $this->tb_akademik;
        $builder->orderBy('id_akun', 'DESC');
        $query = $builder->get()->getResult();

        return $query;
    }
}