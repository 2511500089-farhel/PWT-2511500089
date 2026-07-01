<?php
// ambil id_user dari username yang sedang login
$username = $_SESSION['username'];
$q_me = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_user FROM user WHERE username = '$username'"));
$id_user = $q_me['id_user'];

// ambil jumlah data untuk statistik dashboard pengguna
$q_booking = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM booking WHERE id_user = '$id_user'");
$total_booking = mysqli_fetch_assoc($q_booking)['jumlah'];

$q_aktif = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM booking WHERE id_user = '$id_user' AND status = 'Digunakan'");
$total_aktif = mysqli_fetch_assoc($q_aktif)['jumlah'];

$q_belum_bayar = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM pembayaran
                                          JOIN booking ON pembayaran.id_booking = booking.id_booking
                                          WHERE booking.id_user = '$id_user' AND pembayaran.status_bayar = 'Belum Bayar'");
$total_belum_bayar = mysqli_fetch_assoc($q_belum_bayar)['jumlah'];

$q_lapangan = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM lapangan");
$total_lapangan = mysqli_fetch_assoc($q_lapangan)['jumlah'];
?>

<div class="row">
  <div class="col-lg-3 col-6">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?php echo $total_booking; ?></h3>
        <p>Total Booking Saya</p>
      </div>
      <div class="icon">
        <i class="fas fa-calendar-check"></i>
      </div>
      <a href="index.php?page=riwayat" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?php echo $total_aktif; ?></h3>
        <p>Booking Digunakan</p>
      </div>
      <div class="icon">
        <i class="fas fa-futbol"></i>
      </div>
      <a href="index.php?page=booking" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
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
      <a href="index.php?page=pembayaran" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3><?php echo $total_lapangan; ?></h3>
        <p>Lapangan Tersedia</p>
      </div>
      <div class="icon">
        <i class="fas fa-th-large"></i>
      </div>
      <a href="index.php?page=lapangan" class="small-box-footer">Lihat Detail <i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Booking Terbaru Saya</h3>
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
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $q_recent = mysqli_query($koneksi, "SELECT booking.*, lapangan.nama_lapangan
                                              FROM booking
                                              JOIN lapangan ON booking.id_lapangan = lapangan.id_lapangan
                                              WHERE booking.id_user = '$id_user'
                                              ORDER BY booking.id_booking DESC LIMIT 5");
        while ($row = mysqli_fetch_assoc($q_recent)) {
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
        </tr>
        <?php } ?>
        <?php if ($total_booking == 0) : ?>
        <tr>
          <td colspan="7" class="text-center">Belum ada booking. <a href="index.php?page=booking">Booking sekarang</a>.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
