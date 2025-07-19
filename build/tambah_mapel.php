<?php
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_mapel = $_POST['nama_mapel'];
    $id_guru = $_POST['id_guru'];

    $insert = "INSERT INTO mapel (nama_mapel, id_guru) VALUES ('$nama_mapel', '$id_guru')";
    if ($conn->query($insert)) {
        header("Location: mapel.php");
        exit;
    } else {
        echo "Gagal menambahkan mapel.";
    }
}

$guru_result = $conn->query("SELECT id_user, nama FROM users");
?>

<?php include 'template_header.php'; ?>

<main>
    <h1>Tambah Mapel</h1>
    <form method="POST">
        <label>Nama Mapel:</label><br>
        <input type="text" name="nama_mapel" required><br><br>

        <label>Guru:</label><br>
        <select name="id_guru" required>
            <?php while ($guru = $guru_result->fetch_assoc()): ?>
                <option value="<?= $guru['id_user'] ?>"><?= htmlspecialchars($guru['nama']) ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit">Simpan</button>
        <a href="mapel.php">Batal</a>
    </form>
</main>

</body>
</html>
