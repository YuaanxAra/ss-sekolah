<?php
include_once 'config.php';

// Ambil data nilai lengkap
$query = "
    SELECT n.id_nilai, u.nama AS nama_siswa, m.nama_mapel,
           n.uts, n.uas, n.tugas, n.nilai_akhir
    FROM nilai n
    JOIN users u ON n.id_siswa = u.id_user
    JOIN mapel m ON n.id_mapel = m.id_mapel
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Nilai</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <link href="./assets/css/argon-dashboard-tailwind.css?v=1.0.1" rel="stylesheet" />
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
        }
        main {
            margin-left: 270px;
            padding: 2rem;
        }
        h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f4f6f9;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 -translate-x-full bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0" aria-expanded="false">
  <div class="h-19">
    <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden" sidenav-close></i>
    <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700" href="#">
      <img src="./assets/img/logo-ct-dark.png" class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8" alt="main_logo" />
      <img src="./assets/img/logo-ct.png" class="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-8" alt="main_logo" />
      <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Argon Dashboard 2</span>
    </a>
  </div>

  <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />

  <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
    <ul class="flex flex-col pl-0 mb-0">
      <li class="mt-0.5 w-full"><a class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold text-slate-700 transition-colors" href="index.html"><div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5"><i class="text-sm leading-normal text-blue-500 ni ni-tv-2"></i></div><span class="ml-1">Dashboard</span></a></li>
      <li class="mt-0.5 w-full"><a class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold text-slate-700 transition-colors" href="mapel.php"><div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5"><i class="text-sm leading-normal text-blue-500 ni ni-tv-2"></i></div><span class="ml-1">Mapel</span></a></li>
      <li class="mt-0.5 w-full"><a class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold text-slate-700 transition-colors" href="siswa.php"><div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5"><i class="text-sm leading-normal text-blue-500 ni ni-tv-2"></i></div><span class="ml-1">Siswa</span></a></li>
      <li class="mt-0.5 w-full"><a class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold text-slate-700 transition-colors" href="nilai.php"><div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5"><i class="text-sm leading-normal text-blue-500 ni ni-tv-2"></i></div><span class="ml-1">Nilai</span></a></li>
      <li class="mt-0.5 w-full"><a class="py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold text-slate-700 transition-colors" href="galeri.php"><div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5"><i class="text-sm leading-normal text-blue-500 ni ni-tv-2"></i></div><span class="ml-1">Galeri</span></a></li>
    </ul>
  </div>
</aside>

<!-- MAIN CONTENT -->
<main>
    <h1>Daftar Nilai Siswa</h1>

    <!-- Tombol Tambah Nilai -->
    <div style="margin-bottom: 15px;">
        <a href="tambah_nilai.php" style="background:#28a745; color:white; padding:10px 16px; border-radius:6px; text-decoration:none;">+ Tambah Nilai</a>
    </div>

    <!-- Tabel Data Nilai -->
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Mata Pelajaran</th>
                    <th>UTS</th>
                    <th>UAS</th>
                    <th>Tugas</th>
                    <th>Nilai Akhir</th>
                    <th>Grade</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama_siswa']) ?></td>
                            <td><?= htmlspecialchars($row['nama_mapel']) ?></td>
                            <td><?= $row['uts'] ?></td>
                            <td><?= $row['uas'] ?></td>
                            <td><?= $row['tugas'] ?></td>
                            <td><?= number_format($row['nilai_akhir'], 2) ?></td>
                            <td>
                                <?php
                                    $na = $row['nilai_akhir'];
                                    if ($na >= 90) {
                                        echo 'A';
                                    } elseif ($na >= 80) {
                                        echo 'B';
                                    } elseif ($na >= 70) {
                                        echo 'C';
                                    } elseif ($na >= 50) {
                                        echo 'D';
                                    } else {
                                        echo 'E';
                                    }
                                ?>
                            </td>
                            <td>
                                <a href="edit_nilai.php?id=<?= $row['id_nilai'] ?>" style="margin-right: 8px; background: #ffc107; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none;">Edit</a>
                                <a href="hapus_nilai.php?id=<?= $row['id_nilai'] ?>" onclick="return confirm('Yakin ingin menghapus nilai ini?');" style="background: #dc3545; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none;">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9" style="text-align:center;">Data nilai tidak ditemukan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>
