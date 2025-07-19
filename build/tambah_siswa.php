<?php
include_once 'config.php';

// Proses tambah siswa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_siswa = $_POST['id_siswa'];
    $id_kelas = $_POST['id_kelas'];

    $insert = "INSERT INTO siswa_kelas (id_siswa, id_kelas) VALUES ('$id_siswa', '$id_kelas')";
    if ($conn->query($insert)) {
        header("Location: siswa.php");
        exit;
    } else {
        echo "Gagal menambahkan siswa.";
    }
}

// Ambil data user (siswa) & kelas
$siswa_result = $conn->query("SELECT id_user, nama FROM users");
$kelas_result = $conn->query("SELECT id_kelas, nama_kelas FROM kelas");
?>

<?php include 'template_header.php'; ?>

<main>
    <h1>Tambah Siswa ke Kelas</h1>
    <form method="POST">
        <label>Nama Siswa:</label><br>
        <select name="id_siswa" required>
            <?php while ($siswa = $siswa_result->fetch_assoc()): ?>
                <option value="<?= $siswa['id_user'] ?>"><?= htmlspecialchars($siswa['nama']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Kelas:</label><br>
        <select name="id_kelas" required>
            <?php while ($kelas = $kelas_result->fetch_assoc()): ?>
                <option value="<?= $kelas['id_kelas'] ?>"><?= htmlspecialchars($kelas['nama_kelas']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit">Simpan</button>
        <a href="siswa.php">Batal</a>
    </form>
</main>

</body>
</html>
