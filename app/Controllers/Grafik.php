<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class Grafik extends BaseController
{
    //menampilkan grafik
    public function grafikSv()
    {	
        $id_jenis= $this->request->getPost('jenisP');
        if(!empty($id_jenis)){
            $pelanggaranKategori= $this->pelanggaranModel->pelanggaranKategori($id_jenis);
        } else {
            $pelanggaranKategori= $this->pelanggaranModel->pelanggaranKategori(); 
        }

        $lokasi = $this->request->getPost('lokasi');
        if(!empty($lokasi)){
            $pelanggaranLokasi= $this->pelanggaranModel->pelanggaranLokasi($lokasi);
        } else {
            $pelanggaranLokasi= $this->pelanggaranModel->pelanggaranLokasi(); 
        }

        $sanksi = $this->request->getPost('sanksi');
        if(!empty($sanksi)){
            $pelanggaranSanksi= $this->pelanggaranModel->pelanggaranSanksi($sanksi);
        } else {
            $pelanggaranSanksi= $this->pelanggaranModel->pelanggaranSanksi(); 
        }

        $data = [
            'title' => 'Grafik SV',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'session' => $this->session->getFlashdata('response'),
            'Kpelanggarans' => $this->KpelanggaranModel->getAll(),
            'Jpelanggarans' =>$this->JpelanggaranModel->getAll(),
            'lokasis' => $this->lokasiModel->getAll(),
            'sanksis' => $this->sanksiModel->getAll(),
            'jumlah_verifikasi' => $this->jumlahVerifikasi,
            'jumlah_lapor' => $this->jumlahLapor,
            'jumlah_pengajuan' => $this->jumlahPengajuan,
            'jumlah_pengajuan_surat' => $this->jumlahPengajuanSurat,
            'pelanggaranPerbulan' => $this->pelanggaranModel->pelanggaranPerbulan(),
            'pelanggaranKategori' => $pelanggaranKategori,
            'pelanggaranLokasi' => $pelanggaranLokasi,
            'pelanggaranSanksi' => $pelanggaranSanksi,
        ];

        return view('admin/grafik_sv', $data);
    }

    public function grafikProdi()
    {	
        $prodi1 = $this->request->getPost('prodi1');
        $prodi2 = $this->request->getPost('prodi2');
        $prodi3 = $this->request->getPost('prodi3');
        $prodi4 = $this->request->getPost('prodi4');
        $id_jenis= $this->request->getPost('jenisP');

        if(!empty($prodi1)){
            $pelanggaranPerbulan= $this->pelanggaranModel->pelanggaranPerbulanProdi($prodi1);
        } else {
            $pelanggaranPerbulan= $this->pelanggaranModel->pelanggaranPerbulanProdi(); 
        }

        if(!empty($id_jenis) AND !empty($prodi2)){
            $pelanggaranKategori= $this->pelanggaranModel->pelanggaranKategoriProdi($id_jenis,$prodi2);
        } elseif (!empty($id_jenis) AND empty($prodi2)) {
            $pelanggaranKategori= $this->pelanggaranModel->pelanggaranKategoriProdi($id_jenis,'A-KMN'); 
        } elseif (empty($id_jenis) AND !empty($prodi2)) {
            $pelanggaranKategori= $this->pelanggaranModel->pelanggaranKategoriProdi(1,$prodi2); 
        } else {
            $pelanggaranKategori= $this->pelanggaranModel->pelanggaranKategoriProdi(); 
        }

        $lokasi = $this->request->getPost('lokasi');
        if(!empty($lokasi) AND !empty($prodi3)){
            $pelanggaranLokasi= $this->pelanggaranModel->pelanggaranLokasiProdi($lokasi,$prodi3);
        } elseif (!empty($lokasi) AND empty($prodi3)) {
            $pelanggaranLokasi= $this->pelanggaranModel->pelanggaranLokasiProdi($lokasi,'A-KMN'); 
        } elseif (empty($lokasi) AND !empty($prodi3)) {
            $pelanggaranLokasi= $this->pelanggaranModel->pelanggaranLokasiProdi(1,$prodi3); 
        } else {
            $pelanggaranLokasi= $this->pelanggaranModel->pelanggaranLokasiProdi(); 
        }
        
        $sanksi = $this->request->getPost('sanksi');
        if(!empty($sanksi) AND !empty($prodi4)){
            $pelanggaranSanksi= $this->pelanggaranModel->pelanggaranSanksiProdi($sanksi,$prodi4);
        } elseif (!empty($sanksi) AND empty($prodi4)) {
            $pelanggaranSanksi= $this->pelanggaranModel->pelanggaranSanksiProdi($sanksi,'A-KMN'); 
        } elseif (empty($sanksi) AND !empty($prodi4)) {
            $pelanggaranSanksi= $this->pelanggaranModel->pelanggaranSanksiProdi(1,$prodi4); 
        } else {
            $pelanggaranSanksi= $this->pelanggaranModel->pelanggaranSanksiProdi(); 
        }

        $data = [
            'title' => 'Grafik Prodi',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'session' => $this->session->getFlashdata('response'),
            'Kpelanggarans' => $this->KpelanggaranModel->getAll(),
            'Jpelanggarans' =>$this->JpelanggaranModel->getWhere(old('kategoriP')),
            'lokasis' => $this->lokasiModel->getAll(),
            'sanksis' => $this->sanksiModel->getAll(),
            'jumlah_verifikasi' => $this->jumlahVerifikasi,
            'jumlah_lapor' => $this->jumlahLapor,
            'jumlah_pengajuan' => $this->jumlahPengajuan,
            'jumlah_pengajuan_surat' => $this->jumlahPengajuanSurat,
            'pelanggaranPerbulan' => $pelanggaranPerbulan,
            'pelanggaranKategori' => $pelanggaranKategori,
            'pelanggaranLokasi' => $pelanggaranLokasi,
            'pelanggaranSanksi' => $pelanggaranSanksi,
        ];

        return view('admin/grafik_prodi', $data);
    }

}
