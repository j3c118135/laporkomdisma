<!DOCTYPE html>
<head>
    <title>Surat Bebas Komdisma</title>
    <meta charset="utf-8">

</head>

<body>
    <!--Surat-->
        <div class="surat" style="margin : 0 25px">
            <br>
            <table>
                <tr>
                    <td><img src="https://4.bp.blogspot.com/-kg9B6SrjXvA/WazwA8sn6EI/AAAAAAAAAD8/7MaFbH1120sAozsSwsTVmju4ywhkKbQNQCLcBGAs/s1600/logo_IPB.svg-image4144-4294966727.png" style="width:90px;"> </td>
                    <td><p align="center" style="line-height: 1px;margin-left:35px;"> KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN </p>
                    <p align="center" style="line-height: 1px;margin-left:25px;"> INSTITUT PERTANIAN BOGOR </p>
                    <p align="center" style="line-height: 1px;margin-left:25px;"> SEKOLAH VOKASI</p>
                    <p align="center" style="line-height: 1px;margin-left:25px;"> Kampus IPB Cilibende, Jl. Kumbang No.14 Bogor 16151</p>
                    <p align="center" style="line-height: 1px;margin-left:25px;"> Telp. (0251) 8329101, 8329101, Fax (0251) 8348007</p></td>
                    <td><p align="center" style="margin-top:-80px; margin-left:5px">FRM/SV/DIS/004</p><td>
                </tr>
            </table>
                <hr>
                <br>
                <p class="judul" align="center"><b>SURAT KETERANGAN</b></p>
                <br>
                <br>                
                <div class="isi-surat">
                        <table class="tabel-surat-mahasiswa" style="padding-left:30px;">
                            <tr>
                                <td class="data-mahasiswa" colspan="3" style="width: 100%; padding-bottom: 20px;">
                                Bersama ini menerangkan bahwa mahasiswa :
                                </td>
                            </tr>
                            <tr>
                                <td class="data-mahasiswa" style="width: 30%;">Nama</td>
                                <td class="data-mahasiswa" style="width: 1%">:</td>
                                <td class="data-mahasiswa" style="width: 65%;"><?= $user->nama ;?></td>
                            </tr>
                            <tr>
                                <td class="data-mahasiswa" style="width: 30%;">NIM</td>
                                <td class="data-mahasiswa" style="width: 1%">:</td>
                                <td class="data-mahasiswa" style="width: 65%;"><?= $user->nim ;?></td>
                            </tr>
                            <tr>
                                <td class="data-mahasiswa" style="width: 30%; vertical-align: top;">Program Studi</td>
                                <td class="data-mahasiswa" style="width: 1%">:</td>
                                <td class="data-mahasiswa" style="width: 65%;"><?= $prodi ;?></td>
                            </tr>
                            <tr>
                                <td class="data-mahasiswa" colspan="3" style="width: 100%; padding-top: 10px;">
                                <p>Telah menyelesaikan kewajiban tatap muka <?= $jum_lapor;?> kali kepada Komisi Disiplin dan Kemahasiswaan pada tanggal <?php setlocale(LC_TIME, 'id_ID'); echo strftime("%d %B %Y",strtotime($tgl_terakhir_lapor));?>.</p>
                                <p>Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
                                </td>
                            </tr>
                        </table>

                        
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="ttd-surat">
                        <div style="width: 50%; text-align: left; float: right;">Bogor, <?php setlocale(LC_TIME, 'id_ID'); echo strftime("%d %B %Y",strtotime($tgl_surat_bebas));?></div><br>
                        <div style="width: 50%; text-align: left; float: right;">Komisi Disiplin dan Kemahasiswaan</div><br><br><br><br><br><br><br><br>
                        <div style="width: 50%; text-align: left; float: right;"><img src="https://raw.githubusercontent.com/komdismasvipb/ttdsurat/main/foto/<?= $nama_inspektur;?>.jpg" style="width:170px; margin-top:-120px"></div><br><br>
                        <div style="width: 50%; text-align: left; float: right;"><?= $nama_inspektur;?></div><br>
                    </div>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <table>
                    <thead>
                        <tr>
                            <td class="data-mahasiswa" style="width: 30%;">No Revisi : 00</td>
                            <td class="data-mahasiswa" style="width: 5%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hal : 1/1</td>
                            <td class="data-mahasiswa" style="width: 65%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tanggal Berlaku : 7 Juli 2019</td>
                        </tr>
                    </thead>
                </table>
        </div>
    <!-- end surat -->
</body>

