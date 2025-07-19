<?php
include_once 'config.php';

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID Mapel tidak ditemukan.");
}

// Ambil data mapel berdasarkan ID
$query = "SELECT * FROM mapel WHERE id_mapel = $id";
$result = $conn->query($query);
$mapel = $result->fetch_assoc();

if (!$mapel) {
    die("Data mapel tidak ditemukan.");
}

// Proses saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_mapel = $_POST['nama_mapel'];
    $id_guru = $_POST['id_guru'];

    $update = "UPDATE mapel SET nama_mapel = '$nama_mapel', id_guru = '$id_guru' WHERE id_mapel = $id";
    if ($conn->query($update)) {
        header("Location: mapel.php");
        exit;
    } else {
        echo "Gagal mengupdate data.";
    }
}

// Ambil daftar guru untuk dropdown
$guru_result = $conn->query("SELECT id_user, nama FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mapel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 60px;
        }

        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            border-radius: 5px;
            margin-left: 10px;
        }

        a:hover {
            background-color: #5a6268;
        }

        .action-buttons {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Data Mapel</h2>
        <form method="POST">
            <label for="nama_mapel">Nama Mapel:</label>
            <input type="text" name="nama_mapel" id="nama_mapel" value="<?= htmlspecialchars($mapel['nama_mapel']) ?>" required>

            <label for="id_guru">Guru:</label>
            <select name="id_guru" id="id_guru" required>
                <?php while ($guru = $guru_result->fetch_assoc()): ?>
                    <option value="<?= $guru['id_user'] ?>" <?= $guru['id_user'] == $mapel['id_guru'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($guru['nama']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <div class="action-buttons">
                <button type="submit">Simpan</button>
                <a href="mapel.php">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
