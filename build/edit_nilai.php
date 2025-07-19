<?php
include_once 'config.php';

// Ambil ID nilai dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID nilai tidak ditemukan.");
}

// Ambil data nilai berdasarkan ID
$query = "SELECT * FROM nilai WHERE id_nilai = $id";
$result = $conn->query($query);
$nilai = $result->fetch_assoc();
if (!$nilai) {
    die("Data nilai tidak ditemukan.");
}

// Saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_mapel = $_POST['id_mapel'];
    $id_siswa = $_POST['id_siswa'];
    $uts = $_POST['uts'];
    $uas = $_POST['uas'];
    $tugas = $_POST['tugas'];
    $nilai_akhir = ($uts + $uas + $tugas) / 3;

    $update = "UPDATE nilai SET id_mapel='$id_mapel', id_siswa='$id_siswa', uts='$uts', uas='$uas', tugas='$tugas', nilai_akhir='$nilai_akhir' WHERE id_nilai=$id";
    if ($conn->query($update)) {
        header("Location: nilai.php");
        exit;
    } else {
        echo "Gagal mengupdate data nilai.";
    }
}

// Data siswa & mapel
$siswa = $conn->query("SELECT id_user, nama FROM users");
$mapel = $conn->query("SELECT id_mapel, nama_mapel FROM mapel");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Nilai</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        form { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 8px; }
        input, select { width: 100%; padding: 8px; margin-bottom: 15px; }
        button { padding: 10px 15px; background: #007BFF; color: white; border: none; border-radius: 4px; }
        a { margin-left: 10px; color: #555; }
    </style>
</head>
<body>
    <h2>Edit Data Nilai</h2>
    <form method="POST">
        <label>Mata Pelajaran</label>
        <select name="id_mapel">
            <?php while ($m = $mapel->fetch_assoc()): ?>
                <option value="<?= $m['id_mapel'] ?>" <?= $m['id_mapel'] == $nilai['id_mapel'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($m['nama_mapel']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Nama Siswa</label>
        <select name="id_siswa">
            <?php while ($s = $siswa->fetch_assoc()): ?>
                <option value="<?= $s['id_user'] ?>" <?= $s['id_user'] == $nilai['id_siswa'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['nama']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>UTS</label>
        <input type="number" name="uts" value="<?= $nilai['uts'] ?>" required>

        <label>UAS</label>
        <input type="number" name="uas" value="<?= $nilai['uas'] ?>" required>

        <label>Tugas</label>
        <input type="number" name="tugas" value="<?= $nilai['tugas'] ?>" required>

        <button type="submit">Simpan Perubahan</button>
        <a href="nilai.php">Batal</a>
    </form>
</body>
</html>
