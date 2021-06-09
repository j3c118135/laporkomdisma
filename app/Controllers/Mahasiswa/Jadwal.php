<?php
namespace App\Controllers\Mahasiswa;
use App\Controllers\BaseController;

class Jadwal extends BaseController
{
    public function tambah(){
        
        $group = 'Mahasiswa';
        if (!$this->auth->inGroup($group))
        {
            return redirect()->back();
        } else {
            if(!empty($this->request->getPost('id'))){
                $this->session->set('id_pelanggaran',$this->request->getPost('id')); 
            }
            $id = $this->session->get('id_pelanggaran');
            $data = [
                'title' => 'Tambah Jadwal',
                'user'  => $this->user,
                'group_name'  => $this->group_name,
                'session' => $this->session->getFlashdata('response'),
                'dosens' => $this->auth->getAllDosen(),
                'jum_sanksi' => $this->sanksiModel->getSkorsing($id),
                'validation' => \Config\Services::validation(),
                'id_pelanggaran' => $id,
            ];
            return view('mahasiswa/tambah_jadwal', $data);
        }


    }

    public function simpan(){
        $id_pelanggaran = $this->request->getPost('id_pelanggaran');
        $tanggal = $this->request->getPost('tanggal[]');
        $tanggal_distinct = array_unique($this->request->getPost('tanggal[]'));
        $jum_sanksi = $this->sanksiModel->getSkorsing($id_pelanggaran);
        $jum_jadwal = count($tanggal_distinct);
        if($jum_jadwal == $jum_sanksi){
            $result = array();
            foreach ($tanggal as $key => $val):
                $result[] = array(
                    'id_pelanggaran' => $id_pelanggaran,
                    'tanggal' => $tanggal[$key],
                    'matkul' =>$this->request->getPost('matkul[]')[$key],
                    'jam_mulai' =>$this->request->getPost('jam_mulai[]')[$key],
                    'jam_selesai' =>$this->request->getPost('jam_selesai[]')[$key],
                    'dosen' =>$this->request->getPost('dosen[]')[$key],
                    'koordinator' =>$this->request->getPost('koordinator[]')[$key],

                );
            endforeach;
            $query = $this->jadwalModel->simpan($result,$id_pelanggaran);
            if($query){
                $this->session->setFlashdata('response', ['message' => 'AddJadwalBerhasil']);
                return redirect()->to(base_url('mahasiswa/pelanggaran/detail'));
            
            }
                
        } else{
            $this->session->setFlashdata('response', ['message' => 'jumSkorsNotSame,'.$jum_sanksi]);
            return redirect()->back();
        }
    }

    public function edit(){
        $where = $this->request->getPost('id');
        $data=[
            'id_pelanggaran' => $this->request->getPost('id_pelanggaran'),
            'jam_mulai' => $this->request->getPost('jam_mulai'),
            'jam_selesai' => $this->request->getPost('jam_selesai'),
            'matkul' => $this->request->getPost('matkul'),
            'dosen' => $this->request->getPost('dosen'),
            'koordinator' => $this->request->getPost('koordinator'),
        ];

        $query = $this->jadwalModel->edit($where,$data);
        if ($query){
            $this->session->setFlashdata('response', ['message' => 'JadwalBerhasilEdit']);
            return redirect()->back();
        }
       
    }
}
