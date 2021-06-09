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
        <li class="breadcrumb-item active" aria-current="page">Surat Keterangan Berkelakuan Baik</li>
      </ol>
    </nav>
    <?php if ($statusPelanggaran == FALSE){ ?>
    <div class="alert alert-danger" role="alert">
          <div class="d-flex align-items-center" href="#">
              <div class="mr-3">
                    <i class='bx bxs-lock-alt h2 mb-0'></i>
              </div>
              <div>
                  <span class="font-weight-bold h6 mb-0">Anda belum diijinkan mengajukan Surat Keterangan Berkelakuan Baik</span>
                  <div class="">Silahkan selesaikan dahulu semua pelanggaran anda</div>
              </div>
          </div>
    </div>
    <?php } elseif (($statusPelanggaran == TRUE AND $pengajuanTerakhir['result'] == TRUE AND $pengajuanTerakhir['status'] == 1 )){?>
    <!-- Card Filter -->
    <div class="row">
        <div class="col-md-8">
        <div class="card shadow mb-4">
                <div class="card-header bg-blue">
                    <h6 class="m-0 font-weight-bold">Pengajuan Surat Keterangan Berkelakuan Baik</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo base_url('mahasiswa/surat/pengajuan'); ?>" class="needs-validation" novalidate>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label>Nama</label>
                                <input type="text" class="form-control" value="<?= $user->nama?>" disabled>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label>NIM</label>
                                <input type="text" class="form-control" value="<?= $user->nim?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Keperluan</label>
                            <textarea class="form-control" name="keperluan" id="keperluan" rows="2" placeholder="Masukkan keperluan pembuatan surat" required></textarea>
                            <div class="invalid-feedback">Keperluan tidak boleh kosong</div>
                        </div>
                        <button class="btn btn-success">Ajukan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } elseif (($statusPelanggaran == TRUE AND $pengajuanTerakhir['result'] == TRUE AND $pengajuanTerakhir['status'] == 0 AND !empty($pengajuanTerakhir['komentar']))){?>
        <div class="alert alert-warning shadow" role="alert">
          <div class="d-flex align-items-center" href="#">
              <div class="mr-3">
                    <i class='bx bx-info-circle h2 mb-0'></i>
              </div>
              <div>
                  <span class="font-weight-bold h6 mb-0">Pengajuan surat keterangan berkelakuan baik tanggal <?php setlocale(LC_TIME, 'id_ID'); echo strftime("%d %B %Y",strtotime($pengajuanTerakhir['tgl_pengajuan']));?> ditolak! Silahkan ajukan kembali</span>
                  <div>Alasan ditolak: <?= $pengajuanTerakhir['komentar'];?></div>
              </div>
          </div>
      </div>
    <!-- Card Filter -->
    <div class="row">
        <div class="col-md-8">
        <div class="card shadow mb-4">
                <div class="card-header bg-blue">
                    <h6 class="m-0 font-weight-bold">Pengajuan Surat Keterangan Berkelakuan Baik</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?php echo base_url('mahasiswa/surat/pengajuan'); ?>" class="needs-validation" novalidate>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label>Nama</label>
                                <input type="text" class="form-control" value="<?= $user->nama?>" disabled>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label>NIM</label>
                                <input type="text" class="form-control" value="<?= $user->nim?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Keperluan</label>
                            <textarea class="form-control" name="keperluan" id="keperluan" rows="2" placeholder="Masukkan keperluan pembuatan surat" required></textarea>
                            <div class="invalid-feedback">Keperluan tidak boleh kosong</div>
                        </div>
                        <button class="btn btn-success">Ajukan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } elseif ($statusPelanggaran == TRUE AND $pengajuanTerakhir['result'] == FALSE AND $pengajuanTerakhir['status'] == 0 AND empty($pengajuanTerakhir['komentar'])){?>
    <div class="row">
        <div class="col-md-8">
        <div class="card shadow mb-4">
                <div class="card-header bg-blue">
                    <h6 class="m-0 font-weight-bold">Pengajuan Surat Keterangan Berkelakuan Baik</h6>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label>Nama</label>
                                <input type="text" class="form-control" value="<?= $user->nama?>" disabled>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label>NIM</label>
                                <input type="text" class="form-control" value="<?= $user->nim?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Keperluan</label>
                            <textarea class="form-control" name="keperluan" id="keperluan" rows="2" disabled><?= $pengajuanTerakhir['keperluan'];?></textarea>
                        </div>
                        <small class="form-text">
                          <i class="fas fa-exclamation-circle mr-1"></i>Pengajuan surat keterangan berkelakuan baik menunggu diverifikasi
                          </small>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } elseif ($statusPelanggaran == TRUE  AND $pengajuanTerakhir['result'] == FALSE AND $pengajuanTerakhir['status'] == 1){?>
    <div class="row">
        <div class="col-md-8">
        <div class="card shadow mb-4"> 
                <div class="card-body">
                    <form method="POST" action="<?php echo base_url('mahasiswa/surat/unduh'); ?>" class="needs-validation" novalidate>
                    <input type="hidden" name="prodi" value="<?= $prodi?>">
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label>Nama</label>
                                <input type="text" class="form-control" value="<?= $user->nama?>" disabled>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label>NIM</label>
                                <input type="text" class="form-control" value="<?= $user->nim?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tempat, tanggal lahir</label>
                            <input type="text" class="form-control" placeholder="Bogor, 25 April 2000" name="ttl" required>
                            <div class="invalid-feedback">Tempat tanggal lahir tidak boleh kosong</div>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
                            <div class="invalid-feedback">Alamat tidak boleh kosong</div>
                        </div>
                        <button class="btn btn-success">Unduh surat</button>
                    </form>
                    <small class="form-text">
                          <i class="fas fa-exclamation-circle mr-1"></i>Surat berlaku sampai dengan tanggal <?php setlocale(LC_TIME, 'id_ID'); echo strftime("%d %B %Y",strtotime($pengajuanTerakhir['tgl_berakhir']));?>
                          </small>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

     
</div>
<?= $this->endSection();?>