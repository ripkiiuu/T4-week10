<?php
include 'config/database.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($conn, "DELETE FROM barang WHERE id = ?");

    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: index.php?pesan=berhasil_hapus");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    header("Location: index.php");
    exit();
}
?>