<?php

include '../koneksi.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM produksi WHERE id='$id'");

header("location:tampil.php");

?>