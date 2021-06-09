<?= $this->extend('templates/index');?>

<?= $this->section('page-content');?>

<!-- Topbar -->
<?= $this->include('mahasiswa/topbar'); ?>
<!-- End of Topbar -->

<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url();?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('mahasiswa/pelanggaran');?>">Pelanggaran</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Pelanggaran</li>
      </ol>
    </nav>

    <div class="row justify-content-between align-items-center mb-3">
      <div class="col-md-3 col-sm-12">
        <div>Status
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
      <div class="col-md-4 col-sm-12 text-right">
      <?php if($pelanggaran->status == "Selesai" AND $pelanggaran->lapor != NULL ) {?>
        <form method="POST" action="<?php echo base_url('mahasiswa/pelanggaran/surat/unduh'); ?>" class="needs-validation" novalidate>
          <?= csrf_field();?>
          <input type="hidden" name="jum_lapor" value="<?=  ($pelanggaran->lapor) ? $pelanggaran->lapor : "";?>">
          <input type="hidden" name="tgl_surat_bebas" value="<?= ($pelanggaran->tgl_surat_bebas) ? $pelanggaran->tgl_surat_bebas : ""?>">
          <input type="hidden" name="nama_inspektur" value="<?= ($pelanggaran->inspektur) ? $nama_inspektur : ""?>">
          <input type="hidden" name="tgl_terakhir_lapor" value="<?= ($lastLapor != NULL ) ? $lastLapor : $pelanggaran->tgl_surat_bebas;?>">
          <input type="hidden" name="prodi" value="<?= $prodi;?>">
          <button type="submit" class="btn btn-primary"><i class='fas fa-download mr-2'></i>Unduh surat bebas lapor</button>
        </form>
      <?php } ?>
      <?php if(($canLapor['hasil'] == TRUE) AND ($pelanggaran->status != "Sedang diskors")){ ?>
        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#Lapor">Ajukan lapor</a>
      <?php }else if(($canLapor['hasil'] == FALSE) AND (($canLapor['keterangan'] == "Lapor lengkap") OR ($canLapor['keterangan'] == "Tidak ada lapor")) OR ($pelanggaran->status == "Sedang diskors")){
        echo ''; ?>
      <?php }elseif (($canLapor['keterangan'] == "Jadwal belum lengkap")){ ?>
        <form action="<?= base_url('mahasiswa/jadwal/tambah');?>" method="post"> 
            <input type="hidden" value="<?= $pelanggaran->id_pelanggaran;?>" name="id">
            <button class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Tambah jadwal</button>
        </form>
        <small class="form-text">
        <i class="fas fa-exclamation-circle mr-1"></i>Tambahkan jadwal matkul skorsing agar dapat lapor
        </small>
        <?php }elseif (($canLapor['hasil'] == FALSE) AND ($canLapor['keterangan'] == "Hari libur")){ 
          echo '';
         } else{ ?>
        <a class="btn btn-primary disabled">Ajukan lapor</a>
          <small class="form-text">
          <i class="fas fa-exclamation-circle mr-1"></i><?= $canLapor['keterangan'];?>
          </small>
      <?php } ?>
      </div>
    </div>
     <!-- Profile -->
    <div class="row">

      <div class="col-md-12 col-sm-12">
        <!-- Detail Pelanggaran -->
        <div class="card shadow mb-4">
            <div class="card-header bg-blue">
                <h6 class="m-0 font-weight-bold">Detail Pelanggaran</h6>
            </div>
            <div class="card-body">
                        <form>
                        <input type="hidden" class="form-control" value="<?= $pelanggaran->id_pelanggaran;?>" name="id_pelanggaran">
                          <div class="form-row">
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="exampleInputEmail1">Tanggal Pelanggaran</label>
                                <input type="text" class="form-control" disabled value="<?php setlocale(LC_TIME, 'id_ID'); echo strftime("%d %B %Y",strtotime($pelanggaran->tanggal));?>">
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="exampleInputEmail1">Jam Pelanggaran</label>
                                <input type="text" class="form-control" disabled value="<?= $pelanggaran->jam;?>">
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="exampleInputEmail1">Lokasi Pelanggaran</label>
                                <input type="text" class="form-control" disabled value="<?= $pelanggaran->nama_lokasi;?>">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="exampleInputEmail1">Kategori Pelanggaran</label>
                                <input type="text" class="form-control" disabled value="Pelanggaran <?= $pelanggaran->nama_kategori;?>">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="exampleInputEmail1">Jenis Pelanggaran</label>
                                <input type="text" class="form-control" disabled value="<?= $pelanggaran->nama_jenis;?>">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="exampleInputEmail1">Keterangan</label>
                                <input type="text" class="form-control" disabled value="<?= $pelanggaran->keterangan;?>">
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
                                  <input type="text" class="form-control" disabled value="<?=  $pelanggaran->nama_sanksi;?>">
                              </div>
                              <div class="form-group col-md-6 col-sm-12">
                                  <label for="exampleInputEmail1">Inspektur</label>
                                  <input type="text" class="form-control" disabled value="<?= $nama_inspektur;?>">
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="form-group col-md-4 col-sm-12">
                                  <label for="exampleInputEmail1">Lapor</label>
                                  <input type="text" class="form-control" disabled value="<?=  (empty($pelanggaran->lapor)) ? "-" : "$pelanggaran->lapor Kali";?>">
                              </div>
                              <div class="form-group col-md-4 col-sm-12">
                                  <label for="exampleInputEmail1">Skorsing</label>
                                  <input type="text" class="form-control" disabled value="<?=  (empty($pelanggaran->skorsing)) ? "-" : "$pelanggaran->skorsing Hari";?>">
                              </div>
                              <div class="form-group col-md-4 col-sm-12">
                                  <label for="exampleInputEmail1">Drop out</label>
                                  <input type="text" class="form-control" disabled value="<?=  ($pelanggaran->drop_out == 0) ? "-" : "Ya" ;?>">
                              </div>
                            </div>
                          <?php } ?>
                    </form>
            </div>
        </div>
      </div>
    </div>
  <?php if (!empty($lapors)) { ?>
    <!-- Lapor Pelanggaran -->
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="card shadow mb-4">
            <div class="card-header bg-blue">
                <h6 class="m-0 font-weight-bold">Detail Lapor</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                          <th scope="row">No</th>
                          <th>Tanggal</th>
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
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php if (!empty($skorsing)) { ?>
    <!-- Jadwal Matkul Skorsing -->
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="card shadow mb-4">
            <div class="card-header bg-blue">
                <h6 class="m-0 font-weight-bold">Detail Skorsing</h6>
            </div>
            <div class="card-body">
            <div class="row justify-content-between align-items-center mb-3">
              <div class="col-sm-6">
            <?php if(!empty($cekPenundaan)){
                    if ($cekPenundaan->status == 0 AND empty($cekPenundaan->komentar)){
                      echo '<button type="button" class="btn btn-primary" disabled>Ajukan penundaan skorsing</button>';
                      echo '<small class="form-text"><i class="fas fa-exclamation-circle mr-1"></i>Pengajuan penundaan skorsing menunggu diverifikasi</small>';
                    } elseif ($cekPenundaan->status == 0 AND !empty($cekPenundaan->komentar)){
                      echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#penundaanSkors" >Ajukan penundaan skorsing</button>';
                      setlocale(LC_TIME, 'id_ID'); 
                      echo "<small class='form-text text-danger'><i class='fas fa-exclamation-circle mr-1'></i>Pengajuan penundaan skorsing tanggal ".strftime("%d %B %Y",strtotime($cekPenundaan->tgl_pengajuan))." ditolak! Silahkan ajukan kembali</small><small class='form-text text-danger'>Alasan ditolak: $cekPenundaan->komentar</small>";
                    } else {
                      echo '<button type="button" class="btn btn-primary" disabled>Ajukan penundaan skorsing</button>';
                      echo '<small class="form-text text-success"><i class="fas fa-check-circle mr-1"></i>Penundaan skorsing diterima</small>';
                    }
                } else {
                  if ($statusSkorsing != "Selesai"){ ?>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#penundaanSkors" >Ajukan penundaan skorsing</button>
            <?php }} ?>
                      
                
              </div>
              <div class="col-sm-6 text-right">
              <?php if((empty($cekPenundaan)) OR ($cekPenundaan->status == 0)){
                  if ($statusSkorsing != "Selesai"){ ?>
                <form action="<?= base_url('mahasiswa/jadwal/tambah');?>" method="post" id="jadwal-baru"> 
                      <input type="hidden" value="<?= $pelanggaran->id_pelanggaran;?>" name="id">
                      <button type="submit" class="btn btn-outline-success"><i class="fas fa-plus mr-2"></i>Tambah jadwal baru</button>
                  </form>
              <?php }}?>
              </div>
            </div>
            <div class="table-responsive">
                <div class="table-responsive">
                  <table class="table table-striped" id="tb_detailSkors" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="row">No</th>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Mata Kuliah (MK)</th>
                            <th>Dosen MK</th>
                            <th>Koordinator MK</th>
                            <?php if((empty($cekPenundaan)) OR ($cekPenundaan->status == 0)){
                            if ($statusSkorsing != "Selesai"){ ?>
                            <th>Edit</th>
                            <?php }}?>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $no=1;
                      foreach ($skorsing as $skors) : ?>
                       <tr>
                            <td><?= $no++;?></td>
                            <td><?= $skors->hari;?></td>
                            <td><?= $skors->tanggal_matkul;?></td>
                            <td><?= $skors->jam_mulai;?> - <?= $skors->jam_selesai;?></td>
                            <td><?= $skors->matkul;?></td>
                            <td id=dosen><?= $skors->nama_dosen;?></td>
                            <td><?= $skors->nama_koor;?></td>
                            <?php if((empty($cekPenundaan)) OR ($cekPenundaan->status == 0)){ 
                              if ($statusSkorsing != "Selesai"){ ?>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#edit-<?= $skors->id;?>" class="btn rounded-circle btn-outline-primary btn-sm"><i class="fas fa-pen"></i></a>
                            </td>
                            <?php }}?>
                       </tr>
                      <?php endforeach;  ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row justify-content-start align-items-center mb-0">
                <div class="col-md-12 col-sm-12">
                  <div>Status Skorsing
                    <?php 
                          if ($statusSkorsing == "Belum mengisi jadwal"){
                              echo "<span class='badge badge-danger badge-md ml-3 mb-0'>$statusSkorsing</span>";
                          } elseif ($statusSkorsing == "Skorsing belum dimulai"){
                              echo "<span class='badge badge-md badge-secondary ml-3 mb-0'>$statusSkorsing</span>";
                          } elseif ($statusSkorsing == "Sedang diskors"){
                              echo "<span class='badge badge-md badge-warning ml-3 mb-0'>$statusSkorsing</span>";
                          } elseif ($statusSkorsing == "Selesai"){
                            echo "<span class='badge badge-md badge-success ml-3 mb-0'>$statusSkorsing</span>";
                        }
                    ?>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  <?php } ?>
</div>

<!-- Modal Tambah Lapor -->
<div class="modal fade" id="Lapor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ajukan Lapor</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
          </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo base_url('mahasiswa/lapor'); ?>" class="needs-validation" novalidate>
        <?= csrf_field();?>
        <input type="hidden" name="id_pelanggaran" value="<?= $pelanggaran->id_pelanggaran;?>">
        <div class="form-group">
          <select class="custom-select" id="dosen" name="dosen" required>
              <option value="" selected>Pilih Dosen</option>
              <?php foreach ($dosen as $row) : ?>
                <option value="<?= $row->id_akun;?>"><?= $row->nama;?></option>
              <?php endforeach; ?>
          </select>
          <div class="invalid-feedback">Silahkan pilih dosen</div>
        </div>
        <button type="submit" id="btn-lapor" class="btn btn-success btn-block">Ajukan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal edit jadwal matkul -->
<?php foreach ($skorsing as $row) : ?>
    <div class="modal fade" id="edit-<?= $row->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Jadwal Mata Kuliah</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="<?= base_url('mahasiswa/jadwal/edit');?>" method="POST" class="needs-validation" novalidate>
                <?= csrf_field();?>
                    <input type="hidden" name="id" value="<?= $row->id;?>">
                    <input type="hidden" name="id_pelanggaran" value="<?= $row->id_pelanggaran;?>">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="<?= $row->tanggal;?>" disabled>
                        <small class="form-text"><i class="fas fa-exclamation-circle mr-1"></i>Tambahkan jadwal baru jika ingin mengubah tanggal</small>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6 col-sm-12">
                          <label>Jam Mulai</label>
                          <input type="time" class="form-control" name="jam_mulai" value="<?= $row->jam_mulai;?>" required>
                          <div class="invalid-feedback">Jam mulai tidak boleh kosong</div>
                      </div>
                      <div class="form-group col-md-6 col-sm-12">
                          <label>Jam Selesai</label>
                          <input type="time" class="form-control" name="jam_selesai" value="<?= $row->jam_selesai;?>" required>
                          <div class="invalid-feedback">Jam selesai tidak boleh kosong</div>
                      </div>
                    </div>
                    <div class="form-group">
                        <label>Mata Kuliah (MK)</label>
                        <input type="text" class="form-control" name="matkul" value="<?= $row->matkul;?>" required>
                        <div class="invalid-feedback">Mata kuliah tidak boleh kosong</div>
                    </div>
                    <div class="form-group">
                        <label>Dosen MK</label>
                        <select class="custom-select" name="dosen" required>
                        <option value="" selected disabled>Pilih...</option>
                        <?php foreach ($dosen as $dsn) : ?>
                            <option value="<?= $dsn->id_akun;?>" <?=($dsn->id_akun == $row->dosen) ? "selected" : ""?>><?= $dsn->nama;?></option>
                          <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Silahkan pilih dosen</div>
                    </div>
                    <div class="form-group">
                        <label>Koordinator MK</label>
                        <select class="custom-select" name="koordinator" required>
                        <option value="" selected disabled>Pilih...</option>
                        <?php foreach ($dosen as $dsn) : ?>
                            <option value="<?= $dsn->id_akun;?>" <?=($dsn->id_akun == $row->koordinator) ? "selected" : ""?>><?= $dsn->nama;?></option>
                          <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Silahkan pilih koordinator</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn" data-dismiss="modal">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Moda Penundaan Skorsing -->
<div class="modal fade" id="penundaanSkors" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pengajuan Penundaan Skorsing</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
          </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?php echo base_url('mahasiswa/skorsing/penundaan'); ?>" class="needs-validation" novalidate>
        <?= csrf_field();?>
        <input type="hidden" name="id_pelanggaran" value="<?= $pelanggaran->id_pelanggaran;?>">
        <div class="form-group">
          <label>Menunda skorsing untuk keperluan :</label>
          <textarea class="form-control" name="keterangan" id="keterangan" rows="3" required></textarea>
          <div class="invalid-feedback">Keperluan tidak boleh kosong</div>
        </div>
        <div class="form-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
            <label class="form-check-label" for="invalidCheck">Saya sudah mengubah jadwal matkul untuk skorsing dengan jadwal matkul terbaru dan saya setuju jadwal matkul tidak akan bisa diubah lagi</label>
            <div class="invalid-feedback">Ketentuan harus disetujui sebelum penundaan diajukan</div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <a class="btn" data-dismiss="modal">Batal</a>
          <button type="submit" class="btn btn-success">Ajukan</button>
      </div>
      </form>
    </div>
  </div>
</div>


<?= $this->endSection();?>