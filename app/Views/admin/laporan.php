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
        <li class="breadcrumb-item active" aria-current="page">Laporan</li>
      </ol>
    </nav>

    <!-- Card Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
        <div class="form-row align-items-center justify-content-start">
                <div class="col-md-auto col-sm-12 pt-2"><h6>Filter</h6></div>
                <div class="col-md-auto col-sm-12 py-1">
                    <select class="form-control" id="prodi">
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
        </div>
    </div>

    <!-- Table Pelanggaran -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="tableData" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="row">No</th>
                            <th>Tanggal Lapor</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Pelanggaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lapors as $row) : ?>
                        <tr>
                            <td></td>
                            <td><?= $row->tgl_lapor;?></td>
                            <td><?= $row->nama_mahasiswa;?></td>
                            <td><?= $row->prodi;?></td>
                            <td><?= $row->pelanggaran;?></td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#terimaLapor-<?= $row->id_lapor;?>">
                                    <span class="btn rounded-circle btn-outline-primary btn-sm"><i class="fas fa-check"></i></span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php foreach ($lapors as $row) : ?>
<div class="modal fade" id="terimaLapor-<?= $row->id_lapor;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Terima Laporan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="<?= base_url('laporan/terima');?>" method="POST">
                <input type="hidden" name="id_lapor" value="<?= $row->id_lapor;?>">
                <textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="Masukkan komentar (optional)"></textarea>
            </div>
            <div class="modal-footer">
                <a class="btn" data-dismiss="modal">Batal</a>
                <button type="submit" class="btn btn-success">Terima</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?= $this->endSection();?>