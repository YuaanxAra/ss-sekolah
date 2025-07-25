<?php
session_start();
include_once '../config.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $query = "DELETE FROM users WHERE id_user = $id AND role = 'guru'";
    if ($conn->query($query)) {
        header("Location: guru.php");
        exit;
    } else {
        echo "Gagal menghapus data guru.";
    }
} else {
    echo "ID guru tidak ditemukan.";
}
?>