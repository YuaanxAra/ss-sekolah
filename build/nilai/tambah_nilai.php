<?php
include_once '../config.php';

// Ambil daftar siswa dan mapel
$siswa = $conn->query("SELECT id_user, nama FROM users");
$mapel = $conn->query("SELECT id_mapel, nama_mapel FROM mapel");

// Proses submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_siswa = $_POST['id_siswa'];
    $id_mapel = $_POST['id_mapel'];
    $uts = $_POST['uts'];
    $uas = $_POST['uas'];
    $tugas = $_POST['tugas'];
    $nilai_akhir = ($uts + $uas + $tugas) / 3;

    $insert = "INSERT INTO nilai (id_siswa, id_mapel, uts, uas, tugas, nilai_akhir)
               VALUES ('$id_siswa', '$id_mapel', '$uts', '$uas', '$tugas', '$nilai_akhir')";

    if ($conn->query($insert)) {
        header("Location: nilai.php");
        exit;
    } else {
        echo "Gagal menambahkan data nilai.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Nilai</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        form { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 8px; }
        input, select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { text-decoration: none; color: #555; margin-left: 10px; }
        h2 { text-align: center; color: #333; }
    </style>
</head>
<body>
    <h2>Tambah Data Nilai</h2>
    <form method="POST">
        <label>Nama Siswa</label>
        <select name="id_siswa" required>
            <option value="">-- Pilih Siswa --</option>
            <?php while ($s = $siswa->fetch_assoc()): ?>
                <option value="<?= $s['id_user'] ?>"><?= htmlspecialchars($s['nama']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>Mata Pelajaran</label>
        <select name="id_mapel" required>
            <option value="">-- Pilih Mapel --</option>
            <?php while ($m = $mapel->fetch_assoc()): ?>
                <option value="<?= $m['id_mapel'] ?>"><?= htmlspecialchars($m['nama_mapel']) ?></option>
            <?php endwhile; ?>
        </select>

        <label>UTS</label>
        <input type="number" name="uts" required>

        <label>UAS</label>
        <input type="number" name="uas" required>

        <label>Tugas</label>
        <input type="number" name="tugas" required>

        <button type="submit">Simpan</button>
        <a href="nilai.php">Batal</a>
    </form>
</body>
</html>
