<?php
namespace App\Controllers;
use CodeIgniter\I18n\Time;
use phpDocumentor\Reflection\Types\This;

class Pelanggaran extends BaseController
{

    public function tambah(){

        if(!empty($this->request->getPost('nim'))){
            $this->session->set('nim',$this->request->getPost('nim')); 
        }
        $nim = $this->session->get('nim');

        $mahasiswas = $this->mahasiswaModel->getMahasiswa($nim);

        $data = [
            'title' => 'Tambah Pelanggaran Mahasiswa',
            'user'  => $this->user,
            'group_name'  => $this->group_name,
            'mahasiswa' => $mahasiswas,
            'Kpelanggarans' => $this->KpelanggaranModel->getAll(),
            'lokasis' => $this->lokasiModel->getAll(),
            'pelanggarans' => $this->pelanggaranModel->getPelanggaranMahasiswa($nim),
            'skorsings' => $this->pelanggaranModel->getWhereSkorsing($nim),
            'validation' => \Config\Services::validation(),
            'Jpelanggarans' =>$this->JpelanggaranModel->getWhere(old('kategoriP')),
            'session' => $this->session->getFlashdata('response'),
            'jumlah_verifikasi' => $this->jumlahVerifikasi,
            'jumlah_lapor' => $this->jumlahLapor,
            'jumlah_pengajuan_surat' => $this->jumlahPengajuanSurat,
        ];

        if(empty($mahasiswas)){
            $this->session->setFlashdata('response', ['message' => 'DataNotFound']);
            return redirect()->back();
            
        } else {
            return view('admin/tambah_pelanggaran', $data);
        }

    }

    public function getJenisPelanggaran(){
        $JpelanggaranModel = new \App\Models\JPelanggaranModel();

        $id_kategori = $this->request->getPost('id');
        $query = $JpelanggaranModel->getJenisPelanggaran($id_kategori);
        $data ='';
        
        foreach ($query as $row) {

            $data .= "<option value='".$row->id."'set_select('jenisP', $row->id);>".$row->nama."</option>";

        }

        echo json_encode($data);
    }

    public function simpan(){
        //validasi
        if(!$this->validate([
            'tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal tidak boleh kosong',
                ]
                ],
            'jam' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jam tidak boleh kosong',
                ]
                ],
            'tingkat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tingkat tidak boleh kosong',
                ]
                ],
            'lokasi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih lokasi',
                ]
                ],
            'kategoriP' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih kategori pelanggaran',
                ]
                ],
            'jenisP' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Silahkan pilih jenis pelanggaran',
                ]
                ],
            'keterangan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Keterangan tidak boleh kosong',
                ]
                ],
            'bukti_foto' => [
                'rules' => 'uploaded[bukti_foto]|max_size[bukti_foto,200]|is_image[bukti_foto]|mime_in[bukti_foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Bukti foto tidak boleh kosong',
                    'max_size' => 'Ukuran file lebih dari 200kb',
                    'is_image' => 'File yang dipilih bukan gambar',
                    'mime_in' => 'File yang dipilih bukan gambar',
                ]
                ],

        ])) {
            return redirect()->to(base_url('pelanggaran/tambah'))->withInput();
        }

        $fileFoto = $this->request->getFile('bukti_foto');

        if( $fileFoto->getError() == 4){
            $namaFoto='default-image.png';
        } else {
            $namaFoto = $fileFoto->getRandomName();
            $fileFoto->move('upload', $namaFoto);
        }

        $id_user = $this->auth->user()->row()->id;
        $data_pelanggaran = [
            'nim' => $this->request->getPost('nim'),
            'tingkat' => $this->request->getPost('tingkat'),
            'tanggal' => $this->request->getPost('tanggal'),
            'jam' => $this->request->getPost('jam'),
            'id_lokasi' => $this->request->getPost('lokasi'),
            'jenis_pelanggaran' => $this->request->getPost('jenisP'),
            'keterangan' => $this->request->getPost('keterangan'),
            'id_pelapor' => $id_user,
            'bukti_foto' => $namaFoto,
        ];


        $query = $this->pelanggaranModel->insert($data_pelanggaran);
        if($query){
            $this->session->setFlashdata('response', ['message' => 'AddPelanggaranBerhasil']);
            return redirect()->to(base_url(''));
            
        }

    }

    

}
