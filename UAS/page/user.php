<?php
// proses tambah data user
if (isset($_POST['tambah'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);

    mysqli_query($koneksi, "INSERT INTO user (username, password, role) VALUES ('$username', '$password', '$role')");
    echo "<script>window.location='index.php?page=user'</script>";
}

// proses edit data user
if (isset($_POST['edit'])) {
    $id_user = mysqli_real_escape_string($koneksi, $_POST['id_user']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $role = mysqli_real_escape_string($koneksi, $_POST['role']);

    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($koneksi, $_POST['password']);
        mysqli_query($koneksi, "UPDATE user SET username = '$username', password = '$password', role = '$role' WHERE id_user = '$id_user'");
    } else {
        mysqli_query($koneksi, "UPDATE user SET username = '$username', role = '$role' WHERE id_user = '$id_user'");
    }
    echo "<script>window.location='index.php?page=user'</script>";
}

// proses hapus data user
if (isset($_GET['hapus'])) {
    $id_user = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    $q_cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT username FROM user WHERE id_user = '$id_user'"));
    // mencegah admin yang sedang login menghapus akunnya sendiri
    if ($q_cek && $q_cek['username'] != $_SESSION['username']) {
      mysqli_query($koneksi, "DELETE FROM booking WHERE id_user = '$id_user'");
      mysqli_query($koneksi, "DELETE FROM user WHERE id_user = '$id_user'");
    }
    echo "<script>window.location='index.php?page=user'</script>";
}
?>

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Data User</h3>
    <div class="card-tools">
      <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahUser">
        <i class="fas fa-plus"></i> Tambah User
      </button>
    </div>
  </div>
  <div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
      <thead>
        <tr>
          <th>No</th>
          <th>Username</th>
          <th>Role</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        $q_user = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id_user ASC");
        while ($row = mysqli_fetch_assoc($q_user)) {
        ?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><?php echo htmlspecialchars($row['username']); ?></td>
          <td>
            <?php if ($row['role'] == 'admin') : ?>
              <span class="badge badge-primary">Admin</span>
            <?php else : ?>
              <span class="badge badge-secondary">Pengguna</span>
            <?php endif; ?>
          </td>
          <td>
            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditUser<?php echo $row['id_user']; ?>">
              <i class="fas fa-edit"></i> Edit
            </button>
            <a href="index.php?page=user&hapus=<?php echo $row['id_user']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?')">
              <i class="fas fa-trash"></i> Hapus
            </a>
          </td>
        </tr>

        <!-- Modal Edit User -->
        <div class="modal fade" id="modalEditUser<?php echo $row['id_user']; ?>" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="index.php?page=user" method="post">
                <div class="modal-header">
                  <h5 class="modal-title">Edit User</h5>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" name="id_user" value="<?php echo $row['id_user']; ?>">
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password">
                  </div>
                  <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control" required>
                      <option value="admin" <?php echo ($row['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                      <option value="pengguna" <?php echo ($row['role'] == 'pengguna') ? 'selected' : ''; ?>>Pengguna</option>
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
        <!-- /.Modal Edit User -->

        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="index.php?page=user" method="post">
        <div class="modal-header">
          <h5 class="modal-title">Tambah User</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
              <option value="admin">Admin</option>
              <option value="pengguna">Pengguna</option>
            </select>
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
<!-- /.Modal Tambah User -->