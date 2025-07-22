<?php
include_once '../config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID nilai tidak ditemukan.");
}

$query = "DELETE FROM nilai WHERE id_nilai = $id";
if ($conn->query($query)) {
    header("Location: nilai.php");
    exit;
} else {
    echo "Gagal menghapus data nilai.";
}
?>
