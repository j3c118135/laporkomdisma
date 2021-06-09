<?php namespace App\Models;

use CodeIgniter\Model;

class JPelanggaranModel extends Model{
    protected $table      = 'jenis_pelanggaran';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','id_kategori','nama', 'foto'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tb_jpelanggaran = $this->db->table('jenis_pelanggaran');
    }

    public function getAll(){
        $builder = $this->tb_jpelanggaran;
        $query = $builder->get()->getResult();

        return $query;
    }

    public function getAllJenis(){
        $builder = $this->tb_jpelanggaran;
        $builder->select('jenis_pelanggaran.id as id_jenis, jenis_pelanggaran.nama as nama_jenis, kategori_pelanggaran.nama as nama_kategori, id_kategori');
        $builder->join('kategori_pelanggaran', 'kategori_pelanggaran.id=jenis_pelanggaran.id_kategori');
        $builder->orderBy('jenis_pelanggaran.id', 'DESC');
        $query = $builder->get()->getResult();

        return $query;
    }

    public function getJenisPelanggaran($id_kategori){
        $builder = $this->tb_jpelanggaran;
        $builder->where('id_kategori', $id_kategori);
        $query = $builder->get()->getResult();

        return $query;
    }

    public function getWhere($id_kategori){
        $builder = $this->tb_jpelanggaran;
        $builder->where('id_kategori', $id_kategori);
        $query = $builder->get()->getResult();

        return $query;
    }

    public function edit($id, $data){
        return $this->tb_jpelanggaran->update($data, ['id' => $id]);
    }

    public function getName($id_jenis){
        $builder = $this->tb_jpelanggaran;
        $builder->select('jenis_pelanggaran.nama as nama_jenis, kategori_pelanggaran.nama as nama_kategori');
        $builder->join('kategori_pelanggaran', 'kategori_pelanggaran.id=jenis_pelanggaran.id_kategori');
        $builder->where('jenis_pelanggaran.id', $id_jenis);
        $query = $builder->get()->getRow();

        return $query;

    }

    public function cekJpelanggaran($nama){
        $builder = $this->tb_jpelanggaran;
        $builder->where('nama', $nama);
        $query = $builder->get()->getRow();

        return $query;
    }

}
