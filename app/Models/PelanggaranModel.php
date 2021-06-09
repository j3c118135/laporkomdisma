<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class PelanggaranModel extends Model{
    protected $table      = 'pelanggaran_mahasiswa';
    protected $primaryKey = 'id';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id', 'nim' ,'tingkat', 'tanggal', 'jam', 'id_lokasi', 'jenis_pelanggaran', 'keterangan', 'id_pelapor', 'bukti_foto', 'inspektur', 'tgl_verifikasi', 'id_sanksi', 'tgl_surat_bebas'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tb_pelanggaran = $this->db->table('pelanggaran_mahasiswa');
        $this->tb_lapor = $this->db->table('lapor_pelanggaran');
    }

    public function getStatusLapor($id){

        
        $sql = $this->db->table('lapor_pelanggaran');
        $sql->where('id_pelanggaran', $id);
        $sql->orderBy('tanggal', 'DESC');
        $result = $sql->get()->getRow();

        $builder= $this->tb_pelanggaran;
        $builder->select("max(lapor_pelanggaran.tanggal) as tgl_lapor,
        CASE
            WHEN sanksi.lapor IS NULL THEN 'Tidak Ada Lapor' 
            WHEN lapor_pelanggaran.id_pelanggaran IS NULL AND sanksi.lapor IS NOT NULL THEN 'Belum Lapor' 
            WHEN (count(lapor_pelanggaran.tanggal) < sanksi.lapor AND tgl_surat_bebas IS NULL) THEN 'Proses'
            WHEN (count(lapor_pelanggaran.tanggal) = sanksi.lapor OR tgl_surat_bebas IS NOT NULL) THEN 'Selesai'
            WHEN tgl_surat_bebas IS NOT NULL THEN 'Selesai' 
        END AS status", FALSE);
        $builder->join('sanksi', 'sanksi.id = pelanggaran_mahasiswa.id_sanksi');
        $builder->join('lapor_pelanggaran', 'lapor_pelanggaran.id_pelanggaran = pelanggaran_mahasiswa.id');
        $builder->where('pelanggaran_mahasiswa.id', $id);
        $query = $builder->get()->getRow();

        if (!empty($result)){
            if($result->status == 0){
                $query->status = "Lapor belum diterima";
            }
        }
        
        return $query;
    }


    public function getStatusSkors($id){
        $builder= $this->tb_pelanggaran;
        $builder->select("max(jadwal_matkul.tanggal) as tgl_skors, pelanggaran_mahasiswa.id, sanksi.skorsing, tgl_surat_bebas,
        CASE
            WHEN sanksi.skorsing IS NULL THEN 'Tidak Ada Skors' 
            WHEN jadwal_matkul.id_pelanggaran IS NULL AND sanksi.skorsing IS NOT NULL AND tgl_surat_bebas IS NULL THEN 'Belum mengisi jadwal'  
            WHEN (sanksi.skorsing = count(distinct jadwal_matkul.tanggal)  AND min(jadwal_matkul.tanggal) > CURRENT_DATE) AND tgl_surat_bebas IS NULL THEN 'Skorsing belum dimulai' 
            WHEN (sanksi.skorsing = count(distinct jadwal_matkul.tanggal)  AND max(jadwal_matkul.tanggal) < CURRENT_DATE) AND tgl_surat_bebas IS NULL THEN 'Selesai' 
            WHEN tgl_surat_bebas IS NOT NULL THEN  'Selesai' 
        END AS status", FALSE);
        $builder->join('sanksi', 'sanksi.id = pelanggaran_mahasiswa.id_sanksi');
        $builder->join('jadwal_matkul', 'jadwal_matkul.id_pelanggaran = pelanggaran_mahasiswa.id');
        $builder->where('pelanggaran_mahasiswa.id', $id);
        $query = $builder->get()->getRow();

        $date = Time::now('Asia/Jakarta')->toDateString();
        $sql = $this->db->table('jadwal_matkul');
        $sql->select("tanggal");
        $sql->where('id_pelanggaran', $id);
        $array = $sql->get()->getResultArray();

        if ($query->status == NULL){
            if(in_array(['tanggal' => $date],$array)){
                $query->status = 'Sedang diskors';
            } else {
                $query->status = 'Skorsing belum dimulai';
            }
        }        
        return $query;
    }

    public function getStatusPelanggaran($id){
        $builder = $this->tb_pelanggaran;
        $builder->select('tgl_verifikasi, tgl_surat_bebas, sanksi.drop_out as do');
        $builder->join('sanksi', 'sanksi.id = pelanggaran_mahasiswa.id_sanksi');
        $builder->where('pelanggaran_mahasiswa.id', $id);
        $query = $builder->get()->getRow();

         $lapor = $this->getStatusLapor($id)->status;
         $skors = $this->getStatusSkors($id)->status;

        if ((empty($query->tgl_verifikasi)) AND (empty($query->tgl_surat_bebas))){
            $status = 'Menunggu';
        } elseif ((!empty($query->tgl_verifikasi)) AND (empty($query->tgl_surat_bebas))){
           if(($lapor == "Tidak Ada Lapor") AND ($skors == "Tidak Ada Skors") AND ($query->do == 1)){
                $status = 'Drop Out';
           }elseif (($skors == "Sedang diskors") OR ($skors == "Belum mengisi jadwal")){
                $status = $skors;
           } elseif ((($lapor == "Selesai") AND ($skors == "Tidak Ada Skors")) OR (($lapor == "Selesai") AND ($skors == "Selesai"))){
                $status = 'Selesai';
           } elseif(($lapor == "Tidak Ada Lapor") AND ($skors == "Tidak Ada Skors") AND ($query->do == 0)){
                $status = 'Selesai';
           } else {
               $status = 'Proses';
           }
        } elseif ((!empty($query->tgl_verifikasi)) AND (!empty($query->tgl_surat_bebas))){
            $status = 'Selesai';
        } 
            $data= [
                'status' => $status,
                'tgl_lapor' => $this->getStatusLapor($id)->tgl_lapor,
                'tgl_skors' => $this->getStatusSkors($id)->tgl_skors,
            ];
        return $data;
    }

    public function cekStatusMahasiswa($nim){
        $builder = $this->tb_pelanggaran;
        $builder->select('id');
        $builder->where('nim', $nim);
        $query=$builder->get()->getResult();

        $result = array();
        if(!empty($query)){
            foreach ($query as $row) :
                if(($this->getStatusPelanggaran($row->id)['status']) != 'Selesai'){
                    $result[] = 0 ;
                } else {
                    $result[] = 1;
                }
                
            endforeach;
        } else {
            $result[] = 1;
        }

        return $result;
    }
    
    public function getAll(){
        $builder = $this->tb_pelanggaran;
        $builder->select("kategori_pelanggaran.nama as nama_kategori, jenis_pelanggaran.nama as nama_jenis, lokasi.nama as nama_lokasi, DATE_FORMAT(tanggal, '%d/%m/%Y') as tanggal, pelanggaran_mahasiswa.id as id_pelanggaran, keterangan, bukti_foto, mahasiswa.nama as nama_mahasiswa, pelanggaran_mahasiswa.nim as nim_mahasiswa, prodi, jam, id_pelapor, tingkat, sanksi.nama as nama_sanksi, tgl_surat_bebas");
        $builder->join('mahasiswa', 'mahasiswa.nim = pelanggaran_mahasiswa.nim');
        $builder->join('lokasi', 'lokasi.id = pelanggaran_mahasiswa.id_lokasi');
        $builder->join('jenis_pelanggaran', 'jenis_pelanggaran.id = pelanggaran_mahasiswa.jenis_pelanggaran');
        $builder->join('kategori_pelanggaran', 'kategori_pelanggaran.id = jenis_pelanggaran.id_kategori');
        $builder->join('sanksi', 'sanksi.id = pelanggaran_mahasiswa.id_sanksi', 'left');
        $builder->orderBy('pelanggaran_mahasiswa.id', 'DESC');
        $query = $builder->get()->getResult();

        foreach ($query as $row) :
            $row->status = $this->getStatusPelanggaran($row->id_pelanggaran)['status'];
        endforeach;

        return $query;
    }

    public function getWhere($nim){
        $builder = $this->tb_pelanggaran;
        $builder->select("kategori_pelanggaran.nama as nama_kategori, jenis_pelanggaran.nama as nama_jenis, lokasi.nama as nama_lokasi, DATE_FORMAT(tanggal, '%d/%m/%Y') as tanggal, pelanggaran_mahasiswa.id as id_pelanggaran, keterangan, bukti_foto, jam");
        $builder->join('lokasi', 'lokasi.id = pelanggaran_mahasiswa.id_lokasi');
        $builder->join('jenis_pelanggaran', 'jenis_pelanggaran.id = pelanggaran_mahasiswa.jenis_pelanggaran');
        $builder->join('kategori_pelanggaran', 'kategori_pelanggaran.id = jenis_pelanggaran.id_kategori');
        $builder->where('nim', $nim);
        $builder->orderBy('id_pelanggaran', 'DESC');
        $query = $builder->get()->getResult();

        foreach ($query as $row) :
            $row->status = $this->getStatusPelanggaran($row->id_pelanggaran)['status'];
        endforeach;
        

        return $query;
    }

    public function getPelanggaranMahasiswa($nim, $id = null){
        $where = array('nim =' => $nim, 'pelanggaran_mahasiswa.id !=' => $id);
        $builder = $this->tb_pelanggaran;
        $builder->select("kategori_pelanggaran.nama as nama_kategori, jenis_pelanggaran.nama as nama_jenis, lokasi.nama as nama_lokasi, DATE_FORMAT(tanggal, '%d/%m/%Y') as tanggal, pelanggaran_mahasiswa.id as id_pelanggaran, keterangan, bukti_foto, jam, id_sanksi, sanksi.nama as nama_sanksi");
        $builder->join('lokasi', 'lokasi.id = pelanggaran_mahasiswa.id_lokasi');
        $builder->join('jenis_pelanggaran', 'jenis_pelanggaran.id = pelanggaran_mahasiswa.jenis_pelanggaran');
        $builder->join('kategori_pelanggaran', 'kategori_pelanggaran.id = jenis_pelanggaran.id_kategori');
        $builder->join('sanksi', 'sanksi.id = pelanggaran_mahasiswa.id_sanksi', 'left');
        $builder->where($where);
        $builder->orderBy('id_pelanggaran', 'DESC');
        $query = $builder->get()->getResult();

        foreach ($query as $row) :
            $row->status = $this->getStatusPelanggaran($row->id_pelanggaran)['status'];
        endforeach;
        
        return $query;
    }

    public function verifikasi($id, $data){
       return $this->tb_pelanggaran->update($data, ['id' => $id]);
    }


    public function getPelanggaranVerifikasi(){
        $builder = $this->tb_pelanggaran;
        $builder->select('mahasiswa.nama as nama_mahasiswa, prodi, kategori_pelanggaran.nama as nama_kategori, jenis_pelanggaran.nama as nama_jenis, lokasi.nama as nama_lokasi, DATE_FORMAT(tanggal, "%d/%m/%Y") as tanggal, pelanggaran_mahasiswa.id as id_pelanggaran');
        $builder->join('mahasiswa', 'mahasiswa.nim = pelanggaran_mahasiswa.nim');
        $builder->join('lokasi', 'lokasi.id = pelanggaran_mahasiswa.id_lokasi');
        $builder->join('jenis_pelanggaran', 'jenis_pelanggaran.id = pelanggaran_mahasiswa.jenis_pelanggaran');
        $builder->join('kategori_pelanggaran', 'kategori_pelanggaran.id = jenis_pelanggaran.id_kategori');
        $builder->where('tgl_verifikasi', NULL);
        $builder->orderBy('id_pelanggaran', 'ASC');
        $query = $builder->get()->getResult();

        return $query;
    }

    public function countVerifikasi(){
        $builder = $this->tb_pelanggaran;
        $builder->select('count(id) as jumlah');
        $builder->where('tgl_verifikasi', NULL);
        $query = $builder->get()->getRow()->jumlah;

        return $query;

    }

    
    public function getDetail($id){
        $builder = $this->tb_pelanggaran;
        $builder->select("kategori_pelanggaran.nama as nama_kategori, jenis_pelanggaran.nama as nama_jenis, lokasi.nama as nama_lokasi, tanggal, pelanggaran_mahasiswa.id as id_pelanggaran, keterangan, bukti_foto, mahasiswa.nama as nama_mahasiswa, pelanggaran_mahasiswa.nim as nim_mahasiswa, prodi, jam, id_pelapor, tingkat, foto, id_sanksi, inspektur, sanksi.nama as nama_sanksi, lapor, drop_out, skorsing, tgl_surat_bebas");
        $builder->join('mahasiswa', 'mahasiswa.nim = pelanggaran_mahasiswa.nim');
        $builder->join('lokasi', 'lokasi.id = pelanggaran_mahasiswa.id_lokasi');
        $builder->join('jenis_pelanggaran', 'jenis_pelanggaran.id = pelanggaran_mahasiswa.jenis_pelanggaran');
        $builder->join('kategori_pelanggaran', 'kategori_pelanggaran.id = jenis_pelanggaran.id_kategori');
        $builder->join('sanksi', 'sanksi.id = pelanggaran_mahasiswa.id_sanksi', 'left');
        $builder->where('pelanggaran_mahasiswa.id', $id);
        $query = $builder->get()->getRow();

        $query->status = $this->getStatusPelanggaran($query->id_pelanggaran)['status'];

        return $query;
    }

    public function getAllSkorsing(){
        $where = array('sanksi.skorsing !=' => NULL);
        $builder = $this->tb_pelanggaran;
        $builder->select("pelanggaran_mahasiswa.id as pelanggaran_id, mahasiswa.nim as nim_mahasiswa, mahasiswa.nama as nama_mahasiswa, prodi, pelanggaran_mahasiswa.tanggal as tanggal_pelanggaran, sanksi.skorsing as jum_hari, min(jadwal_matkul.tanggal) as tgl_mulai, DATE_FORMAT(max(jadwal_matkul.tanggal), '%d/%m/%Y') as tgl_berakhir");
        $builder->join('mahasiswa', 'mahasiswa.nim = pelanggaran_mahasiswa.nim');
        $builder->join('sanksi', 'sanksi.id = pelanggaran_mahasiswa.id_sanksi','left');
        $builder->join('jadwal_matkul', 'jadwal_matkul.id_pelanggaran = pelanggaran_mahasiswa.id', 'left');
        $builder->where($where);
        $builder->groupBy('pelanggaran_mahasiswa.id');
        $builder->orderBy('pelanggaran_mahasiswa.id', 'DESC');
        $query = $builder->get()->getResult();

        foreach ($query as $row) :
            $row->status = $this->getStatusSkors($row->pelanggaran_id)->status;
        endforeach;

        return $query;
       
    }

    public function getWhereSkorsing($nim){
        $where = array('sanksi.skorsing !=' => NULL, 'pelanggaran_mahasiswa.nim =' => $nim);
        $builder = $this->tb_pelanggaran;
        $builder->select("pelanggaran_mahasiswa.id as pelanggaran_id, mahasiswa.nim as nim_mahasiswa, mahasiswa.nama as nama_mahasiswa, prodi, pelanggaran_mahasiswa.tanggal as tanggal_pelanggaran, sanksi.skorsing as jum_hari, min(jadwal_matkul.tanggal) as tgl_mulai, DATE_FORMAT(max(jadwal_matkul.tanggal), '%d/%m/%Y') as tgl_berakhir");
        $builder->join('mahasiswa', 'mahasiswa.nim = pelanggaran_mahasiswa.nim');
        $builder->join('sanksi', 'sanksi.id = pelanggaran_mahasiswa.id_sanksi','left');
        $builder->join('jadwal_matkul', 'jadwal_matkul.id_pelanggaran = pelanggaran_mahasiswa.id', 'left');
        $builder->where($where);
        $builder->groupBy('pelanggaran_mahasiswa.id');
        $builder->orderBy('pelanggaran_mahasiswa.id', 'DESC');
        $query = $builder->get()->getResult();

        foreach ($query as $row) :
            $row->status = $this->getStatusSkors($row->pelanggaran_id)->status;
        endforeach;

        return $query;
       
    }

    public function getSkorsingMahasiswa($id){
        $this->db->query("SET @@lc_time_names = 'id_ID'");
        $builder = $this->tb_pelanggaran;
        $builder->select("sanksi.skorsing as jum_hari, DATE_FORMAT(jadwal_matkul.tanggal, '%d/%m/%Y') as tanggal_matkul, DAYNAME(jadwal_matkul.tanggal) as hari,mahasiswa.nama as nama_mahasiswa, mahasiswa.nim as nim_mahasiswa, foto, prodi, pelanggaran_mahasiswa.id as pelanggaran_id, pelanggaran_mahasiswa.tanggal as tanggal_pelanggaran, jam_mulai, jam_selesai, dosen, koordinator,matkul");
        $builder->join('mahasiswa', 'mahasiswa.nim = pelanggaran_mahasiswa.nim');
        $builder->join('sanksi', 'sanksi.id = pelanggaran_mahasiswa.id_sanksi', 'right');
        $builder->join('jadwal_matkul', 'jadwal_matkul.id_pelanggaran = pelanggaran_mahasiswa.id', 'right');
        $builder->orderBy('jadwal_matkul.tanggal', 'ASC');
        $builder->groupBy('jadwal_matkul.matkul');
        $builder->where('pelanggaran_mahasiswa.id', $id);
        $query = $builder->get()->getResult();

        $auth = new \IonAuth\Libraries\IonAuth();  
        foreach ($query as $row) :
            $row->nama_dosen = $auth->getWhere($row->dosen)->nama;
            $row->nama_koor = $auth->getWhere($row->koordinator)->nama;
            $row->status = $this->getStatusSkors($row->pelanggaran_id)->status;
        endforeach;
        $data = [
            'mahasiswa' => $query[0],
            'skorsing' => $query,
        ];

        return $data;
    }

    public function cekLapor($nim){
        $where = array('nim =' => $nim, 'sanksi.lapor !=' => NULL);
        $builder = $this->tb_pelanggaran;
        $builder->select('lapor, pelanggaran_mahasiswa.id as id_pelanggaran');
        $builder->join('sanksi', 'sanksi.id=pelanggaran_mahasiswa.id_sanksi');
        $builder->where($where);
        $query= $builder->get()->getResult();
        $date = Time::now('Asia/Jakarta')->toDateString();
        $nameOfDay = date('l', strtotime($date));
        $result = array();
        foreach ($query as $row):
            if(($this->getStatusLapor($row->id_pelanggaran)->status) != "Selesai"){
                $lapor = new \App\Models\LaporModel();
                if (($lapor->canLapor($row->id_pelanggaran)['hasil']) == TRUE){
                    if (($nameOfDay != "Sunday" ) AND ($nameOfDay != "Saturday")){
                        $result[] = TRUE;
                    } else{
                        $result[] = FALSE;
                    }
                } else{
                    $result[] = FALSE;
                }
                
            } 
        endforeach;

        return $result;
    }

    public function loloskan($id){
        $data=[
            'tgl_surat_bebas' => Time::now('Asia/Jakarta')->toDateString(),
        ];
        return $this->tb_pelanggaran->update($data, ['id' => $id]);
    }

    public function rekapan(){
        $auth = new \IonAuth\Libraries\IonAuth(); 
        $komdisma = new \App\Models\KomdismaModel(); 

        $builder= $this->tb_pelanggaran;
        $builder->select('pelanggaran_mahasiswa.id as id_pelanggaran, DATE_FORMAT(tanggal, "%d/%m/%Y") as tanggal, mahasiswa.nama, mahasiswa.nim, mahasiswa.prodi, kategori_pelanggaran.nama as nama_kategori, jenis_pelanggaran.nama as nama_jenis, sanksi.nama as nama_sanksi, lokasi.nama as nama_lokasi, id_pelapor, inspektur, DATE_FORMAT(tgl_surat_bebas, "%d/%m/%Y") as tgl_surat_bebas');
        $builder->join('mahasiswa', 'mahasiswa.nim = pelanggaran_mahasiswa.nim');
        $builder->join('jenis_pelanggaran', 'jenis_pelanggaran.id=pelanggaran_mahasiswa.jenis_pelanggaran');
        $builder->join('kategori_pelanggaran', 'kategori_pelanggaran.id=jenis_pelanggaran.id_kategori');
        $builder->join('lokasi', 'lokasi.id=pelanggaran_mahasiswa.id_lokasi');
        $builder->join('sanksi', 'sanksi.id=pelanggaran_mahasiswa.id_sanksi', 'left');
        $builder->orderBy('pelanggaran_mahasiswa.tanggal', 'DESC');
        $query = $builder->get()->getResult();

        foreach ($query as $row) :
            if(!empty($row->inspektur)){
                $row->nama_inspektur = $komdisma->getWhere($row->inspektur)->nama;
            } else {
                $row->nama_inspektur = NULL;
            }
            $row->nama_pelapor = $auth->getWhere($row->id_pelapor)->nama;
            $row->status = $this->getStatusPelanggaran($row->id_pelanggaran)['status'];
        endforeach;

        return $query;
    }


    public function insertTglSurat(){
        $query = $this->getAll();

        foreach ($query as $row) :
            if(($row->status == "Selesai") AND (empty($row->tgl_surat_bebas))){
                $data=[
                    'tgl_surat_bebas' => Time::now('Asia/Jakarta')->toDateString(),
                ];
                $this->tb_pelanggaran->update($data, ['id' => $row->id_pelanggaran]);
            }
        endforeach;
    }

    public function countPelanggaran(){
        $builder = $this->tb_pelanggaran;
        $query = $builder->countAll();

        return $query;
    }

    public function countPelanggar(){
        $builder = $this->tb_pelanggaran;
        $builder->select('count(distinct nim) as jum');
        $query = $builder->get()->getRow()->jum;

        return $query;
    }

    public function countStatus(){
        $builder = $this->tb_pelanggaran;
        $builder->select('id');
        $query = $builder->get()->getResult();

        $jumlahSelesai = 0;
        $jumlahNotSelesai = 0;
        foreach ($query as $row):
            if( $this->getStatusPelanggaran($row->id)['status'] == "Selesai"){
                $jumlahSelesai= $jumlahSelesai + 1 ;
            }elseif ($this->getStatusPelanggaran($row->id)['status'] != "Selesai"){
                $jumlahNotSelesai = $jumlahNotSelesai + 1; 
            }
        endforeach;

        $data = [$jumlahSelesai,$jumlahNotSelesai];

        return $data;
    }

    public function pelanggaranTerakhir(){
        $sql = "SELECT DATE_FORMAT(tanggal, '%M') AS bulan, COUNT(*) AS jumlah_bulanan
        FROM pelanggaran_mahasiswa WHERE tanggal >= CURDATE() - INTERVAL 6 MONTH GROUP BY YEAR(tanggal),MONTH(tanggal);";
        $query = $this->db->query($sql)->getResult();

        $bulan = array();
        $jumlah = array();
        foreach ($query as $row):
            $bulan[] = $row->bulan;
            $jumlah[] = $row->jumlah_bulanan;
        endforeach;

        $data=[$bulan, $jumlah];
        return $data;
        
    }

    public function pelanggaranProdi(){
        $builder=$this->tb_pelanggaran;
        $builder->select('COUNT(*) AS jumlah, prodi');
        $builder->join('mahasiswa', 'mahasiswa.nim = pelanggaran_mahasiswa.nim');
        $builder->groupBy('prodi');
        $query = $builder->get()->getResult();

        if(!empty($query)){
            $nama_prodi = array();
            $jumlah = array();
            foreach ($query as $row):
                $nama_prodi[] = $row->prodi;
                $jumlah[] = $row->jumlah;
            endforeach;

            $data=[$nama_prodi, $jumlah];
        } else {
            $data=[NULL, NULL];
        }

        return $data;
        
    }

    public function pelanggaranPerbulan(){
        $sql = "SELECT DATE_FORMAT(tanggal, '%M') AS bulan, COUNT(*) AS jumlah_bulanan
        FROM pelanggaran_mahasiswa WHERE tanggal >= CURDATE() - INTERVAL 12 MONTH GROUP BY YEAR(tanggal),MONTH(tanggal);";
        $query = $this->db->query($sql)->getResult();

        if(!empty($query)){
            $bulan = array();
            $jumlah = array();
            foreach ($query as $row):
                $bulan[] = $row->bulan;
                $jumlah[] = $row->jumlah_bulanan;
            endforeach;

            $data=[$bulan, $jumlah];
        } else {

            $data=[NULL, NULL];
        }

        return $data;
        
    }

    public function pelanggaranKategori($id = 1){
        $sql = "SELECT DATE_FORMAT(tanggal, '%M') AS bulan, COUNT(*) AS jumlah_bulanan, kategori_pelanggaran.nama as nama_kategori, jenis_pelanggaran.nama as nama_jenis FROM pelanggaran_mahasiswa join jenis_pelanggaran on jenis_pelanggaran.id=pelanggaran_mahasiswa.jenis_pelanggaran join kategori_pelanggaran on kategori_pelanggaran.id=jenis_pelanggaran.id_kategori WHERE tanggal >= CURDATE() - INTERVAL 12 MONTH AND jenis_pelanggaran= $id GROUP BY YEAR(tanggal),MONTH(tanggal);";
        $query = $this->db->query($sql)->getResult();

        if(!empty($query)){
            $bulan = array();
            $jumlah = array();
            foreach ($query as $row):
                $bulan[] = $row->bulan;
                $jumlah[] = $row->jumlah_bulanan;
                $nama_kategori = $row->nama_kategori;
                $nama_jenis = $row->nama_jenis;
            endforeach;

            $data=[$bulan, $jumlah, $nama_kategori, $nama_jenis];
        } else {
            $jpelanggaran = new \App\Models\JPelanggaranModel();
            $nama_kategori = $jpelanggaran->getName($id)->nama_kategori;
            $nama_jenis = $jpelanggaran->getName($id)->nama_jenis;
            $data=[NULL, NULL, $nama_kategori, $nama_jenis];
        }
        return $data;
        
    }

    public function pelanggaranLokasi($id = 1){
        $sql = "SELECT DATE_FORMAT(tanggal, '%M') AS bulan, COUNT(*) AS jumlah_bulanan, lokasi.nama as nama_lokasi FROM pelanggaran_mahasiswa join lokasi on lokasi.id=pelanggaran_mahasiswa.id_lokasi WHERE tanggal >= CURDATE() - INTERVAL 12 MONTH AND id_lokasi = $id GROUP BY YEAR(tanggal),MONTH(tanggal);";
        $query = $this->db->query($sql)->getResult();

        if(!empty($query)){
            $bulan = array();
            $jumlah = array();
            foreach ($query as $row):
                $bulan[] = $row->bulan;
                $jumlah[] = $row->jumlah_bulanan;
                $nama_lokasi = $row->nama_lokasi;
            endforeach;

            $data=[$bulan, $jumlah, $nama_lokasi];

        } else {
            $lokasi= new \App\Models\LokasiModel();
            $nama_lokasi = $lokasi->getName($id)->nama;
            $data=[NULL, NULL, $nama_lokasi];
        }
        return $data;
        
    }

    public function pelanggaranSanksi($id = 1){
        $sql = "SELECT DATE_FORMAT(tanggal, '%M') AS bulan, COUNT(*) AS jumlah_bulanan, sanksi.nama as nama_sanksi FROM pelanggaran_mahasiswa join sanksi on sanksi.id=pelanggaran_mahasiswa.id_sanksi WHERE tanggal >= CURDATE() - INTERVAL 12 MONTH AND id_sanksi = $id GROUP BY YEAR(tanggal),MONTH(tanggal);";
        $query = $this->db->query($sql)->getResult();

        if(!empty($query)){
            $bulan = array();
            $jumlah = array();
            foreach ($query as $row):
                $bulan[] = $row->bulan;
                $jumlah[] = $row->jumlah_bulanan;
                $nama_sanksi = $row->nama_sanksi;
            endforeach;

            $data=[$bulan, $jumlah, $nama_sanksi];

        } else {
            $sanksi= new \App\Models\SanksiModel();
            $nama_sanksi = $sanksi->getSanksi($id)->nama;
            $data=[NULL, NULL, $nama_sanksi];
        }
        return $data;
        
    }

    public function pelanggaranPerbulanProdi($prodi = 'A-KMN'){
        $sql = "SELECT DATE_FORMAT(tanggal, '%M') AS bulan, COUNT(*) AS jumlah_bulanan, mahasiswa.prodi
        FROM pelanggaran_mahasiswa join mahasiswa on mahasiswa.nim=pelanggaran_mahasiswa.nim WHERE tanggal >= CURDATE() - INTERVAL 12 MONTH AND mahasiswa.prodi = '$prodi' GROUP BY YEAR(tanggal),MONTH(tanggal);";
        $query = $this->db->query($sql)->getResult();

        if(!empty($query)){
            $bulan = array();
            $jumlah = array();
            foreach ($query as $row):
                $bulan[] = $row->bulan;
                $jumlah[] = $row->jumlah_bulanan;
                $nama_prodi = $row->prodi;
            endforeach;

            $data=[$bulan, $jumlah, $nama_prodi];
        } else {
            $data=[NULL, NULL,  $prodi];
        }

        return $data;
        
    }

    public function pelanggaranKategoriProdi($id = 1, $prodi = 'A-KMN'){
        $sql = "SELECT DATE_FORMAT(tanggal, '%M') AS bulan, COUNT(*) AS jumlah_bulanan, mahasiswa.prodi, kategori_pelanggaran.nama as nama_kategori, jenis_pelanggaran.nama as nama_jenis FROM pelanggaran_mahasiswa join jenis_pelanggaran on jenis_pelanggaran.id=pelanggaran_mahasiswa.jenis_pelanggaran join kategori_pelanggaran on kategori_pelanggaran.id=jenis_pelanggaran.id_kategori join mahasiswa on mahasiswa.nim=pelanggaran_mahasiswa.nim WHERE tanggal >= CURDATE() - INTERVAL 12 MONTH AND jenis_pelanggaran= $id AND mahasiswa.prodi = '$prodi' GROUP BY YEAR(tanggal),MONTH(tanggal);";
        $query = $this->db->query($sql)->getResult();

        if(!empty($query)){
            $bulan = array();
            $jumlah = array();
            foreach ($query as $row):
                $bulan[] = $row->bulan;
                $jumlah[] = $row->jumlah_bulanan;
                $nama_kategori = $row->nama_kategori;
                $nama_jenis = $row->nama_jenis;
                $nama_prodi = $row->prodi;
            endforeach;

            $data=[$bulan, $jumlah, $nama_kategori, $nama_jenis, $nama_prodi];
        } else {
            $jpelanggaran = new \App\Models\JPelanggaranModel();
            $nama_kategori = $jpelanggaran->getName($id)->nama_kategori;
            $nama_jenis = $jpelanggaran->getName($id)->nama_jenis;
            $data=[NULL, NULL, $nama_kategori, $nama_jenis, $prodi];
        }
        
        return $data;
        
    }

    public function pelanggaranLokasiProdi($id = 1, $prodi = 'A-KMN'){
        $sql = "SELECT DATE_FORMAT(tanggal, '%M') AS bulan, COUNT(*) AS jumlah_bulanan, mahasiswa.prodi, lokasi.nama as nama_lokasi FROM pelanggaran_mahasiswa join lokasi on lokasi.id=pelanggaran_mahasiswa.id_lokasi join mahasiswa on mahasiswa.nim=pelanggaran_mahasiswa.nim WHERE tanggal >= CURDATE() - INTERVAL 12 MONTH AND id_lokasi = $id AND mahasiswa.prodi = '$prodi' GROUP BY YEAR(tanggal),MONTH(tanggal);";
        $query = $this->db->query($sql)->getResult();

        if(!empty($query)){
            $bulan = array();
            $jumlah = array();
            foreach ($query as $row):
                $bulan[] = $row->bulan;
                $jumlah[] = $row->jumlah_bulanan;
                $nama_lokasi = $row->nama_lokasi;
                $nama_prodi = $row->prodi;
            endforeach;

            $data=[$bulan, $jumlah, $nama_lokasi, $nama_prodi];

        } else {
            $lokasi= new \App\Models\LokasiModel();
            $nama_lokasi = $lokasi->getName($id)->nama;
            $data=[NULL, NULL, $nama_lokasi, $prodi];
        }
        return $data;
        
    }

    public function pelanggaranSanksiProdi($id = 1, $prodi ='A-KMN'){
        $sql = "SELECT DATE_FORMAT(tanggal, '%M') AS bulan, COUNT(*) AS jumlah_bulanan, mahasiswa.prodi, sanksi.nama as nama_sanksi FROM pelanggaran_mahasiswa join sanksi on sanksi.id=pelanggaran_mahasiswa.id_sanksi join mahasiswa on mahasiswa.nim=pelanggaran_mahasiswa.nim WHERE tanggal >= CURDATE() - INTERVAL 12 MONTH AND id_sanksi = $id AND mahasiswa.prodi = '$prodi' GROUP BY YEAR(tanggal),MONTH(tanggal);";
        $query = $this->db->query($sql)->getResult();

        if(!empty($query)){
            $bulan = array();
            $jumlah = array();
            foreach ($query as $row):
                $bulan[] = $row->bulan;
                $jumlah[] = $row->jumlah_bulanan;
                $nama_sanksi = $row->nama_sanksi;
                $nama_prodi = $row->prodi;
            endforeach;

            $data=[$bulan, $jumlah, $nama_sanksi, $nama_prodi];

        } else {
            $sanksi= new \App\Models\SanksiModel();
            $nama_sanksi = $sanksi->getSanksi($id)->nama;
            $data=[NULL, NULL, $nama_sanksi, $prodi];
        }
        return $data;
        
    }
}
