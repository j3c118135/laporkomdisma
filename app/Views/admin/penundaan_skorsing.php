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
        <li class="breadcrumb-item active" aria-current="page">Penundaan Skorsing Mahasiswa</li>
      </ol>
    </nav>

     <!-- Card Filter -->
     <div class="card shadow mb-4">
        <div class="card-body">
            <form>
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
            </form>
        </div>
    </div>

    <!-- Table Pelanggaran -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-striped" id="tablePenundaan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="row">No</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>NIM</th>
                            <th>Keperluan</th>
                            <th>Inspektur</th>
                            <th>Komentar</th>
                            <th>Status</th>
                            <th class="w-10">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php $no=1; foreach ($skorsings as $skorsing): 
                        ?>
                        <tr>
                            <td><?= $no++?></td>
                            <td><?= $skorsing->tgl_pengajuan;?></td>
                            <td><?= $skorsing->nama;?></td>
                            <td><?= $skorsing->prodi;?></td>
                            <td><?= $skorsing->nim;?></td>
                            <td><?= $skorsing->keterangan?></td>
                            <td><?= (!empty($skorsing->nama_inspektur)) ? $skorsing->nama_inspektur : "<span class='text-danger'>Belum diverifikasi</span>";?></td>
                            <td><?= (!empty($skorsing->komentar)) ? $skorsing->komentar : "-";?></td>
                            <td>
                                <?php 
                                    if (($skorsing->status == 0) && empty($skorsing->komentar)){
                                      echo "<span class='badge badge-outline-danger'>Menunggu verifikasi</span>";
                                    } elseif ($skorsing->status == 0 && !empty($skorsing->komentar)){
                                        echo "<span class='badge badge-outline-secondary'>Ditolak</span>";
                                      } else{
                                        echo "<span class='badge badge-outline-success'>Diterima</span>";
                                      } 
                                ?>
                            </td>
                            <td>
                                <?php if (($skorsing->status == 1) || !empty($skorsing->komentar)){?>
                                    <button class="btn rounded-circle btn-outline-secondary btn-sm mr-1" disabled><i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn rounded-circle btn-outline-secondary btn-sm" disabled><i class="fas fa-times px-15"></i>
                                    </button>
                                <?php } else {?>
                                    <a href="#" data-toggle="modal" data-target="#verifPenundaan-<?= $skorsing->id;?>">
                                        <span class="btn rounded-circle btn-outline-primary btn-sm mr-1"><i class="fas fa-check"></i></span>
                                    </a>
                                    <a href="#" class="btn rounded-circle btn-outline-danger btn-sm" data-toggle="modal" data-target="#tolakPenundaan-<?= $skorsing->id;?>"><i class="fas fa-times px-15"></i>
                                    </a>
                                </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php foreach ($skorsings as $skorsing):?>
<div class="modal fade" id="verifPenundaan-<?= $skorsing->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verifikasi Penundaan Skorsing</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
            <table border="0">
                <tr>
                    <td colspan="3" class="pb-2">Menyetujui pengajuan penundaan skorsing dari mahasiswa berikut :</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><?= $skorsing->nama;?></td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td><?= $skorsing->nim;?></td>
                </tr>
                <tr>
                    <td>Program Studi</td>
                    <td>:</td>
                    <td><?= $skorsing->prodi;?></td>
                </tr>
                <tr>
                    <td colspan="3" class="pt-2">Yang mengajukan penundaan pada <span class="font-weight-bold"><?php
                    setlocale(LC_TIME, 'id_ID');
                    echo strftime("%A, %d %B %Y",strtotime($skorsing->tanggal));
                    ?></span></td>
                </tr>
                <tr>
                    <td colspan="3" class="pt-2">Untuk keperluan <span class="font-weight-bold"><?= $skorsing->keterangan;?></span></td>
                </tr>
            </table>
            <form action="<?= base_url('admin/skorsing/penundaan/terima');?>" method="POST">
                <input type="hidden" name="id" value="<?= $skorsing->id?>">
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
    <div class="modal fade" id="tolakPenundaan-<?= $skorsing->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verifikasi Penundaan Skorsing</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/skorsing/penundaan/tolak');?>" method="POST" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $skorsing->id?>">
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