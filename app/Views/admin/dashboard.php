<!-- Topbar -->
<?= $this->include('admin/topbar'); ?>
<!-- End of Topbar -->

<div class="container-fluid">
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Dashboard <?= $group_name;?></h1>
    <!-- card -->
    <div class="row">
        <div class="col-sm-3 mb-3">
            <div class="card bg-indigo">
            <div class="card-body">
                <h2 class="card-title"><i class="fas fa-ban mr-2"></i><?=$jumlah_pelanggaran;?></h2>
                <p class="card-text">Total Pelanggaran</p>
            </div>
            </div>
        </div>
        <div class="col-sm-3 mb-3">
            <div class="card bg-teal">
            <div class="card-body">
                <h2 class="card-title"><i class="fas fa-user-check mr-2"></i><?=$jumlah_status[0];?></h2>
                <p class="card-text">Pelanggaran Selesai</p>
            </div>
            </div>
        </div>
        <div class="col-sm-3 mb-3">
            <div class="card bg-yellow">
            <div class="card-body">
                <h2 class="card-title"><i class="fas fa-user-clock mr-2"></i><?=$jumlah_status[1];?></h2>
                <p class="card-text">Pelanggaran Belum Selesai</p>
            </div>
            </div>
        </div>
        <div class="col-sm-3 mb-3">
            <div class="card bg-pink">
            <div class="card-body">
                <h2 class="card-title"><i class="fas fa-user-slash mr-2"></i><?= $jumlah_pelanggar;?></h2>
                <p class="card-text">Total Mahasiswa Pelanggar</p>
            </div>
            </div>
        </div>

    </div>

    <!-- Grafik-->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <!-- Bar Chart -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Total Pelanggaran dalam 6 Bulan Terakhir</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="myBarChart"></canvas>
                        <script>
                            var ctx = document.getElementById("myBarChart");
                            var myBarChart = new Chart(ctx, {
                              type: 'bar',
                              data: {
                                labels: [<?php foreach ($jumlah_terakhir[0] as $row):
                                            echo "'$row',";
                                endforeach;
                                    ?>
                                ],
                                datasets: [{
                                  label: "Mahasiswa",
                                  backgroundColor: "#4e73df",
                                  hoverBackgroundColor: "#2e59d9",
                                  borderColor: "#4e73df",
                                  data: [<?php foreach ($jumlah_terakhir[1] as $row):
                                                echo $row.",";
                                    endforeach;
                                        ?>],
                                    maxBarThickness: 50,
                                }],
                              },
                              options: {
                                maintainAspectRatio: false,
                                layout: {
                                  padding: {
                                    left: 10,
                                    right: 25,
                                    top: 25,
                                    bottom: 0
                                  }
                                },
                                scales: {
                                  xAxes: [{
                                    time: {
                                      unit: 'Bulan'
                                    },
                                    gridLines: {
                                      display: false,
                                      drawBorder: false
                                    },
                                  }],
                                  yAxes: [{
                                    gridLines: {
                                      color: "rgb(234, 236, 244)",
                                      zeroLineColor: "rgb(234, 236, 244)",
                                      drawBorder: false,
                                      borderDash: [2],
                                      zeroLineBorderDash: [2]
                                    },
                                    ticks: {
                                          beginAtZero: true,
                                          stepSize: 1,
                                       },
                                  }],
                                },
                                legend: {
                                  display: true,
                                  position: 'top'
                                },
                              }
                            });
                        </script>
                    </div>
                </div>
            </div>

        </div>

        <!-- Donut Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 ">
                <!-- Card Header - Dropdown -->
                  <div class="card-header">
                      <h6 class="m-0 font-weight-bold text-primary">Total Pelanggaran</h6>
                  </div>
                <!-- Card Body -->
                <div class="card-body ">
                    <div class="chart-bar py-3">
                        <canvas id="TotalPelanggaran"></canvas>
                        <script>
                            var ctx = document.getElementById("TotalPelanggaran");
                            var TotalPelanggaran = new Chart(ctx, {
                              type: 'doughnut',
                              data: {
                                labels: ["Selesai", "Belum Selesai"],
                                datasets: [{
                                  data: [<?=$jumlah_status[0];?>, <?=$jumlah_status[1];?>],
                                  backgroundColor: ['#1cc88a', '#e74a3b'],
                                  hoverBackgroundColor: ['#17a673', '#aa1f13'],
                                  hoverBorderColor: "rgba(234, 236, 244, 1)",
                                }],
                              },
                              options: {
                                maintainAspectRatio: false,
                                legend: {
                                  display: true,
                                  position: 'bottom'
                                },
                                cutoutPercentage: 60,
                              },
                            });

                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col">
          <!-- Bar Chart -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Total Pelanggaran Prodi</h6>
                </div>
                <div class="card-body">
                  <div class="chart-bar">
                    <canvas id="semuaProdi"></canvas>
                    <script>
                        var ctx = document.getElementById("semuaProdi");
                        var semuaProdi = new Chart(ctx, {
                          type: 'bar',
                          data: {
                            labels: [
                            <?php if($pelanggaranProdi[0] != NULL){
                              foreach ($pelanggaranProdi[0] as $row):
                                echo "'$row',";
                            endforeach;
                            }?>
                            ],
                            datasets: [{
                              label: "Total Mahasiswa",
                              backgroundColor: "#6610f2",
                              data: [
                                <?php if($pelanggaranProdi[1] != NULL){
                                  foreach ($pelanggaranProdi[1] as $row):
                                    echo $row.",";
                                endforeach;
                                }?>
                              ],
                                maxBarThickness: 50,
                            }],
                          },
                          options: {
                            title: {
                                display: true,
                                text: "Total Pelanggaran Prodi"
                            },
                            maintainAspectRatio: false,
                            layout: {
                              padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                              }
                            },
                            scales: {
                              xAxes: [{
                                time: {
                                  unit: 'Bulan'
                                },
                                gridLines: {
                                  display: false,
                                  drawBorder: false
                                },
                              }],
                              yAxes: [{
                                gridLines: {
                                  color: "rgb(234, 236, 244)",
                                  zeroLineColor: "rgb(234, 236, 244)",
                                  drawBorder: false,
                                  borderDash: [2],
                                  zeroLineBorderDash: [2]
                                },
                                ticks: {
                                      beginAtZero: true, 
                                      stepSize: 1,
                                  },
                              }],
                            },
                            legend: {
                              display: true,
                              position: 'top'
                            },
                          }
                        });
                    </script>
                  </div>
                </div>
            </div>
      </div>   
    </div>
</div>
