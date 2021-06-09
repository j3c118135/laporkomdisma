<?php namespace App\Models;

use CodeIgniter\Model;

class PenundaanSkorsModel extends Model{
    protected $table      = 'penundaan_skorsing';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'id_pelanggaran', 'tgl_pengajuan', 'inspektur', 'status', 'keterangan', 'komentar'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tb_penundaan = $this->db->table('penundaan_skorsing');
    }
        
    public function getAll(){
        $this->db->query("SET @@lc_time_names = 'id_ID'");
        $builder = $this->tb_penundaan;
        $builder->select('penundaan_skorsing.id, id_pelanggaran, DATE_FORMAT(tgl_pengajuan, "%d/%m/%Y") as tgl_pengajuan, DATE_FORMAT(tgl_pengajuan, "%Y-%m-%d") as tanggal, penundaan_skorsing.inspektur, penundaan_skorsing.keterangan, mahasiswa.nim, mahasiswa.nama, prodi, status, penundaan_skorsing.komentar');
        $builder->join('pelanggaran_mahasiswa', 'pelanggaran_mahasiswa.id = penundaan_skorsing.id_pelanggaran');
        $builder->join('mahasiswa', 'pelanggaran_mahasiswa.nim = mahasiswa.nim');
        $builder->orderBy('tgl_pengajuan', 'DESC');
        $query = $builder->get()->getResult();

        $komdisma = new \App\Models\KomdismaModel();  
        foreach ($query as $row) :
            if(!empty($row->inspektur)){
                $row->nama_inspektur = $komdisma->getWhere($row->inspektur)->nama;
            }
        endforeach;

        return $query;
    }

    public function cekPenundaan($id_pelanggaran){
        $builder = $this->tb_penundaan;
        $builder->select("status,komentar,tgl_pengajuan");
        $builder->where('id_pelanggaran', $id_pelanggaran);
        $builder->limit(1);
        $builder->orderBy('id','DESC');
        $query = $builder->get()->getRow();
        return $query;
    }

    public function verifikasi($id, $data){
        return $this->tb_penundaan->update($data, ['id' => $id]);
     }

    public function countPengajuan(){
        $where = array('komentar =' => NULL, 'status =' => 0);
        $builder = $this->tb_penundaan;
        $builder->selectCount('id');
        $builder->where($where);
        $query = $builder->get()->getRow()->id;

        return $query;
    }
}