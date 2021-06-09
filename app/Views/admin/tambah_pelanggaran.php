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
        <li class="breadcrumb-item active" aria-current="page"><?= $title; ?></li>
      </ol>
    </nav>

    <!-- Tambah Pelanggaran Mahasiswa -->
    <div class="card shadow mb-4">
        <div class="card-header bg-blue">
            <h6 class="m-0 font-weight-bold">Tambah Pelanggaran</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo base_url('pelanggaran/simpan'); ?>" enctype="multipart/form-data">
                <?= csrf_field();?>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right text-sm-left">NIM</label>
                    <div class="col-md-6">
                    <input type="text" class="form-control" value="<?= (!empty($mahasiswa)) ? $mahasiswa->nim : old('nim'); ?>"  disabled>
                    <input type="hidden" class="form-control" name="nim" value="<?= (!empty($mahasiswa)) ? $mahasiswa->nim : old('nim'); ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right text-sm-left">Nama</label>
                    <div class="col-md-6">
                    <input type="text" class="form-control" name="nama" value="<?= (!empty($mahasiswa)) ? $mahasiswa->nama : old('nama'); ?>" disabled>
                    <input type="hidden" class="form-control" name="nama" value="<?= (!empty($mahasiswa)) ? $mahasiswa->nama : old('nama'); ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right text-sm-left">Program Studi</label>
                    <div class="col-md-6">
                    <input type="text" class="form-control" name="prodi" value="<?= (!empty($mahasiswa)) ? $mahasiswa->prodi : old('prodi'); ?>" disabled>
                    <input type="hidden" class="form-control" name="prodi" value="<?= (!empty($mahasiswa)) ? $mahasiswa->prodi : old('prodi'); ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right text-sm-left">Tanggal Pelanggaran*</label>
                    <div class="col-md-auto">
                    <input type="date" format="yy-mm-dd" class="form-control <?= ($validation->hasError('tanggal')) ? "is-invalid" : ""?>" name="tanggal" value="<?= old('tanggal'); ?>">
                      <div class="invalid-feedback">
                        <?= $validation->getError('tanggal')?>
                      </div>
                    </div>
                    <label class="col-md-auto col-form-label text-md-right text-sm-left">Jam Pelanggaran*</label>
                    <div class="col-md-2">
                    <input type="time" class="form-control <?= ($validation->hasError('jam')) ? "is-invalid" : ""?>" name="jam" value="<?= old('jam'); ?>">
                      <div class="invalid-feedback">
                        <?= $validation->getError('jam')?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right text-sm-left">Tingkat Mahasiswa*</label>
                    <div class="col-md-6">
                    <select class="custom-select <?= ($validation->hasError('tingkat')) ? "is-invalid" : ""?>" name="tingkat" id="tingkat">
                              <option selected disabled>Pilih...</option>
                              <option value="1" <?= set_select('tingkat', '1') ?>>Tingkat 1</option>
                              <option value="2" <?= set_select('tingkat', '2') ?>>Tingkat 2</option>
                              <option value="3" <?= set_select('tingkat', '3') ?>>Tingkat 3</option>
                    </select>
                    <div class="invalid-feedback">
                      <?= $validation->getError('tingkat')?>
                    </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right text-sm-left">Lokasi Pelanggaran*</label>
                    <div class="col-md-6">
                      <select class="custom-select <?= ($validation->hasError('lokasi')) ? "is-invalid" : ""?>" name="lokasi" id="lokasi">
                                <option value="" selected disabled>Pilih...</option>
                                <?php foreach ($lokasis as $lokasi):?>
                                  <option value="<?= $lokasi->id?>" <?= set_select('lokasi', $lokasi->id) ?>><?= $lokasi->nama?></option>
                                <?php endforeach;?>
                      </select>
                      <div class="invalid-feedback">
                        <?= $validation->getError('lokasi')?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right text-sm-left">Kategori Pelanggaran*</label>
                    <div class="col-md-6">
                      <select class="custom-select <?= ($validation->hasError('kategoriP')) ? "is-invalid" : ""?>" name="kategoriP" id="kategoriP">
                          <option selected disabled value="">Pilih...</option>
                          <?php foreach ($Kpelanggarans as $Kpelanggaran):?>
                              <option value="<?= $Kpelanggaran->id?>" <?= set_select('kategoriP', $Kpelanggaran->id) ?>>Pelanggaran <?= $Kpelanggaran->nama?></option>
                          <?php endforeach;?>
                      </select>
                      <div class="invalid-feedback">
                        <?= $validation->getError('kategoriP')?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right text-sm-left">Jenis Pelanggaran*</label>
                    <div class="col-md-6">
                    <select class="custom-select <?= ($validation->hasError('jenisP')) ? "is-invalid" : ""?>" name="jenisP" id="jenisP">
                    <?php if (!empty(old('jenisP')) AND !empty(old('kategoriP'))) { ?>
                          <option disabled value="">Pilih...</option>
                          <?php foreach ($Jpelanggarans as $Jpelanggaran) :?>
                          <option value='<?= $Jpelanggaran->id?>' <?= (($Jpelanggaran->id) == (old('jenisP'))) ? "selected" : "";?>><?= $Jpelanggaran->nama?></option>
                      <?php endforeach; 
                      }elseif (empty(old('jenisP')) AND !empty(old('kategoriP'))) {?>
                        <option selected disabled value="">Pilih...</option>
                        <?php foreach ($Jpelanggarans as $Jpelanggaran) :?>
                      <option value='<?= $Jpelanggaran->id?>'><?= $Jpelanggaran->nama?></option>
                      <?php endforeach;
                      } elseif (empty(old('jenisP')) AND empty(old('kategoriP'))){?>
                      <option selected disabled value="">Pilih...</option>
                    <?php } ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('jenisP')?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right text-sm-left">Keterangan*</label>
                    <div class="col-md-6">
                      <textarea class="form-control <?= ($validation->hasError('keterangan')) ? "is-invalid" : ""?>" name="keterangan" id="keterangan" rows="2" placeholder="Rambut Gondrong"><?= old('keterangan')?></textarea>
                      <div class="invalid-feedback">
                        <?= $validation->getError('keterangan')?>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right text-sm-left">Bukti Foto*</label>
                    <div class="col-md-6">
                      <input type="file" class="form-control <?= ($validation->hasError('bukti_foto')) ? "is-invalid" : ""?>" name="bukti_foto" id="bukti_foto">
                      <div class="invalid-feedback">
                        <?= $validation->getError('bukti_foto')?>
                      </div>
                      <small class="form-text"><i class="fas fa-exclamation-circle mr-1"></i>File harus foto dengan ukuran kurang dari 200kb</small>
                    </div>
                  </div>
                  <div class="row">
                    <div class="container my-4 px-4">

                    <div class="accordion" id="accordionExample">
                        <!-- Daftar Pelanggaran -->
                        <div class="card">
                          <div class="card-header p-0 " id="headingOne">
                            <h6 class="m-0">
                              <button class="btn btn-block text-light-blue text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                              <i class="fas fa-angle-down mr-3"></i>Daftar pelanggaran mahasiswa
                              </button>
                            </h6>
                          </div>

                          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                            <?php if(empty($pelanggarans)){ ?>
                              <h6 class="text-center">Tidak ada pelanggaran</h6>
                            <?php } else {?>
                                <div class="table-responsive">
                                  <table class="table">
                                    <thead>
                                      <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Id Pelanggaran</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Lokasi</th>
                                        <th scope="col">Kategori Pelanggaran</th>
                                        <th scope="col">Jenis Pelanggaran</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Bukti</th>
                                        <th scope="col">Status</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                      $no=1;
                                      foreach ($pelanggarans as $pelanggaran) :
                                    ?>
                                      <tr>
                                        <td><?= $no++;?></td>
                                        <td><?= $pelanggaran->id_pelanggaran;?></td>
                                        <td><?= $pelanggaran->tanggal;?></td>
                                        <td><?= $pelanggaran->nama_lokasi;?></td>
                                        <td><?= $pelanggaran->nama_kategori;?></td>
                                        <td><?= $pelanggaran->nama_jenis;?></td>
                                        <td><?= $pelanggaran->keterangan;?></td>
                                        <td><img src="<?= base_url('upload/'.$pelanggaran->bukti_foto);?>" class="img-fluid" width="75"></td>
                                        <td>
                                        <?php 
                                              if ($pelanggaran->status == "Menunggu"){
                                                      echo '<span class="badge badge-outline-danger">Menunggu verifikasi</span>';
                                                  } elseif ($pelanggaran->status == "Drop Out"){
                                                      echo '<span class="badge badge-outline-danger">Drop Out</span>';
                                                  } elseif ($pelanggaran->status == "Belum mengisi jadwal" OR $pelanggaran->status == "Jadwal belum lengkap"){
                                                      echo "<span class='badge badge-outline-warning'>Proses</span>";
                                                  } elseif ($pelanggaran->status == "Proses"){
                                                      echo '<span class="badge badge-outline-warning">Proses</span>';
                                                  } elseif ($pelanggaran->status == "Sedang diskors"){
                                                      echo '<span class="badge badge-outline-warning">Sedang diskors</span>';
                                                  } elseif ($pelanggaran->status == "Selesai"){
                                                      echo '<span class="badge badge-outline-success">Selesai</span>';
                                                }
                                          ?>
                                        </td>
                                      </tr>
                                    <?php
                                      endforeach;
                                    ?>
                                    </tbody>
                                  </table>
                                </div>
                            <?php } ?> 
                            </div>
                          </div>
                        </div>
                        <!-- End Daftar Pelanggaran -->
                        <!-- Daftar Skorsing Mahasiswa -->
                        <div class="card">
                          <div class="card-header p-0 " id="headingOne">
                            <h6 class="m-0">
                              <button class="btn btn-block text-light-blue text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
                              <i class="fas fa-angle-down mr-3"></i>Daftar skorsing mahasiswa
                              </button>
                            </h6>
                          </div>

                          <div id="collapseTwo" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <div class="card-body">
                            <?php if(empty($skorsings)){ ?>
                              <h6 class="text-center">Tidak ada skorsing</h6>
                            <?php } else {?>
                            <div class="table-responsive">
                                <table class="table">
                                  <thead>
                                      <tr>
                                          <th scope="row">No</th>
                                          <th>Id Pelanggaran</th>
                                          <th>Nama</th>
                                          <th>Prodi</th>
                                          <th>Tanggal Berakhir</th>
                                          <th>Lama Skorsing</th>
                                          <th>Status</th>
                                      </tr>
                                  </thead>
                                  <tbody>

                                  <?php $no = 1;
                                   foreach ($skorsings as $skorsing): 
                                      ?>
                                      <tr>
                                          <td class="align-middle"><?= $no++;?></td>
                                          <td class="align-middle"><?= $skorsing->pelanggaran_id;?></td>
                                          <td class="align-middle"><?= $skorsing->nama_mahasiswa;?></td>
                                          <td class="align-middle"><?= $skorsing->prodi;?></td>
                                          <td class="align-middle"><?= (!empty($skorsing->tgl_berakhir)) ? $skorsing->tgl_berakhir : "00/00/0000";?></td>
                                          <td class="align-middle"><?= $skorsing->jum_hari?> Hari</td>
                                          <td class="align-middle">
                                              <?php 
                                                  if ($skorsing->status == "Belum mengisi jadwal"){
                                                    echo "<span class='badge badge-outline-danger'>$skorsing->status</span>";
                                                    } elseif ($skorsing->status == "Skorsing belum dimulai"){
                                                      echo "<span class='badge badge-outline-secondary'>$skorsing->status</span>";
                                                    } elseif ($skorsing->status == "Sedang diskors"){
                                                      echo "<span class='badge badge-outline-warning'>$skorsing->status</span>";
                                                    } elseif ($skorsing->status == "Selesai"){
                                                      echo "<span class='badge badge-outline-success'>Skorsing selesai</span>";
                                                    }
                                              ?>
                                          </td>
                                      </tr>
                                      <?php endforeach; ?>
                                  </tbody>
                              </table>
                              </div>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                        <!-- End Daftar Skorsing Mahasiswa -->
                    </div>
                    </div>
                  </div>
                  <div class="form-group row justify-content-center">
                    <div class="col-md-6 col-sm-12 text-center">
                        <button class="btn btn-success btn-block">Simpan</button>
                    </div>
                  </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection();?>