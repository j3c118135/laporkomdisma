<?= $this->extend('auth/templates/index');?> 
 
<?= $this->section('content'); ?>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-md-5 col-sm-12">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <a class="navbar-brand mb-2" href="#">
                                            <img src="<?= base_url('img/logo-pink.png');?>" width="45%" alt="">
                                        </a>
                                    </div>
									<div id="infoMessage"><?php echo $message;?></div>

                                    <form action="<?= base_url('pengurus/login');?>" method="post" class="user mt-3">

                                        <div class="form-group">
                                            <input type="text" name="identity" id="identity" class="form-control form-control-user <?= ($validation->hasError('identity')) ?
                                            'is-invalid' : '';?>" placeholder="Username" value="<?= set_value('identity');?>">
                                            <div class="invalid-feedback">
                                                <?= $validation->getError('identity');?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group login" id="password">
                                                <input type="password" name="password" id="password" class="form-control form-control-user <?= ($validation->hasError('password')) ?
                                                'is-invalid' : '';?>" placeholder="Password">
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><a href=""><i class="fa fa-eye-slash text-secondary " aria-hidden="true"></i></a></div>
                                                  </div>
                                                <div class="invalid-feedback">
                                                    <?= $validation->getError('password');?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <small class="form-text text-muted">
                                              Masukkan NIK/NIP/NPI/NIDN sebagai username dan password
                                            </small>
                                        </div>
                                        
                                        <button href="#" class="btn btn-pink btn-user btn-block">
                                            Login
                                        </button>
                                    </form>
                                    <!-- <hr>
                                        <div class="text-center small mb-1">
                                            Belum punya akun? <a href="">Register</a>
                                        </div>
                                        <div class="text-center small">
                                            <a href="<?= base_url('auth/forgot_password');?>">Lupa Password?</a>
                                        </div> -->
                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="row text-white justify-content-center small">
            Copyright &copy; Komisi Disiplin dan Kemahasiswaan Sekolah Vokasi IPB <?= date('Y'); ?>. All rights reserved.
        </div>

    </div>
<?= $this->endSection(); ?>
