<?php
session_start();
include_once '../config.php';

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

$guru_result = $conn->query("SELECT id_user, nama FROM users WHERE role = 'guru'");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Mapel</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; padding: 20px; }
        form { max-width: 500px; margin: auto; background: white; padding: 20px; border-radius: 8px; }
        input { width: 95%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        button { padding: 10px 15px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { text-decoration: none; color: #555; margin-left: 10px; }
        h2 { text-align: center; color: #333; }
    </style>
</head>
<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-200 leading-default bg-gray-50 text-slate-900">
    <h2>Tambah Mapel</h2>
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

</body>

</html>