<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data Siswa</h1>
      </div>
    </div>
  </div>
</div>
<?php
//kode otomatis
$carikode = mysqli_query($koneksi,"select max(Nis) from siswa") or die (
    mysqli_error());
$datakode = mysqli_fetch_array($carikode);
if($datakode) {
    $nilaikode = substr($datakode[0], 2);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $hasilkode = "S-".str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {$hasilkode = "S-"; }
$_SESSION['KODE'] = $hasilkode;

if(isset($_POST['tambah'])) {
    $Nis = $_POST['Nis'];
    $Nm_siswa = $_POST['Nm_siswa'];
    $Jenkel = $_POST['Jenkel'];
    $Hp = $_POST['Hp'];
    $Id_kelas = $_POST['Id_kelas'];

    $username = $_POST['username'];
    $password = '1234';
    $role = "siswa";

    $insert = mysqli_query($koneksi,"INSERT INTO siswa values ('$Nis','$Nm_siswa','$Jenkel','$Hp','$Id_kelas')");

    $insert = mysqli_query($koneksi,"INSERT INTO users (username, password, role) values ('$username','$password','$role')");
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=siswa">';
    } else {
        echo '<div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Gagal Disimpan</h4></div>';
    }
}
?>
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="card-body p-2">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="Nis">NIS</label>
                            <input type="text" name="Nis" value="<?= $hasilkode; ?>" placeholder="NIS" class="form-control" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="Nm_siswa">Nama Siswa</label>
                            <input type="text" name="Nm_siswa" id="Nm_siswa" placeholder="Nama Siswa" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Jenkel">Jenkel</label>
                            <input type="text" name="Jenkel" id="Jenkel" placeholder="Jenkel" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Hp">Hp</label>
                            <input type="text" name="Hp" id="Hp" placeholder="Hp" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Id_kelas">Id_kelas</label>
                            <input type="text" name="Id_kelas" id="Id_kelas" placeholder="Id Kelas" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" placeholder="Username" class="form-control">
                        </div>

                        <div class="card-footer">
                            <input type="submit" class="btn btn-primary" name="tambah" value="simpan">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>