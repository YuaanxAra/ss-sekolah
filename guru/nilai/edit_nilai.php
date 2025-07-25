<?php
session_start();
include_once '../config.php';

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
// Ambil nama siswa dari id_siswa yang ada di nilai
$id_siswa = $nilai['id_siswa'];
$siswa_result = $conn->query("SELECT nama FROM users WHERE id_user = $id_siswa");
$siswa_data = $siswa_result->fetch_assoc();
$nama_siswa = $siswa_data['nama'] ?? '';

$mapel = $conn->query("SELECT id_mapel, nama_mapel FROM mapel");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Nilai</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 20px;
        }

        form {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        input {
            width: 95%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 15px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: #555;
            margin-left: 10px;
        }

        h2 {
            text-align: center;
            color: #333;
        }
    </style>
</head>

<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-200 leading-default bg-gray-50 text-slate-900">
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
        <input type="text" value="<?= htmlspecialchars($nama_siswa) ?>" readonly>
        <input type="hidden" name="id_siswa" value="<?= $id_siswa ?>">

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