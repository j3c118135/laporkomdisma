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
        <li class="breadcrumb-item active" aria-current="page">Akademik</li>
      </ol>
    </nav>
    <!-- Tambah Mahasiswa -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Akademik</h6>
            
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-12">
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="First group">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#importExcel"><i class="fa fa-upload mr-2" ></i>Import Data</button>
                        </div>
                        <div class="btn-group mr-2" role="group" aria-label="Second group">
                            <a class="btn btn-primary btn-sm" href="<?= base_url('excel/Format Import Pengurus.xlsx');?>" download data-toggle="tooltip" data-placement="top" title="Unduh Format Excel"><i class="fas fa-file"></i></a>
                        </div>
                        <div class="btn-group ml-auto" role="group" aria-label="Third group">
                            <button type="button" class="btn btn-primary btn-sm" id="rowAddD"><i class="fa fa-plus mr-2" ></i>Tambah Input</button>
                        </div>
                    </div>
                </div>
            </div>
            <form method="POST" action="<?php echo base_url('admin/akademik/simpan'); ?>" class="needs-validation" novalidate>
                <?= csrf_field();?>
                <div class="form-row align-items-end" id="inputRowD">
                    <div class="form-group col-md-6">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama[]" placeholder="Masukkan nama lengkap beserta gelar" required>
                        <div class="invalid-tooltip">Nama tidak boleh kosong</div>
                    </div>
                    <div class="form-group col-md-5">
                        <label>Id</label>
                        <input type="text" class="form-control" name="id[]" placeholder="Masukkan NIK/NIP/NPI/NIDN" required>
                        <div class="invalid-tooltip">Id tidak boleh kosong</div>
                    </div>
                    <div class="form-group col-md-auto col-sm-12 align-self-md-end align-self-sm-start">
                      <button type="button" class="btn btn-danger mt-0 btn-block" data-toggle="tooltip" data-placement="top" title="Hapus Input" id="rowRemD"><i class="fa fa-trash"></i></button>
                    </div>
                </div>
                <div id="newRowD"></div>
                <div class="row justify-content-center">
                    <div class="col-md-3 col-sm-12">
                        <button type="submit" class="btn btn-success btn-block">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Table Akun -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Akademik</h6>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('admin/akun/hapus');?>" id="form-delete">
                <div class="table-responsive">
                    <table class="table table-striped" id="tableUser" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th scope="row">No</th>
                                <th>Id</th>
                                <th>Nama</th>
                                <th><div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input check-all" id="check-all">
                                <label class="custom-control-label" for="check-all"></label>
                                </div></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($akademiks as $akademik) : ?>
                            <tr>
                                <td></td>
                                <td><?= $akademik->id;?></td>
                                <td><?= $akademik->nama;?></td>
                                <td><div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input check-item" name='id[]' value="<?=$akademik->id_akun?>" id="checkitem<?=$akademik->id_akun?>">
                                <label class="custom-control-label" for="checkitem<?=$akademik->id_akun?>"></label>
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
                <form action="<?= base_url('admin/akademik/import');?>" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
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