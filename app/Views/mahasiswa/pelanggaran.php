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
        <li class="breadcrumb-item active" aria-current="page">Pelanggaran</li>
      </ol>
    </nav>
     <div class="card shadow mb-4">
        <div class="card-header bg-blue">
            <h6 class="m-0 font-weight-bold">Daftar Pelanggaran</h6>
        </div>
        <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="tableData" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Kategori Pelanggaran</th>
                        <th scope="col">Jenis Pelanggaran</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1;
                          foreach ($pelanggarans as $row) : ?>
                      <tr>
                        <td><?= $no++;?></td>
                        <td><?= $row->tanggal;?></td>
                        <td><?= $row->nama_lokasi;?></td>
                        <td><?= $row->nama_kategori;?></td>
                        <td><?= $row->nama_jenis;?></td>
                        <td><?= $row->keterangan;?></td>
                        <td>
                          <?php 
                              if ($row->status == "Menunggu"){
                                      echo '<span class="badge badge-outline-danger">Menunggu verifikasi</span>';
                                  } elseif ($row->status == "Drop Out"){
                                      echo '<span class="badge badge-outline-danger">Drop Out</span>';
                                  } elseif ($row->status == "Belum mengisi jadwal"){
                                      echo "<span class='badge badge-outline-danger'>$row->status</span>";
                                  } elseif ($row->status == "Proses"){
                                      echo '<span class="badge badge-outline-warning">Proses</span>';
                                  } elseif ($row->status == "Sedang diskors"){
                                      echo '<span class="badge badge-outline-warning">Sedang diskors</span>';
                                  } elseif ($row->status == "Selesai"){
                                      echo '<span class="badge badge-outline-success">Selesai</span>';
                                }
                          ?>
                        </td>
                        <td>
                            <form action="<?= base_url('mahasiswa/pelanggaran/detail');?>" method="post"> 
                                <input type="hidden" value="<?= $row->id_pelanggaran;?>" name="id">
                                <button type="submit" class="btn rounded-circle btn-outline-primary btn-sm"><i class="fas fa-search"></i></button>
                            </form>
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