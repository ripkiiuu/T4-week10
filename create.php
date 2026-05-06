<?php
include 'config/database.php';

if (isset($_POST['simpan'])) {
    $nama     = trim($_POST['nama_barang']);
    $kategori = trim($_POST['kategori']);
    $jumlah   = $_POST['jumlah'];
    $harga    = $_POST['harga'];
    $lokasi   = trim($_POST['lokasi']);

    if (empty($nama) || empty($kategori) || empty($harga)) {
        die("Kesalahan: Field utama tidak boleh kosong!");
    }

    if ($jumlah < 0 || $harga < 0) {
        die("Kesalahan: Jumlah atau harga tidak boleh angka negatif!");
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO barang (nama_barang, kategori, jumlah, harga, lokasi) VALUES (?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param($stmt, "ssids", $nama, $kategori, $jumlah, $harga, $lokasi);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: index.php?pesan=berhasil_tambah");
        exit();
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0"><i class="fa fa-plus-circle me-2"></i>Tambah Barang Baru</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Laptop Asus" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Elektronik">Elektronik</option>
                                    <option value="Perabotan">Perabotan</option>
                                    <option value="Alat Tulis">Alat Tulis</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Jumlah Stok</label>
                                    <input type="number" name="jumlah" class="form-control" value="0" min="0">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Harga Satuan</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga" class="form-control" placeholder="0" min="0" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">Lokasi Gudang</label>
                                <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Rak A-12">
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="index.php" class="btn btn-outline-secondary me-md-2">Batal</a>
                                <button type="submit" name="simpan" class="btn btn-primary px-4">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>