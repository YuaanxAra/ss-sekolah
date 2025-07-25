<?php
session_start();
include_once '../config.php';

// Tentukan jumlah data per halaman
$per_page = 5;

// Ambil halaman aktif dari parameter GET, default ke 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Hitung offset
$offset = ($page - 1) * $per_page;

// Ambil total data untuk menghitung jumlah halaman
$total_result = $conn->query("SELECT COUNT(*) AS total FROM galeri");
$total_row = $total_result->fetch_assoc();
$total_data = $total_row['total'];
$total_pages = ceil($total_data / $per_page);

// Ambil data sesuai halaman
$query = "SELECT * FROM galeri ORDER BY id_galeri DESC LIMIT $per_page OFFSET $offset";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Daftar Foto</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <link href="../assets/css/argon-dashboard-tailwind.css?v=1.0.1" rel="stylesheet" />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Popper -->
  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <!-- Main Styling -->
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
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    th,
    td {
      padding: 12px 16px;
      border: 1px solid #e0e0e0;
      text-align: center;
    }

    th {
      background-color: #5e72e4;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f4f6f9;
    }
  </style>
  <script>
    console.log("DEBUG SESSION:");
    console.log("ID User:", "<?php echo $_SESSION['id_user'] ?? 'null'; ?>");
    console.log("Username:", "<?php echo $_SESSION['username'] ?? 'null'; ?>");
    console.log("Nama:", "<?php echo $_SESSION['nama'] ?? 'null'; ?>");
    console.log("Email:", "<?php echo $_SESSION['email'] ?? 'null'; ?>");
    console.log("Role:", "<?php echo $_SESSION['role'] ?? 'null'; ?>");
    console.log("NISN:", "<?php echo $_SESSION['nisn'] ?? 'null'; ?>");
  </script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-200 leading-default bg-gray-50 text-slate-900">

  <!-- SIDEBAR -->
  <aside class="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 -translate-x-full bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0 m-0 font-sans text-base antialiased font-normal dark:bg-white leading-default bg-gray-50 text-slate-500" aria-expanded="false">
    <div class="h-19">
      <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-slate-900 text-slate-400 xl:hidden" sidenav-close></i>
      <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-slate-900 text-slate-700" href="#">
        <img src="../assets/img/logo-ct-dark.png" class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8" alt="main_logo" />
        <img src="../assets/img/logo-ct.png" class="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-8" alt="main_logo" />
        <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Dashboard Guru</span>
      </a>
    </div>

    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />

    <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
      <ul class="flex flex-col pl-0 mb-0">
        <li class="mt-0.5 w-full">
          <a class="py-2.7 hover:bg-blue-100 dark:text-slate-600 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="../index.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-tv-2"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Dashboard</span>
          </a>
        </li>

        <!-- <li class="mt-0.5 w-full">
          <a class="py-2.7 hover:bg-blue-100 dark:text-slate-600 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="../mapel/mapel.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-book-bookmark"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Mapel</span>
          </a>
        </li> -->
        <li class="mt-0.5 w-full">
          <a class="py-2.7 hover:bg-blue-100 dark:text-slate-600 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="../siswa/siswa.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-hat-3"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Siswa</span>
          </a>
        </li>
        <!-- <li class="mt-0.5 w-full">
          <a class="py-2.7 hover:bg-blue-100 dark:text-slate-600 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="../guru/guru.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-hat-3"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Guru</span>
          </a>
        </li> -->
        <li class="mt-0.5 w-full">
          <a class="py-2.7 hover:bg-blue-100 dark:text-slate-600 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="../nilai/nilai.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-chart-bar-32"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Nilai</span>
          </a>
        </li>
        <li class="mt-0.5 w-full">
          <a class="py-2.7 bg-blue-500 text-white dark:text-white text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="galeri.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-white-500 ni ni-camera-compact"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Galeri</span>
          </a>
        </li>
        <li class="mt-auto w-full">
          <a class="py-2.7 bg-red-600 hover:bg-red-700 text-white text-sm ease-nav-brand my-4 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200"
            href="../../logout.php">
            <div
              class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-white ni ni-button-power"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="p-6">
    <h1 class="text-2xl font-semibold text-slate-700 mb-4">Daftar Foto</h1>
    <div class="flex justify-between items-center mb-4">
      <a href="tambah_galeri.php"
        style="display:inline-block; background-color:#28a745; color:white; padding:8px 16px; border-radius:6px; text-decoration:none; box-shadow:0 2px 4px rgba(0,0,0,0.1);"
        onmouseover="this.style.backgroundColor='#218838'"
        onmouseout="this.style.backgroundColor='#28a745'">
        + Tambah Foto
      </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-4 overflow-x-auto">
      <table class="min-w-full border border-slate-200 text-sm text-slate-600">
        <thead class="bg-slate-100">
          <tr>
            <th class="px-4 py-2 border">No</th>
            <th class="px-4 py-2 border">Judul</th>
            <th class="px-4 py-2 border">Deskripsi</th>
            <th class="px-4 py-2 border">Gambar</th>
            <th class="px-4 py-2 border">Tipe</th>
            <th class="px-4 py-2 border">Tanggal Upload</th>
            <th class="px-4 py-2 border">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php $no = 1;
            while ($row = $result->fetch_assoc()): ?>
              <tr class="hover:bg-slate-50 transition">
                <td class="px-4 py-2 border"><?= $no++ ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['judul']) ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['deskripsi']) ?></td>
                <td class="px-4 py-2 border">
                  <img src="../../uploads/<?= htmlspecialchars($row['nama_file']) ?>" alt="gambar" class="w-24 h-24 object-cover rounded">
                </td>
                <td class="px-4 py-2 border capitalize"><?= $row['tipe'] ?></td>
                <td class="px-4 py-2 border"><?= date('d-m-Y H:i', strtotime($row['tanggal_upload'])) ?></td>
                <td class="px-4 py-2 border">
                  <a href="edit_galeri.php?id=<?= $row['id_galeri'] ?>"
                    style="background-color:#ffc107; color:white; padding:6px 12px; border-radius:4px; text-decoration:none; margin-right:6px;"
                    onmouseover="this.style.backgroundColor='#e0a800'"
                    onmouseout="this.style.backgroundColor='#ffc107'">Edit</a>

                  <a href="hapus_galeri.php?id=<?= $row['id_galeri'] ?>"
                    onclick="return confirm('Yakin ingin menghapus gambar ini?');"
                    style="background-color:#dc3545; color:white; padding:6px 12px; border-radius:4px; text-decoration:none;"
                    onmouseover="this.style.backgroundColor='#c82333'"
                    onmouseout="this.style.backgroundColor='#dc3545'">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center py-4">Belum ada foto galeri yang ditambahkan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
      <div class="flex justify-center items-center mt-6 space-x-2">
        <?php if ($page > 1): ?>
          <a href="?page=<?= $page - 1 ?>" class="px-4 py-2 rounded bg-slate-200 text-slate-700 hover:bg-slate-300">&laquo;</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <a href="?page=<?= $i ?>" class="px-4 py-2 rounded <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' ?>">
            <?= $i ?>
          </a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
          <a href="?page=<?= $page + 1 ?>" class="px-4 py-2 rounded bg-slate-200 text-slate-700 hover:bg-slate-300">&raquo;</a>
        <?php endif; ?>
      </div>
    </div>
  </main>

</body>

</html>