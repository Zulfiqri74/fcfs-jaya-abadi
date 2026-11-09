<?php

include '../koneksi.php';

$id = $_GET['id'];

/* Ubah pesanan menjadi selesai */
mysqli_query($conn,
"UPDATE produksi
SET status='Produk Telah Selesai Dikerjakan'
WHERE id='$id'");

/* Cari antrian berikutnya */
$next = mysqli_query($conn,
"SELECT * FROM produksi
WHERE status='Dalam Antrian'
ORDER BY waktu_mulai ASC
LIMIT 1");

/* Jika ada antrian berikutnya */
if(mysqli_num_rows($next) > 0){

    $n = mysqli_fetch_array($next);

    mysqli_query($conn,
    "UPDATE produksi
    SET status='Sedang Dikerjakan'
    WHERE id='$n[id]'");
}

header("location:tampil.php?success=1");

?>