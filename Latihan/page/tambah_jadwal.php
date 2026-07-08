<div class="content-header">
    <div class="container-fluid">
        <div class ="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Data Jadwal</h1>
            </div>
        </div>
    </div>
</div>

<?php
$carikode = mysqli_query($koneksi, "SELECT MAX(Kd_jadwal) FROM jadwal") or die(mysqli_error($koneksi));
$datakode = mysqli_fetch_array($carikode);

if ($datakode && $datakode[0] != null) {
    $nilaikode = substr($datakode[0], 2);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $hasilkode = "J-" . str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {
    $hasilkode = "J-001"; // atau bisa juga default "M-001"
}

$_SESSION["KODE"] = $hasilkode;

if(isset($_POST['tambah'])){
    $Kd_jadwal = $_POST['Kd_jadwal'];
    $Kd_guru = $_POST['Kd_guru'];
    $Semester = $_POST['Semester'];
    $Tahun_ajaran = $_POST['Tahun_ajaran'];

    $Kd_mapel = $_POST['Kd_mapel'];
    $Hari = $_POST['Hari'];
    $Jam = $_POST['Jam'];
    $Kelas = $_POST['Kelas'];

    // Insert ke tabel jadwal
    $insertjadwal = mysqli_query($koneksi, "INSERT INTO jadwal VALUES ('$Kd_jadwal', '$Kd_guru', '$Semester', '$Tahun_ajaran')");

    if (!$insertjadwal) {
        echo "Gagal insert ke tabel jadwal: " . mysqli_error($koneksi);
        die;
    }

    // Insert ke detail_jadwal
    $allSuccess = true;
    for ($i = 0; $i < count($Kd_mapel); $i++) {
        $insert = mysqli_query($koneksi, "INSERT INTO detail_jadwal (Kd_jadwal, Kd_mapel, Hari, Jam, Kelas)
        VALUES ('$Kd_jadwal', '{$Kd_mapel[$i]}', '{$Hari[$i]}', '{$Jam[$i]}', '{$Kelas[$i]}')");
        if (!$insert) {
            $allSuccess = false;
            echo "Gagal insert detail ke-$i: " . mysqli_error($koneksi);
        }
    }

    if ($allSuccess) {
        echo '<div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info</h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=jadwal">';
    } else {
        echo '<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info</h5>
        <h4>Gagal menyimpan sebagian atau seluruh data detail.</h4></div>';
    }
}
    ?>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h3>Tambah Jadwal</h3>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Kode Jadwal</label>
                            <input type="text" name="Kd_jadwal" value="<?= $hasilkode ?>" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Guru</label>
                            <select name="Kd_guru" class="form-control">
                                <tr>
                                    <?php
                                    $guru = mysqli_query($koneksi, "SELECT * FROM guru");
                                    while ($g = mysqli_fetch_assoc($guru)) {
                                        echo "<option value='{$g['Kd_guru']}'>{$g['Nm_guru']}</option>";
                                    }
                                    ?>
                            </select>
                                                    </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <select name="Semester" class="form-control" required>
                                <option selected disabled>--Pilih Semester--</option>
                                <option>Ganjil</option>
                                <option>Genap</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tahun Ajaran</label>
                            <select name="Tahun_ajaran" class="form-control" required>
                                <option selected disabled>--Pilih Tahun Ajaran--</option>
                                <option>2024-2025</option>
                                <option>2025-2026</option>
                            </select>
                    </div>

                    <hr>
                    <h5>Detail Jadwal</h5>
                    <div id="detail_jadwal">
                        <div class="row mb-2">
                            <div class="col-md-3">
                                <select name="Kd_mapel[]" class="form-control">
                                    <option selected disabled>--Pilih Mapel--</option>
                                    <?php
                                    $mapel = mysqli_query($koneksi, "SELECT * FROM mapel");
                                    while ($m = mysqli_fetch_assoc($mapel)) {
                                        echo "<option value='{$m['Kd_mapel']}'>{$m['Nm_mapel']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="Hari[]" class="form-control" required>
                                    <option selected disabled>--Pilih Hari--</option>
                                    <option>Senin</option>
                                    <option>Selasa</option>
                                    <option>Rabu</option>
                                    <option>Kamis</option>
                                    <option>Jumat</option>
                                    <option>Sabtu</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="Jam[]" class="form-control" required>
                                    <option selected disabled>--Pilih Jam--</option>
                                    <option>08.00-10.00</option>
                                    <option>08.00-09.30</option>
                                    <option>10.30-12.00</option>
                                    <option>12.30-14.00</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="Kelas[]" class="form-control" placeholder="Kelas" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-info" onclick="tambahBaris()">+ Tambah Mapel</button>
                        <br><br>
                        <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
                    </form>
                    
                    <script>
                    function tambahBaris() {
                        let container = document.getElementById('detail_jadwal');
                        let row = container.firstElementChild.cloneNode(true);
                        row.querySelectorAll('input').forEach(input => input.value = '');
                        container.appendChild(row);
                        }
                        </script>

                        </div>
                    </div>
                </div>
            </div>