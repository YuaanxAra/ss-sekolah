<?php
include_once '../config.php';

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID Siswa tidak ditemukan.");
}

// Ambil data siswa berdasarkan ID
$query = "
    SELECT u.id_user, u.nama, k.nama_kelas
    FROM siswa_kelas sk
    JOIN users u ON sk.id_siswa = u.id_user
    JOIN kelas k ON sk.id_kelas = k.id_kelas
";
$result = $conn->query($query);
$siswa = $result->fetch_assoc();

if (!$siswa) {
    die("Data siswa tidak ditemukan.");
}

// Proses update saat form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];

    $update = "UPDATE users SET nama = '$nama' WHERE id_user = $id";
    if ($conn->query($update)) {
        header("Location: siswa.php");
        exit;
    } else {
        echo "Gagal memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Siswa</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 40px; }
        .form-box {
            background: white; padding: 20px; max-width: 400px;
            margin: auto; border-radius: 8px; box-shadow: 0 0 10px #ccc;
        }
        h2 { text-align: center; margin-bottom: 20px; }
        label { font-weight: bold; display: block; margin-bottom: 5px; }
        input[type="text"] {
            width: 100%; padding: 8px; margin-bottom: 15px;
            border: 1px solid #ccc; border-radius: 4px;
        }
        button, a {
            padding: 8px 16px; text-decoration: none;
            border: none; border-radius: 4px;
        }
        button { background: #007bff; color: white; }
        a { background: gray; color: white; margin-left: 10px; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Edit Siswa</h2>
        <form method="POST">
            <label>Nama Siswa</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($siswa['nama']) ?>" required>
            <label>Kelas</label>
            <input type="text" name="kelas" value="<?= htmlspecialchars($siswa['nama_kelas']) ?>" required>
            <button type="submit">Simpan</button>
            <a href="siswa.php">Batal</a>
        </form>
    </div>
</body>
</html>
