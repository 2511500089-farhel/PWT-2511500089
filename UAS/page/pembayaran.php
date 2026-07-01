<?php
// ambil id_user dari username yang sedang login
$username = $_SESSION['username'];
$q_me = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_user FROM user WHERE username = '$username'"));
$id_user = $q_me['id_user'];

// Catatan: konfirmasi "Sudah Bayar" hanya boleh dilakukan oleh admin
// melalui halaman pembayaran_admin.php, sehingga tidak ada proses
// update status_bayar di halaman pengguna ini.
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Pembayaran Saya</h3>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <thead>
        <tr>
          <th>No</th>
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
        $q_pembayaran = mysqli_query($koneksi, "SELECT pembayaran.*, booking.tanggal, booking.total_harga, lapangan.nama_lapangan
                                                  FROM pembayaran
                                                  JOIN booking ON pembayaran.id_booking = booking.id_booking
                                                  JOIN lapangan ON booking.id_lapangan = lapangan.id_lapangan
                                                  WHERE booking.id_user = '$id_user'
                                                  ORDER BY pembayaran.id_pembayaran DESC");
        while ($row = mysqli_fetch_assoc($q_pembayaran)) {
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
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
            <?php if ($row['status_bayar'] == 'Belum Bayar') : ?>
            <span class="text-muted"><i class="fas fa-clock"></i> Menunggu konfirmasi admin</span>
            <?php else : ?>
            <span class="text-muted">Lunas</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php } ?>
        <?php if ($no == 1) : ?>
        <tr>
          <td colspan="7" class="text-center">Belum ada data pembayaran.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>