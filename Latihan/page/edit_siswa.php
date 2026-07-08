<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Siswa</h1>
            </div>
        </div>
    </div>
</div>

    <?php
    $kd = $_GET['kd'];
    $edit = mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM siswa WHERE Nis='$kd'"));

    if(isset($_POST['tambah'])){
        $Nis = $_POST['Nis'];
        $Nm_siswa = $_POST['Nm_siswa'];
        $Jenkel = $_POST['Jenkel'];
        $Hp = $_POST['Hp'];
        $Id_kelas = $_POST['Id_kelas'];
        
        $insert = mysqli_query($koneksi,"UPDATE siswa SET Nm_siswa='$Nm_siswa', Jenkel='$Jenkel', Hp='$Hp', Id_kelas='$Id_kelas' WHERE Nis='$Nis'");
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
                                <input type="text" name="Nis" value="<?= $edit['Nis']; ?>" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label for="Nm_siswa">Nama Siswa</label>
                                <input type="text" name="Nm_siswa" value="<?= $edit['Nm_siswa']; ?>" id="Nm_siswa" placeholder="Nama guru" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="Jenkel">Jenkel</label>
                                <input type="text" name="Jenkel" value="<?= $edit['Jenkel']; ?>" id="Jenkel" placeholder="Jenkel" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="Hp">Hp</label>
                                <input type="text" name="Hp" value="<?= $edit['Hp']; ?>" id="Hp" placeholder="Hp" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="Id_kelas">Id Kelas</label>
                                <input type="text" name="Id_kelas" value="<?= $edit['Id_kelas']; ?>" id="Id_kelas" placeholder="Id_kelas" class="form-control">
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