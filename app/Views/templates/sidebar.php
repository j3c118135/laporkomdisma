<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion fixed-top" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('/');?>">
                <div class="sidebar-brand-icon">
                </div>
                <div class="sidebar-brand-text mx-3">LAPOR KOMDISMA</div>
            </a>

            <?php if(($group_name == 'Admin') OR ($group_name == 'Super Admin') OR ($group_name == 'Dosen')) :?>
            <!-- Divider -->
            <hr class="sidebar-divider">
        
            <li class="nav-item ">
                <a class="nav-link btn-pelanggaran" href="#" data-toggle="modal" data-target="#modalTambah" >
                    <i class="fas fa-plus"></i>
                    <span>Tambah Pelanggaran</span></a>
                    
            </li>  
            <?php endif;?>
            
            <hr class="sidebar-divider">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php if (current_url(true)->getTotalSegments() == 0 || current_url(true)->getSegment(1) == '/') echo ' active'; ?>">
                <a class="nav-link " href="<?= base_url('/');?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            
 
            <?php if(($group_name == 'Admin') OR ($group_name == 'Super Admin') OR ($group_name == 'Dosen')) :?>
            
            <!-- Nav Item - Laporan -->
            <li class="nav-item <?php if (uri_string() == 'laporan') echo ' active'; ?>">
                <a class="nav-link" href="<?= base_url('laporan');?>">
                    <i class="fas fa-clipboard-check"></i>
                    <span>Terima Laporan</span>
                    <?php 
                        if (empty($jumlah_lapor)) {
                            echo "";
                        } elseif ($jumlah_lapor > 99) {
                            echo "<span class='badge badge-danger badge-counter'>99+</span>";
                        } else {
                            echo "<span class='badge badge-danger badge-counter'>$jumlah_lapor</span>";
                        }
                    ?>
                </a>
            </li>

            <?php endif;?>

            <?php if(($group_name == 'Admin') OR ($group_name == 'Super Admin')) :?>
            <!-- Nav Item - surat kelakuan baik -->
            <li class="nav-item<?php if (uri_string() == 'admin/surat') echo ' active'; ?>">
                <a class="nav-link" href="<?= base_url('admin/surat');?>">
                    <i class="fas fa-edit"></i>
                    <span>Surat Kelakuan Baik</span>
                    <?php 
                        if (empty($jumlah_pengajuan_surat)) {
                            echo "";
                        } elseif ($jumlah_pengajuan_surat> 99) {
                            echo "<span class='badge badge-danger badge-counter'>99+</span>";
                        } else {
                            echo "<span class='badge badge-danger badge-counter'>$jumlah_pengajuan_surat</span>";
                        }
                    ?>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

             <div class="sidebar-heading">
                Kelola Data Master
            </div>

            <li class="nav-item<?php if (uri_string() == 'admin/akun') echo ' active'; ?>">
                <a class="nav-link" href="<?= base_url('admin/akun');?>">
                    <i class="fas fa-user"></i>
                    <span>Akun</span></a>
            </li>

                <li class="nav-item<?php if ((uri_string() == 'admin/komdisma') || (uri_string() == 'admin/akademik') || (uri_string() == 'admin/dosen') || (uri_string() == 'admin/mahasiswa') || (uri_string() == 'admin/pelanggaran/jenis') || (uri_string() == 'admin/pelanggaran/lokasi')) echo ' active'; ?>">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseData"
                        aria-expanded="true" aria-controls="collapseData">
                        <i class="fas fa-users"></i>
                        <span>Input Data Master</span>
                    </a>
                    <div id="collapseData" class="collapse" aria-labelledby="headingData"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- <h6 class="collapse-header">Data Master:</h6> -->
                            <?php if($group_name == 'Super Admin') :?>
                            <a class="collapse-item" href="<?= base_url('admin/komdisma');?>">Komdisma</a>
                            <?php endif;?>
                            <a class="collapse-item" href="<?= base_url('admin/akademik');?>">Akademik</a>
                            <a class="collapse-item" href="<?= base_url('admin/dosen');?>">Dosen</a>
                            <a class="collapse-item" href="<?= base_url('admin/mahasiswa');?>">Mahasiswa</a>
                            <a class="collapse-item" href="<?= base_url('admin/pelanggaran/jenis');?>">Jenis Pelanggaran</a>
                            <a class="collapse-item" href="<?= base_url('admin/pelanggaran/lokasi');?>">Lokasi Pelanggaran</a>
                        </div>
                    </div>
                </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Kelola Data Pelanggaran
            </div>

            <!-- Nav Item - Laporan -->
            <li class="nav-item<?php if (uri_string() == 'admin/verifikasi') echo ' active'; ?>">
                <a class="nav-link" href="<?= base_url('admin/verifikasi');?>">
                    <i class="fas fa-tasks"></i>
                    <span>Verifikasi Pelanggaran</span>
                    <?php 
                        if (empty($jumlah_verifikasi)) {
                            echo "";
                        } elseif ($jumlah_verifikasi > 99) {
                            echo "<span class='badge badge-danger badge-counter'>99+</span>";
                        } else {
                            echo "<span class='badge badge-danger badge-counter'>$jumlah_verifikasi</span>";
                        }
                    ?>
                </a>   
            </li>

            <?php endif;?>
           
            
            <?php if(($group_name == 'Admin') OR ($group_name == 'Super Admin') OR ($group_name == 'Akademik')):?>
            <!-- Nav Item - Pelanggran -->
            <li class="nav-item<?php if (uri_string() == 'admin/pelanggaran') echo ' active'; ?>">
                <a class="nav-link" href="<?= base_url('admin/pelanggaran');?>">
                    <i class="fas fa-users-slash"></i>
                    <span>Pelanggaran Mahasiswa</span></a>
            </li>

            <?php endif;?>
            

            <?php if(($group_name == 'Admin') OR ($group_name == 'Super Admin') OR ($group_name == 'Akademik')) :?>
            <li class="nav-item<?php if (uri_string() == 'admin/skorsing') echo ' active'; ?>">
                <a class="nav-link" href="<?= base_url('admin/skorsing');?>">
                    <i class="fas fa-ban"></i>
                    <span>Skorsing Mahasiswa</span></a>
            </li>

            <?php endif;?>
            <?php if(($group_name == 'Admin') OR ($group_name == 'Super Admin')):?>
            <li class="nav-item<?php if (uri_string() == 'admin/skorsing/penundaan') echo ' active'; ?>">
                <a class="nav-link" href="<?= base_url('admin/skorsing/penundaan');?>">
                    <i class="fas fa-file-alt"></i>
                    <span>Penundaan Skorsing</span>
                    <?php 
                        if (empty($jumlah_pengajuan)) {
                            echo "";
                        } elseif ($jumlah_pengajuan > 99) {
                            echo "<span class='badge badge-danger badge-counter'>99+</span>";
                        } else {
                            echo "<span class='badge badge-danger badge-counter'>$jumlah_pengajuan</span>";
                        }
                    ?>
                </a>
            </li>
            <?php endif;?>

            <?php if(($group_name == 'Admin') OR ($group_name == 'Akademik') OR ($group_name == 'Super Admin')) :?>
            <!-- Nav Item - Rekapan -->
            <li class="nav-item<?php if (uri_string() == 'rekapan') echo ' active'; ?>">
                <a class="nav-link" href="<?= base_url('rekapan');?>">
                    <i class="fas fa-download"></i>
                    <span>Unduh Rekapan</span></a>
            </li>

            <li class="nav-item<?php if ((uri_string() == 'grafik/sv') || (uri_string() == 'grafik/prodi')) echo ' active'; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseData2"
                    aria-expanded="true" aria-controls="collapseData2">
                    <i class="fas fa-chart-pie"></i>
                    <span>Grafik</span>
                </a>
                <div id="collapseData2" class="collapse" aria-labelledby="headingData"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="<?= base_url('grafik/sv');?>">Grafik SV</a>
                        <a class="collapse-item" href="<?= base_url('grafik/prodi');?>">Grafik Prodi</a>
                    </div>
                </div>
            </li>
            <?php endif;?>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Kelola Data Pelanggaran
            </div> -->
            <!-- Nav Item - Profile -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-user"></i>
                    <span>My Profile</span></a>
            </li> -->

            <!-- Nav Item - Edit Profile -->
            <!-- <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-user-edit"></i>
                    <span>Edit Profile</span></a>
            </li>  -->
            <?php if($group_name == 'Mahasiswa') :?>
            <li class="nav-item<?php if (uri_string() == 'mahasiswa/pelanggaran') echo ' active'; ?>">
                <a class="nav-link" href="<?= base_url('mahasiswa/pelanggaran');?>">
                    <i class="fas fa-file"></i>
                    <span>Pelanggaran</span></a>
            </li>
            <li class="nav-item<?php if (uri_string() == 'mahasiswa/surat') echo ' active'; ?>">
                <a class="nav-link" href="<?= base_url('mahasiswa/surat');?>">
                    <i class="fas fa-download"></i>
                    <span>Surat Kelakuan Baik</span></a>
            </li>
            <?php endif;?>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">


             <!-- Sidebar Toggler (Sidebar) -->
             <!-- <div class="text-center d-none d-md-inline">
                        <button class="rounded-circle border-0" id="sidebarToggle"></button>
                    </div> -->

           

        </ul>

