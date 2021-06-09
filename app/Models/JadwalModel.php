<?php namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model{
    protected $table      = 'jadwal_matkul';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id','id_pelanggaran', 'tanggal', 'matkul', 'jam_mulai', 'jam_selesai','dosen', 'koordinator'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tb_jadwal= $this->db->table('jadwal_matkul');
    }

    
    public function getJadwal($id){
        $this->db->query("SET @@lc_time_names = 'id_ID'");
        $builder = $this->tb_jadwal;
        $builder->select("id,DATE_FORMAT(tanggal, '%d-%m-%Y') as tanggal_matkul, tanggal, DAYNAME(tanggal) as hari, jam_mulai, jam_selesai, dosen, koordinator,matkul, id_pelanggaran");
        $builder->orderBy('tanggal', 'ASC');
        $builder->where('id_pelanggaran', $id);
        $query = $builder->get()->getResult();

        $auth = new \IonAuth\Libraries\IonAuth();  
        foreach ($query as $row) :
            $row->nama_dosen = $auth->getWhere($row->dosen)->nama;
            $row->nama_koor = $auth->getWhere($row->koordinator)->nama;
        endforeach;

        return $query;
    }

    public function edit($id, $data){
        return $this->tb_jadwal->update($data, ['id' => $id]);
    }

    public function cekJadwal($id_pelanggaran){
        $builder = $this->tb_jadwal;
        $builder->where('id_pelanggaran', $id_pelanggaran);
        $query = $builder->get()->getResult();

        return $query;
    }

    public function simpan($data,$id){
        if(!empty($this->cekJadwal($id))){
            $where = ['id_pelanggaran' => $id];
            $delete = $this->tb_jadwal->delete($where);
            if($delete){
                return $this->tb_jadwal->insertBatch($data);
            }
        } else {
            return $this->tb_jadwal->insertBatch($data);
        }
    }

}