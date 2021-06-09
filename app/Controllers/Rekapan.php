<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Rekapan extends BaseController
{
    //menampilkan data rekapan
    public function rekapan()
    {	
        
        $data = [
            'title' => 'Unduh Rekapan Data',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'session' => $this->session->getFlashdata('response'),
            'data' => $this->pelanggaranModel->rekapan(),
            'Kpelanggarans' => $this->KpelanggaranModel->getAll(),
            'lokasis' => $this->lokasiModel->getAll(),
            'Jpelanggarans' =>$this->JpelanggaranModel->getAll(),
            'sanksis' => $this->sanksiModel->getAll(),
            'jumlah_verifikasi' => $this->jumlahVerifikasi,
            'jumlah_lapor' => $this->jumlahLapor,
            'jumlah_pengajuan' => $this->jumlahPengajuan,
            'jumlah_pengajuan_surat' => $this->jumlahPengajuanSurat,
        ];

        return view('admin/rekapan', $data);
    }

}
