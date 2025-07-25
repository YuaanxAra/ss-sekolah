<?php
session_start();
include_once '../config.php';

// Ambil data siswa dan nama kelas
$query = "
    SELECT u.id_user, u.nama, u.nisn, u.email, u.username, k.nama_kelas
    FROM siswa_kelas sk
    JOIN users u ON sk.id_siswa = u.id_user
    JOIN kelas k ON sk.id_kelas = k.id_kelas
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Daftar Siswa</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://unpkg.com/@popperjs/core@2"></script>
  <link href="../assets/css/argon-dashboard-tailwind.css?v=1.0.1" rel="stylesheet" />
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
      text-align: left;
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
        <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Argon Dashboard 2</span>
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

        <li class="mt-0.5 w-full">
          <a class="py-2.7 hover:bg-blue-100 dark:text-slate-600 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="../mapel/mapel.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-book-bookmark"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Mapel</span>
          </a>
        </li>
        <li class="mt-0.5 w-full">
          <a class="py-2.7 bg-blue-500 text-white dark:text-white text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="siswa.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-white ni ni-hat-3"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Siswa</span>
          </a>
        </li>
        <li class="mt-0.5 w-full">
          <a class="py-2.7 hover:bg-blue-100 dark:text-slate-600 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="../guru/guru.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-hat-3"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Guru</span>
          </a>
        </li>
        <li class="mt-0.5 w-full">
          <a class="py-2.7 hover:bg-blue-100 dark:text-slate-600 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="../nilai/nilai.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-chart-bar-32"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Nilai</span>
          </a>
        </li>
        <li class="mt-0.5 w-full">
          <a class="py-2.7 hover:bg-blue-100 dark:text-slate-600 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="../galeri/galeri.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-camera-compact"></i>
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
    <h1 class="text-2xl font-semibold text-slate-700 mb-4">Daftar Siswa</h1>
    <a href="tambah_siswa.php"
      style="display:inline-block; background-color:#28a745; color:white; padding:8px 16px; border-radius:6px; text-decoration:none; margin-bottom:16px; box-shadow:0 2px 4px rgba(0,0,0,0.1);"
      onmouseover="this.style.backgroundColor='#218838'"
      onmouseout="this.style.backgroundColor='#28a745'">
      + Tambah Siswa
    </a>

    <div class="bg-white rounded-xl shadow-lg p-4 overflow-x-auto">
      <table class="min-w-full border border-slate-200 text-sm text-slate-600">
        <thead class="bg-slate-100">
          <tr>
            <th class="px-4 py-2 border">No</th>
            <th class="px-4 py-2 border">Nama Siswa</th>
            <th class="px-4 py-2 border">Kelas</th>
            <th class="px-4 py-2 border">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php $no = 1;
            while ($row = $result->fetch_assoc()): ?>
              <tr class="hover:bg-slate-50 transition">
                <td class="px-4 py-2 border"><?= $no++ ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['nama']) ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['nama_kelas']) ?></td>
                <td class="px-4 py-2 border">

                  <!-- TOMBOL DETAIL-->
                  <a href="javascript:void(0);"
                    onclick="showModal('<?= htmlspecialchars($row['nama']) ?>',
                     '<?= htmlspecialchars($row['nama_kelas']) ?>',
                     '<?= $row['nisn'] ?>',
                     '<?= $row['username'] ?>',
                     '<?= $row['email'] ?>')"
                    style="background-color:#0d6efd; color:white; padding:6px 12px; border-radius:4px; text-decoration:none; margin-right:6px;"
                    onmouseover="this.style.backgroundColor='#0b5ed7'"
                    onmouseout="this.style.backgroundColor='#0d6efd'">Lihat</a>

                  <!-- TOMBOL EDIT-->
                  <a href="edit_siswa.php?id=<?= $row['id_user'] ?>"
                    style="background-color:#ffc107; color:white; padding:6px 12px; border-radius:4px; text-decoration:none; margin-right:6px;"
                    onmouseover="this.style.backgroundColor='#e0a800'"
                    onmouseout="this.style.backgroundColor='#ffc107'">
                    Edit
                  </a>

                  <!-- TOMBOL HAPUS-->
                  <a href="hapus_siswa.php?id=<?= $row['id_user'] ?>"
                    onclick="return confirm('Yakin ingin menghapus siswa ini?');"
                    style="background-color:#dc3545; color:white; padding:6px 12px; border-radius:4px; text-decoration:none;"
                    onmouseover="this.style.backgroundColor='#c82333'"
                    onmouseout="this.style.backgroundColor='#dc3545'">
                    Hapus
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center py-4">Data nilai tidak ditemukan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Modal -->
    <div id="nilaiModal" class="fixed inset-0 hidden bg-black/50 z-50 flex items-center justify-center px-4">
      <div class="bg-white w-full max-w-lg rounded-xl shadow-lg p-6 text-slate-700 relative">
        <h2 class="text-2xl font-semibold mb-6 border-b pb-3 text-center">Detail Nilai Siswa</h2>
        <div class="space-y-4">
          <div class="flex justify-between">
            <span class="font-medium text-slate-600">Nama Siswa:</span>
            <span id="modalNama" class="text-slate-800 font-semibold text-right"></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-slate-600">Kelas:</span>
            <span id="modalKelas" class="text-slate-800 font-semibold text-right"></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-slate-600">NISN:</span>
            <span id="modalNISN" class="text-slate-800 font-semibold text-right"></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-slate-600">Username:</span>
            <span id="modalUsername" class="text-slate-800 font-semibold text-right"></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-slate-600">Email:</span>
            <span id="modalEmail" class="text-slate-800 font-semibold text-right"></span>
          </div>
        </div>
        <div class="mt-6 text-center">
          <button onclick="closeModal()" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg shadow">
            Tutup
          </button>
        </div>
      </div>
    </div>
    <script>
      function showModal(nama, nama_kelas, nisn, username, email) {
        document.getElementById('modalNama').textContent = nama;
        document.getElementById('modalKelas').textContent = nama_kelas;
        document.getElementById('modalNISN').textContent = nisn;
        document.getElementById('modalUsername').textContent = username;
        document.getElementById('modalEmail').textContent = email;
        document.getElementById('nilaiModal').classList.remove('hidden');
      }

      function closeModal() {
        document.getElementById('nilaiModal').classList.add('hidden');
      }
    </script>
  </main>


</body>

</html>