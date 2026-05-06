<?php
include 'config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];

$stmt_get = mysqli_prepare($conn, "SELECT * FROM barang WHERE id = ?");
mysqli_stmt_bind_param($stmt_get, "i", $id);
mysqli_stmt_execute($stmt_get);
$result = mysqli_stmt_get_result($stmt_get);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan!");
}

if (isset($_POST['update'])) {
    $nama     = trim($_POST['nama_barang']);
    $kategori = trim($_POST['kategori']);
    $jumlah   = $_POST['jumlah'];
    $harga    = $_POST['harga'];
    $lokasi   = trim($_POST['lokasi']);

    if ($jumlah < 0 || $harga < 0) {
        $error = "Jumlah atau harga tidak boleh negatif!";
    } else {
        $stmt_upd = mysqli_prepare($conn, "UPDATE barang SET nama_barang=?, kategori=?, jumlah=?, harga=?, lokasi=? WHERE id=?");
        mysqli_stmt_bind_param($stmt_upd, "ssidsi", $nama, $kategori, $jumlah, $harga, $lokasi, $id);

        if (mysqli_stmt_execute($stmt_upd)) {
            header("Location: index.php?pesan=berhasil_update");
            exit();
        } else {
            $error = "Gagal mengupdate data: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-warning py-3">
                        <h5 class="mb-0 text-dark"><i class="fa fa-edit me-2"></i>Edit Data Barang</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger"><?= $error; ?></div>
                        <?php endif; ?>

                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" value="<?= htmlspecialchars($data['nama_barang']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <?php $kats = ['Elektronik', 'Perabotan', 'Alat Tulis', 'Lainnya']; ?>
                                    <?php foreach($kats as $k): ?>
                                        <option value="<?= $k; ?>" <?= ($data['kategori'] == $k) ? 'selected' : ''; ?>><?= $k; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jumlah Stok</label>
                                    <input type="number" name="jumlah" class="form-control" value="<?= htmlspecialchars($data['jumlah']); ?>" min="0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Harga Satuan</label>
                                    <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($data['harga']); ?>" min="0" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Lokasi Gudang</label>
                                <input type="text" name="lokasi" class="form-control" value="<?= htmlspecialchars($data['lokasi']); ?>">
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="index.php" class="btn btn-outline-secondary me-md-2">Batal</a>
                                <button type="submit" name="update" class="btn btn-warning px-4 fw-bold">Update Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>