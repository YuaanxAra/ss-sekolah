<?php
session_start();
?>
<!--

=========================================================
* Argon Dashboard 2 Tailwind - v1.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-tailwind
* Copyright 2022 Creative Tim (https://www.creative-tim.com)

* Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="./assets/img/favicon.png" />
    <title>Daftar Foto</title>
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

<body
    class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-200 leading-default bg-gray-50 text-slate-500">
    <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>
    <!-- sidenav  -->
    <aside
        class="bg-white text-slate-800 fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 -translate-x-full border-0 shadow-xl dark:shadow-none dark:bg-white max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0"
        aria-expanded="false">
        <div class="h-19">
            <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-slate-800 text-slate-400 xl:hidden"
                sidenav-close></i>
            <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-slate-900 text-slate-700"
                href="https://demos.creative-tim.com/argon-dashboard-tailwind/pages/dashboard.html" target="_blank">
                <img src="./assets/img/logo-ct-dark.png"
                    class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8"
                    alt="main_logo" />
                <img src="./assets/img/logo-ct.png"
                    class="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-8"
                    alt="main_logo" />
                <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Dashboard Siswa</span>
            </a>
        </div>

        <hr
            class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />

        <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
            <ul class="flex flex-col pl-0 mb-0">
                <li class="mt-0.5 w-full">
                    <a class="py-2.7 hover:bg-blue-100 dark:text-slate-600 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="index.php">
                        <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                            <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-tv-2"></i>
                        </div>
                        <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Dashboard</span>
                    </a>
                </li>
                <li class="mt-0.5 w-full">
                    <a class="py-2.7 hover:bg-blue-100 dark:text-slate-600 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-all duration-200" href="nilai/nilai.php">
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
                        href="../logout.php">
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

    <!-- end sidenav -->

    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
        <?php
        include_once '../config.php';

        // Ambil semua data galeri
        $query = "SELECT * FROM galeri ORDER BY id_galeri DESC";
        $result = $conn->query($query);

        // Pisahkan data berdasarkan jenis
        $fotoProfil = [];
        $fotoKegiatan = [];

        while ($row = $result->fetch_assoc()) {
            if ($row['tipe'] === 'profil') {
                $fotoProfil[] = $row;
            } else {
                $fotoKegiatan[] = $row;
            }
        }
        ?>

        <!-- Di dalam <main> halaman siswa -->
        <div class="p-6">
            <!-- FOTO PROFIL -->
            <h2 class="text-xl font-bold text-slate-700 mb-4">Foto Profil Guru</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($fotoProfil as $foto): ?>
                    <div class="bg-white/80 backdrop-blur-md border border-slate-200 hover:shadow-xl transition-shadow duration-300 p-4 rounded-2xl shadow-md hover:scale-[1.02] transform">
                        <img src="../uploads/<?= $foto['nama_file'] ?>" alt="<?= $foto['judul'] ?>" class="w-full aspect-square object-cover rounded-xl shadow-sm mb-3" />
                        <h3 class="text-base font-semibold text-slate-800"><?= $foto['judul'] ?></h3>
                        <p class="text-sm text-slate-600"><?= $foto['deskripsi'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- FOTO KEGIATAN -->
            <h2 class="text-xl font-bold text-slate-700 mt-10 mb-4">Foto Kegiatan</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($fotoKegiatan as $foto): ?>
                    <div class="bg-white/80 backdrop-blur-md border border-slate-200 hover:shadow-xl transition-shadow duration-300 p-4 rounded-2xl shadow-md hover:scale-[1.02] transform">
                        <img src="../uploads/<?= $foto['nama_file'] ?>" alt="<?= $foto['judul'] ?>" class="w-full aspect-square object-cover rounded-xl shadow-sm mb-3" />
                        <h3 class="text-base font-semibold text-slate-800"><?= $foto['judul'] ?></h3>
                        <p class="text-sm text-slate-600"><?= $foto['deskripsi'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>
<!-- plugin for charts  -->
<script src="./assets/js/plugins/chartjs.min.js" async></script>
<!-- plugin for scrollbar  -->
<script src="./assets/js/plugins/perfect-scrollbar.min.js" async></script>
<!-- main script file  -->
<script src="./assets/js/argon-dashboard-tailwind.js?v=1.0.1" async></script>

</html>