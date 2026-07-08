<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data Guru</h1>
      </div>
    </div>
  </div>
</div>
<?php
//kode otomatis
$carikode = mysqli_query($koneksi,"select max(Kd_guru) from guru") or die (
    mysqli_error());
$datakode = mysqli_fetch_array($carikode);
if($datakode) {
    $nilaikode = substr($datakode[0], 2);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $hasilkode = "K-".str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {$hasilkode = "K-"; }
$_SESSION['KODE'] = $hasilkode;

if(isset($_POST['tambah'])) {
    $Kd_guru = $_POST['Kd_guru'];
    $Nm_guru = $_POST['Nm_guru'];
    $Jenkel = $_POST['Jenkel'];
    $Pend_terakhir = $_POST['Pend_terakhir'];
    $Hp = $_POST['Hp'];
    $Alamat = $_POST['Alamat'];

    $username = $_POST['username'];
    $password = '1234';
    $role = "guru";

    $insert = mysqli_query($koneksi,"INSERT INTO guru values ('$Kd_guru','$Nm_guru','$Jenkel','$Pend_terakhir','$Hp','$Alamat')");

    $insert = mysqli_query($koneksi,"INSERT INTO users (username, password, role) values ('$username','$password','$role')");
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=guru">';
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
                            <label for="Kd_guru">Kode Guru</label>
                            <input type="text" name="Kd_guru" value="<?= $hasilkode; ?>" placeholder="Kd Guru" class="form-control" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="Nm_guru">Nama Guru</label>
                            <input type="text" name="Nm_guru" id="Nm_guru" placeholder="Nama Guru" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Jenkel">Jenkel</label>
                            <input type="text" name="Jenkel" id="Jenkel" placeholder="Jenkel" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Pend_terakhir">Pendidikan Terakhir</label>
                            <input type="text" name="Pend_terakhir" id="Pend_terakhir" placeholder="Pendidikan Terakhir" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Hp">Hp</label>
                            <input type="text" name="Hp" id="Hp" placeholder="Hp" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Alamat">Alamat</label>
                            <input type="text" name="Alamat" id="Alamat" placeholder="Alamat" class="form-control">
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