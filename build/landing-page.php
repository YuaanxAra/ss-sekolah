<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Nilai Siswa - SMKN 2 Magelang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
        body {
            background: linear-gradient(135deg, #3f87a6, #ebf8e1);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            max-width: 600px;
            width: 90%;
            text-align: center;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 15px;
            color: #2c3e50;
        }
        h2 {
            font-size: 18px;
            font-weight: normal;
            color: #555;
            margin-bottom: 30px;
        }
        p {
            font-size: 16px;
            color: #333;
            margin-bottom: 30px;
        }
        .btn {
            padding: 12px 25px;
            background-color: #3f87a6;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background-color: #316c86;
        }

        @media (max-width: 600px) {
            h1 { font-size: 22px; }
            p { font-size: 14px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang di Aplikasi Nilai Siswa</h1>
        <h2>SMKN 2 Magelang</h2>
        <p>
            Aplikasi ini dirancang untuk membantu kegiatan akademik SMKN 2 Magelang. 
            Setiap siswa akan mendapatkan akses informasi nilai untuk satu semester tahun ajaran berjalan. 
            Anda akan direkomendasikan <strong>kompeten</strong> apabila memenuhi semua unit kompetensi yang ada.
        </p>
        <a href="build/login.php" class="btn">Masuk ke Sistem</a>
    </div>
</body>
</html>

