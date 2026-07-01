<?php
// ambil id_user dari username yang sedang login
$username = $_SESSION['username'];
$q_me = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_user FROM user WHERE username = '$username'"));
$id_user = $q_me['id_user'];
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Riwayat Booking Saya</h3>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <thead>
        <tr>
          <th>No</th>
          <th>Lapangan</th>
          <th>Tanggal</th>
          <th>Jam Mulai</th>
          <th>Durasi</th>
          <th>Total Harga</th>
          <th>Status Booking</th>
          <th>Status Bayar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $q_riwayat = mysqli_query($koneksi, "SELECT booking.*, lapangan.nama_lapangan, pembayaran.status_bayar
                                              FROM booking
                                              JOIN lapangan ON booking.id_lapangan = lapangan.id_lapangan
                                              LEFT JOIN pembayaran ON pembayaran.id_booking = booking.id_booking
                                              WHERE booking.id_user = '$id_user'
                                              ORDER BY booking.tanggal DESC, booking.jam_mulai DESC");
        while ($row = mysqli_fetch_assoc($q_riwayat)) {
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
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
            <?php if ($row['status_bayar'] == 'Sudah Bayar') : ?>
              <span class="badge badge-success">Sudah Bayar</span>
            <?php elseif ($row['status_bayar'] == 'Belum Bayar') : ?>
              <span class="badge badge-danger">Belum Bayar</span>
            <?php else : ?>
              <span class="badge badge-secondary">-</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php } ?>
        <?php if ($no == 1) : ?>
        <tr>
          <td colspan="8" class="text-center">Belum ada riwayat booking.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
