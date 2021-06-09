<?php namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model{
    protected $table      = 'mahasiswa';
    protected $primaryKey = 'nim';

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nim', 'id_akun' ,'nama', 'prodi', 'foto', 'foto_ktm', 'foto_simawa', 'foto_datalulusan', 'tgl_surat_kelakukan', 'tgl_sidang', 'kontak'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->tb_mahasiswa = $this->db->table('mahasiswa');
    }
        
    public function getAll(){
        $builder = $this->tb_mahasiswa;
        $builder->orderBy('id_akun', 'DESC');
        $query = $builder->get()->getResult();

        return $query;
    }

    public function getMahasiswa($nim){
        $builder = $this->tb_mahasiswa;
        $builder -> where('nim', $nim);
        $query = $builder ->get()->getRow();

        return $query;
    }

    public function getProdi($prodi){
        if ($prodi == "A-KMN"){
            $hasil = "Komunikasi";
        } elseif ($prodi == "B-EKW"){
            $hasil = "Ekowisata";
        } elseif ($prodi == "C-INF"){
            $hasil = "Manajemen Informatika";
        } elseif ($prodi == "D-TEK"){
            $hasil = "Teknik Komputer";
        } elseif ($prodi == "E-JMP"){
            $hasil = "Supervisor Jaminan Mutu Pangan";
        } elseif ($prodi == "F-GZI"){
            $hasil = "Manajemen Industri Jasa Makanan dan Gizi";
        } elseif ($prodi == "G-TIB"){
            $hasil = "Teknologi Industri Benih";
        } elseif ($prodi == "H-IKN"){
            $hasil = "Teknologi Produksi dan Manajemen Perikanan Budidaya";
        } elseif ($prodi == "I-TNK"){
            $hasil = "Teknologi dan Manajemen Ternak";
        } elseif ($prodi == "J-MAB"){
            $hasil = "Manajemen Agribisnis";
        } elseif ($prodi == "K-MNI"){
            $hasil = "Manajemen Industri";
        } elseif ($prodi == "L-KIM"){
            $hasil = "Analisis Kimia";
        } elseif ($prodi == "M-LNK"){
            $hasil = "Teknik dan Manajemen Lingkungan";
        } elseif ($prodi == "N-AKN"){
            $hasil = "Akuntansi";
        } elseif ($prodi == "P-PVT"){
            $hasil = "Paramedik Veteriner";
        } elseif ($prodi == "T-TMP"){
            $hasil = "Teknologi dan Manajemen Produksi Perkebunan";
        } elseif ($prodi == "W-PPP"){
            $hasil = "Teknologi Produksi dan Pengembangan Masyarakat Pertanian";
        }

        return $hasil;
    }

    public function updateData($nim, $data){
        return $this->tb_mahasiswa->update($data, ['nim' => $nim]);
     }
}
