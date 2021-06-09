<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use PHPExcel;
use PHPExcel_IOFactory;

class Mahasiswa extends BaseController
{
    //menampilkan data mahasiswa
    public function getAll()
    {	
        $data = [
            'title' => 'Data Mahasiswa',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'mahasiswas'  => $this->mahasiswaModel->getAll(),
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
            return view('admin/data/mahasiswa', $data);
        }
    }

    //tambah data mahasiswa
    public function simpan()
    {  
        $nama = $this->request->getPost('nama[]');
        foreach ($nama as $key => $val) :
            $group_id = $this->auth->getNameGroup('Mahasiswa')->id;
            $username = $this->request->getPost('nim[]')[$key];
            $password = $this->request->getPost('nim[]')[$key];
            $email = $this->request->getPost('nim[]')[$key].'@gmail.com';
            $additional_data = array( 'active' => 1, );
            if (!$this->auth->usernameCheck($username))
            {
                $group = array($group_id);
                $last_id = $this->auth->register($username, $password, $email, $additional_data, $group);
                if($last_id){
                    $data_mahasiswa=[
                        'nim' => $this->request->getPost('nim[]')[$key],
                        'nama' => $this->request->getPost('nama[]')[$key],
                        'prodi' => $this->request->getPost('prodi[]')[$key],
                        'id_akun' =>$last_id,
                    ];
                    $this->mahasiswaModel->insert($data_mahasiswa);
                }
            } else{
                continue;
            }
        endforeach;

        $this->session->setFlashdata('response', ['message' => 'TambahDataBerhasil']);
        return redirect()->to(base_url('admin/mahasiswa'));
    }

    public function importExcel(){

        $file = $this->request->getFile('fileExcel');

        new PHPExcel;
        $fileLocation = $file->getTempName();
        $objPHPExcel = PHPExcel_IOFactory::load($fileLocation);

        $sheet = $objPHPExcel->getActiveSheet()->toArray(true,true);

        foreach ($sheet as $key => $value) :
            //skip baris judul
            if ($key==0){
                continue;
            }
            //skip jika ada data sama
            if (($this->auth->usernameCheck($value[0])) == TRUE){
                continue;
            }

            $group_id = $this->auth->getNameGroup('Mahasiswa')->id;
            $username = $value[0];
            $password = $value[0];
            $email = $value[0].'@gmail.com';
            $additional_data = array( 'active' => 1, );
            $group = array($group_id);
            
            $last_id = $this->auth->register($username, $password, $email, $additional_data, $group);
            if($last_id){
                $data_mahasiswa=[
                    'nim' => $value[0],
                    'nama' => $value[1],
                    'prodi' => $value[2],
                    'id_akun' =>$last_id,
                ];
                $this->mahasiswaModel->insert($data_mahasiswa);
            }
        endforeach;
        $this->session->setFlashdata('response', ['message' => 'TambahDataBerhasil']);
        return redirect()->to(base_url('admin/mahasiswa'));

    }


}
