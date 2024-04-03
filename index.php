<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="google-site-verification" content="JJ_Bqeyo1XzBRIPKHSxA3Q9aW_bpqK5M3k848xmmY8Q" />
  <meta name="description" content="Website untuk hafalan alfiyah dengan fitur menarik, santri sangat di undang untuk mencoba">
  <link rel="icon" href="/favicon.png" type="image/x-icon">
  <title>Taftisan Nawasena AlFalah Ploso</title>
  <style>
    body {
      width: 80%;
      margin-left: auto;
      margin-right: auto;
      align-items: center;
    }

    a {
      background-color: #4caf50;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      margin: 5px auto;
      display: block;
      text-align: center;
      text-decoration: none;
    }


    h1>span {
      font-style: italic;
    }

    #logout {
      background-color: #e6473c;
    }

    p,
    ul,
    li {
      font-style: italic;
      font-size: 12px;
    }
  </style>
</head>

<body>
  <?php if (isset($_SESSION['settings']['name'])) { ?>
    <h1>Selamat Berjuang <span><?php echo $_SESSION['settings']['name'] ?></span></h1>
  <?php } ?>
  <h1>Silahkan Pilih Salah Satu Menu</h1>
  <a href="baitalfiyah.php" id="baitlengkap">Bait Alfiyah Lengkap</a>
  <a href="settingquiz.php" id="quiz">Mode Quiz</a>
  <a href="settinglalaran.php" id="lalaran">Mode Lalaran</a>
  <a href="mumarrin.php" id="mumarrin">Mode Mumarrin</a>
  <a href="tentang.php" id="tentang">Tentang</a>
  <a href="saran.php" id="saran">Saran/Kritik</a>
  <?php if (isset($_SESSION['settings']['name'])) { ?>
    <a href="riwayat.php" id="riwayat">Riwayat Lengkap</a>
    <a href="logout.php" id="logout">Logout</a>
  <?php } ?>
  <p>Version : 1.0.1 Last Updated 01/04/2024</p>
  <p>Logs (fixed) : </p>
  <ul>
    <li>nama pada tipe umum tidak tersimpan</li>
    <li>penambahan fitur kritik dan saran</li>
    <li>penambahan default bait dan tipe</li>
    <li>Lainnya</li>
  </ul>
</body>

</html>