<?php
// hanya admin yang boleh mengubah/menghapus data pembayaran
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo '<div class="alert alert-danger">Akses ditolak. Hanya admin yang dapat mengubah status pembayaran.</div>';
    return;
}

// proses update pembayaran
if (isset($_POST['edit'])) {
    $id_pembayaran = mysqli_real_escape_string($koneksi, $_POST['id_pembayaran']);
    $metode = mysqli_real_escape_string($koneksi, $_POST['metode']);
    $status_bayar = mysqli_real_escape_string($koneksi, $_POST['status_bayar']);

    mysqli_query($koneksi, "UPDATE pembayaran SET metode = '$metode', status_bayar = '$status_bayar' WHERE id_pembayaran = '$id_pembayaran'");
    echo "<script>window.location='index.php?page=pembayaran_admin'</script>";
}

// proses hapus data pembayaran
if (isset($_GET['hapus'])) {
    $id_pembayaran = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM pembayaran WHERE id_pembayaran = '$id_pembayaran'");
    echo "<script>window.location='index.php?page=pembayaran_admin'</script>";
}
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data Pembayaran</h3>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <thead>
        <tr>
          <th>No</th>
          <th>User</th>
          <th>Lapangan</th>
          <th>Tanggal Booking</th>
          <th>Total Harga</th>
          <th>Metode</th>
          <th>Status Bayar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $q_pembayaran = mysqli_query($koneksi, "SELECT pembayaran.*, booking.tanggal, booking.total_harga, user.username, lapangan.nama_lapangan
                                                  FROM pembayaran
                                                  JOIN booking ON pembayaran.id_booking = booking.id_booking
                                                  JOIN user ON booking.id_user = user.id_user
                                                  JOIN lapangan ON booking.id_lapangan = lapangan.id_lapangan
                                                  ORDER BY pembayaran.id_pembayaran DESC");
        while ($row = mysqli_fetch_assoc($q_pembayaran)) {
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><?php echo htmlspecialchars($row['username']); ?></td>
          <td><?php echo htmlspecialchars($row['nama_lapangan']); ?></td>
          <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
          <td>Rp <?php echo number_format((float)$row['total_harga'], 0, ',', '.'); ?></td>
          <td><?php echo htmlspecialchars($row['metode']); ?></td>
          <td>
            <?php if ($row['status_bayar'] == 'Sudah Bayar') : ?>
              <span class="badge badge-success">Sudah Bayar</span>
            <?php else : ?>
              <span class="badge badge-danger">Belum Bayar</span>
            <?php endif; ?>
          </td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditBayar<?php echo $row['id_pembayaran']; ?>">
              <i class="fas fa-edit"></i> Edit
            </button>
            <a href="index.php?page=pembayaran_admin&hapus=<?php echo $row['id_pembayaran']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data pembayaran ini?')">
              <i class="fas fa-trash"></i> Hapus
            </a>
          </td>
        </tr>

        <!-- Modal Edit Pembayaran -->
        <div class="modal fade" id="modalEditBayar<?php echo $row['id_pembayaran']; ?>" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="index.php?page=pembayaran_admin" method="post">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Pembayaran</h5>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id_pembayaran" value="<?php echo $row['id_pembayaran']; ?>">
                  <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <select name="metode" class="form-control" required>
                      <option value="Cash" <?php echo ($row['metode'] == 'Cash') ? 'selected' : ''; ?>>Cash</option>
                      <option value="Transfer" <?php echo ($row['metode'] == 'Transfer') ? 'selected' : ''; ?>>Transfer</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Status Bayar</label>
                    <select name="status_bayar" class="form-control" required>
                      <option value="Belum Bayar" <?php echo ($row['status_bayar'] == 'Belum Bayar') ? 'selected' : ''; ?>>Belum Bayar</option>
                      <option value="Sudah Bayar" <?php echo ($row['status_bayar'] == 'Sudah Bayar') ? 'selected' : ''; ?>>Sudah Bayar</option>
                    </select>
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
        <!-- /.Modal Edit Pembayaran -->

        <?php } ?>
      </tbody>
    </table>
  </div>
</div>