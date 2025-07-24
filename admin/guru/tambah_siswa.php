<?php
session_start();
include_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nisn     = $_POST['nisn'];
    $username     = $_POST['username'];
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $id_kelas = $_POST['id_kelas'];

    $password = password_hash($nisn, PASSWORD_DEFAULT);
    $role     = 'siswa';
    $created  = date('Y-m-d H:i:s');

    // Simpan ke tabel users
    $stmt = $conn->prepare("INSERT INTO users (nisn, username, password, nama, email, role, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nisn, $username, $password, $nama, $email, $role, $created);

    if ($stmt->execute()) {
        $id_user = $conn->insert_id;

        // Simpan ke tabel siswa_kelas
        $stmt2 = $conn->prepare("INSERT INTO siswa_kelas (id_siswa, id_kelas) VALUES (?, ?)");
        $stmt2->bind_param("ii", $id_user, $id_kelas);
        $stmt2->execute();

        header("Location: siswa.php");
        exit;
    } else {
        echo "Gagal menambahkan siswa: " . $conn->error;
    }
}

// Ambil data kelas (saja, karena siswa belum ada)
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

<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-200 leading-default bg-gray-50 text-slate-900">
    <h2>Tambah Siswa</h2>
    <form method="POST">
        <label>NISN:</label><br>
        <input type="text" name="nisn" required placeholder="NISN Siswa"><br><br>

        <label>Nama Siswa:</label><br>
        <input type="text" name="nama" required placeholder="Nama Siswa"><br><br>

        <label>Username:</label><br>
        <input type="text" name="username" required placeholder="Username untuk akun"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required placeholder="Email Siswa"><br><br>

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