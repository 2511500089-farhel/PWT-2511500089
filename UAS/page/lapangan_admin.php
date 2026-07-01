<?php
// proses tambah data lapangan
if (isset($_POST['tambah'])) {
    $nama_lapangan = mysqli_real_escape_string($koneksi, $_POST['nama_lapangan']);
    $harga_perjam = mysqli_real_escape_string($koneksi, $_POST['harga_perjam']);

    mysqli_query($koneksi, "INSERT INTO lapangan (nama_lapangan, harga_perjam) VALUES ('$nama_lapangan', '$harga_perjam')");
    echo "<script>window.location='index.php?page=lapangan_admin'</script>";
}

// proses edit data lapangan
if (isset($_POST['edit'])) {
    $id_lapangan = mysqli_real_escape_string($koneksi, $_POST['id_lapangan']);
    $nama_lapangan = mysqli_real_escape_string($koneksi, $_POST['nama_lapangan']);
    $harga_perjam = mysqli_real_escape_string($koneksi, $_POST['harga_perjam']);

    mysqli_query($koneksi, "UPDATE lapangan SET nama_lapangan = '$nama_lapangan', harga_perjam = '$harga_perjam' WHERE id_lapangan = '$id_lapangan'");
    echo "<script>window.location='index.php?page=lapangan_admin'</script>";
}

// proses hapus data lapangan
if (isset($_GET['hapus'])) {
    $id_lapangan = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM lapangan WHERE id_lapangan = '$id_lapangan'");
    echo "<script>window.location='index.php?page=lapangan_admin'</script>";
}
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data Lapangan</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahLapangan">
        <i class="fas fa-plus"></i> Tambah Lapangan
      </button>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Lapangan</th>
          <th>Harga / Jam</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $q_lapangan = mysqli_query($koneksi, "SELECT * FROM lapangan ORDER BY id_lapangan ASC");
        while ($row = mysqli_fetch_assoc($q_lapangan)) {
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><?php echo htmlspecialchars($row['nama_lapangan']); ?></td>
          <td>Rp <?php echo number_format((float)$row['harga_perjam'], 0, ',', '.'); ?></td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditLapangan<?php echo $row['id_lapangan']; ?>">
              <i class="fas fa-edit"></i> Edit
            </button>
            <a href="index.php?page=lapangan_admin&hapus=<?php echo $row['id_lapangan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus lapangan ini?')">
              <i class="fas fa-trash"></i> Hapus
            </a>
          </td>
        </tr>

        <!-- Modal Edit Lapangan -->
        <div class="modal fade" id="modalEditLapangan<?php echo $row['id_lapangan']; ?>" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="index.php?page=lapangan_admin" method="post">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Lapangan</h5>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id_lapangan" value="<?php echo $row['id_lapangan']; ?>">
                  <div class="form-group">
                    <label>Nama Lapangan</label>
                    <input type="text" name="nama_lapangan" class="form-control" value="<?php echo htmlspecialchars($row['nama_lapangan']); ?>" required>
                  </div>
                  <div class="form-group">
                    <label>Harga per Jam</label>
                    <input type="number" name="harga_perjam" class="form-control" value="<?php echo htmlspecialchars($row['harga_perjam']); ?>" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.Modal Edit Lapangan -->

        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah Lapangan -->
<div class="modal fade" id="modalTambahLapangan" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="index.php?page=lapangan_admin" method="post">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Lapangan</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Lapangan</label>
            <input type="text" name="nama_lapangan" class="form-control" placeholder="Contoh: Lapangan A" required>
          </div>
          <div class="form-group">
            <label>Harga per Jam</label>
            <input type="number" name="harga_perjam" class="form-control" placeholder="Contoh: 100000" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.Modal Tambah Lapangan -->