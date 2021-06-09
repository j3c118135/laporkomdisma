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
        <li class="breadcrumb-item active" aria-current="page">Skorsing Mahasiswa</li>
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
                            <option value="Belum mengisi jadwal">Belum mengisi jadwal</option>
                            <option value="Skorsing belum dimulai">Skorsing belum dimulai</option>
                            <option value="Sedang diskors">Sedang diskors</option>
                            <option value="Skorsing Selesai">Skorsing selesai</option>
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
                <table class="table table-striped" id="tableSkorsing" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="row">No</th>
                            <th>Id Pelanggaran</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Tanggal Berakhir</th>
                            <th>Lama Skorsing</th>
                            <th>Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($skorsings as $skorsing): 
                        ?>
                        <tr>
                            <td class="align-middle"></td>
                            <td>
                                <form action="<?= base_url('admin/pelanggaran/detail');?>" method="post"> 
                                    <input type="hidden" value="<?= $skorsing->pelanggaran_id;?>" name="id">
                                    <button class="btn btn-link "><?= $skorsing->pelanggaran_id;?></button>
                                </form>
                            </td>
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
                            <td class="align-middle">
                                <?php if($skorsing->status != "Belum mengisi jadwal"){ ?> 
                                    <form action="<?= base_url('admin/skorsing/detail');?>" method="post"> 
                                    <input type="hidden" value="<?= $skorsing->pelanggaran_id;?>" name="id">
                                    <button type="submit" class="btn rounded-circle btn-outline-primary btn-sm"><i class="fas fa-search"></i></button>
                                    </form>
                                <?php } else {?>
                                    <button class="btn rounded-circle btn-outline-primary btn-sm" disabled><i class="fas fa-search"></i></button>
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
<?= $this->endSection();?>