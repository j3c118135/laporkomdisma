<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Lokasi extends BaseController
{

    public function getAll(){
        $data = [
            'title' => 'Lokasi Pelanggaran',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'lokasis' => $this->lokasiModel->getAll(),
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
            return view('admin/lokasi', $data);
        }
        
    }

    public function simpan(){
        $lokasi = $this->request->getPost('lokasi[]');
        $data = array();
        foreach ($lokasi as $key => $val) :
            if (!empty($this->lokasiModel->cekLokasi($lokasi[$key]))){
                continue;
            }
            $data = ['nama' => $lokasi[$key]];
            $this->lokasiModel->insert($data);
        endforeach ;
        $this->session->setFlashdata('response', ['message' => 'TambahDataBerhasil']);
        return redirect()->to(base_url('admin/pelanggaran/lokasi'));
    }

    public function edit(){
        $where = $this->request->getPost('id_lokasi');
        $data=[
            'nama' => $this->request->getPost('nama'),
        ];

        $query = $this->lokasiModel->edit($where,$data);
        if ($query){
            $this->session->setFlashdata('response', ['message' => 'DataBerhasilEdit']);
            return redirect()->to(base_url('admin/pelanggaran/lokasi'));
        }
       
    }

}
