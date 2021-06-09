<!-- Topbar -->
<?= $this->include('mahasiswa/topbar'); ?>
<!-- End of Topbar -->
<!-- Page Heading -->
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard <?= $group_name;?></h1>
    <?php if($alert_lapor == TRUE){ ?>
        <div class="alert alert-warning shadow" role="alert">
          <div class="d-flex align-items-center" href="#">
              <div class="mr-3">
                    <i class='bx bx-info-circle h2 mb-0'></i>
              </div>
              <div>
                  <span class="font-weight-bold h6 mb-0">Anda belum melakukan lapor hari ini!</span>
                  <div>Sanksi berikutnya akan diberikan bila lapor tidak diselesaikan tepat waktu</div>
              </div>
          </div>
      </div>
    <?php } ?>
    <!-- Detail Content -->
    <div class="card shadow mb-4 p-3">
        <div class="card-body text-center">
            <h3>Selamat Datang di Sistem Pelayanan Online Lapor Komdisma</h3>
            <img src="<?= base_url('img/logo-sv.png');?>" class="img-fluid mt-4">
        </div>
    </div>
</div>

