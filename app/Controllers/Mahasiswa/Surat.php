<?php
namespace App\Controllers\Mahasiswa;
use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;
use Dompdf\Dompdf;
use Dompdf\Options;

class Surat extends BaseController
{

    public function suratKelakuan(){
        $array = $this->pelanggaranModel->cekStatusMahasiswa($this->user->nim);
        if((in_array(0,$array)) == TRUE){
            $statusPelanggaran = FALSE;
        } else {
            $statusPelanggaran = TRUE;
        }

        $data = [
            'title' => 'Surat Berkelakuan Baik',
            'user'  => $this->user,
            'statusPelanggaran' => $statusPelanggaran,
            'pengajuanTerakhir' => $this->suratModel->pengajuanTerakhir($this->user->nim),
            'group_name'  => $this->group_name,
            'session' => $this->session->getFlashdata('response'),
            'prodi' => $this->mahasiswaModel->getProdi($this->user->prodi),
        ];

        $group = 'Mahasiswa';
        if (!$this->auth->inGroup($group))
        {
            return redirect()->back();
        } else {
            return view('mahasiswa/surat', $data);

        }


    }

    public function insertPengajuan(){
        $data=[
            'nim' => $this->user->nim,
            'tgl_pengajuan' => Time::now('Asia/Jakarta')->toDateString(),
            'keperluan' => $this->request->getPost('keperluan'),
        ];

        $query = $this->suratModel->insert($data);
        if ($query){
            $this->session->setFlashdata('response', ['message' => 'PengajuanTundaBerhasil']);
            return redirect()->back();
        }

    }

    public function unduhSuratKelakuan(){
        $data = [
            'user'  => $this->user,
            'prodi' => $this->request->getPost('prodi'),
            'ttl' => $this->request->getPost('ttl'),
            'alamat' => $this->request->getPost('alamat'),
            'tgl_pengajuan' => $this->suratModel->pengajuanTerakhir($this->user->nim)['tgl_pengajuan'],
        ];
        $html = view('templates/surat_kelakuan_baik', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        //options
        //$options = new Options();
        //$options->setIsRemoteEnabled(true);
        //$dompdf->setOptions($options);

        
        

        $dompdf->setOptions($options);
        $dompdf->output();

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'potrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('Surat Keterangan Berkelakuan Baik.pdf');
    }

    public function unduhSuratBebas(){
        setlocale(LC_ALL, 'Indonesian'); 
        $data = [
            'user'  => $this->user,
            'prodi' => $this->request->getPost('prodi'),
            'nama_inspektur' => $this->request->getPost('nama_inspektur'),
            'tgl_surat_bebas' => $this->request->getPost('tgl_surat_bebas'),
            'tgl_terakhir_lapor' => $this->request->getPost('tgl_terakhir_lapor'),
            'jum_lapor' => $this->request->getPost('jum_lapor'),
        ];

        $html = view('templates/surat_bebas', $data);

        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        //options
        //$options = new Options();
        //$options->setIsRemoteEnabled(true);
        //$dompdf->setOptions($options);

        
        

        $dompdf->setOptions($options);
        $dompdf->output();

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'potrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('Surat Keterangan Bebas Lapor.pdf');
    }

}
