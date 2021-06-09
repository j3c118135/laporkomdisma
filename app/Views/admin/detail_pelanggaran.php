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
        <li class="breadcrumb-item"><a href="<?= base_url('admin/pelanggaran');?>">Pelanggaran Mahasiswa</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Pelanggaran</li>
      </ol>
    </nav>

     <!-- Profile -->
    <div class="row">
      <div class="col-md-2 col-sm-12">
       <div class="card shadow mb-4">
            <div class="card-header bg-blue">
                <h6 class="m-0 font-weight-bold">Profile</h6>
            </div>
            <div class="card-body">
                <div class="row align-items-center justify-content-center">
                    <img src="<?= base_url('upload/'.$pelanggaran->foto);?>" class="img-thumbnail border-0">
                    <ul class="text-center px-0 pt-3 profile">
                          <li><h6 class="font-weight-bold"><?= $pelanggaran->nama_mahasiswa;?></h6></li>
                          <li><h6><?= $pelanggaran->nim_mahasiswa;?></h6></li>
                          <li><h6><?= $pelanggaran->prodi;?></h6></li>
                    </ul>
                </div>
            </div>
         </div>
      </div>

      <div class="col-md-10 col-sm-12">
        <!-- Detail Pelanggaran -->
        <div class="card shadow mb-4">
            <div class="card-header bg-blue">
                <h6 class="m-0 font-weight-bold">Detail Pelanggaran</h6>
            </div>
            <div class="card-body">
                        <form action="<?= base_url('admin/verifikasi/lolos');?>" method="post">
                        <input type="hidden" class="form-control" value="<?= $pelanggaran->id_pelanggaran;?>" name="id_pelanggaran">
                          <div class="form-row">
                            <div class="col-md-4 col-sm-12">
                                <label for="exampleInputEmail1">Tingkat</label>
                                <input type="text" class="form-control" disabled value="Tingkat <?= $pelanggaran->tingkat;?>">
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="exampleInputEmail1">Tanggal Pelanggaran</label>
                                <input type="text" class="form-control" disabled value="<?php setlocale(LC_TIME, 'id_ID'); echo strftime("%d %B %Y",strtotime($pelanggaran->tanggal));?>">
                            </div>
                            <div class="form-group col-md-2 col-sm-12">
                                <label for="exampleInputEmail1">Jam</label>
                                <input type="text" class="form-control" disabled value="<?= $pelanggaran->jam;?>">
                            </div>
                            <div class="form-group col-md-2 col-sm-12">
                                <label for="exampleInputEmail1">Prodi</label>
                                <input type="text" class="form-control" disabled value="<?= $pelanggaran->prodi;?>">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="exampleInputEmail1">Kategori Pelanggaran</label>
                                <input type="text" class="form-control" disabled value="Pelanggaran <?= $pelanggaran->nama_kategori;?>">
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="exampleInputEmail1">Jenis Pelanggaran</label>
                                <input type="text" class="form-control" disabled value="<?= $pelanggaran->nama_jenis;?>">
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="exampleInputEmail1">Lokasi</label>
                                <input type="text" class="form-control" disabled value="<?= $pelanggaran->nama_lokasi;?>">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="exampleInputEmail1">Keterangan</label>
                                <textarea class="form-control" name="keterangan" rows="2" disabled><?= $pelanggaran->keterangan;?></textarea>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                  <label for="exampleInputEmail1">Pelapor</label>
                                  <input type="text" class="form-control" disabled value="<?= $nama_dosen;?>">
                              </div>
                          </div>
                          <?php if ((!empty($pelanggaran->id_sanksi)) AND (!empty($pelanggaran->inspektur))) { ?>
                            <div class="form-row">
                              <div class="form-group col-md-6 col-sm-12">
                                <label for="exampleInputEmail1">Sanksi</label>
                                <input type="text" class="form-control" name="keterangan" disabled value="<?=  $pelanggaran->nama_sanksi;?><?= (!empty($pelanggaran->lapor)) ? ' - '.$pelanggaran->lapor.'x lapor': "";?><?= (!empty($pelanggaran->skorsing)) ? ' - '.$pelanggaran->skorsing.' hari skorsing' : "";?><?= (($pelanggaran->drop_out) == 1) ? '- Drop Out' : "";?>">
                               </div>
                              <div class="form-group col-md-6 col-sm-12">
                                  <label for="exampleInputEmail1">Inspektur</label>
                                  <input type="text" class="form-control" disabled value="<?= $nama_inspektur;?>">
                              </div>
                            </div>
                          <?php } ?>
                          <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                              <div class="align-middle">Status
                                <?php 
                                      if ($pelanggaran->status == "Menunggu"){
                                          echo '<span class="badge badge-danger ml-3"><div class="h6 m-0">Menunggu verifikasi</div></span>';
                                      } elseif ($pelanggaran->status == "Drop Out"){
                                          echo '<span class="badge badge-danger ml-3"><div class="h6 m-0">Drop Out</div></span>';
                                      } elseif ($pelanggaran->status == "Belum mengisi jadwal"){
                                          echo "<span class='badge badge-danger ml-3'><div class='h6 m-0'>$pelanggaran->status</div></span>";
                                      } elseif ($pelanggaran->status == "Proses"){
                                          echo '<span class="badge badge-warning ml-3"><div class="h6 m-0">Proses</div></span>';
                                      } elseif ($pelanggaran->status == "Sedang diskors"){
                                          echo '<span class="badge badge-warning ml-3"><div class="h6 m-0">Sedang diskors</div></span>';
                                      } elseif ($pelanggaran->status == "Selesai"){
                                          echo '<span class="badge badge-success ml-3"><div class="h6 m-0">Selesai</div></span>';
                                    }
                                ?>
                                </div>
                            </div>
                          </div>
                          <?php if(($pelanggaran->tgl_surat_bebas == NULL) AND ($pelanggaran->status != "Selesai")) { ?>
                            <div class="form-group">
                              <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input loloskan"  id="loloskanPelanggaran">
                                  <label class="custom-control-label" for="loloskanPelanggaran">Loloskan pelanggaran ini</label>
                                  <a href="<?= base_url('admin/pelanggaran/loloskan/'.$pelanggaran->id_pelanggaran);?>" id="loloskan"></a>
                              </div>
                            </div>
                          <?php } else {?>
                            <div class="form-group">
                              <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input loloskan"  id="loloskanPelanggaran" disabled checked>
                                  <label class="custom-control-label" for="loloskanPelanggaran">Loloskan pelanggaran ini</label>
                              </div>
                            </div>
                          <?php } ?>
                    </form>
            </div>
        </div>
      </div>
    </div>
   <!-- Lapor Pelanggaran -->
   <div class="row justify-content-end">

    <div class="col-md-10 col-sm-12">
      <div class="card shadow mb-4">
          <div class="card-header bg-blue">
              <h6 class="m-0 font-weight-bold">Detail Lapor</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="tableData" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="row">No</th>
                        <th>Tanggal Lapor</th>
                        <th>Penerima Lapor</th>
                        <th>Keterangan</th>
                        <th>Status Lapor</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $no=1;
                  foreach ($lapors as $lapor) : ?>
                   <tr>
                        <td><?= $no++;?></td>
                        <td><?= $lapor->tanggal;?></td>
                        <td><?= $lapor->nama_penerima_lapor;?></td>
                        <td><?= (empty($lapor->keterangan)) ? "-" : $lapor->keterangan;?></td>
                        <td><?= ($lapor->status == 1) ? '<span class="badge badge-outline-success">Diterima</span>' : '<span class="badge badge-outline-warning">Proses</span>';?></td>
                  </tr>
                  <?php endforeach;  ?>
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection();?>