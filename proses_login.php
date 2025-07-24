<?php
session_start();
include 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    $role = $user['role'];
    $isValid = false;

    if ($role === 'siswa') {
        // Siswa: password adalah hasil hash dari NISN
        $isValid = password_verify($password, $user['password']);
    } else {
        // Guru/Admin: password biasa
        $isValid = ($password === $user['password']);
    }

    if ($isValid) {
        $_SESSION['id_user']  = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama']     = $user['nama'];
        $_SESSION['email']    = $user['email'];
        $_SESSION['role']     = $user['role'];

        if ($role === 'siswa') {
            $_SESSION['nisn'] = $user['nisn'];
            header("Location: siswa/index.php");
        } elseif ($role === 'guru') {
            header("Location: guru/index.php");
        } elseif ($role === 'admin') {
            header("Location: admin/index.php");
        } else {
            $_SESSION['error'] = "Role tidak dikenali.";
            header("Location: login.php");
        }
        exit;
    } else {
        $_SESSION['error'] = "Password salah.";
        header("Location: login.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Username tidak ditemukan.";
    header("Location: login.php");
    exit;
}