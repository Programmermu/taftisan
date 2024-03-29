<?php
session_start(); // Hapus semua data session

if (isset($_SESSION['settings']['timer'])) {
  if ($_SESSION['settings']['timer'] == 1) {
    $timer = "Aktif";
  } else {
    $timer = "Tidak Aktif";
  }
} else {
  $timer = "Tidak Aktif";
}

if ($timer == "Aktif") {
  $time = $_SESSION['settings']['time'] . " Detik";
} else {
  $time = "-";
}

include("koneksi.php");
// Persiapkan statement SQL dengan parameter
$sql = "INSERT INTO hasil (nama, kamar, start_bait, end_bait, timer, time, score) VALUES (?, ?, ?, ?, ?, ?, ?)";

// Persiapkan statement
$stmt = mysqli_prepare($conn, $sql);




// Periksa apakah statement berhasil dibuat
if ($stmt) {
  // Bind parameter ke statement
  mysqli_stmt_bind_param(
    $stmt,
    "ssiiiii",
    $_SESSION['settings']['name'],
    $_SESSION['settings']['room'],
    $_SESSION['settings']['start_bait'],
    $_SESSION['settings']['end_bait'],
    $timer,
    $time,
    $_SESSION['score']
  );

  // Jalankan statement
  mysqli_stmt_execute($stmt);

  // Periksa apakah data berhasil dimasukkan
  if (!mysqli_stmt_affected_rows($stmt) > 0) {
    echo "Gagal menyimpan data";
  }

  // Tutup statement
  mysqli_stmt_close($stmt);
} else {
  echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Nilai Akhir</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #fff;
      border-radius: 8px;
      padding: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
    }

    .info {
      margin-bottom: 20px;
    }

    .info p {
      margin: 5px 0;
    }

    .score {
      font-size: 24px;
      font-weight: bold;
      text-align: center;
      color: #4CAF50;
    }

    .link-container {
      text-align: center;
      margin-top: 20px;
    }

    .link-container a {
      text-decoration: none;
      color: #007bff;
      margin: 0 10px;
    }

    .link-container a:hover {
      text-decoration: underline;
    }

    a {
      border-radius: 5px;
      border: 2px solid black;
      box-shadow: 2px 2px 2px Aqua;
      padding: 5px;
      display: block;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Nilai Akhir</h1>
    <div class="info">
      <p>Nama: <?= $_SESSION['settings']['name']; ?></p>
      <p>Kelas: <?= $_SESSION['settings']['room']; ?></p>
      <p>Bait: <?= $_SESSION['settings']['start_bait']; ?> - <?= $_SESSION['settings']['end_bait']; ?></p>
      <p> Timer : <?= $timer ?></p>
      <p <?php if ($timer == "Tidak Aktif") echo "hidden" ?>> Waktu: <?= $time ?></p>
    </div>
    <p class="score">Nilai Akhir Kamu Adalah : <?= $score ?></p>
    <div class="link-container">
      <a href="index.php">Kembali ke Awal</a>
      <a href="logout.php">Logout</a>
      <a href="riwayat.php">Hasil Nilai Lengkap</a>
    </div>
  </div>
</body>

</html>