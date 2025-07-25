<?php
session_start();
include_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email    = $_POST['email'];

    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $role         = 'guru';
    $created      = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO users (username, password, nama, email, role, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $hashPassword, $nama, $email, $role, $created);

    if ($stmt->execute()) {
        header("Location: guru.php");
        exit;
    } else {
        echo "Gagal menambahkan guru: " . $conn->error;
    }
}
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
    <h2>Tambah Guru</h2>
    <form method="POST">
        <label>Nama Guru:</label><br>
        <input type="text" name="nama" required placeholder="Nama Guru"><br><br>

        <label>Username:</label><br>
        <input type="text" name="username" required placeholder="Username untuk akun"><br><br>

        <label>Password:</label><br>
        <input type="text" name="password" required placeholder="Password untuk akun"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required placeholder="Email Guru"><br><br>

        <button type="submit">Simpan</button>
        <a href="guru.php">Batal</a>
    </form>

</body>

</html>