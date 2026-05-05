<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'config/database.php';

    $errors = [];

    // Ambil ID dari GET
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header("Location: index.php?pesan=notfound");
        exit();
    }

    $id = (int) $_GET['id'];

    // Ambil data berdasarkan ID
    $cek = $conn->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
    $cek->bind_param("i", $id);
    $cek->execute();
    $result = $cek->get_result();

    if ($result->num_rows == 0) {
        header("Location: index.php?pesan=notfound");
        exit();
    }

    $data = $result->fetch_assoc();
    $cek->close();

    // Pre-fill nilai awal dari database
    $kode      = $data['kode_kategori'];
    $nama      = $data['nama_kategori'];
    $deskripsi = $data['deskripsi'];
    $status    = $data['status'];

    // Proses update kalau POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $kode      = trim(htmlspecialchars($_POST['kode_kategori']));
        $nama      = trim(htmlspecialchars($_POST['nama_kategori']));
        $deskripsi = trim(htmlspecialchars($_POST['deskripsi']));
        $status    = trim(htmlspecialchars($_POST['status']));

        // Validasi kode kategori
        if (empty($kode)) {
            $errors[] = "Kode kategori wajib diisi.";
        } elseif (strlen($kode) < 4 || strlen($kode) > 10) {
            $errors[] = "Kode kategori harus 4-10 karakter.";
        } elseif (substr($kode, 0, 4) !== 'KAT-') {
            $errors[] = "Kode kategori harus diawali dengan 'KAT-'.";
        } else {
            // Cek duplikasi, exclude diri sendiri
            $dupCek = $conn->prepare("SELECT id_kategori FROM kategori WHERE kode_kategori = ? AND id_kategori != ?");
            $dupCek->bind_param("si", $kode, $id);
            $dupCek->execute();
            $dupCek->store_result();
            if ($dupCek->num_rows > 0) {
                $errors[] = "Kode kategori sudah digunakan, pilih kode lain.";
            }
            $dupCek->close();
        }

        // Validasi nama
        if (empty($nama)) {
            $errors[] = "Nama kategori wajib diisi.";
        } elseif (strlen($nama) < 3) {
            $errors[] = "Nama kategori minimal 3 karakter.";
        } elseif (strlen($nama) > 50) {
            $errors[] = "Nama kategori maksimal 50 karakter.";
        }

        // Validasi deskripsi
        if (!empty($deskripsi) && strlen($deskripsi) > 200) {
            $errors[] = "Deskripsi maksimal 200 karakter.";
        }

        // Validasi status
        if (!in_array($status, ['Aktif', 'Nonaktif'])) {
            $errors[] = "Status tidak valid.";
        }

        // Kalau tidak ada error, update
        if (empty($errors)) {
            $stmt = $conn->prepare("UPDATE kategori SET kode_kategori=?, nama_kategori=?, deskripsi=?, status=? WHERE id_kategori=?");
            $stmt->bind_param("ssssi", $kode, $nama, $deskripsi, $status, $id);

            if ($stmt->execute()) {
                header("Location: index.php?pesan=edit");
                exit();
            } else {
                $errors[] = "Gagal mengupdate data, coba lagi.";
            }
            $stmt->close();
        }
    }
    ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Kategori</h4>
                    </div>
                    <div class="card-body">

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $e): ?>
                                        <li><?= $e ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Kode Kategori <span class="text-danger">*</span></label>
                                <input type="text" name="kode_kategori" class="form-control"
                                    value="<?= $kode ?>" required>
                                <small class="text-muted">Format: KAT-XXX, 4-10 karakter</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" name="nama_kategori" class="form-control"
                                    value="<?= $nama ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" class="form-control" rows="3"><?= $deskripsi ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Status</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status"
                                        value="Aktif" <?= $status == 'Aktif' ? 'checked' : '' ?>>
                                    <label class="form-check-label">Aktif</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status"
                                        value="Nonaktif" <?= $status == 'Nonaktif' ? 'checked' : '' ?>>
                                    <label class="form-check-label">Nonaktif</label>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="index.php" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>