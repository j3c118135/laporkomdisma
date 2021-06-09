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
        <li class="breadcrumb-item active" aria-current="page">Jenis Pelanggaran</li>
      </ol>
    </nav>

    <!-- Tambah jenis pelanggaran -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Jenis Pelanggaran</h6>
            
        </div>
        <div class="card-body">
            <div class="row mb-3" >
                <div class="col text-right">
                    <button type="button" class="btn btn-primary btn-sm" id="rowAddJ"><i class="fa fa-plus mr-2" ></i>Tambah Input</button>
                </div>
            </div>
            <form method="POST" action="<?php echo base_url('admin/pelanggaran/jenis/simpan'); ?>" class="needs-validation" novalidate>
                <?= csrf_field();?>
                <div class="form-row align-items-end" id="inputRowJ">
                    <div class="form-group col-md-6">
                        <label>Kategori Pelanggaran</label>
                        <select class="custom-select" name="kategori[]" required>
                        <option value="" selected disabled>Pilih...</option>
                        <?php foreach($Kpelanggarans as $row): ?>
                            <option value="<?= $row->id?>">Pelanggaran <?= $row->nama?></option>
                        <?php endforeach; ?>
                        </select>
                        <div class="invalid-tooltip">Silahkan pilih kategori pelangaran</div>
                    </div>
                    <div class="form-group col-md-5">
                        <label>Jenis Pelanggaran</label>
                        <input type="text" class="form-control" name="jenis[]" placeholder="Masukkan jenis pelanggaran" required>
                        <div class="invalid-tooltip">Jenis pelanggaran tidak boleh kosong</div>
                    </div>
                    <div class="form-group col-md-auto col-sm-12 align-self-md-end align-self-sm-start">
                      <button type="button" class="btn btn-danger mt-0 btn-block" data-toggle="tooltip" data-placement="top" title="Hapus Input" id="rowRemJ"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
                <div id="newRowJ"></div>
                <div class="row justify-content-center">
                        <div class="col-md-3 col-sm-12">
                        <button type="submit" class="btn btn-success btn-block">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table jenis pelanggaran -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Jenis Pelanggaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle" id="tableData" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="row">No</th>
                            <th>Kategori Pelanggaran</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($Jpelanggarans as $row) : ?>
                        <tr>
                            <td></td>
                            <td><?= $row->nama_kategori;?></td>
                            <td><?= $row->nama_jenis;?></td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#edit-<?= $row->id_jenis;?>" class="btn rounded-circle btn-outline-primary btn-sm"><i class="fas fa-pen"></i></a>
                            </td>
                        </tr>
                    <?php  endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit jenis pelanggaran -->
<?php foreach ($Jpelanggarans as $jenis) : ?>
    <div class="modal fade" id="edit-<?= $jenis->id_jenis;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Jenis Pelanggaran</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="<?= base_url('admin/pelanggaran/jenis/edit');?>" method="POST" class="needs-validation" novalidate>
                <?= csrf_field();?>
                    <input type="hidden" name="id_jenis" value="<?= $jenis->id_jenis;?>">
                    <div class="form-group">
                        <label>Kategori Pelanggaran</label>
                        <select class="custom-select" name="kategori" id="kategori" required>
                        <option value="" selected disabled>Pilih...</option>
                        <?php foreach($Kpelanggarans as $kategori): ?>
                            <option value="<?= $kategori->id?>" <?= ($kategori->id == $jenis->id_kategori) ? "selected" : "";?>>Pelanggaran <?= $kategori->nama?></option>
                        <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Silahkan pilih kategori pelangaran</div>
                    </div>
                    <div class="form-group">
                        <label>Jenis Pelanggaran</label>
                        <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Masukkan jenis pelanggaran" value="<?= $jenis->nama_jenis;?>" required>
                        <div class="invalid-feedback">Jenis pelanggaran tidak boleh kosong</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn" data-dismiss="modal">Batal</a>
                    <button type="submit" id="btn-lokasi" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Add form dynamic insert jenis pelanggaran -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
        $("#rowAddJ").click(function () {
            var html = '';
            html += '<div class="form-row align-items-end" id="inputRowJ">';
            html += '<div class="form-group col-md-6">';
            html += '<label>Kategori Pelanggaran</label>';
            html += '<select class="custom-select" name="kategori[]" required>';
            html += '<option value="" selected disabled>Pilih...</option>';
            html += '<?php foreach($Kpelanggarans as $row): ?><option value="<?= $row->id?>">Pelanggaran <?= $row->nama?></option><?php endforeach; ?>';
            html += '</select>';
            html += '<div class="invalid-tooltip">Silahkan pilih kategori pelanggaran</div>';
            html += '</div>';
            html += '<div class="form-group col-md-5">';
            html += '<label>Jenis Pelanggaran</label>';
            html += '<input type="text" class="form-control" name="jenis[]" placeholder="Masukkan jenis pelanggaran" required>';
            html += '<div class="invalid-tooltip">Jenis pelanggaran tidak boleh kosong</div>';
            html += '</div>';
            html += '<div class="form-group col-md-auto col-sm-12 align-self-md-end align-self-sm-start">';
            html += '<button type="button" class="btn btn-danger mt-0 btn-block" data-toggle="tooltip" data-placement="top" title="Hapus Input" id="rowRemJ"><i class="fa fa-trash"></i></button>';
            html += '</div>';
            html += '</div>';
            $('#newRowJ').append(html);
        });

        // remove row
        $(document).on('click', '#rowRemJ', function () {
            $(this).closest('#inputRowJ').remove();
        });
</script>
<?= $this->endSection();?>