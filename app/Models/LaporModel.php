<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class LaporModel extends Model{
    protected $table      = 'lapor_pelanggaran';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'id_pelanggaran', 'tanggal','id_penerima_lapor', 'keterangan', 'status'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tb_lapor = $this->db->table('lapor_pelanggaran');
    }

    public function getLapor($id){
        $dosen = new \IonAuth\Libraries\IonAuth();  
        $builder = $this->tb_lapor;
        $builder -> select('lapor_pelanggaran.id as id_lapor, DATE_FORMAT(tanggal, "%d/%m/%Y") as tanggal, status, keterangan, id_penerima_lapor');
        $builder->where('id_pelanggaran', $id);
        $query = $builder->get()->getResult();

        foreach ($query as $row) :
            $row->nama_penerima_lapor = $dosen->getWhere($row->id_penerima_lapor)->nama;
        endforeach;

        return $query;
    }

    public function getLaporMahasiswa(){
        $auth = new \IonAuth\Libraries\IonAuth(); 
        $id_dosen = $auth->user()->row()->id;
        $where = array('id_penerima_lapor =' => $id_dosen, 'status =' => 0);
        $builder = $this->tb_lapor;
        $builder -> select('lapor_pelanggaran.id as id_lapor, DATE_FORMAT(lapor_pelanggaran.tanggal, "%d/%m/%Y") as tgl_lapor, lapor_pelanggaran.keterangan as keterangan_lapor, prodi, mahasiswa.nama as nama_mahasiswa, pelanggaran_mahasiswa.keterangan as pelanggaran');
        $builder->join('pelanggaran_mahasiswa', 'pelanggaran_mahasiswa.id = lapor_pelanggaran.id_pelanggaran');
        $builder->join('mahasiswa', 'mahasiswa.nim = pelanggaran_mahasiswa.nim');
        $builder->where($where);
        $query = $builder->get()->getResult();

        return $query;
    }

    public function countLapor(){
        $auth = new \IonAuth\Libraries\IonAuth(); 
        $id_dosen = $auth->user()->row()->id;
        $where = array('id_penerima_lapor =' => $id_dosen, 'status =' => 0);
        $builder = $this->tb_lapor;
        $builder->selectCount('id');
        $builder->where($where);
        $query = $builder->get()->getRow()->id;

        return $query;
    }


    public function canLapor($id){
        $where = array('id_pelanggaran =' => $id, 'status =' => 1);
        $builder = $this->tb_lapor;
        $builder ->select('count(id) as jum_lapor');
        $builder->where($where);
        $lapor = $builder->get()->getRow();
        $jum_lapor = $lapor->jum_lapor;

        $builder2 = $this->tb_lapor;
        $builder2 ->select('max(tanggal) as tgl_terakhir');
        $builder2->where('id_pelanggaran', $id);
        $lapor2 = $builder2->get()->getRow();
        $tgl_terakhir = $lapor2->tgl_terakhir;

       $query = $this->db->table('pelanggaran_mahasiswa');
       $query->select('tgl_verifikasi, tgl_surat_bebas, lapor, skorsing, drop_out');
       $query->join('sanksi', 'sanksi.id = pelanggaran_mahasiswa.id_sanksi', 'left');
       $query->where('pelanggaran_mahasiswa.id',$id);
       $pelanggaran= $query->get()->getRow();

       $sql = $this->db->table('jadwal_matkul');
       $sql->select('count(distinct tanggal) as jum_hari_matkul');
       $sql->where('id_pelanggaran', $id);
       $jadwal = $sql->get()->getRow()->jum_hari_matkul;
       $tanggal =(Time::now('Asia/Jakarta')->toDateString());
       $didTanggalNow = ($tanggal == $tgl_terakhir);
       $didTanggalVerifikasi = (($pelanggaran->tgl_verifikasi) == $tanggal);
       $nameOfDay = date('l', strtotime($tanggal));

        if(empty($pelanggaran)){
            $data = [
                'hasil' => FALSE,
                'keterangan' => 'Pelanggaran tidak ada',
            ];
        } else {
            if ((!empty($pelanggaran->tgl_verifikasi)) AND (empty($pelanggaran->tgl_surat_bebas))){
                    if ((!empty($pelanggaran->skorsing)) AND (!empty($pelanggaran->lapor))){
                        if(($jadwal == $pelanggaran->skorsing) AND ($jum_lapor < ($pelanggaran->lapor)) AND ($didTanggalNow == FALSE) AND ($didTanggalVerifikasi == FALSE) AND ($nameOfDay != "Sunday" ) AND ($nameOfDay != "Saturday")){
                            $data = [
                                'hasil' => TRUE,
                                'keterangan' => '',
                            ];
                        } elseif (($jadwal == $pelanggaran->skorsing) AND ($jum_lapor == ($pelanggaran->lapor))){
                            $data = [
                                'hasil' => FALSE,
                                'keterangan' => 'Lapor lengkap',
                            ];
                        } elseif(($didTanggalNow == TRUE)){
                            $data = [
                                'hasil' => FALSE,
                                'keterangan' => 'Hari ini sudah lapor',
                            ];
                        }  elseif(($jadwal < $pelanggaran->skorsing)){
                            $data = [
                                'hasil' => FALSE,
                                'keterangan' => 'Jadwal belum lengkap',
                            ];
                        } elseif(($jadwal == $pelanggaran->skorsing) AND ($didTanggalVerifikasi == TRUE)){
                            $data = [
                                'hasil' => FALSE,
                                'keterangan' => 'Lapor dapat dimulai besok',
                            ];
                        } else{
                            $data = [
                                'hasil' => FALSE,
                                'keterangan' => 'Hari libur',
                            ];
                        }
                    } elseif ((empty($pelanggaran->skorsing)) AND (!empty($pelanggaran->lapor))){
                        if (($jum_lapor < $pelanggaran->lapor) AND ($didTanggalNow == FALSE) AND ($didTanggalVerifikasi == FALSE) AND ($nameOfDay != "Sunday" ) AND ($nameOfDay != "Saturday")){
                            $data = [
                                'hasil' => TRUE,
                                'keterangan' => '',
                            ];
                        } elseif(($didTanggalNow == TRUE)){
                            $data = [
                                'hasil' => FALSE,
                                'keterangan' => 'Hari ini sudah lapor',
                            ];
                        } elseif ($jum_lapor == ($pelanggaran->lapor)){
                            $data = [
                                'hasil' => FALSE,
                                'keterangan' => 'Lapor lengkap',
                            ];
                        } elseif(($jadwal == $pelanggaran->skorsing) AND ($didTanggalVerifikasi == TRUE)){
                            $data = [
                                'hasil' => FALSE,
                                'keterangan' => 'Lapor dapat dimulai besok',
                            ];
                        } else{
                            $data = [
                                'hasil' => FALSE,
                                'keterangan' => 'Hari libur',
                            ];
                        }
                    } else {
                        $data = [
                            'hasil' => FALSE,
                            'keterangan' => 'Tidak ada lapor',
                        ];
                    }
            } elseif (empty($pelanggaran->tgl_verifikasi)) {
                $data = [
                        'hasil' => FALSE,
                        'keterangan' => 'Belum diverifikasi',
                    ];
            } elseif (!empty($pelanggaran->tgl_surat_bebas)) {
                $data = [
                        'hasil' => FALSE,
                        'keterangan' => 'Lapor lengkap',
                    ];
            }
        }

        return $data;

        }

    public function terimaLapor($id, $data){
       return $this->tb_lapor->update($data, ['id' => $id]);
    }

    public function lastLapor($id){
        $builder=$this->tb_lapor;
        $builder->select('(max(tanggal)) as tanggal');
        $builder->where('id_pelanggaran', $id);
        $query = $builder->get()->getRow();

        if(!empty($query)){
            return $query->tanggal;
        } else {
            return NULL ;
        }

    }
}