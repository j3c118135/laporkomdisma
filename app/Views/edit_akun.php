<?= $this->extend('templates/index');?>

<?= $this->section('page-content');?>
<?php if(($group_name == 'Admin') OR ($group_name == 'Akademik') OR ($group_name == 'Dosen') OR ($group_name == 'Super Admin')) :?>
<!-- Dashboard Admin -->
    <?= $this->include('admin/edit_akun'); ?>
<!-- End of dashboard-->

<?php elseif ($group_name == 'Mahasiswa') : ?>
    <!-- Dashboard Mahasiswa -->
        <?= $this->include('mahasiswa/edit_akun'); ?>
    <!-- End of dashboard-->

<?php endif;?>
<?= $this->endSection();?>