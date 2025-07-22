<?php
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_siswa = trim($_POST['nama_siswa']);
    $nisn = trim($_POST['nisn']);
    $nama_kelas = trim($_POST['nama_kelas']);

    if (!empty($nama_siswa) && !empty($nisn) && !empty($nama_kelas)) {
        // ---------- HANDLE KELAS ----------
        $stmt_kelas = $conn->prepare("SELECT id_kelas FROM kelas WHERE nama_kelas = ?");
        $stmt_kelas->bind_param("s", $nama_kelas);
        $stmt_kelas->execute();
        $kelas_result = $stmt_kelas->get_result();

        if ($kelas_result->num_rows > 0) {
            $row_kelas = $kelas_result->fetch_assoc();
            $id_kelas = $row_kelas['id_kelas'];
        } else {
            $insert_kelas = $conn->prepare("INSERT INTO kelas (nama_kelas) VALUES (?)");
            $insert_kelas->bind_param("s", $nama_kelas);
            $insert_kelas->execute();
            $id_kelas = $insert_kelas->insert_id;
        }

        // ---------- HANDLE SISWA ----------
        $stmt_siswa = $conn->prepare("SELECT id_user FROM users WHERE nama = ? AND role = 'siswa'");
        $stmt_siswa->bind_param("s", $nama_siswa);
        $stmt_siswa->execute();
        $siswa_result = $stmt_siswa->get_result();

        if ($siswa_result->num_rows > 0) {
            $row_siswa = $siswa_result->fetch_assoc();
            $id_siswa = $row_siswa['id_user'];
        } else {
            $username = strtolower(str_replace(' ', '', $nama_siswa));
            $password = $username; // default password
            $role = 'siswa';
            $insert_user = $conn->prepare("INSERT INTO users (username, password, nama, nisn, role) VALUES (?, ?, ?, ?, ?)");
            $insert_user->bind_param("sssss", $username, $password, $nama_siswa, $nisn, $role);
            $insert_user->execute();
            $id_siswa = $insert_user->insert_id;
        }

        // ---------- MASUKKAN KE siswa_kelas ----------
        $cek_relasi = $conn->prepare("SELECT * FROM siswa_kelas WHERE id_siswa = ? AND id_kelas = ?");
        $cek_relasi->bind_param("ii", $id_siswa, $id_kelas);
        $cek_relasi->execute();
        $cek_result = $cek_relasi->get_result();

        if ($cek_result->num_rows === 0) {
            $stmt_insert = $conn->prepare("INSERT INTO siswa_kelas (id_siswa, id_kelas) VALUES (?, ?)");
            $stmt_insert->bind_param("ii", $id_siswa, $id_kelas);
            $stmt_insert->execute();

            header("Location: siswa.php");
            exit;
        } else {
            $error = "Siswa sudah terdaftar di kelas ini.";
        }
    } else {
        $error = "Nama siswa, NISN, dan kelas tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Siswa + Kelas Manual</title>
    <style>
        body {
            background-color: #f4f6f8;
            font-family: Arial, sans-serif;
        }

        main {
            max-width: 500px;
            margin: 60px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333333;
            margin-bottom: 25px;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            margin-left: 10px;
            color: #dc3545;
            text-decoration: none;
            font-size: 14px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<main>
    <h1>Tambah Siswa dan Kelas Baru</h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="nama_siswa">Nama Siswa:</label>
        <input type="text" name="nama_siswa" id="nama_siswa" required>

        <label for="nisn">NISN:</label>
        <input type="text" name="nisn" id="nisn" required>

        <label for="nama_kelas">Nama Kelas:</label>
        <input type="text" name="nama_kelas" id="nama_kelas" required>

        <button type="submit">Simpan</button>
        <a href="siswa.php">Batal</a>
    </form>
</main>

</body>
</html>
