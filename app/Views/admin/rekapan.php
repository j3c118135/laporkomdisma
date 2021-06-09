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
        <li class="breadcrumb-item active" aria-current="page">Unduh Rekapan Data</li>
      </ol>
    </nav>

     <!-- Card Filter -->
     <div class="card shadow mb-4">
        <div class="card-body">
        <form>
                <div class="form-row align-items-center justify-content-start">
                    <div class="col-md-auto col-sm-12 pt-2"><h6>Filter</h6></div>
                    <div class="col-md-2 col-sm-12 py-1">
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
                    <div class="col-md-3  col-sm-12 py-1">
                        <select class="form-control" name="lokasi" id="lokasi">
                            <option value="" selected>Semua Lokasi</option>
                            <?php foreach ($lokasis as $lokasi):?>
                            <option value="<?= $lokasi->nama?>"><?= $lokasi->nama?></option>
                            <?php endforeach;?>
                          </select>
                    </div>
                    <div class="col-md-3  col-sm-12 py-1">
                        <select class="form-control" name="sanksi" id="sanksi">
                            <option value="" selected>Semua Sanksi</option>
                            <?php foreach ($sanksis as $sanksi):?>
                            <option value="<?= $sanksi->nama?>"><?= $sanksi->nama?></option>
                            <?php endforeach;?>
                          </select>
                    </div>
                    <div class="col-md-3 col-sm-12 py-1">
                        <select class="form-control" id="status">
                            <option value="" selected>Semua Status</option>
                            <option value="Menunggu verifikasi">Menunggu verifikasi</option>
                            <option value="Sedang diskors">Sedang diskors</option>
                            <option value="Proses">Proses</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Drop Out">Drop Out</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 py-1">
                        <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                              </div>
                                <input type="text" class="form-control fix-rounded-right" id="datesearch" placeholder="Pilih tanggal">
                            </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Pelanggaran -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped" id="tableRekapan" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Prodi</th>
                            <th>Kategori Pelanggaran</th>
                            <th>Jenis Pelanggaran</th>
                            <th>Lokasi</th>
                            <th>Pelapor</th>
                            <th>Sanksi</th>
                            <th>Inspektur</th>
                            <th>Tanggal Surat Bebas Lapor</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($data as $row) : ?>
                            <tr>
                                <td><?= $row->tanggal;?></td>
                                <td><?= $row->nama;?></td>
                                <td><?= $row->nim;?></td>
                                <td><?= $row->prodi;?></td>
                                <td><?= $row->nama_kategori;?></td>
                                <td><?= $row->nama_jenis;?></td>
                                <td><?= $row->nama_lokasi;?></td>
                                <td><?= $row->nama_pelapor;?></td>
                                <td><?= (!empty($row->nama_sanksi)) ? $row->nama_sanksi : "-";?></td>
                                <td><?= (!empty($row->nama_inspektur)) ? $row->nama_inspektur : "-";?></td>
                                <td><?= (!empty($row->tgl_surat_bebas)) ? $row->tgl_surat_bebas : "-";?></td>
                                <td>
                                    <?php 
                                        if ($row->status == "Menunggu"){
                                                echo '<span class="badge badge-outline-danger">Menunggu verifikasi</span>';
                                            } elseif ($row->status == "Drop Out"){
                                                echo '<span class="badge badge-outline-danger">Drop Out</span>';
                                            } elseif ($row->status == "Belum mengisi jadwal"){
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
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection();?>