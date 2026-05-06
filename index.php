<?php
include 'config/database.php';
$query = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar { background: linear-gradient(45deg, #1a237e, #0d47a1); }
        .table-hover tbody tr:hover { background-color: #f1f4f9; transition: 0.3s; }
        .badge-stock { width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark shadow-sm mb-4">
        <div class="container">
            <span class="navbar-brand fw-bold"></i>Inventory System</span>
        </div>
    </nav>

    <div class="container">

        <?php if(isset($_GET['pesan'])): ?>
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fa fa-check-circle me-2"></i>
                <?php
                    if($_GET['pesan'] == "berhasil_tambah") echo "Data barang berhasil ditambahkan!";
                    if($_GET['pesan'] == "berhasil_update") echo "Perubahan data berhasil disimpan!";
                    if($_GET['pesan'] == "berhasil_hapus") echo "Data barang telah dihapus.";
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-primary fw-bold">Daftar Stok Barang</h5>
                <a href="create.php" class="btn btn-primary shadow-sm"><i class="fa fa-plus me-1"></i> Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th>Informasi Barang</th>
                                <th>Kategori</th>
                                <th class="text-center">Stok</th>
                                <th>Harga Satuan</th>
                                <th>Lokasi</th>
                                <th class="text-center" width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; while($row = mysqli_fetch_assoc($query)) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($row['nama_barang']); ?></div>
                                    <small class="text-muted">ID: #<?= $row['id']; ?></small>
                                </td>
                                <td><span class="badge rounded-pill bg-light text-primary border border-primary"><?= htmlspecialchars($row['kategori']); ?></span></td>
                                <td class="text-center">
                                    <span class="badge bg-<?= $row['jumlah'] < 5 ? 'danger' : 'success'; ?>">
                                        <?= htmlspecialchars($row['jumlah']); ?>
                                    </span>
                                </td>
                                <td class="fw-bold">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td><i class="fa fa-location-dot text-danger me-1"></i><?= htmlspecialchars($row['lokasi']); ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>