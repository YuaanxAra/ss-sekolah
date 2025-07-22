<?php
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_siswa = trim($_POST['nama_siswa']);
    $nama_mapel = trim($_POST['nama_mapel']);
    $uts = floatval($_POST['uts']);
    $uas = floatval($_POST['uas']);
    $tugas = floatval($_POST['tugas']);
    $nilai_akhir = ($uts + $uas + $tugas) / 3;

    // --- Simpan siswa jika belum ada ---
    $stmt_siswa = $conn->prepare("SELECT id_user FROM users WHERE nama = ? AND role = 'siswa'");
    $stmt_siswa->bind_param("s", $nama_siswa);
    $stmt_siswa->execute();
    $siswa_result = $stmt_siswa->get_result();

    if ($siswa_result->num_rows > 0) {
        $id_siswa = $siswa_result->fetch_assoc()['id_user'];
    } else {
        $username = strtolower(str_replace(' ', '', $nama_siswa));
        $password = $username;
        $role = 'siswa';
        $stmt_insert_siswa = $conn->prepare("INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, ?)");
        $stmt_insert_siswa->bind_param("ssss", $username, $password, $nama_siswa, $role);
        $stmt_insert_siswa->execute();
        $id_siswa = $stmt_insert_siswa->insert_id;
    }

    // --- Simpan mapel jika belum ada ---
    $stmt_mapel = $conn->prepare("SELECT id_mapel FROM mapel WHERE nama_mapel = ?");
    $stmt_mapel->bind_param("s", $nama_mapel);
    $stmt_mapel->execute();
    $mapel_result = $stmt_mapel->get_result();

    if ($mapel_result->num_rows > 0) {
        $id_mapel = $mapel_result->fetch_assoc()['id_mapel'];
    } else {
        $id_guru = 1; // default id_guru (bisa kamu ubah agar dinamis)
        $stmt_insert_mapel = $conn->prepare("INSERT INTO mapel (nama_mapel, id_guru) VALUES (?, ?)");
        $stmt_insert_mapel->bind_param("si", $nama_mapel, $id_guru);
        $stmt_insert_mapel->execute();
        $id_mapel = $stmt_insert_mapel->insert_id;
    }

    // --- Simpan ke tabel nilai ---
    $stmt_nilai = $conn->prepare("INSERT INTO nilai (id_siswa, id_mapel, uts, uas, tugas, nilai_akhir) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt_nilai->bind_param("iidddd", $id_siswa, $id_mapel, $uts, $uas, $tugas, $nilai_akhir);

    if ($stmt_nilai->execute()) {
        header("Location: nilai.php");
        exit;
    } else {
        $error = "Gagal menyimpan nilai.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Nilai Manual</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        form { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { text-decoration: none; color: #555; margin-left: 10px; }
        h2 { text-align: center; color: #333; }
        .error { color: red; text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>

    <h2>Tambah Nilai Siswa (Manual)</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Nama Siswa</label>
        <input type="text" name="nama_siswa" placeholder="" required>

        <label>Mata Pelajaran</label>
        <input type="text" name="nama_mapel" placeholder="" required>

        <label>UTS</label>
        <input type="number" name="uts" step="0.01" required>

        <label>UAS</label>
        <input type="number" name="uas" step="0.01" required>

        <label>Tugas</label>
        <input type="number" name="tugas" step="0.01" required>

        <button type="submit">Simpan</button>
        <a href="nilai.php">Batal</a>
    </form>

</body>
</html>
