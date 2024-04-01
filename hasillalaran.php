<?php
session_start();
$score = $_SESSION['score'];
// Hapus semua data session


include("koneksi.php");
// Persiapkan statement SQL dengan parameter
$sql = "INSERT INTO hasil (nama, kamar, start_bait, end_bait, timer, time, score) VALUES (?, ?, ?, ?, ?, ?, ?)";

// Persiapkan statement
$stmt = mysqli_prepare($conn, $sql);

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



// Periksa apakah statement berhasil dibuat
if ($stmt) {
  // Bind parameter ke statement
  mysqli_stmt_bind_param(
    $stmt,
    "ssiiiii",
    $_SESSION['settings']['name'],
    $_SESSION['settings']['room'],
    $_SESSION['settings']['start_bait'],
    $_SESSION['settings']['baitsoal'],
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

    .salahjawabContainer>div {
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100%;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Nilai Akhir</h1>
    <div class="info">
      <p>Nama: <?= $_SESSION['settings']['name']; ?></p>
      <p>Kelas: <?= $_SESSION['settings']['room']; ?></p>
      <p>Bait: <?= $_SESSION['settings']['start_bait']; ?> - <?= $_SESSION['settings']['baitsoal']; ?></p>
      <p> Timer : <?= $timer ?></p>
      <p <?php if ($timer == "Tidak Aktif") echo "hidden" ?>> Waktu: <?= $time ?></p>
    </div>
    <p class="score">Nilai Akhir Kamu Adalah : <?= $score ?></p>
    <p style="text-align:center">Kamu Salah Di Bait</p>
    <?php
    if (count($_SESSION['settings']['salahjawab']) > 0) {
      foreach ($_SESSION['settings']['salahjawab'] as $salahjawab) { ?>
        <div class="salahjawabContainer">
          <div>...<?= $salahjawab[0]; ?></div>
          <div>...<?= $salahjawab[1]; ?></div>
          <hr>
        </div>
      <?php };
    } else { ?>
      <div>Full Mening...</div>
    <?php } ?>
    <div class="link-container">
      <a href="settinglalaran.php">Kembali ke Setting Lalaran</a>
      <a href="index.php">Kembali ke Menu Awal</a>
      <a href="riwayat.php">Hasil Nilai Lengkap</a>
    </div>
  </div>
</body>

</html>