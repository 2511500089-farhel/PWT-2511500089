<div class="content-header">
    <div class="container-fluid">
        <div class ="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Detail Jadwal</h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <?php 
                $hasil = mysqli_query($koneksi, "SELECT * FROM jadwal_kelas");
                $data = mysqli_fetch_array($hasil);
                ?>
                <br>
                <a href="cetak.php" target="_blank" class="btn btn-danger">Download PDF</a>
                <table>
                    <tr>
                        <td>Tahun Ajaran</td>
                        <td>:</td>
                        <td>  </td>
                        <td><?= $data['Thn_ajaran']; ?></td>
                    </tr>
                    <tr>
                        <td>Semester</td>
                        <td>:</td>
                        <td>  </td>
                        <td><?= $data['Semester']; ?></td>
                    </tr>
                    <tr>
                        <td>Kelas</td>
                        <td>:</td>
                        <td>  </td>
                        <td><?= $data['Kelas']; ?></td>
                    </tr>
                </table>
            <br><strong>DETAIL JADWAL KELAS</strong>
            <table class="table table-striped">
                <tread>
                    <tr>
                        <th>NO</th>
                        <th>Kd Mapel</th>
                        <th>Nama Mapel</th>
                        <th>Nama Guru</th>
                        <th>Hari</th>
                        <th>Jam</th>
                    </tr>
                </tread>
                <?php
                $no =0;
                $query = mysqli_query($koneksi,"SELECT * FROM jadwal_kelas
                JOIN detail_jadwal ON jadwal_kelas.Id_jadwal=detail_jadwal.Id_jadwal
                JOIN mapel ON mapel.Kd_mapel=detail_jadwal.Kd_mapel
                JOIN guru ON guru.Kd_guru=detail_jadwal.Kd_guru");
                while ($result = mysqli_fetch_array($query) ) {
                    $no++
                    ?>
                    <tbody>
                        <tr>
                            <td><?= $no;?></td>
                            <td><?=$result['Kd_mapel']; ?></td>
                            <td><?=$result['Nm_mapel']; ?></td>
                            <td><?=$result['Nm_guru']; ?></td>
                            <td><?=$result['Hari']; ?></td>
                            <td><?=$result['Jam_mulai']; ?> s.d <?=$result['Jam_selesai']; ?></td>
                        </tr>
                    </tbody>
                <?php } ?>
            </table>
            </div>
        </div>
    </div>
</div>