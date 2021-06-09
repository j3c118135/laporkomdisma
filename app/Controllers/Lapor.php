<?php
namespace App\Controllers;

class Lapor extends BaseController
{

    public function getLaporMahasiswa()
    {
        // dd($this->laporModel->countLapor());die;
        $data = [
            'title' => 'Laporan Pelanggaran Mahasiswa',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'lapors' => $this->laporModel->getLaporMahasiswa(),
            'session' => $this->session->getFlashdata('response'),
            'jumlah_verifikasi' => $this->jumlahVerifikasi,
            'jumlah_lapor' => $this->jumlahLapor,
            'jumlah_pengajuan' => $this->jumlahPengajuan,
            'jumlah_pengajuan_surat' => $this->jumlahPengajuanSurat,
        ];
        $group = 'Dosen';
        if((!$this->auth->isAdmin()) AND (!$this->auth->inGroup($group))){
            return redirect()->back();
        } else {
            return view('admin/laporan', $data);
        }
    }

    public function terimaLapor(){

        $id_lapor = $this->request->getPost('id_lapor');
        $data = [
            'keterangan' => $this->request->getPost('keterangan'),
            'status' => 1,
        ];
        
        $query = $this->laporModel->terimaLapor($id_lapor,$data);
        
        if($query){
            $this->session->setFlashdata('response', ['message' => 'terimaLaporBerhasil']);
            return redirect()->to(base_url('laporan'));
            
        }

    }

}
