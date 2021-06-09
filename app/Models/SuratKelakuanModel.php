<?php namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class SuratKelakuanModel extends Model{
    protected $table      = 'surat_kelakuan_baik';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'nim', 'tgl_pengajuan','keperluan', 'inspektur', 'tgl_berakhir','status', 'komentar'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tb_surat = $this->db->table('surat_kelakuan_baik');
    }
        
    public function getAll(){
        $builder = $this->tb_surat;
        $builder->select('surat_kelakuan_baik.id, mahasiswa.nim, nama, prodi, DATE_FORMAT(tgl_pengajuan, "%d/%m/%Y") as tgl_pengajuan, inspektur, keperluan, DATE_FORMAT(tgl_berakhir, "%d/%m/%Y") as tgl_berakhir, status, surat_kelakuan_baik.komentar');
        $builder->join('mahasiswa', 'surat_kelakuan_baik.nim = mahasiswa.nim');
        $builder->orderBy('surat_kelakuan_baik.tgl_pengajuan', 'DESC');
        $query = $builder->get()->getResult();

        $komdisma = new \App\Models\KomdismaModel();  
        foreach ($query as $row) :
            if(!empty($row->inspektur)){
                $row->nama_inspektur = $komdisma->getWhere($row->inspektur)->nama;
            }
        endforeach;

        return $query;
    }

    public function pengajuanTerakhir($nim){
        $date = Time::now('Asia/Jakarta')->toDateString();
        $builder = $this->tb_surat;
        $builder->select('tgl_pengajuan, tgl_berakhir, status, keperluan, komentar');
        $builder->where('nim', $nim);
        $builder->limit(1);
        $builder->orderBy('id','DESC');
        $query = $builder->get()->getRow();

        if(!empty($query->tgl_pengajuan)){
            if($query->status == 0){
                if(!empty($query->komentar)){
                    $data=[
                        'result' => TRUE,
                        'status' => $query->status,
                        'keperluan' => $query->keperluan,
                        'tgl_berakhir' => $query->tgl_berakhir,
                        'tgl_pengajuan' => $query->tgl_pengajuan,
                        'komentar' => $query->komentar,
                    ];
                } else {
                    $data=[
                        'result' => FALSE,
                        'status' => $query->status,
                        'keperluan' => $query->keperluan,
                        'tgl_berakhir' => $query->tgl_berakhir,
                        'tgl_pengajuan' => $query->tgl_pengajuan,
                        'komentar' => $query->komentar,
                    ];
                }
                
            } elseif($query->status == 1){
                if ($date > $query->tgl_berakhir){
                    $data=[
                        'result' => TRUE,
                        'status' => $query->status,
                        'keperluan' => $query->keperluan,
                        'tgl_berakhir' => $query->tgl_berakhir,
                        'tgl_pengajuan' => $query->tgl_pengajuan,
                        'komentar' => $query->komentar,
                    ];
                }else{
                    $data=[
                        'result' => FALSE,
                        'status' => $query->status,
                        'keperluan' => $query->keperluan,
                        'tgl_berakhir' => $query->tgl_berakhir,
                        'tgl_pengajuan' => $query->tgl_pengajuan,
                        'komentar' => $query->komentar,
                    ];
                }
            }
        } else {
            $data=[
                'result' => TRUE,
                'status' => 1,
                'keperluan' => NULL,
                'tgl_berakhir' => NULL,
                'tgl_pengajuan' => NULL,
                'komentar' => NULL,
            ];
        }

        return $data;
    }

    public function verifikasi($id, $data){
        return $this->tb_surat->update($data, ['id' => $id]);
     }

    public function countPengajuan(){
        $where = array('komentar =' => NULL, 'status =' => 0);
        $builder = $this->tb_surat;
        $builder->selectCount('id');
        $builder->where($where);
        $query = $builder->get()->getRow()->id;

        return $query;
    }

}