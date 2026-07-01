<?php
// ambil jumlah data untuk statistik dashboard admin
$q_lapangan = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM lapangan");
$total_lapangan = mysqli_fetch_assoc($q_lapangan)['jumlah'];

$q_booking = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM booking");
$total_booking = mysqli_fetch_assoc($q_booking)['jumlah'];

$q_user = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM user");
$total_user = mysqli_fetch_assoc($q_user)['jumlah'];

$q_bayar = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM pembayaran WHERE status_bayar = 'Belum Bayar'");
$total_belum_bayar = mysqli_fetch_assoc($q_bayar)['jumlah'];
?>

<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?php echo $total_lapangan; ?></h3>
        <p>Total Lapangan</p>
      </div>
      <div class="icon">
        <i class="fas fa-futbol"></i>
      </div>
      <a href="index.php?page=lapangan_admin" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?php echo $total_booking; ?></h3>
        <p>Total Booking</p>
      </div>
      <div class="icon">
        <i class="fas fa-calendar-check"></i>
      </div>
      <a href="index.php?page=booking_admin" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3><?php echo $total_belum_bayar; ?></h3>
        <p>Belum Bayar</p>
      </div>
      <div class="icon">
        <i class="fas fa-money-bill-wave"></i>
      </div>
      <a href="index.php?page=pembayaran_admin" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?php echo $total_user; ?></h3>
        <p>Total User</p>
      </div>
      <div class="icon">
        <i class="fas fa-users"></i>
      </div>
      <a href="index.php?page=user" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Booking Terbaru</h3>
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
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $q_recent = mysqli_query($koneksi, "SELECT booking.*, user.username, lapangan.nama_lapangan
                                              FROM booking
                                              JOIN user ON booking.id_user = user.id_user
                                              JOIN lapangan ON booking.id_lapangan = lapangan.id_lapangan
                                              ORDER BY booking.id_booking DESC LIMIT 5");
        while ($row = mysqli_fetch_assoc($q_recent)) {
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
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
