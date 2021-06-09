<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function __construct(){
        $pelanggaranModel= new \App\Models\PelanggaranModel();
        $pelanggaranModel->insertTglSurat();
    }
    public function index() {
        //dd($this->pelanggaranModel->pelanggaranProdi());die;
        $auth = new \IonAuth\Libraries\IonAuth();
        $data['title'] = 'Dashboard';
		$data['user'] = $auth->getProfile();
        $data['group_name'] = $auth->getUsersGroups()->getRow()->name;
        $data['session'] = $this->session->getFlashdata('response');
        $data['jumlah_verifikasi'] = $this->jumlahVerifikasi;
        $data['jumlah_lapor'] = $this->jumlahLapor;
        $data['jumlah_pengajuan'] = $this->jumlahPengajuan;
        $data['jumlah_pengajuan_surat'] = $this->jumlahPengajuanSurat;
        $data['jumlah_pelanggaran'] = $this->pelanggaranModel->countPelanggaran();
        $data['jumlah_pelanggar'] = $this->pelanggaranModel->countPelanggar();
        $data['jumlah_status'] = $this->pelanggaranModel->countStatus();
        $data['jumlah_terakhir'] = $this->pelanggaranModel->pelanggaranTerakhir();
        $data['pelanggaranProdi'] = $this->pelanggaranModel->pelanggaranProdi();
        

        if($auth->getUsersGroups()->getRow()->name == "Mahasiswa"){
            $nim=$auth->getProfile()->nim;
            $cekLapor = $this->pelanggaranModel->cekLapor($nim);
            if(in_array(TRUE, $cekLapor)){
                $data['alert_lapor'] = TRUE;
            } else{
                $data['alert_lapor'] = FALSE;
            }
        }
        return view('dashboard', $data);

    }
}
