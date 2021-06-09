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
        <li class="breadcrumb-item active" aria-current="page">Pelanggaran Mahasiswa</li>
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
                    <div class="col-md-3  col-sm-12 py-1">
                        <select class="form-control" name="kategori" id="kategori">
                            <option selected value="">Semua Kategori Pelanggaran</option>
                            <?php foreach ($Kpelanggarans as $Kpelanggaran):?>
                            <option value="<?= $Kpelanggaran->nama?>">Pelanggaran <?= $Kpelanggaran->nama?></option>
                            <?php endforeach;?>
                          </select>
                    </div>
                    <div class="col-md-3  col-sm-12 py-1">
                    <select class="form-control" name="jenis" id="jenis">
                            <option selected value="">Semua Jenis Pelanggaran</option>
                            <?php foreach ($Jpelanggarans as $Jpelanggaran) :?>
                            <option><?= $Jpelanggaran->nama?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2  col-sm-12 py-1">
                        <select class="form-control" name="lokasi" id="lokasi">
                            <option value="" selected>Semua Lokasi</option>
                            <?php foreach ($lokasis as $lokasi):?>
                            <option value="<?= $lokasi->nama?>"><?= $lokasi->nama?></option>
                            <?php endforeach;?>
                          </select>
                    </div>
                    <div class="col-md-2  col-sm-12 py-1">
                        <select class="form-control" name="sanksi" id="sanksi">
                            <option value="" selected>Semua Sanksi</option>
                            <?php foreach ($sanksis as $sanksi):?>
                            <option value="<?= $sanksi->nama?>"><?= $sanksi->nama?></option>
                            <?php endforeach;?>
                          </select>
                    </div>
                    <div class="col-md-auto col-sm-12 py-1">
                        <select class="form-control" id="status">
                            <option value="" selected>Semua Status</option>
                            <option value="Menunggu verifikasi">Menunggu verifikasi</option>
                            <option value="Sedang diskors">Sedang diskors</option>
                            <option value="Proses">Proses</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Drop Out">Drop Out</option>
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
            <table class="table table-striped" id="tableData" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="row">No</th>
                            <th>Tanggal Pelanggaran</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Kategori Pelanggaran</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Lokasi</th>
                            <th>Sanksi</th>
                            <th>Status</th>
                            <?php if(($group_name == 'Admin') OR ($group_name == 'Super Admin')) {?>
                            <th>Detail</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($pelanggarans as $pelanggaran): 
                        ?>
                        <tr>
                            <td></td>
                            <td><?= $pelanggaran->tanggal;?></td>
                            <td><?= $pelanggaran->nama_mahasiswa;?></td>
                            <td><?= $pelanggaran->prodi;?></td>
                            <td><?= $pelanggaran->nama_kategori;?></td>
                            <td><?= $pelanggaran->nama_jenis;?></td>
                            <td><?= $pelanggaran->nama_lokasi;?></td>
                            <td><?= (empty($pelanggaran->nama_sanksi)) ? "Perlu verifikasi" : $pelanggaran->nama_sanksi;?></td>
                            <td>
                                <?php 
                                    if ($pelanggaran->status == "Menunggu"){
                                            echo '<span class="badge badge-outline-danger">Menunggu verifikasi</span>';
                                        } elseif ($pelanggaran->status == "Drop Out"){
                                            echo '<span class="badge badge-outline-danger">Drop Out</span>';
                                        } elseif ($pelanggaran->status == "Belum mengisi jadwal"){
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
                            <?php if(($group_name == 'Admin') OR ($group_name == 'Super Admin')) {?>
                                <td>
                                    <form action="<?= base_url('admin/pelanggaran/detail');?>" method="post"> 
                                        <input type="hidden" value="<?= $pelanggaran->id_pelanggaran;?>" name="id">
                                        <button type="submit" class="btn rounded-circle btn-outline-primary btn-sm"><i class="fas fa-search"></i></button>
                                    </form>
                                </td>
                            <?php } ?>
                        </tr>
                        <?php endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection();?>