<?php
// proses update status booking
if (isset($_POST['edit_status'])) {
    $id_booking = mysqli_real_escape_string($koneksi, $_POST['id_booking']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);

    mysqli_query($koneksi, "UPDATE booking SET status = '$status' WHERE id_booking = '$id_booking'");
    echo "<script>window.location='index.php?page=booking_admin'</script>";
}

// proses hapus data booking
if (isset($_GET['hapus'])) {
    $id_booking = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM booking WHERE id_booking = '$id_booking'");
    echo "<script>window.location='index.php?page=booking_admin'</script>";
}
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data Booking</h3>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <thead>
        <tr>
          <th>No</th>
          <th>User</th>
          <th>Lapangan</th>
          <th>Tanggal</th>
          <th>Jam Mulai</th>
          <th>Durasi</th>
          <th>Total Harga</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $q_booking = mysqli_query($koneksi, "SELECT booking.*, user.username, lapangan.nama_lapangan
                                              FROM booking
                                              JOIN user ON booking.id_user = user.id_user
                                              JOIN lapangan ON booking.id_lapangan = lapangan.id_lapangan
                                              ORDER BY booking.id_booking DESC");
        while ($row = mysqli_fetch_assoc($q_booking)) {
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><?php echo htmlspecialchars($row['username']); ?></td>
          <td><?php echo htmlspecialchars($row['nama_lapangan']); ?></td>
          <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
          <td><?php echo htmlspecialchars($row['jam_mulai']); ?></td>
          <td><?php echo htmlspecialchars($row['durasi']); ?> Jam</td>
          <td>Rp <?php echo number_format((float)$row['total_harga'], 0, ',', '.'); ?></td>
          <td>
            <?php if ($row['status'] == 'Digunakan') : ?>
              <span class="badge badge-danger">Digunakan</span>
            <?php else : ?>
              <span class="badge badge-success">Kosong</span>
            <?php endif; ?>
          </td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalStatus<?php echo $row['id_booking']; ?>">
              <i class="fas fa-edit"></i> Ubah Status
            </button>
            <a href="index.php?page=booking_admin&hapus=<?php echo $row['id_booking']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus booking ini?')">
              <i class="fas fa-trash"></i> Hapus
            </a>
          </td>
        </tr>

        <!-- Modal Ubah Status Booking -->
        <div class="modal fade" id="modalStatus<?php echo $row['id_booking']; ?>" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="index.php?page=booking_admin" method="post">
                <div class="modal-header">
                  <h5 class="modal-title">Ubah Status Booking</h5>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id_booking" value="<?php echo $row['id_booking']; ?>">
                  <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                      <option value="Kosong" <?php echo ($row['status'] == 'Kosong') ? 'selected' : ''; ?>>Kosong</option>
                      <option value="Digunakan" <?php echo ($row['status'] == 'Digunakan') ? 'selected' : ''; ?>>Digunakan</option>
                    </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  <button type="submit" name="edit_status" class="btn btn-primary">Simpan Perubahan</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.Modal Ubah Status Booking -->

        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
