<?= $this->extend('templates/index');?>

<?= $this->section('page-content');?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">My Profile</h1>

    <!-- Detail Content -->
    <div class="card shadow mb-4">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="<?= base_url('img/default-profile.png');?>" class="card-img" alt="">
            </div>
                <div class="col-md-8  d-flex align-items-center">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"></li>
                        <li class="list-group-item"></li>
                        <li class="list-group-item"></li>
                        <li class="list-group-item"></li>
                        <li class="list-group-item"></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection();?>