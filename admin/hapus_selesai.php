<?php

include '../koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,
"DELETE FROM produksi WHERE id='$id'");

echo "
<script>
    window.location='selesai_data.php';
</script>
";

?>