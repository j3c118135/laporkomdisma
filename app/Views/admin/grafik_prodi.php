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
        <li class="breadcrumb-item"><a href="#">Grafik</a></li>
        <li class="breadcrumb-item active" aria-current="page">Grafik Program Studi</li>
      </ol>
    </nav>


    <!-- chart pelanggaran perbulan -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="<?php echo base_url('grafik/prodi'); ?>">
            <div class="form-row align-items-center">
                <lable class="col-md-auto col-sm-12 col-form-label">Prodi</lable>
                <div class="col-md-2 col-sm-12">
                  <select class="custom-select" name="prodi2" required>
                      <option selected disabled value="">Pilih...</option>
                      <option value="A-KMN">A-KMN</option>
                      <option value="B-EKW">B-EKW</option>
                      <option value="C-INF">C-INF</option>
                      <option value="D-TEK">D-TEK</option>
                      <option value="E-JMP">E-JMP</option>
                      <option value="F-GZI">F-GZI</option>
                      <option value="G-TIB">G-TIB</option>
                      <option value="H-IKN">H-IKN</option>
                      <option value="I-TNK">I-TNK</option>
                      <option value="J-MAB">J-MAB</option>
                      <option value="K-MNI">K-MNI</option>
                      <option value="L-KIM">L-KIM</option>
                      <option value="M-LNK">M-LNK</option>
                      <option value="N-AKN">N-AKN</option>
                      <option value="P-PVT">P-PVT</option>
                      <option value="T-TMP">T-TMP</option>
                      <option value="W-PPP">W-PPP</option>
                  </select>
                </div>
                <div class="from-group col-md-auto mt-sm-3 mt-md-0">
                    <button type="submit" class="btn btn-primary btn-block">Terapkan</button>
                </div>
              </div>
            </form>
            <div class="chart-bar">
                <canvas id="myBarChart"></canvas>
                <script>
                    var ctx = document.getElementById("myBarChart");
                    var myBarChart = new Chart(ctx, {
                      type: 'bar',
                      data: {
                        labels: [
                        <?php if($pelanggaranPerbulan[0] != NULL){
                          foreach ($pelanggaranPerbulan[0] as $row):
                            echo "'$row',";
                        endforeach;
                        }?>
                        ],
                        datasets: [{
                          label: "Total Mahasiswa",
                          backgroundColor: "#6610f2",
                          data: [
                            <?php if($pelanggaranPerbulan[1] != NULL){
                              foreach ($pelanggaranPerbulan[1] as $row):
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
                            text: "Total Pelanggaran Mahasiswa Prodi <?=$pelanggaranPerbulan[2];?> Per Bulan "
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
    
    <!-- chart pelanggaran perbulan berdasarkan kategori & jenis pelanggaran -->
    <div class="card shadow mb-4">
      <div class="card-body">
          <form method="POST" action="<?php echo base_url('grafik/prodi'); ?>">
              <div class="form-row">
                <lable class="col-md-auto col-sm-12 col-form-label">Prodi</lable>
                <div class="col-md-2 col-sm-12">
                  <select class="custom-select" name="prodi2" required>
                      <option selected disabled value="">Pilih...</option>
                      <option value="A-KMN">A-KMN</option>
                      <option value="B-EKW">B-EKW</option>
                      <option value="C-INF">C-INF</option>
                      <option value="D-TEK">D-TEK</option>
                      <option value="E-JMP">E-JMP</option>
                      <option value="F-GZI">F-GZI</option>
                      <option value="G-TIB">G-TIB</option>
                      <option value="H-IKN">H-IKN</option>
                      <option value="I-TNK">I-TNK</option>
                      <option value="J-MAB">J-MAB</option>
                      <option value="K-MNI">K-MNI</option>
                      <option value="L-KIM">L-KIM</option>
                      <option value="M-LNK">M-LNK</option>
                      <option value="N-AKN">N-AKN</option>
                      <option value="P-PVT">P-PVT</option>
                      <option value="T-TMP">T-TMP</option>
                      <option value="W-PPP">W-PPP</option>
                  </select>
                </div>
                <label class="col-md-auto col-sm-12 col-form-label">Kategori Pelanggaran</label>
                <div class="col-md-2 col-sm-12">
                  <select class="custom-select" name="kategoriP" id="kategoriP" required>
                      <option selected disabled value="">Pilih...</option>
                      <?php foreach ($Kpelanggarans as $Kpelanggaran):?>
                          <option value="<?= $Kpelanggaran->id?>">Pelanggaran <?= $Kpelanggaran->nama?></option>
                      <?php endforeach;?>
                  </select>
                </div>
                <label class="col-md-auto col-sm-12 col-form-label">Jenis Pelanggaran</label>
                <div class="col-md-2 col-sm-12">
                  <select class="custom-select" name="jenisP" id="jenisP" required>
                  <option selected disabled value="">Pilih...</option>
                  </select>
                <div class="invalid-feedback">
                  </div>
                </div>
                <div class="from-group col-md-auto mt-sm-3 mt-md-0">
                    <button type="submit" class="btn btn-primary btn-block">Terapkan</button>
                </div>
              </div>
          </form>
          <div class="chart-bar">
              <canvas id="pelanggaranKategori"></canvas>
              <script>
                var ctx = document.getElementById("pelanggaranKategori");
                var pelanggaranKategori = new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: [
                      <?php if($pelanggaranKategori[0] != NULL){
                        foreach ($pelanggaranKategori[0] as $row):
                          echo "'$row',";
                      endforeach;
                      }?>
                    ],
                    datasets: [{
                      label: "Total Mahasiswa",
                      backgroundColor: "#e83e8c",
                      data: [<?php if($pelanggaranKategori[1] != NULL){
                                    foreach ($pelanggaranKategori[1] as $row):
                                      echo $row.",";
                                  endforeach;
                                  }?>],
                        maxBarThickness: 50,
                    }],
                  },
                  options: {
                    title: {
                        display: true,
                        text: "Total Pelanggaran Mahasiswa Prodi <?=$pelanggaranKategori[4];?> Per Bulan dengan Kategori Pelanggaran <?= $pelanggaranKategori[2];?> dan Jenis Pelanggaran <?= $pelanggaranKategori[3]?>"
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
    
    <!-- chart pelanggaran perbulan berdasarkan lokasi-->
    <div class="card shadow mb-4">
      <div class="card-body">
        <form method="POST" action="<?php echo base_url('grafik/prodi'); ?>">
            <div class="form-row align-items-center">
                <lable class="col-md-auto col-sm-12 col-form-label">Prodi</lable>
                <div class="col-md-2 col-sm-12">
                  <select class="custom-select" name="prodi3" required>
                      <option selected disabled value="">Pilih...</option>
                      <option value="A-KMN">A-KMN</option>
                      <option value="B-EKW">B-EKW</option>
                      <option value="C-INF">C-INF</option>
                      <option value="D-TEK">D-TEK</option>
                      <option value="E-JMP">E-JMP</option>
                      <option value="F-GZI">F-GZI</option>
                      <option value="G-TIB">G-TIB</option>
                      <option value="H-IKN">H-IKN</option>
                      <option value="I-TNK">I-TNK</option>
                      <option value="J-MAB">J-MAB</option>
                      <option value="K-MNI">K-MNI</option>
                      <option value="L-KIM">L-KIM</option>
                      <option value="M-LNK">M-LNK</option>
                      <option value="N-AKN">N-AKN</option>
                      <option value="P-PVT">P-PVT</option>
                      <option value="T-TMP">T-TMP</option>
                      <option value="W-PPP">W-PPP</option>
                  </select>
                </div>
              <label class="col-md-auto col-sm-12 col-form-label">Lokasi Pelanggaran</label>
              <div class="col-md-3 col-sm-12">
                <select class="custom-select" name="lokasi" id="lokasi" required>
                    <option selected disabled value="">Pilih...</option>
                    <?php foreach ($lokasis as $lokasi):?>
                        <option value="<?= $lokasi->id?>"><?= $lokasi->nama?></option>
                    <?php endforeach;?>
                </select>
              </div>
              <div class="from-group col-md-auto mt-sm-3 mt-md-0">
                    <button type="submit" class="btn btn-primary btn-block">Terapkan</button>
                </div>
            </div>
        </form>
        <div class="chart-bar">
            <canvas id="pelanggaranLokasi"></canvas>
            <script>
              var ctx = document.getElementById("pelanggaranLokasi");
              var pelanggaranLokasi = new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: [
                    <?php if($pelanggaranLokasi[0] != NULL){
                      foreach ($pelanggaranLokasi[0] as $row):
                        echo "'$row',";
                    endforeach;
                    }?>
                  ],
                  datasets: [{
                    label: "Total Mahasiswa",
                    backgroundColor: "#fd7e14",
                    data: [<?php if($pelanggaranLokasi[1] != NULL){
                      foreach ($pelanggaranLokasi[1] as $row):
                        echo $row.",";
                    endforeach;
                    }?>],
                      maxBarThickness: 50,
                  }],
                },
                options: {
                  title: {
                      display: true,
                      text: "Total Pelanggaran Mahasiswa Prodi <?= $pelanggaranLokasi[3];?> Per Bulan di <?= $pelanggaranLokasi[2];?>"
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

    <!-- chart pelanggaran perbulan berdasarkan sanksi-->
    <div class="card shadow mb-4">
      <div class="card-body">
        <form method="POST" action="<?php echo base_url('grafik/prodi'); ?>">
            <div class="form-row align-items-center">
                <lable class="col-md-auto col-sm-12 col-form-label">Prodi</lable>
                <div class="col-md-2 col-sm-12 col-sm-10">
                  <select class="custom-select" name="prodi4" required>
                      <option selected disabled value="">Pilih...</option>
                      <option value="A-KMN">A-KMN</option>
                      <option value="B-EKW">B-EKW</option>
                      <option value="C-INF">C-INF</option>
                      <option value="D-TEK">D-TEK</option>
                      <option value="E-JMP">E-JMP</option>
                      <option value="F-GZI">F-GZI</option>
                      <option value="G-TIB">G-TIB</option>
                      <option value="H-IKN">H-IKN</option>
                      <option value="I-TNK">I-TNK</option>
                      <option value="J-MAB">J-MAB</option>
                      <option value="K-MNI">K-MNI</option>
                      <option value="L-KIM">L-KIM</option>
                      <option value="M-LNK">M-LNK</option>
                      <option value="N-AKN">N-AKN</option>
                      <option value="P-PVT">P-PVT</option>
                      <option value="T-TMP">T-TMP</option>
                      <option value="W-PPP">W-PPP</option>
                  </select>
                </div>
              <label class="col-md-auto col-sm-12 col-form-label">Sanksi</label>
              <div class="col-md-3 col-sm-12">
                <select class="custom-select" name="sanksi" id="sanksi" required>
                    <option selected disabled value="">Pilih...</option>
                    <?php foreach ($sanksis as $sanksi):?>
                        <option value="<?= $sanksi->id?>"><?= $sanksi->nama?></option>
                    <?php endforeach;?>
                </select>
              </div>
              <div class="from-group col-md-auto mt-sm-3 mt-md-0">
                    <button type="submit" class="btn btn-primary btn-block">Terapkan</button>
                </div>
            </div>
        </form>
        <div class="chart-bar">
            <canvas id="pelanggaranSanksi"></canvas>
            <script>
              var ctx = document.getElementById("pelanggaranSanksi");
              var pelanggaranSanksi = new Chart(ctx, {
                type: 'bar',
                data: {
                  labels: [<?php if($pelanggaranSanksi[0] != NULL){
                      foreach ($pelanggaranSanksi[0] as $row):
                        echo "'$row',";
                    endforeach;
                    }?>
                  ],
                  datasets: [{
                    label: "Total Mahasiswa",
                    backgroundColor: "#20c9a6",
                    data: [<?php if($pelanggaranSanksi[1] != NULL){
                      foreach ($pelanggaranSanksi[1] as $row):
                        echo $row.",";
                    endforeach;
                    }?>],
                      maxBarThickness: 50,
                  }],
                },
                options: {
                  title: {
                      display: true,
                      text: "Total Pelanggaran Mahasiswa Prodi <?= $pelanggaranSanksi[3];?> Per Bulan dengan Sanksi <?= $pelanggaranSanksi[2];?>"
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
<?= $this->endSection();?>
