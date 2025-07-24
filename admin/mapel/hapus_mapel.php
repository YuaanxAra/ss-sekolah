<?php
session_start();
include_once '../config.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $query = "DELETE FROM mapel WHERE id_mapel = $id";
    if ($conn->query($query)) {
        header("Location: mapel.php");
        exit;
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
