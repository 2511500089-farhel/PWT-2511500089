<?php
// halaman daftar lapangan untuk pengguna (hanya lihat, booking dilakukan di halaman booking)
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Daftar Lapangan Futsal</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <?php
      $q_lapangan = mysqli_query($koneksi, "SELECT * FROM lapangan ORDER BY id_lapangan ASC");
      if (mysqli_num_rows($q_lapangan) > 0) {
          while ($row = mysqli_fetch_assoc($q_lapangan)) {
      ?>
      <div class="col-md-4">
        <div class="card card-outline card-primary">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-futbol"></i> <?php echo htmlspecialchars($row['nama_lapangan']); ?></h3>
          </div>
          <div class="card-body">
            <p class="mb-1">Harga Sewa</p>
            <h4 class="text-primary">Rp <?php echo number_format((float)$row['harga_perjam'], 0, ',', '.'); ?> <small>/ jam</small></h4>
          </div>
          <div class="card-footer">
            <a href="index.php?page=booking" class="btn btn-primary btn-block">
              <i class="fas fa-calendar-plus"></i> Booking Sekarang
            </a>
          </div>
        </div>
      </div>
      <?php
          }
      } else {
      ?>
      <div class="col-12">
        <p class="text-center">Belum ada data lapangan.</p>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
