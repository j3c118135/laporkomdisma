<?php
namespace App\Controllers\Mahasiswa;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class PenundaanSkorsing extends BaseController
{

    //menampilkan data akademik
    public function ajukanPenundaan()
    {	
        $data=[
            'id_pelanggaran' => $this->request->getPost('id_pelanggaran'),
            'tgl_pengajuan' => Time::now('Asia/Jakarta')->toDateString(),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        $query = $this->penundaanModel->insert($data);
        if ($query){
            $this->session->setFlashdata('response', ['message' => 'PengajuanTundaBerhasil']);
            return redirect()->back();
        }
    }

    

}
