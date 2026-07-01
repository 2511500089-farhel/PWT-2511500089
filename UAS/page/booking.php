<?php
// ambil id_user dari username yang sedang login
$username = $_SESSION['username'];
$q_me = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_user FROM user WHERE username = '$username'"));
$id_user = $q_me['id_user'];

$pesan_error = "";

// proses tambah booking baru
if (isset($_POST['booking'])) {
    $id_lapangan = mysqli_real_escape_string($koneksi, $_POST['id_lapangan']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $jam_mulai = mysqli_real_escape_string($koneksi, $_POST['jam_mulai']);
    $durasi = mysqli_real_escape_string($koneksi, $_POST['durasi']);
    $metode = mysqli_real_escape_string($koneksi, $_POST['metode']);

    // cek apakah lapangan sudah dibooking pada tanggal & jam yang sama
    $q_cek = mysqli_query($koneksi, "SELECT * FROM booking WHERE id_lapangan = '$id_lapangan' AND tanggal = '$tanggal' AND jam_mulai = '$jam_mulai'");
    if (mysqli_num_rows($q_cek) > 0) {
        $pesan_error = "Lapangan tersebut sudah dibooking pada tanggal dan jam yang sama. Silakan pilih jam lain.";
    } else {
        $q_harga = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT harga_perjam FROM lapangan WHERE id_lapangan = '$id_lapangan'"));
        $total_harga = ((float)$q_harga['harga_perjam']) * ((float)$durasi);

        mysqli_query($koneksi, "INSERT INTO booking (id_user, id_lapangan, tanggal, jam_mulai, durasi, total_harga, status)
                                 VALUES ('$id_user', '$id_lapangan', '$tanggal', '$jam_mulai', '$durasi', '$total_harga', 'Digunakan')");
        $id_booking = mysqli_insert_id($koneksi);

        mysqli_query($koneksi, "INSERT INTO pembayaran (id_booking, metode, status_bayar) VALUES ('$id_booking', '$metode', 'Belum Bayar')");

        echo "<script>window.location='index.php?page=booking'</script>";
        exit;
    }
}

// proses batalkan booking (hanya milik sendiri)
if (isset($_GET['batal'])) {
    $id_booking = mysqli_real_escape_string($koneksi, $_GET['batal']);
    $q_cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id_booking FROM booking WHERE id_booking = '$id_booking' AND id_user = '$id_user'"));
    if ($q_cek) {
        mysqli_query($koneksi, "DELETE FROM pembayaran WHERE id_booking = '$id_booking'");
        mysqli_query($koneksi, "DELETE FROM booking WHERE id_booking = '$id_booking'");
    }
    echo "<script>window.location='index.php?page=booking'</script>";
    exit;
}
?>

<?php if ($pesan_error != "") : ?>
<div class="alert alert-danger alert-dismissible">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
  <?php echo $pesan_error; ?>
</div>
<?php endif; ?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Booking Lapangan</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahBooking">
        <i class="fas fa-plus"></i> Buat Booking
      </button>
    </div>
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
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $q_booking = mysqli_query($koneksi, "SELECT booking.*, lapangan.nama_lapangan
                                              FROM booking
                                              JOIN lapangan ON booking.id_lapangan = lapangan.id_lapangan
                                              WHERE booking.id_user = '$id_user'
                                              ORDER BY booking.tanggal DESC, booking.jam_mulai DESC");
        while ($row = mysqli_fetch_assoc($q_booking)) {
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
            <a href="index.php?page=booking&batal=<?php echo $row['id_booking']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan booking ini?')">
              <i class="fas fa-times"></i> Batalkan
            </a>
          </td>
        </tr>
        <?php } ?>
        <?php if ($no == 1) : ?>
        <tr>
          <td colspan="8" class="text-center">Anda belum memiliki booking.</td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah Booking -->
<div class="modal fade" id="modalTambahBooking" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="index.php?page=booking" method="post">
        <div class="modal-header">
          <h5 class="modal-title">Buat Booking Lapangan</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Lapangan</label>
            <select name="id_lapangan" class="form-control" required>
              <option value="" disabled selected>Pilih Lapangan</option>
              <?php
              $q_pilih_lapangan = mysqli_query($koneksi, "SELECT * FROM lapangan ORDER BY id_lapangan ASC");
              while ($lp = mysqli_fetch_assoc($q_pilih_lapangan)) {
              ?>
              <option value="<?php echo $lp['id_lapangan']; ?>">
                <?php echo htmlspecialchars($lp['nama_lapangan']); ?> - Rp <?php echo number_format((float)$lp['harga_perjam'], 0, ',', '.'); ?> / jam
              </option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" min="<?php echo date('Y-m-d'); ?>" required>
          </div>
          <div class="form-group">
            <label>Jam Mulai</label>
            <input type="time" name="jam_mulai" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Durasi (Jam)</label>
            <input type="number" name="durasi" class="form-control" min="1" max="24" value="1" required>
          </div>
          <div class="form-group">
            <label>Metode Pembayaran</label>
            <select name="metode" class="form-control" required>
              <option value="Cash">Cash</option>
              <option value="Transfer">Transfer</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" name="booking" class="btn btn-primary">Simpan Booking</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- /.Modal Tambah Booking -->