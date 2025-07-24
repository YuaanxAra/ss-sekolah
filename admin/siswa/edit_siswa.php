<?php
session_start();
include_once '../config.php';

$id_user = $_GET['id'] ?? null;

if (!$id_user) {
    echo "ID tidak valid.";
    exit;
}

// Ambil data siswa + kelas
$query = "
    SELECT u.*, k.id_kelas, k.nama_kelas
    FROM users u
    LEFT JOIN siswa_kelas sk ON u.id_user = sk.id_siswa
    LEFT JOIN kelas k ON sk.id_kelas = k.id_kelas
    WHERE u.id_user = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
$siswa = $result->fetch_assoc();

// Ambil daftar kelas
$kelas_result = $conn->query("SELECT id_kelas, nama_kelas FROM kelas");

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = $_POST['nama'];
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $id_kelas = $_POST['id_kelas'];

    // Update users
    $stmt1 = $conn->prepare("UPDATE users SET nama = ?, username = ?, email = ? WHERE id_user = ?");
    $stmt1->bind_param("sssi", $nama, $username, $email, $id_user);
    $stmt1->execute();

    // Update siswa_kelas
    $cek_kelas = $conn->prepare("SELECT * FROM siswa_kelas WHERE id_siswa = ?");
    $cek_kelas->bind_param("i", $id_user);
    $cek_kelas->execute();
    $res = $cek_kelas->get_result();

    if ($res->num_rows > 0) {
        $stmt2 = $conn->prepare("UPDATE siswa_kelas SET id_kelas = ? WHERE id_siswa = ?");
        $stmt2->bind_param("ii", $id_kelas, $id_user);
        $stmt2->execute();
    } else {
        $stmt2 = $conn->prepare("INSERT INTO siswa_kelas (id_siswa, id_kelas) VALUES (?, ?)");
        $stmt2->bind_param("ii", $id_user, $id_kelas);
        $stmt2->execute();
    }

    header("Location: siswa.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Siswa</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 40px;
        }

        .form-box {
            background: white;
            padding: 20px;
            max-width: 400px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"]
        {
            width: 95%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button,
        a {
            padding: 8px 16px;
            text-decoration: none;
            border: none;
            border-radius: 4px;
        }

        button {
            background: #007bff;
            color: white;
        }

        a {
            background: gray;
            color: white;
            margin-left: 10px;
        }
    </style>
</head>

<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-200 leading-default bg-gray-50 text-slate-900">
    <div class="form-box">
        <h2>Edit Siswa</h2>
        <form method="POST">
            <label>Nama Siswa:</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($siswa['nama']) ?>" required>

            <label>Username:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($siswa['username']) ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($siswa['email']) ?>" required>

            <label>Kelas:</label>
            <select name="id_kelas" required>
                <?php while ($kelas = $kelas_result->fetch_assoc()): ?>
                    <option value="<?= $kelas['id_kelas'] ?>" <?= $kelas['id_kelas'] == $siswa['id_kelas'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($kelas['nama_kelas']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit">Simpan</button>
            <a href="siswa.php">Batal</a>
        </form>
    </div>
</body>
</html>