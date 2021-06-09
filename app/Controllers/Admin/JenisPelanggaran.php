<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class JenisPelanggaran extends BaseController
{

    public function getAll(){
        $data = [
            'title' => 'Jenis Pelanggaran',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'Kpelanggarans' => $this->KpelanggaranModel->getAll(),
            'Jpelanggarans' =>$this->JpelanggaranModel->getAllJenis(),
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
            return view('admin/jenis_pelanggaran', $data);
        }
        
    }

    public function simpan(){
        $kategori = $this->request->getPost('kategori[]');
        $jenis = $this->request->getPost('jenis[]');
        foreach ($kategori as $key => $val) :
            if (!empty($this->JpelanggaranModel->cekJpelanggaran($jenis[$key]))){
                continue;
            }
            $data = [
                'id_kategori' => $this->request->getPost('kategori[]')[$key],
                'nama' => $this->request->getPost('jenis[]')[$key]
            ];
            $this->JpelanggaranModel->insert($data);
        endforeach ;
        $this->session->setFlashdata('response', ['message' => 'TambahDataBerhasil']);
        return redirect()->to(base_url('admin/pelanggaran/jenis'));
    }

    public function edit(){
        $where = $this->request->getPost('id_jenis');
        $data=[
            'id_kategori' => $this->request->getPost('kategori'),
            'nama' => $this->request->getPost('jenis'),
        ];

        $query = $this->JpelanggaranModel->edit($where,$data);
        if ($query){
            $this->session->setFlashdata('response', ['message' => 'DataBerhasilEdit']);
            return redirect()->to(base_url('admin/pelanggaran/jenis'));
        }
       
    }

}
