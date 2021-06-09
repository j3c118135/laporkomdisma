<?= $this->extend('templates/index');?>

<?= $this->section('page-content');?>

<!-- Topbar -->
<?= $this->include('admin/topbar'); ?>
<!-- End of Topbar -->

<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url();?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Data Master</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
      </ol>
    </nav>
    
    <!-- Tambah Mahasiswa -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Mahasiswa</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-12">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importExcel"><i class="fa fa-upload mr-2" ></i>Import Data</button>
                        </div>
                        <div class="btn-group mr-2" role="group" aria-label="Second group">
                            <a class="btn btn-primary btn-sm" href="<?= base_url('excel/Format Import Mahasiswa.xlsx');?>" download data-toggle="tooltip" data-placement="top" title="Unduh Format Excel"><i class="fas fa-file"></i></a>
                        </div>
                        <div class="btn-group ml-auto" role="group" aria-label="Third group">
                            <button type="button" class="btn btn-primary btn-sm" id="rowAddM"><i class="fa fa-plus mr-2" ></i>Tambah Input</button>
                        </div>
                    </div>
                </div>
            </div>
            <form method="POST" action="<?php echo base_url('admin/mahasiswa/simpan'); ?>" class="needs-validation" novalidate>
                <?= csrf_field();?>
                <div class="form-row align-items-end" id="inputRowM">
                    <div class="form-group col-md-5 col-sm-12">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama[]" placeholder="Masukkan nama lengkap" aria-describedby="namaHelpBlock" required>
                        <div class="invalid-tooltip">Nama tidak boleh kosong</div>
                    </div>
                    <div class="form-group col-md-4 col-sm12">
                        <label>NIM</label>
                        <input type="text" class="form-control" name="nim[]" placeholder="Masukkan NIM" aria-describedby="nimHelpBlock" required>
                        <div class="invalid-tooltip">NIM tidak boleh kosong</div>
                    </div>
                    <div class="form-group col-md-2 col-sm-12">
                        <label>Program Studi</label>
                        <select class="custom-select" name="prodi[]" required>
                            <option disabled selected value="">Pilih...</option>
                            <option value="A-KMN">A-KMN</option>
                            <option>B-EKW</option>
                            <option>C-INF</option>
                            <option>D-TEK</option>
                            <option>E-JMP</option>
                            <option>F-GZI</option>
                            <option>G-TIB</option>
                            <option>H-IKN</option>
                            <option>I-TNK</option>
                            <option>J-MAB</option>
                            <option>K-MNI</option>
                            <option>L-KIM</option>
                            <option>M-LNK</option>
                            <option>N-AKN</option>
                            <option>P-PVT</option>
                            <option>T-TMP</option>
                            <option>W-PPP</option>
                        </select>
                        <div class="invalid-tooltip">Silahkan pilih prodi</div>
                    </div>
                    <div class="form-group col-md-auto col-sm-12 align-self-md-end align-self-sm-start">
                      <button type="button" class="btn btn-danger mt-0 btn-block" data-toggle="tooltip" data-placement="top" title="Hapus Input" id="rowRemM"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
                <div id="newRowM"></div>
                <div class="row justify-content-center">
                    <div class="col-md-3 col-sm-12">
                        <button type="submit" class="btn btn-success btn-block">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Card Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form>
                <div class="form-row align-items-center justify-content-start">
                    <div class="col-md-auto col-sm-12 pt-2"><h6>Filter</h6></div>
                    <div class="col-md-auto col-sm-12 py-1">
                        <select class="form-control filter" id="prodi">
                            <option value="" selected>Semua Prodi</option>
                            <option>A-KMN</option>
                            <option>B-EKW</option>
                            <option>C-INF</option>
                            <option>D-TEK</option>
                            <option>E-JMP</option>
                            <option>F-GZI</option>
                            <option>G-TIB</option>
                            <option>H-IKN</option>
                            <option>I-TNK</option>
                            <option>J-MAB</option>
                            <option>K-MNI</option>
                            <option>L-KIM</option>
                            <option>M-LNK</option>
                            <option>N-AKN</option>
                            <option>P-PVT</option>
                            <option>T-TMP</option>
                            <option>W-PPP</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Table Mahasiswa -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Mahasiswa</h6>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('admin/akun/hapus');?>" id="form-delete">
                <div class="table-responsive">
                    <table class="table table-striped" id="tableUser" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="row">No</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Prodi</th>
                                <th>Kontak</th>
                                <th><div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input check-all" id="check-all">
                                <label class="custom-control-label" for="check-all"></label>
                                </div></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1; 
                            foreach ($mahasiswas as $mahasiswa) : ?>
                            <tr>
                                <td><?= $no++;?></td>
                                <td><?= $mahasiswa->nim;?></td>
                                <td><?= $mahasiswa->nama;?></td>
                                <td><?= $mahasiswa->prodi;?></td>
                                <td>
                                    <?php if (!empty($mahasiswa->kontak)){ ?>
                                        <a href="https://wa.me/+62<?=$mahasiswa->kontak;?>" class="text-success"><i class="fab fa-whatsapp fa-2x" ></i></a>
                                    <?php } else {?>
                                        <div class="text-disabled"><i class="fab fa-whatsapp fa-2x" ></i></div>
                                    <?php } ?>
                                </td>
                                <td><div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input check-item" name='id[]' value="<?=$mahasiswa->id_akun?>" id="checkitem<?=$mahasiswa->id_akun?>">
                                <label class="custom-control-label" for="checkitem<?=$mahasiswa->id_akun?>"></label>
                                </div></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Data Excel</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('admin/mahasiswa/import');?>" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Upload file excel</label>
                        <input type="file" class="form-control" name="fileExcel" required accept=".xls, .xlsx">
                        <div class="invalid-feedback">Silahkan pilih file dengan format .xls atau .xlsx</div>
                    </div>
            </div>
            <div class="modal-footer">
                <a class="btn" data-dismiss="modal">Batal</a>
                <button type="submit" class="btn btn-success">Import</button>
            </div>
                </form>
        </div>
    </div>
</div>
<?= $this->endSection();?>