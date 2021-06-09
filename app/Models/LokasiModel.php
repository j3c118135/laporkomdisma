<?php namespace App\Models;

use CodeIgniter\Model;

class LokasiModel extends Model{
    protected $table      = 'lokasi';
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
        $this->tb_lokasi = $this->db->table('lokasi');
    }

    public function getAll(){
        $builder = $this->tb_lokasi;
        $builder->orderBy('id', 'DESC');
        $query = $builder->get()->getResult();

        return $query;
    }

    public function edit($id, $data){
        return $this->tb_lokasi->update($data, ['id' => $id]);
    }

    public function getName($id){
        $builder = $this->tb_lokasi;
        $builder->where('id', $id);
        $query = $builder->get()->getRow();

        return $query;
    }

    public function cekLokasi($nama){
        $builder = $this->tb_lokasi;
        $builder->where('nama', $nama);
        $query = $builder->get()->getRow();

        return $query;
    }
}
