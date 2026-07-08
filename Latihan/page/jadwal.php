<?php
if (isset($_GET['hapus'])) {
    $Kd_jadwal = $_GET['hapus'];

    // Hapus detail jadwal dulu
    mysqli_query($koneksi, "DELETE FROM detail_jadwal WHERE Kd_jadwal = '$Kd_jadwal'");

    // Lalu hapus jadwal
    $hapus = mysqli_query($koneksi, "DELETE FROM jadwal WHERE Kd_jadwal = '$Kd_jadwal'");

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
                <a href="index.php?page=tambah_jadwal" class="btn btn-primary btn-sm">
                    Tambah Jadwal</a>
        </a>
    <?php } ?>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Kode Jadwal</th>
                            <th>Guru</th>
                            <th>Semester</th>
                            <th>Tahun Ajaran</th>
                            <th>Detail Jadwal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = mysqli_query($koneksi, "SELECT * FROM jadwal JOIN guru ON jadwal.Kd_guru = guru.Kd_guru");
                        while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>
                                <td>{$row['Kd_jadwal']}</td>
                                <td>{$row['Nm_guru']}</td>
                                <td>{$row['Semester']}</td>
                                <td>{$row['Tahun_ajaran']}</td>
                                <td>
                                <ul>";
                             $det = mysqli_query($koneksi, "SELECT d.*, m.Nm_mapel FROM detail_jadwal d 
                                JOIN mapel m ON d.Kd_mapel = m.Kd_mapel 
                                WHERE Kd_jadwal = '{$row['Kd_jadwal']}'");
                            while ($d = mysqli_fetch_assoc($det)) {
                                echo "<li>{$d['Nm_mapel']} - {$d['Hari']} - {$d['Jam']} - {$d['Kelas']}</li>";
                            }
                            echo "</ul></td><td>";
                            if ($role == 'admin') {
                                echo "<a href='index.php?page=jadwal&hapus={$row['Kd_jadwal']}' 
                                onclick=\"return confirm('yakin ingin menghapus data ini?')\" 
                                class='btn btn-danger btn-sm'>Hapus</a>";
                                }
                                echo "<a href='cetak_jadwal.php?Kd_jadwal={$row['Kd_jadwal']}' 
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