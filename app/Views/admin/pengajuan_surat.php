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
        <li class="breadcrumb-item active" aria-current="page">Pengajuan Surat Keterangan Kelakuan Baik</li>
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
                <div class="col-md-auto col-sm-12 py-1">
                    <select class="form-control" id="status">
                        <option value="" selected>Semua Status</option>
                        <option value="Menunggu verifikasi">Menunggu verifikasi</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Pelanggaran -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="tablePengajuan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="row">No</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>NIM</th>
                            <th>Keperluan</th>
                            <th>Tanggal Berakhir</th>
                            <th>Inspektur</th>
                            <th>Komentar</th>
                            <th>Status</th>
                            <th class="w-10">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pengajuanSurat as $row) : ?>
                        <tr>
                            <td></td>
                            <td><?= $row->tgl_pengajuan;?></td>
                            <td><?= $row->nama;?></td>
                            <td><?= $row->prodi;?></td>
                            <td><?= $row->nim;?></td>
                            <td><?= $row->keperluan;?></td>
                            <td>
                                <?php if (!empty($row->tgl_berakhir) && empty($row->komentar)){
                                echo $row->tgl_berakhir;
                                } elseif (empty($row->tgl_berakhir) && !empty($row->komentar)) {
                                    echo "-";
                                } else {
                                    echo "<span class='text-danger'>Belum diverifikasi</span>";
                                }?>
                            </td>
                            <td>
                                <?= (!empty($row->nama_inspektur)) ? $row->nama_inspektur : "<span class='text-danger'>Belum diverifikasi</span>" ;?>
                            </td>
                            <td><?= (!empty($row->komentar)) ? $row->komentar : "-";?></td>
                            <td>
                                <?php 
                                    if ($row->status == 0 && empty($row->komentar)){
                                        echo "<span class='badge badge-outline-danger'>Menunggu verifikasi</span>";
                                      } elseif ($row->status == 0 && !empty($row->komentar)){
                                        echo "<span class='badge badge-outline-secondary'>Ditolak</span>";
                                      }else{
                                        echo "<span class='badge badge-outline-success'>Diterima</span>";
                                      } 
                                ?>
                            </td>
                            <td>
                                <?php if ($row->status == 1 || !empty($row->komentar)){?>
                                    <button class="btn rounded-circle btn-outline-secondary btn-sm mr-1" disabled><i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn rounded-circle btn-outline-secondary btn-sm" disabled><i class="fas fa-times px-15"></i>
                                    </button>
                                <?php } else {?>
                                    <a href="#" class="btn rounded-circle btn-outline-primary btn-sm mr-1" data-toggle="modal" data-target="#verifPengajuan-<?= $row->id;?>"><i class="fas fa-check"></i>
                                    </a>
                                    <a href="#" class="btn rounded-circle btn-outline-danger btn-sm" data-toggle="modal" data-target="#tolakPengajuan-<?= $row->id;?>"><i class="fas fa-times px-15"></i>
                                    </a>
                                </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php foreach ($pengajuanSurat as $row) : ?>
<div class="modal fade" id="verifPengajuan-<?= $row->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verifikasi Pengajuan Surat</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="<?= base_url('admin/surat/terima');?>" method="POST" class="needs-validation" novalidate>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $row->id;?>">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" value="<?= $row->nama?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>NIM</label>
                        <input type="text" class="form-control" value="<?= $row->nim?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Program Studi</label>
                        <input type="text" class="form-control" value="<?= $row->prodi?>" disabled>
                    </div>
                    <div class="form-group">
                        <label>Keperluan</label>
                        <textarea class="form-control" name="keperluan" rows="2" disabled><?= $row->keperluan;?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Berakhir Masa Berlaku Surat</label>
                        <input type="date" class="form-control" name="tgl_berakhir" required>
                        <div class="invalid-feedback">Tanggal berakhir tidak boleh kosong</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn" data-dismiss="modal">Batal</a>
                    <button type="submit" class="btn btn-success">Setuju</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tolak Pengajuan -->
    <div class="modal fade" id="tolakPengajuan-<?= $row->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verifikasi Pengajuan Surat</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/surat/tolak');?>" method="POST" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $row->id;?>">
                        <div class="form-group">
                            <label>Alasan Penolakan</label>
                            <textarea class="form-control" rows="3" placeholder="Masukkan alasan penolakan" name="komentar" required></textarea>
                            <div class="invalid-feedback">Alasan penolakan tidak boleh kosong</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn" data-dismiss="modal">Batal</a>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?= $this->endSection();?>