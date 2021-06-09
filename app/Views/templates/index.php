<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title; ?> | Sistem Lapor Komdisma SV IPB</title>
    
    <link rel="icon" href="<?= base_url('favicon.ico');?>"/>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css');?>" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <!-- Custom styles for this template-->
    <link href="<?= base_url('css/main.css');?>" rel="stylesheet">
    <!-- Custom styles for this page -->
    <!-- <link href="<?= base_url();?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.22/b-1.6.5/b-colvis-1.6.5/b-html5-1.6.5/b-print-1.6.5/r-2.2.6/datatables.min.css"/>
    <link href="<?= base_url();?>/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet">
    <!--Daterangepicker -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="<?= base_url('vendor/chart.js/Chart.min.js');?>"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?= $this->include('templates/sidebar');?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
        <div class="flash-data" data-flashdata="<?php echo $session['message']; ?>"></div>

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <?= $this->renderSection('page-content');?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?php if (($group_name == 'Admin') OR ($group_name == 'Dosen') OR ($group_name == 'Super Admin')) : ?>
                <!-- Moda Tambah Pelanggaran -->
                <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cari NIM Mahasiswa</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="<?php echo base_url('pelanggaran/tambah'); ?>">
                            <?= csrf_field();?>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Masukkan NIM mahasiswa yang melakukan pelanggaran" name="nim">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Cari</button>
                            </form>
                      </div>
                    </div>
                  </div>
                </div>

            <?php endif; ?>

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span> Copyright &copy; Komisi Disiplin dan Kemahasiswaan Sekolah Vokasi IPB <?= date('Y'); ?>. All rights reserved.</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="<?= base_url('vendor/jquery/jquery.min.js');?>"></script>
    <script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js');?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('vendor/jquery-easing/jquery.easing.min.js');?>"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="<?= base_url();?>/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('js/main.js');?>"></script>
    <!-- Page level plugins -->
    <script src="<?=base_url();?>/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/plug-ins/1.10.24/sorting/date-uk.js"></script>
    
    <!-- <script  src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script> -->
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.22/b-1.6.5/b-colvis-1.6.5/b-html5-1.6.5/b-print-1.6.5/r-2.2.6/datatables.min.js"></script>
    <script src="<?=base_url();?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    
    <!--DateRangePicker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?=base_url();?>/js/demo/datatables-demo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>

<?php if (($group_name == 'Admin') OR ($group_name == 'Dosen') OR ($group_name == 'Super Admin') OR ($group_name == 'Akademik')) : ?>
    <script type="text/javascript">
        $(document).ready(function(){
 
            $('#kategoriP').change(function(){ 
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo base_url('pelanggaran/getJenisPelanggaran');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                        var html = '<option selected disabled value="">Pilih...</option>';
                        $('#jenisP').html(html+data);
 
                    }
                });
                return false;
            });

            $('input[type="checkbox"].loloskan').on('change', function(e){
                if(e.target.checked){
                  e.preventDefault();
                  const link = $('#loloskan').attr('href');
  
                  const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                      confirmButton: 'btn btn-success',
                      cancelButton: 'btn btn-danger mr-3'
                    },
                    buttonsStyling: false
                  })

                  swalWithBootstrapButtons.fire({
                    title: 'Apakah anda yakin?',
                    text: "Status pelanggaran akan berubah menjadi selesai dan mahasiswa dapat mengunduh surat keterangan bebas lapor",
                    icon: 'warning',
                    position: 'top',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, lanjutkan',
                    cancelButtonText: 'Tidak, batalkan',
                    reverseButtons: true
                  }).then((result) => {
                    if (result.isConfirmed) {
                      document.location.href = link;
                    } else {
                      $('input[type="checkbox"].loloskan').prop('checked', false);
                    }
                  })
                }
              });

            
            jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "date-uk-pre": function ( a ) {
                var ukDatea = a.split('/');
                return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
            },

            "date-uk-asc": function ( a, b ) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-uk-desc": function ( a, b ) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
            } );

            //filter rekapan
            var start_date;
             var end_date;
             var DateFilterFunction = (function (oSettings, aData, iDataIndex) {
                var dateStart = parseDateValue(start_date);
                var dateEnd = parseDateValue(end_date);
                //Kolom tanggal yang akan kita gunakan berada dalam urutan 2, karena dihitung mulai dari 0
                //nama depan = 0
                //nama belakang = 1
                //tanggal terdaftar =2
                var evalDate= parseDateValue(aData[0]);
                  if ( ( isNaN( dateStart ) && isNaN( dateEnd ) ) ||
                       ( isNaN( dateStart ) && evalDate <= dateEnd ) ||
                       ( dateStart <= evalDate && isNaN( dateEnd ) ) ||
                       ( dateStart <= evalDate && evalDate <= dateEnd ) )
                  {
                      return true;
                  }
                  return false;
            });

            // fungsi untuk converting format tanggal dd/mm/yyyy menjadi format tanggal javascript menggunakan zona aktubrowser
            function parseDateValue(rawDate) {
                var dateArray= rawDate.split("/");
                var parsedDate= new Date(dateArray[2], parseInt(dateArray[1])-1, dateArray[0]);  // -1 because months are from 0 to 11   
                return parsedDate;
            }    

            //konfigurasi DataTable pada tabel dengan id example dan menambahkan  div class dateseacrhbox dengan dom untuk meletakkan inputan daterangepicker
             var dTable = $('#tableRekapan').DataTable({
               dom:
                  "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6 text-right'B>>" +
                  "<'row'<'col-sm-12'tr>>" +
                  "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
              renderer: 'bootstrap',
              buttons: [
                  { extend: 'excel', text: 'Unduh Excel', className: 'btn btn-success', 
                  title: 'Data Pelanggaran Mahasiswa SV IPB' },
              ],
              "aoColumns": [
                    { "sType": "date-uk" },null,null,null,null,null,null,null,null,null,{ "sType": "date-uk" },null
                ]
             });

             //konfigurasi daterangepicker pada input dengan id datesearch
             $('#datesearch').daterangepicker({
                autoUpdateInput: false
              });

             //menangani proses saat apply date range
              $('#datesearch').on('apply.daterangepicker', function(ev, picker) {
                 $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                 start_date=picker.startDate.format('DD/MM/YYYY');
                 end_date=picker.endDate.format('DD/MM/YYYY');
                 $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
                 dTable.draw();
              });

              $('#datesearch').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                start_date='';
                end_date='';
                $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
                dTable.draw();
              });
              
              $('#prodi').on('change', function () {
                    dTable.columns(3).search( this.value).draw();
                } );
                $('#kategori').on('change', function () {
                    dTable.columns(4).search( this.value).draw();
                } );
                $('#jenis').on('change', function () {
                    dTable.columns(5).search( this.value).draw();
                } );
                $('#lokasi').on('change', function () {
                    dTable.columns(6).search( this.value).draw();
                } );
                $('#sanksi').on('change', function () {
                    dTable.columns(8).search( this.value).draw();
                } );
                $('#status').on('change', function () {
                    dTable.columns(11).search( this.value).draw();
                } );

            var tableAkun = $('#tableAkun').DataTable({
                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
            });

            tableAkun.on('order.dt search.dt', function () {
                tableAkun.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                });
            }).draw();

            $('#role').on('change', function () {
                    tableAkun.columns(3).search( this.value).draw();
            } );



            $('input[type="checkbox"].check-all').click(function(){ // Ketika user men-cek checkbox all
              if($(this).is(":checked")) // Jika checkbox all diceklis
                $('input[type="checkbox"].check-item').prop("checked", true); // ceklis semua checkbox siswa dengan class "check-item"
              else // Jika checkbox all tidak diceklis
                $('input[type="checkbox"].check-item').prop("checked", false); // un-ceklis semua checkbox siswa dengan class "check-item"
            });

            var tableUser = $('#tableUser').DataTable({
               dom:
                "<'row'<'col-sm-12 col-md-4'l><'text-right col-sm-12 col-md-6 ml-auto'f><'col-sm-12 col-md-auto mx-0 px-0'B>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
              renderer: 'bootstrap',
              buttons: [
                  { text: 'Hapus Data', className: 'btn btn-danger btn-sm', 
                    action: function ( e, dt, node, config ) {
                        e.preventDefault();
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                              confirmButton: 'btn btn-success',
                              cancelButton: 'btn btn-danger mr-3'
                            },
                            buttonsStyling: false
                          })

                        swalWithBootstrapButtons.fire({
                            title: 'Apakah anda yakin?',
                            text: "Seluruh data yang terkait dengan pengguna yang dipilih akan ikut terhapus",
                            icon: 'warning',
                            position: 'top',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, lanjutkan',
                            cancelButtonText: 'Tidak, batalkan',
                            reverseButtons: true
                          }).then((result) => {
                            if (result.isConfirmed) {
                              $('#form-delete').submit();
                            }
                          })
                    }, attr:  {
                    id: 'HapusUser'
                } },
              ],
             });

             tableUser.on('order.dt search.dt', function () {
                tableUser.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                });
            }).draw();

            $('#prodi').on('change', function () {
                tableUser.columns(3).search( this.value).draw();
            } );

            var tableData = $('#tableData').DataTable({
                "columnDefs" : [{"targets":1, "sType":"date-uk"}],
            });

            tableData.on('order.dt search.dt', function () {
                tableData.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                });
            }).draw();

            $('#prodi').on('change', function () {
                tableData.columns(3).search( this.value).draw();
            } );
            $('#kategori').on('change', function () {
                tableData.columns(4).search( this.value).draw();
            } );
            $('#jenis').on('change', function () {
                tableData.columns(5).search( this.value).draw();
            } );
            $('#lokasi').on('change', function () {
                tableData.columns(6).search( this.value).draw();
            } );
            $('#sanksi').on('change', function () {
                tableData.columns(7).search( this.value).draw();
            } );
            $('#status').on('change', function () {
                tableData.columns(8).search( this.value).draw();
            } );

            var tableSkorsing = $('#tableSkorsing').DataTable({
                "columnDefs" : [{"targets":4, "sType":"date-uk"}],
            });

            tableSkorsing.on('order.dt search.dt', function () {
                tableSkorsing.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                });
            }).draw();

            $('#prodi').on('change', function () {
                tableSkorsing.columns(3).search( this.value).draw();
            } );
            $('#status').on('change', function () {
                tableSkorsing.columns(6).search( this.value).draw();
            } );

            var tablePenundaan = $('#tablePenundaan').DataTable({
                "columnDefs" : [{"targets":1, "sType":"date-uk"}],
            });

            tablePenundaan.on('order.dt search.dt', function () {
                tablePenundaan.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                });
            }).draw();
            $('#prodi').on('change', function () {
                tablePenundaan.columns(3).search( this.value).draw();
            } );
            $('#status').on('change', function () {
                tablePenundaan.columns(8).search( this.value).draw();
            } );

            var tablePengajuan = $('#tablePengajuan').DataTable({
                "columnDefs" : [{"targets":1, "sType":"date-uk"}],
            });

            tablePengajuan.on('order.dt search.dt', function () {
                tablePengajuan.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                });
            }).draw();
            $('#prodi').on('change', function () {
                tablePengajuan.columns(3).search( this.value).draw();
            } );
            $('#status').on('change', function () {
                tablePengajuan.columns(9).search( this.value).draw();
            } );


            
        });

        
    </script>
    <script>
            $("#rowAddM").click(function () {
                var html = '';
                html += '<div class="form-row align-items-end" id="inputRowM">';
                html += '<div class="form-group col-md-5 col-sm-12">';
                html += '<label>Nama</label>';
                html += '<input type="text" class="form-control" name="nama[]" placeholder="Masukkan nama lengkap" required>';
                html += '<div class="invalid-tooltip">Nama tidak boleh kosong</div>';
                html += '</div>';
                html += '<div class="form-group col-md-4 col-sm12">';
                html += '<label>NIM</label>';
                html += '<input type="text" class="form-control" name="nim[]" placeholder="Masukkan NIM" required>';
                html += '<div class="invalid-tooltip">NIM tidak boleh kosong</div>';
                html += '</div>';
                html += '<div class="form-group col-md-2 col-sm-12">';
                html += '<label>Program Studi</label>';
                html += '<select class="custom-select" name="prodi[]" required>';
                html += '<option disabled selected value="">Pilih Prodi</option>';
                html += '<option value="A-KMN">A-KMN</option>';
                html += '<option>B-EKW</option>';
                html += '<option>C-INF</option>';
                html += '<option>D-TEK</option>';
                html += '<option>E-JMP</option>';
                html += '<option>F-GZI</option>';
                html += '<option>G-TIB</option>';
                html += '<option>H-IKN</option>';
                html += '<option>I-TNK</option>';
                html += '<option>J-MAB</option>';
                html += '<option>K-MNI</option>';
                html += '<option>L-KIM</option>';
                html += '<option>M-LNK</option>';
                html += '<option>N-AKN</option>';
                html += '<option>P-PVT</option>';
                html += '<option>T-TMP</option>';
                html += '<option>W-PPP</option>';
                html += '</select>';
                html += '<div class="invalid-tooltip">Silahkan pilih prodi</div>';
                html += '</div>';
                html += '<div class="form-group col-md-auto col-sm-12 align-self-md-end align-self-sm-start">';
                html += '<button type="button" class="btn btn-danger mt-0 btn-block" data-toggle="tooltip" data-placement="top" title="Hapus Input" id="rowRemM"><i class="fa fa-trash"></i></button>';
                html += '</div>';
                html += '</div>';

                $('#newRowM').append(html);
            });

            // remove row
            $(document).on('click', '#rowRemM', function () {
                $(this).closest('#inputRowM').remove();
            });
    </script>
    <script>
            $("#rowAddD").click(function () {
                var html = '';
                html += '<div class="form-row align-items-end" id="inputRowD">';
                html += '<div class="form-group col-md-6">';
                html += '<label>Nama</label>';
                html += '<input type="text" class="form-control" name="nama[]" placeholder="Masukkan nama lengkap beserta gelar" required>';
                html += '<div class="invalid-tooltip">Nama tidak boleh kosong</div>';
                html += '</div>';
                html += '<div class="form-group col-md-5">';
                html += '<label>Id</label>';
                html += '<input type="text" class="form-control" name="id[]" placeholder="Masukkan NIK/NIP/NPI" required>';
                html += '<div class="invalid-tooltip">Id tidak boleh kosong</div>';
                html += '</div>';
                html += '<div class="form-group col-md-auto col-sm-12 align-self-md-end align-self-sm-start">';
                html += '<button type="button" class="btn btn-danger mt-0 btn-block" data-toggle="tooltip" data-placement="top" title="Hapus Input" id="rowRemD"><i class="fa fa-trash"></i></button>';
                html += '</div>';
                html += '</div>';
                $('#newRowD').append(html);
            });

            // remove row
            $(document).on('click', '#rowRemD', function () {
                $(this).closest('#inputRowD').remove();
            });
    </script>
<?php endif; ?>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
            });
        }, false);
        })();
    </script>
</body>

</html>