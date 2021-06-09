<?php namespace App\Models;

use CodeIgniter\Model;

class KPelanggaranModel extends Model{
    protected $table      = 'kategori_pelanggaran';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','nama'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tb_kpelanggaran = $this->db->table('kategori_pelanggaran');
    }

    public function getAll(){
        $builder = $this->tb_kpelanggaran;
        $query = $builder->get()->getResult();

        return $query;
    }
}
