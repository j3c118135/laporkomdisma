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
        <li class="breadcrumb-item"><a href="<?= base_url('admin/verifikasi');?>">Verifikasi Pelanggaran</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Pelanggaran</li>
      </ol>
    </nav>


     <!-- Card Filter -->
     <div class="card shadow mb-4">
        <div class="card-body">
                <div class="row align-items-center">
				<div class="col-md-4 col-sm-12">
                    <img src="<?= base_url('upload/'.$pelanggaran->bukti_foto);?>" class="img-fluid" width="300">
                </div>
                <div class="col-md-8 col-sm-12">
                <form action="<?= base_url('admin/verifikasi/edit');?>" id="form-normal" method="post" class="needs-validation" novalidate>
                    <input type="hidden" class="form-control" value="<?= $pelanggaran->id_pelanggaran?>" name="id_pelanggaran">
                      <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" class="form-control" disabled value="<?= $pelanggaran->nama_mahasiswa?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">NIM</label>
                            <input type="text" class="form-control" disabled value="<?= $pelanggaran->nim_mahasiswa?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Prodi</label>
                            <input type="text" class="form-control" disabled value="<?= $pelanggaran->prodi?>">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="exampleInputEmail1">Tingkat</label>
                            <input type="text" class="form-control" disabled value="Tingkat <?= $pelanggaran->tingkat?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Tanggal Pelanggaran</label>
                            <input type="text" class="form-control" disabled value="<?php setlocale(LC_TIME, 'id_ID'); echo strftime("%d %B %Y",strtotime($pelanggaran->tanggal));?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Jam</label>
                            <input type="text" class="form-control" disabled value="<?= $pelanggaran->jam?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Pelapor</label>
                            <input type="text" class="form-control" disabled value="<?= $nama_dosen?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Kategori Pelanggaran</label>
                            <input type="text" class="form-control" disabled value="<?= $pelanggaran->nama_kategori?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Jenis Pelanggaran</label>
                            <input type="text" class="form-control" disabled value="<?= $pelanggaran->nama_jenis?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Lokasi</label>
                            <input type="text" class="form-control" disabled value="<?= $pelanggaran->nama_lokasi?>">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="exampleInputEmail1">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="2" disabled><?= $pelanggaran->keterangan?></textarea>
                        </div>
                        <div class="form-group col-md-7">
                            <label for="exampleInputEmail1">Sanksi*</label>
                            <select class="custom-select <?= ($validation->hasError('id_sanksi')) ? "is-invalid" : "";?>" name="id_sanksi" required>
                                <option value="" disabled selected>Pilih...</option>
                                <?php foreach ($sanksis as $sanksi) : ?>
                                <option value="<?= $sanksi->id?>">
                                <span><?= $sanksi->nama?></span>
                                <?= (!empty($sanksi->lapor)) ? ' - '.$sanksi->lapor.'x lapor': ""?>
                                <?= (!empty($sanksi->skorsing)) ? ' - '.$sanksi->skorsing.' hari skorsing' : ""?>
                                <?= (($sanksi->drop_out) == 1) ? '- Drop Out' : ""?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                  Silahkan pilih sanksi
                            </div>
                        </div>
                        <div class="form-group col-md-1 align-self-start">
                            <label class="form-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <a class="btn btn-primary btn-small btn-block" id="btn-collapse" href="#"><i class="fas fa-plus"></i></a>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-auto">
                            <button type="submit" class="btn btn-success btn-block">Verifikasi</button>
                        </div>
                      </div>
                </form>
                <form action="<?= base_url('admin/verifikasi/ubah');?>" id="form-collapse" method="post" class="needs-validation d-none" novalidate>
                      <input type="hidden" class="form-control" value="<?= $pelanggaran->id_pelanggaran?>" name="id_pelanggaran">
                        <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="exampleInputEmail1">Nama</label>
                              <input type="text" class="form-control" disabled value="<?= $pelanggaran->nama_mahasiswa?>">
                          </div>
                          <div class="form-group col-md-4">
                              <label for="exampleInputEmail1">NIM</label>
                              <input type="text" class="form-control" disabled value="<?= $pelanggaran->nim_mahasiswa?>">
                          </div>
                          <div class="form-group col-md-2">
                              <label for="exampleInputEmail1">Prodi</label>
                              <input type="text" class="form-control" disabled value="<?= $pelanggaran->prodi?>">
                          </div>
                          <div class="form-group col-md-2">
                              <label for="exampleInputEmail1">Tingkat</label>
                              <input type="text" class="form-control" disabled value="Tingkat <?= $pelanggaran->tingkat?>">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="exampleInputEmail1">Tanggal Pelanggaran</label>
                              <input type="text" class="form-control" disabled value="<?php setlocale(LC_TIME, 'id_ID'); echo strftime("%d %B %Y",strtotime($pelanggaran->tanggal));?>">
                          </div>
                          <div class="form-group col-md-4">
                              <label for="exampleInputEmail1">Jam</label>
                              <input type="text" class="form-control" disabled value="<?= $pelanggaran->jam?>">
                          </div>
                          <div class="form-group col-md-4">
                              <label for="exampleInputEmail1">Pelapor</label>
                              <input type="text" class="form-control" disabled value="<?= $nama_dosen?>">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                              <label for="exampleInputEmail1">Kategori Pelanggaran</label>
                              <input type="text" class="form-control" disabled value="<?= $pelanggaran->nama_kategori?>">
                          </div>
                          <div class="form-group col-md-4">
                              <label for="exampleInputEmail1">Jenis Pelanggaran</label>
                              <input type="text" class="form-control" disabled value="<?= $pelanggaran->nama_jenis?>">
                          </div>
                          <div class="form-group col-md-4">
                              <label for="exampleInputEmail1">Lokasi</label>
                              <input type="text" class="form-control" disabled value="<?= $pelanggaran->nama_lokasi?>">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                              <label for="exampleInputEmail1">Keterangan</label>
                              <textarea class="form-control" name="keterangan" rows="2" disabled><?= $pelanggaran->keterangan?></textarea>
                          </div>
                          <div class="form-group col-md-5 col-sm-12">
                              <label for="exampleInputEmail1">Nama Sanksi*</label>
                              <input type="text" class="form-control" name="nama_sanksi" placeholder="Masukkan nama sanksi" required>
                              <div class="invalid-feedback">Nama sanksi tidak boleh kosong</div>
                          </div>
                          <div class="form-group col-md-2 col-sm-12">
                              <label for="exampleInputEmail1">Lapor*</label>
                              <input type="number" class="form-control" name="lapor" value="0">
                              <div class="invalid-feedback">Lapor tidak boleh kosong</div>
                          </div>
                          <div class="form-group col-md-2 col-sm-12">
                              <label for="exampleInputEmail1">Skorsing*</label>
                              <input type="number" class="form-control" name="skorsing" value="0">
                              <div class="invalid-feedback">Skorsing tidak boleh kosong</div>
                          </div>
                          <div class="form-group col-md-2 col-sm-12">
                              <label for="exampleInputEmail1">Drop Out*</label>
                              <select class="custom-select" name="drop_out">
                                  <option value="0" selected>Tidak</option>
                                  <option value="1" >Ya</option>
                              </select>
                              <div class="invalid-feedback">Drop out tidak boleh kosong</div>
                          </div>
                          <div class="form-group col-md-1 col-sm-12 align-self-start">
                            <label class="form-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <a class="btn btn-primary btn-small btn-block" href="#" id="btn-hidden" ><i class="fas fa-minus"></i></a>
                          </div>
                        </div>
                      <div class="form-row">
                        <div class="form-group col-md-auto">
                            <button type="submit" class="btn btn-success btn-block">Verifikasi</button>
                        </div>
                      </div>
                  </form>
                </div>
				</div>
        </div>
     </div>

     <div class="accordion mb-4" id="accordionExample">
        <!-- Daftar Pelanggaran -->
        <div class="card">
          <div class="card-header p-0 bg-blue" id="headingOne">
            <h6 class="m-0">
              <button class="btn btn-block text-white text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              <i class="fas fa-angle-down mr-3"></i>Daftar pelanggaran mahasiswa
              </button>
            </h6>
          </div>

          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Id</th>
                      <th scope="col">Tanggal</th>
                      <th scope="col">Jam</th>
                      <th scope="col">Lokasi</th>
                      <th scope="col">Kategori Pelanggaran</th>
                      <th scope="col">Jenis Pelanggaran</th>
                      <th scope="col">Keterangan</th>
                      <th scope="col">Sanksi</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $no = 1;
                        foreach ($pelanggarans as $row) : ?>
                    <tr>
                      <td><?= $no++;?></td>
                      <td><?= $row->id_pelanggaran?></td>
                      <td><?= $row->tanggal;?></td>
                      <td><?= $row->jam;?></td>
                      <td><?= $row->nama_lokasi;?></td>
                      <td><?= $row->nama_kategori;?></td>
                      <td><?= $row->nama_jenis;?></td>
                      <td><?= $row->keterangan;?></td>
                      <td><?= (empty($row->nama_sanksi)) ? "<span class='text-danger'>Perlu verifikasi</span>" : $row->nama_sanksi;?></td>
                      <td>
                      <?php 
                            if ($row->status == "Menunggu"){
                                    echo '<span class="badge badge-outline-danger">Menunggu</span>';
                                } elseif ($row->status == "Drop Out"){
                                    echo '<span class="badge badge-outline-danger">Drop Out</span>';
                                } elseif ($row->status == "Belum mengisi jadwal" OR $row->status == "Jadwal belum lengkap"){
                                    echo "<span class='badge badge-outline-warning'>Proses</span>";
                                } elseif ($row->status == "Proses"){
                                    echo '<span class="badge badge-outline-warning">Proses</span>';
                                } elseif ($row->status == "Sedang diskors"){
                                    echo '<span class="badge badge-outline-warning">Sedang diskors</span>';
                                } elseif ($row->status == "Selesai"){
                                    echo '<span class="badge badge-outline-success">Selesai</span>';
                              }
                        ?>
                      </td>
                    </tr>
                    <?php endforeach;
                          if(empty($pelanggarans)) { ?>
                          <tr><td colspan="9" class="text-center">Tidak ada pelanggaran</td></tr>

                    <?php   } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- End Daftar Pelanggaran -->
        <!-- Daftar Skorsing Mahasiswa -->
        <div class="card">
          <div class="card-header p-0 bg-blue" id="headingOne">
            <h6 class="m-0">
              <button class="btn btn-block text-white text-left" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseOne">
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

<?= $this->endSection();?>