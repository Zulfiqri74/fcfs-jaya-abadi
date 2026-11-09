<?php
$conn = mysqli_connect("localhost", "root", "", "db_produksi_fcfs", 3307);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>