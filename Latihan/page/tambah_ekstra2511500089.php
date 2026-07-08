<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Data Ekstrakurikuler</h1>
      </div>
    </div>
  </div>
</div>
<?php
//kode otomatis
$carikode = mysqli_query($koneksi,"select max(id_ekstra089) from ekstra_2511500089") or die (
    mysqli_error());
$datakode = mysqli_fetch_array($carikode);
if($datakode) {
    $nilaikode = substr($datakode[0], 2);
    $kode = (int) $nilaikode;
    $kode = $kode + 1;
    $hasilkode = "E-".str_pad($kode, 3, "0", STR_PAD_LEFT);
} else {$hasilkode = "E-"; }
$_SESSION['KODE'] = $hasilkode;

if(isset($_POST['tambah'])) {
    $id_ekstra089 = $_POST['id_ekstra089'];
    $nama_ekstra089 = $_POST['nama_ekstra089'];
    $ket089	 = $_POST['ket089'];
    $semester089 = $_POST['semester089'];
    $thn_ajaran089	 = $_POST['thn_ajaran089'];

    $insert = mysqli_query($koneksi,"INSERT INTO ekstra_2511500089 values ('$id_ekstra089','$nama_ekstra089','$ket089','$semester089','$thn_ajaran089')");
    if ($insert) {
        echo '<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert"
        aria-hidden="true">×</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=ekstra2511500089">';
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
                            <label for="id_ekstra089">Id Ekstrakurikuler</label>
                            <input type="text" name="id_ekstra089" value="<?= $hasilkode; ?>" placeholder="Id Ekstrakurikuler" class="form-control" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="nama_ekstra089">Nama Ekstrakurikuler</label>
                            <input type="text" name="nama_ekstra089" id="nama_ekstra089" placeholder="Nama Ekstrakurikuler" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="ket089">Keterangan</label>
                            <input type="text" name="ket089" id="ket089" placeholder="Keterangan" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="semester089">Semester</label>
                            <input type="text" name="semester089" id="semester089" placeholder="Semester" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="thn_ajaran089">Tahun Ajaran</label>
                            <input type="text" name="thn_ajaran089" id="thn_ajaran089" placeholder="Tahun Ajaran" class="form-control">
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