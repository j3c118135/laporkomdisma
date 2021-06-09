<?php
namespace App\Controllers\Mahasiswa;
use App\Controllers\BaseController;

class Pelanggaran extends BaseController
{

    public function getAll(){
        
        $group = 'Mahasiswa';
        if (!$this->auth->inGroup($group))
        {
            return redirect()->back();
        } else {
            $nim = $this->auth->getProfile()->nim;

            $data = [
                'title' => 'Pelanggaran',
                'user'  => $this->user,
                'group_name'  => $this->group_name,
                'pelanggarans' => $this->pelanggaranModel->getWhere($nim),
                'session' => $this->session->getFlashdata('response'),
            ];
            return view('mahasiswa/pelanggaran', $data);
        }
    }

    public function detailPelanggaran(){
        if(!empty($this->request->getPost('id'))){
            $this->session->set('id_pelanggaran',$this->request->getPost('id')); 
        }
        $id = $this->session->get('id_pelanggaran');
        $detail = $this->pelanggaranModel->getDetail($id);
        if (!empty($detail->inspektur)){
            $komdisma = $this->komdismaModel->getWhere($detail->inspektur)->nama;
        } else {
            $komdisma = "";
        }
        //dd($this->laporModel->canLapor($id));die;
        $data = [
            'title' => 'Detail Pelanggaran',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'session' => $this->session->getFlashdata('response'),
            'pelanggaran' => $detail,
            'lapors' => $this->laporModel->getLapor($id),
            'skorsing' => $this->jadwalModel->getJadwal($id),
            'statusSkorsing' => $this->pelanggaranModel->getStatusSkors($id)->status,
            'nama_dosen' => $this->auth->getWhere($detail->id_pelapor)->nama,
            'nama_inspektur' => $komdisma,
            'validation' => \Config\Services::validation(),
            'canLapor' => $this->laporModel->canLapor($id),
            'cekPenundaan' => $this->penundaanModel->cekPenundaan($id),
            'dosen' => $this->auth->getAllDosen(),
            'lastLapor' => $this->laporModel->lastLapor($id),
            'prodi' => $this->mahasiswaModel->getProdi($detail->prodi),
        ];
        $group = 'Mahasiswa';
        if (!$this->auth->inGroup($group))
        {
            return redirect()->back();
        } else {
            return view('mahasiswa/detail_pelanggaran', $data);

        }
    }

}
