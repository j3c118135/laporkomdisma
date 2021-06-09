<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Akun extends BaseController
{
    //menampilkan data akun
    public function getAll()
    {	

        $data = [
            'title' => 'Data Akun',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'users'  => $this->auth->getAll(),
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
            return view('admin/data/akun', $data);
        }
    }

    public function hapusAkun(){
        $id = $this->request->getPost('id[]');
        if(empty($id)){
            $this->session->setFlashdata('response', ['message' => 'PilihData']);
        } else {
            foreach ($id as $row):
                $this->auth->deleteUser($row);
            endforeach;
            $this->session->setFlashdata('response', ['message' => 'HapusDataBerhasil']);
        }
        return redirect()->back();
    }

    


}
