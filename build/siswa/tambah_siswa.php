<?php
include_once '../config.php';

// Proses tambah siswa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_siswa = $_POST['id_siswa'];
    $id_kelas = $_POST['id_kelas'];

    $insert = "INSERT INTO siswa_kelas (id_siswa, id_kelas) VALUES ('$id_siswa', '$id_kelas')";
    if ($conn->query($insert)) {
        header("Location: siswa.php");
        exit;
    } else {
        echo "Gagal menambahkan siswa.";
    }
}

// Ambil data user (siswa) & kelas
$siswa_result = $conn->query("SELECT id_user, nama FROM users WHERE role = 'siswa'");
$kelas_result = $conn->query("SELECT id_kelas, nama_kelas FROM kelas");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Siswa</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 20px;
        }

        form {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: #555;
            margin-left: 10px;
        }

        h2 {
            text-align: center;
            color: #333;
        }
    </style>
</head>

<body>
    <h2>Tambah Siswa</h2>
    <form method="POST">
        <label>Nama Siswa:</label><br>
        <select name="id_siswa" required>
            <?php while ($siswa = $siswa_result->fetch_assoc()): ?>
                <option value="<?= $siswa['id_user'] ?>"><?= htmlspecialchars($siswa['nama']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Kelas:</label><br>
        <select name="id_kelas" required>
            <?php while ($kelas = $kelas_result->fetch_assoc()): ?>
                <option value="<?= $kelas['id_kelas'] ?>"><?= htmlspecialchars($kelas['nama_kelas']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit">Simpan</button>
        <a href="siswa.php">Batal</a>
    </form>

</body>

</html>