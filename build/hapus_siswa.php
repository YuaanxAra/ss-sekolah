<?php
include_once 'config.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Hapus data terkait di tabel nilai
    $conn->query("DELETE FROM nilai WHERE id_siswa = $id");

    // Hapus data relasi siswa dengan kelas
    $conn->query("DELETE FROM siswa_kelas WHERE id_siswa = $id");

    // Hapus siswa dari tabel utama (users)
    $query = "DELETE FROM users WHERE id_user = $id";
    if ($conn->query($query)) {
        header("Location: siswa.php");
        exit;
    } else {
        echo "Gagal menghapus data dari tabel users.";
    }
} else {
    echo "ID siswa tidak ditemukan.";
}
?>
