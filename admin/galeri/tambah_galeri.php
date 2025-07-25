<?php
session_start();
include_once '../config.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit;
}

// Proses submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tipe = $_POST['tipe'];
    $file = $_FILES['foto'];

    // Folder penyimpanan
    $targetDir = "../../uploads/";
    $fileName = time() . '_' . basename($file["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // Validasi file gambar
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($fileType, $allowedTypes)) {
        if (move_uploaded_file($file["tmp_name"], $targetFilePath)) {
            // Simpan ke DB
            $id_pengunggah = $_SESSION['id_user'];
            $role = $_SESSION['role'];

            $insert = "INSERT INTO galeri (judul, deskripsi, nama_file, tipe, diunggah_oleh, role_pengunggah)
                       VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert);
            $stmt->bind_param("ssssis", $judul, $deskripsi, $fileName, $tipe, $id_pengunggah, $role);

            if ($stmt->execute()) {
                header("Location: galeri.php");
                exit;
            } else {
                echo "Gagal menyimpan ke database.";
            }
        } else {
            echo "Gagal mengupload gambar.";
        }
    } else {
        echo "Tipe file tidak didukung. Gunakan JPG, JPEG, PNG, atau GIF.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Foto Galeri</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        form { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 8px; }
        input, textarea, select { width: 95%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { text-decoration: none; color: #555; margin-left: 10px; }
        h2 { text-align: center; color: #333; }
    </style>
</head>
<body>
    <h2>Tambah Foto Galeri</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Judul</label>
        <input type="text" name="judul" required>

        <label>Deskripsi</label>
        <textarea name="deskripsi" rows="4" required></textarea>

        <label>Tipe</label>
        <select name="tipe" required>
            <option value="">-- Pilih Tipe --</option>
            <option value="kegiatan">Kegiatan</option>
            <option value="profil">Profil Guru</option>
        </select>

        <label>Foto</label>
        <input type="file" name="foto" accept="image/*" required>

        <button type="submit">Simpan</button>
        <a href="galeri.php">Batal</a>
    </form>
</body>
</html>
