<?php
session_start();
include_once '../config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID galeri tidak ditemukan.");
}

// Ambil data galeri berdasarkan ID
$query = "SELECT * FROM galeri WHERE id_galeri = $id";
$result = $conn->query($query);
$galeri = $result->fetch_assoc();
if (!$galeri) {
    die("Data galeri tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tipe = $_POST['tipe'];
    $file = $_FILES['foto'];

    $updateFoto = false;
    $fileName = $galeri['nama_file'];

    // Jika file baru diunggah
    if ($file['name']) {
        $targetDir = "../../uploads/";
        $newName = time() . '_' . basename($file["name"]);
        $targetPath = $targetDir . $newName;
        $fileType = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($file["tmp_name"], $targetPath)) {
                // Hapus file lama
                $oldPath = $targetDir . $galeri['nama_file'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
                $fileName = $newName;
                $updateFoto = true;
            } else {
                echo "Gagal mengupload gambar baru.";
                exit;
            }
        } else {
            echo "Tipe file tidak didukung.";
            exit;
        }
    }

    // Update database
    $stmt = $conn->prepare("UPDATE galeri SET judul=?, deskripsi=?, tipe=?, nama_file=? WHERE id_galeri=?");
    $stmt->bind_param("ssssi", $judul, $deskripsi, $tipe, $fileName, $id);

    if ($stmt->execute()) {
        header("Location: galeri.php");
        exit;
    } else {
        echo "Gagal memperbarui data galeri.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Foto Galeri</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        form { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 8px; }
        input, textarea, select { width: 95%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { text-decoration: none; color: #555; margin-left: 10px; }
        h2 { text-align: center; color: #333; }
        img { max-width: 150px; margin-bottom: 15px; border-radius: 6px; }
    </style>
</head>
<body>
    <h2>Edit Foto Galeri</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Judul</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($galeri['judul']) ?>" required>

        <label>Deskripsi</label>
        <textarea name="deskripsi" rows="4" required><?= htmlspecialchars($galeri['deskripsi']) ?></textarea>

        <label>Tipe</label>
        <select name="tipe" required>
            <option value="kegiatan" <?= $galeri['tipe'] === 'kegiatan' ? 'selected' : '' ?>>Kegiatan</option>
            <option value="profil" <?= $galeri['tipe'] === 'profil' ? 'selected' : '' ?>>Profil Guru</option>
        </select>

        <label>Gambar Saat Ini</label><br>
        <img src="../../uploads/?= htmlspecialchars($galeri['nama_file']) ?>" alt="Foto Saat Ini"><br>

        <label>Ganti Gambar (Opsional)</label>
        <input type="file" name="foto" accept="image/*">

        <button type="submit">Simpan Perubahan</button>
        <a href="galeri.php">Batal</a>
    </form>
</body>
</html>
