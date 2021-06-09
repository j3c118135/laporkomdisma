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
        <li class="breadcrumb-item active" aria-current="page">Verifikasi Pelanggaran</li>
      </ol>
    </nav>

    <!-- Card Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form>
                <div class="form-row align-items-center justify-content-start">
                    <div class="col-md-auto col-sm-12 pt-2"><h6>Filter</h6></div>
                    <div class="col-md-auto col-sm-12 py-1">
                        <select class="form-control filter" id="prodi">
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
                        <select class="form-control filter" name="kategori" id="kategori">
                            <option selected value="">Semua Kategori Pelanggaran</option>
                            <?php foreach ($Kpelanggarans as $Kpelanggaran):?>
                            <option value="<?= $Kpelanggaran->nama?>">Pelanggaran <?= $Kpelanggaran->nama?></option>
                            <?php endforeach;?>
                          </select>
                    </div>
                    <div class="col-md-3  col-sm-12 py-1">
                    <select class="form-control filter" name="jenis" id="jenis">
                            <option selected value="">Semua Jenis Pelanggaran</option>
                            <?php foreach ($Jpelanggarans as $Jpelanggaran) :?>
                            <option value="<?= $Jpelanggaran->nama?>"><?= $Jpelanggaran->nama?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3  col-sm-12 py-1">
                        <select class="form-control filter" name="lokasi" id="lokasi">
                            <option value="" selected>Semua Lokasi</option>
                            <?php foreach ($lokasis as $lokasi):?>
                            <option><?= $lokasi->nama?></option>
                            <?php endforeach;?>
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
                            <th>Verifikasi</th>
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
                            <td>
                                <form action="<?= base_url('admin/verifikasi/detail');?>" method="post"> 
                                    <input type="hidden" value="<?= $pelanggaran->id_pelanggaran;?>" name="id">
                                    <button class="btn rounded-circle btn-outline-primary btn-sm"><i class="fas fa-pen"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection();?>