<?php
if (isset($_GET['hapus'])) {
    $Id_jadwal = $_GET['hapus'];

    // Hapus detail jadwal dulu
    mysqli_query($koneksi, "DELETE FROM detail_kelas WHERE Id_jadwal = '$Id_jadwal'");

    // Lalu hapus jadwal
    $hapus = mysqli_query($koneksi, "DELETE FROM jadwal_kelas WHERE Id_jadwal = '$Id_jadwal'");

    if ($hapus) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Berhasil!</strong> Data jadwal telah dihapus.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Gagal!</strong> Tidak dapat menghapus data.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
    }
}
?>

<div class ="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Data Jadwal</h1>
        </div>
    </div>
</div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                 <?php if ($role == 'admin') { ?>
                <a href="index.php?page=tambah_jadwalkls" class="btn btn-primary btn-sm">
                    Tambah Jadwal</a>
        </a>
    <?php } ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id Jadwal</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Detail Jadwal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM jadwal_kelas JOIN kelas ON jadwal_kelas.Id_kelas = kelas.Id_kelas");
                        while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>
                                <td>{$row['Id_jadwal']}</td>
                                <td>{$row['Nm_kelas']}</td>
                                <td>{$row['Thn_ajaran']}</td>
                                <td>{$row['Semester']}</td>
                                <td>
                                <ul>";
                             $det = mysqli_query($koneksi, "SELECT d.*, m.Nm_mapel, g.Nm_guru 
                                FROM detail_kelas d 
                                JOIN mapel m ON d.Kd_mapel = m.Kd_mapel 
                                JOIN guru g ON d.Kd_guru = g.Kd_guru
                                WHERE d.Id_jadwal = '{$row['Id_jadwal']}'");
                            while ($d = mysqli_fetch_assoc($det)) {
                                echo "<li>{$d['Nm_mapel']} - {$d['Nm_guru']} - {$d['Hari']} - {$d['Jam']}</li>";
                            }
                            echo "</ul></td><td>";
                            if ($role == 'admin') {
                                echo "<a href='index.php?page=jadwal_kelas&hapus={$row['Id_jadwal']}' 
                                onclick=\"return confirm('yakin ingin menghapus data ini?')\" 
                                class='btn btn-danger btn-sm'>Hapus</a>";
                                }
                                echo "<a href='cetak_kelas.php?Id_jadwal={$row['Id_jadwal']}' 
                                target='_blank'
                                class='btn btn-success btn-sm'>Cetak</a>
                                </td>
                                </tr>";
                                }
                        ?>
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>