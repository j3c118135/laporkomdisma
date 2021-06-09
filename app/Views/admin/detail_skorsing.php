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
        <li class="breadcrumb-item"><a href="<?= base_url('admin/skorsing');?>">Skorsing Mahasiswa</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Skorsing</li>
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
                    <img src="<?= base_url('upload/'.$data['mahasiswa']->foto);?>" class="img-thumbnail border-0">
                    <ul class="text-center px-0 pt-3 profile">
                          <li><h6 class="font-weight-bold"><?= $data['mahasiswa']->nama_mahasiswa;?></h6></li>
                          <li><h6><?= $data['mahasiswa']->nim_mahasiswa;?></h6></li>
                          <li><h6><?= $data['mahasiswa']->prodi;?></h6></li>
                    </ul>
                </div>
            </div>
         </div>
      </div>

      <div class="col-md-10 col-sm-12">
        <!-- Detail Skorsing -->
        <div class="card shadow mb-4">
            <div class="card-header bg-blue">
                <h6 class="m-0 font-weight-bold">Detail Skorsing</h6>
            </div>
            <div class="card-body">
            <div class="mb-3">Status
              <?php 
                  $status = $data['mahasiswa']->status;
                  if ($status == "Belum mengisi jadwal"){
                      echo "<span class='badge badge-danger ml-3'><div class='h6 m-0'>$status</div></span>";
                    } elseif ($status == "Skorsing belum dimulai"){
                      echo "<span class='badge badge-secondary ml-3'><div class='h6 m-0'>$status</div></span>";
                    } elseif ($status == "Sedang diskors"){
                      echo "<span class='badge badge-warning ml-3'><div class='h6 m-0'>$status</div></span>";
                    } elseif ($status == "Selesai"){
                      echo "<span class='badge badge-success ml-3'><div class='h6 m-0'>Skorsing selesai</div></span>";
                    }
              ?>
            </div>
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
                    </tr>
                </thead>
                <tbody>
                  <?php $no=1;
                  foreach ($data['skorsing'] as $skors) : ?>
                   <tr>
                        <td><?= $no++;?></td>
                        <td><?= $skors->hari;?></td>
                        <td><?= $skors->tanggal_matkul;?></td>
                        <td><?= $skors->jam_mulai;?> - <?= $skors->jam_selesai;?></td>
                        <td><?= $skors->matkul;?></td>
                        <td id=dosen><?= $skors->nama_dosen;?></td>
                        <td><?= $skors->nama_koor;?></td>
                   </tr>
                  <?php endforeach; 
                    if (empty($data['skorsing'])){?>
                    <tr><td colspan="7" class="text-center">Data Kosong</td></tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            </div>
        </div>
      </div>
    </div>


</div>

<?= $this->endSection();?>