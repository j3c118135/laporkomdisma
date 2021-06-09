<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Surat extends BaseController
{
    //menampilkan data pelanggaran
    public function getAll()
    {   
        $data = [
            'title' => 'Surat Kelakuan Baik',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'pengajuanSurat' => $this->suratModel->getAll(),
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
            return view('admin/pengajuan_surat', $data);
        }

    }

    public function terimaPengajuan(){
        $id = $this->request->getPost('id');
        $data = [
            'inspektur' => $this->auth->getProfile()->id_user,
            'tgl_berakhir' =>$this->request->getPost('tgl_berakhir'),
            'status' => 1,
        ];
        
        $query = $this->suratModel->verifikasi($id,$data);
        
        if($query){
            $this->session->setFlashdata('response', ['message' => 'VerifikasiBerhasil']);
            return redirect()->back();
            
        }
    }
    public function tolakPengajuan(){
        $id = $this->request->getPost('id');
        $data = [
            'inspektur' => $this->auth->getProfile()->id_user,
            'komentar' => $this->request->getPost('komentar'),
            'status' => 0,
        ];
        
        $query = $this->suratModel->verifikasi($id,$data);
        
        if($query){
            $this->session->setFlashdata('response', ['message' => 'VerifikasiBerhasil']);
            return redirect()->back();
            
        }
    }
}
