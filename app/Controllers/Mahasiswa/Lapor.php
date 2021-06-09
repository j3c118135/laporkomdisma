<?php
namespace App\Controllers\Mahasiswa;
use CodeIgniter\I18n\Time;
use App\Controllers\BaseController;

class Lapor extends BaseController
{

    public function tambah(){
        
        $data_lapor = [
            'id_penerima_lapor' => $this->request->getPost('dosen'),
            'id_pelanggaran' => $this->request->getPost('id_pelanggaran'),
            'tanggal' => Time::now('Asia/Jakarta')->toDateString(),
        ];


        $query = $this->laporModel->insert($data_lapor);
        if($query){
            $this->session->setFlashdata('response', ['message' => 'laporBerhasil']);
            return redirect()->back();
            
        }

    }

}
