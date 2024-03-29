<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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
    }

    a {
      text-decoration: none;
    }

    h1>span {
      font-style: italic;
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
  <a href="riwayat.php" id="riwayat">Riwayat Lengkap</a>
  <a href="tentang.php" id="tentang">Tentang</a>
  <a href="logout.php" id="logout">Logout</a>
</body>

</html>