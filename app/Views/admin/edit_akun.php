<!-- Topbar -->
<?= $this->include('admin/topbar'); ?>
<!-- End of Topbar -->


<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url();?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Akun</li>
      </ol>
    </nav>
  <div class="row">
    <div class="col-md-6">
      <div class="card shadow mb-4"> 
        <div class="card-body">
            <form method="POST" action="<?php echo base_url('akun/pengurus'); ?>" class="needs-validation" novalidate>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" value="<?= $user->nama?>" disabled>
                </div>
                <div class="form-group">
                    <label>Id</label>
                    <input type="text" class="form-control" value="<?= $user->id_user?>" disabled>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" value="<?= $user->username?>" disabled>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="<?= $user->email?>" required>
                    <div class="invalid-feedback">Email tidak boleh kosong</div>
                </div>
                <div class="form-group">
                    <label>Password Baru</label>
                    <div class="input-group" id="password">
                        <input type="password" name="passwordBaru" class="form-control"  placeholder="Masukkan password baru jika ingin mengubah password">
                        <div class="input-group-append">
                            <div class="input-group-text"><a href=""><i class="fa fa-eye-slash text-secondary " aria-hidden="true"></i></a></div>
                          </div>
                    </div>
                </div>
                <button class="btn btn-success">Simpan perubahan</button>
            </form>
        </div>
      </div>
    </div>
  </div>
    
     
</div>