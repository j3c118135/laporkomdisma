<?php namespace App\Models;

use CodeIgniter\Model;

class SanksiModel extends Model{
    protected $table      = 'sanksi';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','nama', 'lapor', 'skorsing', 'drop_out'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tb_sanksi = $this->db->table('sanksi');
    }

    public function getAll(){
        $builder = $this->tb_sanksi;
        $query = $builder->get()->getResult();

        return $query;
    }

    public function getSanksi($id){
        $builder = $this->tb_sanksi;
        $builder->where('id', $id);
        $query = $builder->get()->getRow();

        return $query;
    }

    public function getSkorsing($id){
        $builder= $this->db->table('pelanggaran_mahasiswa');
        $builder->select('skorsing');
        $builder->join('sanksi', 'sanksi.id = pelanggaran_mahasiswa.id_sanksi', 'LEFT');
        $builder->where('pelanggaran_mahasiswa.id', $id);
        $query = $builder->get()->getRow()->skorsing;

        return $query;
    }

    public function cekSanksi($nama){
        $builder = $this->tb_sanksi;
        $builder->where('nama', $nama);
        $query = $builder->get()->getRow();

        return $query;
    }
}
