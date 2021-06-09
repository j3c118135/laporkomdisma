<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Laporan extends BaseController
{
    //menampilkan data lapor
    public function getAll()
    {	

        $data = [
            'title' => 'Laporan Pelanggaran',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
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
            return view('admin/laporan', $data);
        }
    }


}
