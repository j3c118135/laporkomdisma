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
        <li class="breadcrumb-item"><a href="#">Data Master</a></li>
        <li class="breadcrumb-item active" aria-current="page">Akun</li>
      </ol>
    </nav>

    <!-- Card Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
        <div class="form-row align-items-center justify-content-start">
                <div class="col-md-auto pt-2"><h6>Filter</h6></div>
                <div class="col-md-auto col-sm-12">
                    <select class="form-control filter role" id="role">
                      <option value="" selected >Semua Role</option>
                      <option>Admin</option>
                      <option>Akademik</option>
                      <option>Dosen</option>
                      <option>Mahasiswa</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Akun -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="tableAkun" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="row">No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td></td>
                            <td><?= $user->username;?></td>
                            <td><?= $user->email;?></td>
                            <td><?= ($user->role == "Super Admin") ? "Admin" : $user->role;?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection();?>
