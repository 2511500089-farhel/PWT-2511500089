<?php
require 'vendor/autoload.php';
include 'config/koneksi.php';

use Dompdf\Dompdf;

// validasi
if (!isset($_GET['Kd_jadwal'])) {
    die("Kode tidak ditemukan");
}

$Kd_jadwal = $_GET['Kd_jadwal'];

// ambil data utama
$query = mysqli_query($koneksi, "SELECT * FROM jadwal JOIN guru ON jadwal.Kd_guru = guru.Kd_guru WHERE Kd_jadwal = '$Kd_jadwal'");
$data = mysqli_fetch_assoc($query);

// ambil detail
$det = mysqli_query($koneksi, "SELECT d.*, m.Nm_mapel FROM detail_jadwal d JOIN mapel m ON d.Kd_mapel = m.Kd_mapel WHERE Kd_jadwal = '$Kd_jadwal'");

// HTML PDF
$html = "
<style>
body {
    font-family: Arial, sans-serif;
    font-size: 12px;
}
table {
    border-collapse: collapse;
    width: 100%;
}
th, td {
    border: 1px solid black;
    padding: 6px;
    text-align: center;
}
th {
    background-color: #ff0000;
}
h3 {
    text-align: center;
}
</style>

<h3>JADWAL GURU</h3>

<table>
<tr>
    <th>Kode Jadwal</th>
    <th>Guru</th>
    <th>Semester</th>
    <th>Tahun</th>
    <th>Mapel</th>
    <th>Hari</th>
    <th>Jam</th>
    <th>Kelas</th>
</tr>
";

// isi tabel
while ($d = mysqli_fetch_assoc($det)) {
    $html .= "
    <tr>
        <td>{$data['Kd_jadwal']}</td>
        <td>{$data['Nm_guru']}</td>
        <td>{$data['Semester']}</td>
        <td>{$data['Tahun_ajaran']}</td>
        <td>{$d['Nm_mapel']}</td>
        <td>{$d['Hari']}</td>
        <td>{$d['Jam']}</td>
        <td>{$d['Kelas']}</td>
    </tr>
    ";
}

$html .= "</table>";

// DOMPDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// tampilkan
$dompdf->stream("jadwal.pdf", array("Attachment" => false));