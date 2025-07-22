<?php
include_once '../config.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $query = "DELETE FROM users WHERE id_user = $id";
    if ($conn->query($query)) {
        header("Location: siswa.php");
        exit;
    } else {
        echo "Gagal menghapus data siswa.";
    }
} else {
    echo "ID siswa tidak ditemukan.";
}
?>
