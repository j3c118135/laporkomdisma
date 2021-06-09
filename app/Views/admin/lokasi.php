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
        <li class="breadcrumb-item active" aria-current="page">Lokasi Pelanggaran</li>
      </ol>
    </nav>
    <!-- Tambah Mahasiswa -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Lokasi Pelanggaran</h6>
            
        </div>
        <div class="card-body">
            <div class="row mb-3" >
                <div class="col text-right">
                    <button type="button" class="btn btn-primary btn-sm" id="rowAddL"><i class="fa fa-plus mr-2" ></i>Tambah Input</button>
                </div>
            </div>
            <form method="POST" action="<?php echo base_url('admin/pelanggaran/lokasi/simpan'); ?>" class="needs-validation" novalidate>
                <?= csrf_field();?>
                <div class="align-items-end" id="inputRowL">
                    <div class="form-group row">
                        <label class="col-md-3 col-sm-12 col-form-label">Nama Lokasi Pelanggaran</label>
                        <div class="col-md-8 col-sm-12">
                          <input type="text" class="form-control" name="lokasi[]" required>
                          <div class="invalid-tooltip">Nama lokasi pelanggaran tidak boleh kosong</div>
                        </div>
                        <div class="col-md-auto col-sm-12 align-self-md-end align-self-sm-start">
                        <button type="button" class="btn btn-danger mt-0 btn-block" data-toggle="tooltip" data-placement="top" title="Hapus Input" id="rowRemL"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>
                <div id="newRowL"></div>
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
            <h6 class="m-0 font-weight-bold text-primary">Data Lokasi Pelanggaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle" id="tableData" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="row">No</th>
                            <th>Nama Lokasi Pelanggaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($lokasis as $row) : ?>
                        <tr>
                            <td></td>
                            <td><?= $row->nama;?></td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#edit-<?= $row->id;?>" class="btn rounded-circle btn-outline-primary btn-sm"><i class="fas fa-pen"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php foreach ($lokasis as $lokasi) : ?>

    <div class="modal fade" id="edit-<?= $lokasi->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Lokasi Pelangaran</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <form  method="POST" action="<?= base_url('admin/pelanggaran/lokasi/edit');?>" class="needs-validation" novalidate>
                <?= csrf_field();?>
                    <input type="hidden" name="id_lokasi" value="<?= $lokasi->id;?>" >
                    <div class="form-group">
                        <label>Nama Lokasi Pelanggaran</label>
                        <input type="text" class="form-control" name="nama" value="<?= $lokasi->nama;?>" required>
                        <div class="invalid-feedback">Lokasi tidak boleh kosong</div>
                    </div>
                    <div class="form-group text-right">
                        <a class="btn" data-dismiss="modal">Batal</a>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
        $("#rowAddL").click(function () {
            var html = '';
            html += '<div class="align-items-end" id="inputRowL">';
            html += '<div class="form-group row">';
            html += '<label class="col-md-3 col-sm-12 col-form-label">Nama Lokasi Pelanggaran</label>';
            html += '<div class="col-md-8 col-sm-12">';
            html += '<input type="text" class="form-control" name="lokasi[]" required>';
            html += '<div class="invalid-tooltip">Nama lokasi pelanggaran tidak boleh kosong</div>';
            html += '</div>';
            html += '<div class="col-md-auto col-sm-12 align-self-md-end align-self-sm-start">';
            html += '<button type="button" class="btn btn-danger mt-0 btn-block" data-toggle="tooltip" data-placement="top" title="Hapus Input" id="rowRemL"><i class="fa fa-trash"></i></button>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
            $('#newRowL').append(html);
        });

        // remove row
        $(document).on('click', '#rowRemL', function () {
            $(this).closest('#inputRowL').remove();
        });
</script>


<?= $this->endSection();?>