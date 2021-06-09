<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Skorsing extends BaseController
{
    //menampilkan data pelanggaran
    public function getAll()
    {   
        $data = [
            'title' => 'Skorsing Mahasiswa',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'Kpelanggarans' => $this->KpelanggaranModel->getAll(),
            'lokasis' => $this->lokasiModel->getAll(),
            'Jpelanggarans' =>$this->JpelanggaranModel->getAll(),
            'skorsings' => $this->pelanggaranModel->getAllSkorsing(),
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
            return view('admin/skorsing', $data);

        }

    }

    public function getDetail()
    {
        if(!empty($this->request->getPost('id'))){
            $this->session->set('id_pelanggaran',$this->request->getPost('id')); 
        }
        $id = $this->session->get('id_pelanggaran');
        
        $data = [
            'title' => 'Detail Skorsing',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'data' => $this->pelanggaranModel->getSkorsingMahasiswa($id),
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
            return view('admin/detail_skorsing', $data);
        }
    }

    public function getAllPenundaan()
    {   
        $data = [
            'title' => 'Penundaan Skorsing Mahasiswa',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'Kpelanggarans' => $this->KpelanggaranModel->getAll(),
            'lokasis' => $this->lokasiModel->getAll(),
            'Jpelanggarans' =>$this->JpelanggaranModel->getAll(),
            'skorsings' => $this->penundaanModel->getAll(),
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
            return view('admin/penundaan_skorsing', $data);
        }

    }

    public function terimaPenundaan(){
        $id = $this->request->getPost('id');
        $data = [
            'inspektur' => $this->auth->getProfile()->id_user,
            'status' => 1,
        ];
        
        $query = $this->penundaanModel->verifikasi($id,$data);
        
        if($query){
            $this->session->setFlashdata('response', ['message' => 'VerifikasiBerhasil']);
            return redirect()->back();
            
        }

    }

    public function tolakPenundaan(){
        $id = $this->request->getPost('id');
        $data = [
            'inspektur' => $this->auth->getProfile()->id_user,
            'komentar' => $this->request->getPost('komentar'),
            'status' => 0,
        ];
        
        $query = $this->penundaanModel->verifikasi($id,$data);
        
        if($query){
            $this->session->setFlashdata('response', ['message' => 'VerifikasiBerhasil']);
            return redirect()->back();
            
        }

    }
}
