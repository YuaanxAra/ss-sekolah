<?php
session_start();
include_once '../config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID galeri tidak ditemukan.");
}

// Ambil nama file gambar terlebih dahulu
$get = $conn->query("SELECT nama_file FROM galeri WHERE id_galeri = $id");
if ($get && $get->num_rows > 0) {
    $data = $get->fetch_assoc();
    $filePath = '../../uploads/' . $data['nama_file'];

    // Hapus data dari database
    $delete = $conn->query("DELETE FROM galeri WHERE id_galeri = $id");

    if ($delete) {
        // Hapus file jika ada
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        header("Location: galeri.php");
        exit;
    } else {
        echo "Gagal menghapus data galeri.";
    }
} else {
    echo "Data galeri tidak ditemukan.";
}
?>
