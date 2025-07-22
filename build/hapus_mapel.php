<?php
include_once 'config.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Hapus dulu semua data di tabel nilai yang terkait dengan mapel ini
    $deleteNilai = "DELETE FROM nilai WHERE id_mapel = $id";
    $conn->query($deleteNilai); // hapus nilai terkait

    // Baru hapus mapelnya
    $query = "DELETE FROM mapel WHERE id_mapel = $id";
    if ($conn->query($query)) {
        header("Location: mapel.php");
        exit;
    } else {
        echo "Gagal menghapus data mapel.";
    }
} else {
    echo "ID tidak ditemukan.";
}
?>
