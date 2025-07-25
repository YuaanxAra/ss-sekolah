<?php
session_start();
include_once '../config.php';

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID Guru tidak ditemukan.");
}

// Ambil data guru berdasarkan ID
$query = "SELECT * FROM users WHERE id_user = $id AND role = 'guru'";
$result = $conn->query($query);
$guru = $result->fetch_assoc();

if (!$guru) {
    die("Data guru tidak ditemukan.");
}

// Proses update saat form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email    = $_POST['email'];

    // Jika password tidak kosong, update dengan hash baru
    if (!empty($password)) {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $update = "UPDATE users SET nama = ?, username = ?, email = ?, password = ? WHERE id_user = ?";
        $stmt = $conn->prepare($update);
        $stmt->bind_param("ssssi", $nama, $username, $email, $hashPassword, $id);
    } else {
        // Jika password kosong, tidak diubah
        $update = "UPDATE users SET nama = ?, username = ?, email = ? WHERE id_user = ?";
        $stmt = $conn->prepare($update);
        $stmt->bind_param("sssi", $nama, $username, $email, $id);
    }

    if ($stmt->execute()) {
        header("Location: guru.php");
        exit;
    } else {
        echo "Gagal memperbarui data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Siswa</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 40px;
        }

        .form-box {
            background: white;
            padding: 20px;
            max-width: 400px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 95%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button,
        a {
            padding: 8px 16px;
            text-decoration: none;
            border: none;
            border-radius: 4px;
        }

        button {
            background: #007bff;
            color: white;
        }

        a {
            background: gray;
            color: white;
            margin-left: 10px;
        }
    </style>
</head>

<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-200 leading-default bg-gray-50 text-slate-900">
    <div class="form-box">
        <h2>Edit Data Guru</h2>
        <form method="POST">
            <label>Nama Guru:</label>
            <input type="text" name="nama" required value="<?= htmlspecialchars($guru['nama']) ?>" placeholder="Nama Guru">

            <label>Username:</label>
            <input type="text" name="username" required value="<?= htmlspecialchars($guru['username']) ?>" placeholder="Username untuk akun">

            <label>Password (kosongkan jika tidak ingin mengubah):</label>
            <input type="text" name="password" placeholder="Password baru (opsional)">

            <label>Email:</label>
            <input type="text" name="email" required value="<?= htmlspecialchars($guru['email']) ?>" placeholder="Email Guru">

            <button type="submit">Update</button>
            <a href="guru.php">Batal</a>
        </form>
    </div>
</body>

</html>