<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class Pelanggaran extends BaseController
{
    //menampilkan data pelanggaran
    public function getAll()
    {
        $data = [
            'title' => 'Pelanggaran Mahasiswa',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'Kpelanggarans' => $this->KpelanggaranModel->getAll(),
            'lokasis' => $this->lokasiModel->getAll(),
            'Jpelanggarans' =>$this->JpelanggaranModel->getAll(),
            'pelanggarans' => $this->pelanggaranModel->getAll(),
            'sanksis' => $this->sanksiModel->getAll(),
            'session' => $this->session->getFlashdata('response'),
            'jumlah_verifikasi' => $this->jumlahVerifikasi,
            'jumlah_lapor' => $this->jumlahLapor,
            'jumlah_pengajuan' => $this->jumlahPengajuan,
            'jumlah_pengajuan_surat' => $this->jumlahPengajuanSurat,
        ];

        $group = array('Super Admin', 'Admin', 'Akademik');
        if (!$this->auth->inGroup($group))
        {
            return redirect()->back();
        } else {
            return view('admin/pelanggaran', $data);
        }

    }

    public function detailPelanggaran(){
        if(!empty($this->request->getPost('id'))){
            $this->session->set('id_pelanggaran',$this->request->getPost('id')); 
        }
        $id = $this->session->get('id_pelanggaran');
        $detail = $this->pelanggaranModel->getDetail($id);
        if (!empty($detail->inspektur)){
            $komdisma = $this->komdismaModel->getWhere($detail->inspektur)->nama;
        } else {
            $komdisma = "";
        }
        $data = [
            'title' => 'Detail Pelanggaran',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'session' => $this->session->getFlashdata('response'),
            'pelanggaran' => $detail,
            'lapors' => $this->laporModel->getLapor($id),
            'nama_dosen' => $this->auth->getWhere($detail->id_pelapor)->nama,
            'nama_inspektur' => $komdisma,
            'validation' => \Config\Services::validation(),
            'jumlah_verifikasi' => $this->jumlahVerifikasi,
            'jumlah_lapor' => $this->jumlahLapor,
            'jumlah_pengajuan' => $this->jumlahPengajuan,
            'jumlah_pengajuan_surat' => $this->jumlahPengajuanSurat,
        ];

        $group = array('Super Admin', 'Admin');
        if (!$this->auth->inGroup($group)){
            return redirect()->back();
        } else {
            return view('admin/detail_pelanggaran', $data);
        }


    }

    public function verifikasi(){
        $data = [
            'title' => 'Verifikasi Pelanggaran',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'pelanggarans' => $this->pelanggaranModel->getPelanggaranVerifikasi(),
            'Kpelanggarans' => $this->KpelanggaranModel->getAll(),
            'lokasis' => $this->lokasiModel->getAll(),
            'Jpelanggarans' =>$this->JpelanggaranModel->getAll(),
            'session' => $this->session->getFlashdata('response'),
            'jumlah_verifikasi' => $this->jumlahVerifikasi,
            'jumlah_lapor' => $this->jumlahLapor,
            'jumlah_pengajuan' => $this->jumlahPengajuan,
            'jumlah_pengajuan_surat' => $this->jumlahPengajuanSurat,
        ];
        $group = array('Super Admin', 'Admin');
        if (!$this->auth->inGroup($group)){
            return redirect()->back();
        } else {
            return view('admin/verifikasi_pelanggaran', $data);
        }
        
    }

    public function detailVerifikasi(){
        if(!empty($this->request->getPost('id'))){
            $this->session->set('id_pelanggaran',$this->request->getPost('id')); 
        }
        $id = $this->session->get('id_pelanggaran');
        $detail = $this->pelanggaranModel->getDetail($id);
        $data = [
            'title' => 'Detail Pelanggaran',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'session' => $this->session->getFlashdata('response'),
            'pelanggaran' => $detail,
            'nama_dosen' => $this->auth->getWhere($detail->id_pelapor)->nama,
            'sanksis' => $this->sanksiModel->getAll(),
            'pelanggarans' => $this->pelanggaranModel->getPelanggaranMahasiswa($detail->nim_mahasiswa, $id),
            'skorsings' => $this->pelanggaranModel->getWhereSkorsing($detail->nim_mahasiswa),
            'validation' => \Config\Services::validation(),
            'jumlah_verifikasi' => $this->jumlahVerifikasi,
            'jumlah_lapor' => $this->jumlahLapor,
            'jumlah_pengajuan' => $this->jumlahPengajuan,
            'jumlah_pengajuan_surat' => $this->jumlahPengajuanSurat,
        ];

        $group = array('Super Admin', 'Admin');
        if (!$this->auth->inGroup($group)){
            return redirect()->back();
        } else {
            return view('admin/detail_verifikasi_pelanggaran', $data);
        }

    }


    public function edit(){
            $id_pelanggaran = (int) ($this->request->getPost('id_pelanggaran'));
            $tanggal = Time::now('Asia/Jakarta')->toDateString();
            $data = [
                'id_sanksi' => $this->request->getPost('id_sanksi'),
                'inspektur' => $this->auth->getProfile()->id_user,
                'tgl_verifikasi' => $tanggal,
            ];
            
            $query = $this->pelanggaranModel->verifikasi($id_pelanggaran,$data);
            
            if($query){
                $this->session->setFlashdata('response', ['message' => 'VerifikasiBerhasil']);
                return redirect()->to(base_url('admin/verifikasi'));
                
            }

    }

    public function ubah(){
        $data_sanksi = [
            'nama' => $this->request->getPost('nama_sanksi'),
            'lapor' => $this->request->getPost('lapor'),
            'skorsing' => $this->request->getPost('skorsing'),
            'drop_out' => $this->request->getPost('drop_out'),
        ];

        if ($this->request->getPost('lapor') == 0){
            $data_sanksi['lapor'] = NULL;
        }

        if ($this->request->getPost('skorsing') == 0){
            $data_sanksi['skorsing'] = NULL;
        }

        if ($this->sanksiModel->cekSanksi($this->request->getPost('nama_sanksi'))){
            $this->session->setFlashdata('response', ['message' => 'VerifikasiGagal']);
            return redirect()->back();
        } else {
            $sql = $this->sanksiModel->insert($data_sanksi);

            if($sql){
                $id_pelanggaran = $this->request->getPost('id_pelanggaran');
                $tanggal = Time::now('Asia/Jakarta')->toDateString();
                $data = [
                    'id_sanksi' => $sql,
                    'inspektur' => $this->auth->getProfile()->id_user,
                    'tgl_verifikasi' => $tanggal,
                ];
        
                $query = $this->pelanggaranModel->verifikasi($id_pelanggaran,$data);
        
                if($query){
                    $this->session->setFlashdata('response', ['message' => 'VerifikasiBerhasil']);
                    return redirect()->to(base_url('admin/verifikasi'));
            
                }
            } 
        }

                   
    }


    public function loloskan($id){
        $query = $this->pelanggaranModel->loloskan($id);
        
        if($query){
            $this->session->setFlashdata('response', ['message' => 'PelanggaranDiloloskan']);
            return redirect()->back();
            
        }
    }

}
