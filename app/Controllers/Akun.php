<?php

namespace App\Controllers;

class Akun extends BaseController
{
    public function editAkun() {
        $auth = new \IonAuth\Libraries\IonAuth();
        $data['title'] = 'Edit Akun';
		$data['user'] = $auth->getProfile();
        $data['group_name'] = $auth->getUsersGroups()->getRow()->name;
        $data['session'] = $this->session->getFlashdata('response');
        $data['jumlah_verifikasi'] = $this->jumlahVerifikasi;
        $data['jumlah_lapor'] = $this->jumlahLapor;
        $data['jumlah_pengajuan'] = $this->jumlahPengajuan;
        $data['jumlah_pengajuan_surat'] = $this->jumlahPengajuanSurat;
        return view('edit_akun', $data);

    }

    public function editAkunPengurus(){
        $id = $this->auth->user()->row()->id;
        $data = [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('passwordBaru'),
        ];

        $query = $this->auth->update($id,$data);
            
        if($query){
            $this->session->setFlashdata('response', ['message' => 'EditAkunBerhasil']);
            return redirect()->to(base_url('akun'));
                
        }
    }

    public function editAkunMahasiswa(){
        $id = $this->auth->user()->row()->id;
        $data = [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('passwordBaru'),
        ];

        $query = $this->auth->update($id,$data);
            
        if($query){
            $data_mahasiswa = [
                'kontak' => $this->request->getPost('kontak'),
            ];
            $nim = $this->auth->getProfile()->nim;
            $this->mahasiswaModel->updateData($nim,$data_mahasiswa);

            $this->session->setFlashdata('response', ['message' => 'EditAkunBerhasil']);
            return redirect()->to(base_url('akun'));
                
        }
    }
}
