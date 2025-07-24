<?php
session_start();
include_once '../config.php';

// Ambil id_user dari session
$id_user = $_SESSION['id_user'] ?? null;

if (!$id_user) {
  echo "Akses ditolak.";
  exit;
}

// Query nilai khusus untuk siswa ini
$query = "
    SELECT n.id_nilai, u.nama AS nama_siswa, m.nama_mapel,
           n.uts, n.uas, n.tugas, n.nilai_akhir
    FROM nilai n
    JOIN users u ON n.id_siswa = u.id_user
    JOIN mapel m ON n.id_mapel = m.id_mapel
    WHERE n.id_siswa = ?
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Daftar Nilai</title>
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
  <script src="https://cdn.tailwindcss.com"></script>
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
</head>

<body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
  <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>

  <!-- SIDEBAR -->
  <aside
    class="bg-[#1b2d4a] text-white fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 -translate-x-full border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0"
    aria-expanded="false">
    <div class="h-19">
      <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden" sidenav-close></i>
      <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700" href="#">
        <img src="../assets/img/logo-ct-dark.png" class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8" alt="main_logo" />
        <img src="../assets/img/logo-ct.png" class="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-8" alt="main_logo" />
        <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Argon Dashboard 2</span>
      </a>
    </div>

    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />

    <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
      <ul class="flex flex-col pl-0 mb-0">
        <li class="mt-0.5 w-full">
          <a class="py-2.7 hover:bg-blue-800 dark:text-slate-300 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="../index.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-tv-2"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Dashboard</span>
          </a>
        </li>

        <li class="mt-0.5 w-full">
          <a class="py-2.7 bg-blue-500 text-white dark:text-white text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="nilai.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-white-500 ni ni-chart-bar-32"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Nilai</span>
          </a>
        </li>
        <!-- <li class="mt-0.5 w-full">
          <a class="py-2.7 hover:bg-blue-800 dark:text-slate-300 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="../galeri.php">
            <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-tv-2"></i>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Galeri</span>
          </a>
        </li> -->
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
    <h1 class="text-2xl font-semibold text-slate-300 mb-4">Daftar Nilai Siswa</h1>

    <div class="bg-[#1b2d4a] rounded-xl shadow-lg p-4 overflow-x-auto">
      <?php
      // Tempatkan fungsi di atas sebelum tag <table>
      function getGrade($nilai)
      {
        if ($nilai >= 90) return 'A';
        elseif ($nilai >= 80) return 'B';
        elseif ($nilai >= 70) return 'C';
        elseif ($nilai >= 50) return 'D';
        else return 'E';
      }
      ?>
      <table class="min-w-full border border-slate-200 text-sm text-slate-600">
        <thead class="bg-slate-100">
          <tr>
            <th class="px-4 py-2 border">No</th>
            <th class="px-4 py-2 border">Nama Siswa</th>
            <th class="px-4 py-2 border">Mata Pelajaran</th>
            <th class="px-4 py-2 border">Nilai Akhir</th>
            <th class="px-4 py-2 border">Grade</th>
            <th class="px-4 py-2 border">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php $no = 1;
            while ($row = $result->fetch_assoc()): ?>
              <tr class="hover:bg-slate-50 transition">
                <td class="px-4 py-2 border"><?= $no++ ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['nama_siswa']) ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['nama_mapel']) ?></td>
                <td class="px-4 py-2 border"><?= number_format($row['nilai_akhir'], 2) ?></td>
                <td class="px-4 py-2 border"><?= getGrade($row['nilai_akhir']) ?></td>
                <td class="px-4 py-2 border">
                  <a href="javascript:void(0);"
                    onclick="showModal('<?= htmlspecialchars($row['nama_siswa']) ?>',
                     '<?= htmlspecialchars($row['nama_mapel']) ?>',
                     '<?= $row['uts'] ?>',
                     '<?= $row['uas'] ?>',
                     '<?= $row['tugas'] ?>',
                     '<?= $row['nilai_akhir'] ?>')"
                    style="background-color:#0d6efd; color:white; padding:6px 12px; border-radius:4px; text-decoration:none; margin-right:6px;"
                    onmouseover="this.style.backgroundColor='#0b5ed7'"
                    onmouseout="this.style.backgroundColor='#0d6efd'">Lihat</a>
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
            <span class="font-medium text-slate-600">Mata Pelajaran:</span>
            <span id="modalMapel" class="text-slate-800 font-semibold text-right"></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-slate-600">UTS:</span>
            <span id="modalUTS" class="text-slate-800 font-semibold text-right"></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-slate-600">UAS:</span>
            <span id="modalUAS" class="text-slate-800 font-semibold text-right"></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-slate-600">Tugas:</span>
            <span id="modalTugas" class="text-slate-800 font-semibold text-right"></span>
          </div>
          <div class="flex justify-between">
            <span class="font-medium text-slate-600">Nilai Akhir:</span>
            <span id="modalNilaiAkhir" class="text-slate-800 font-semibold text-right"></span>
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
      function showModal(nama, mapel, uts, uas, tugas, nilaiAkhir) {
        document.getElementById('modalNama').textContent = nama;
        document.getElementById('modalMapel').textContent = mapel;
        document.getElementById('modalUTS').textContent = uts;
        document.getElementById('modalUAS').textContent = uas;
        document.getElementById('modalTugas').textContent = tugas;
        document.getElementById('modalNilaiAkhir').textContent = nilaiAkhir;
        document.getElementById('nilaiModal').classList.remove('hidden');
      }

      function closeModal() {
        document.getElementById('nilaiModal').classList.add('hidden');
      }
    </script>
  </main>

</body>

</html>