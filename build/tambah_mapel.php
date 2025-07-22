<?php
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_mapel = trim($_POST['nama_mapel']);
    $nama_guru = trim($_POST['nama_guru']);

    if (!empty($nama_mapel) && !empty($nama_guru)) {
        // Cek apakah guru sudah ada
        $stmt = $conn->prepare("SELECT id_user FROM users WHERE nama = ? AND role = 'guru'");
        $stmt->bind_param("s", $nama_guru);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $id_guru = $result->fetch_assoc()['id_user'];
        } else {
            // Tambah guru baru ke users
            $username = strtolower(str_replace(' ', '', $nama_guru));
            $password = $username;
            $role = 'guru';
            $insert_user = $conn->prepare("INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, ?)");
            $insert_user->bind_param("ssss", $username, $password, $nama_guru, $role);
            $insert_user->execute();
            $id_guru = $insert_user->insert_id;
        }

        // Masukkan ke tabel mapel
        $insert_mapel = $conn->prepare("INSERT INTO mapel (nama_mapel, id_guru) VALUES (?, ?)");
        $insert_mapel->bind_param("si", $nama_mapel, $id_guru);

        if ($insert_mapel->execute()) {
            header("Location: mapel.php");
            exit;
        } else {
            $error = "Gagal menambahkan mata pelajaran.";
        }
    } else {
        $error = "Nama mapel dan guru tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mapel</title>
    <style>
        main {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            font-family: Arial, sans-serif;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        main h1 {
            text-align: center;
            color: #333;
        }

        form label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        form input[type="text"] {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        form button {
            background-color: #007bff;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        form button:hover {
            background-color: #0056b3;
        }

        form a {
            margin-left: 10px;
            text-decoration: none;
            color: #dc3545;
            font-size: 14px;
        }

        form a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<main>
    <h1>Tambah Mapel (Guru Manual)</h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="nama_mapel">Nama Mapel:</label>
        <input type="text" name="nama_mapel" id="nama_mapel" placeholder="" required>

        <label for="nama_guru">Nama Guru Pengampu:</label>
        <input type="text" name="nama_guru" id="nama_guru" placeholder="" required>

        <button type="submit">Simpan</button>
        <a href="mapel.php">Batal</a>
    </form>
</main>

</body>
</html>
