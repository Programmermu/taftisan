<?php
// Mulai sesi PHP
session_start();
if (isset($_SESSION['settings'])) {
  $name = $_SESSION['settings']['name'];
  $room = $_SESSION['settings']['room'];
  $tipe = $_SESSION['settings']['tipe'];
  $start_bait = $_SESSION['settings']['start_bait'];
  $end_bait = $_SESSION['settings']['end_bait'];
  if (isset($_SESSION['settings']['timer'])) {
    $timer = $_SESSION['settings']['timer'];
    $time = $_SESSION['settings']['time'];
  } else {
    $time = 5;
    $timer = 0;
  }
  if (isset($_SESSION['settings']['mode'])) {
    $mode = $_SESSION['settings']['mode'];
  } else {
    $mode = "satar_awal";
  }
} else {
  $name = '';
  $room = '';
  $start_bait = 100;
  $end_bait = 500;
  $timer = 0;
  $time = 5;
  $mode = "satar_awal";
  $tipe = "umum";
}



$siswa = array(
  "M.SYAHIR AKMAL MUWAFAQ",
  "MOHAMMAD TAQWIM", "AKHMAD ARYA ARDANI", "SAIFAN NAJIH AHMAD", "ACHMAD ZAINUN NURI", "M. JAUHARUL MA'ARIF", "MUHAMMAD FAIZ AL KHUNAINI", "THORIQ ZIYADUFFAQIH", "MOH. FAJRUL FALAH",
  "MUHAMMAD FAHMI ALHIKAM", "MUKHAMMAD WAHYU ALFIN"
)
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/favicon.png" type="image/x-icon">
  <title>Setting Lalaran</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }

    form {
      background-color: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 400px;
      text-align: center;
    }

    label {
      display: inline-block;
      margin-bottom: 8px;
    }

    input[type="text"],
    input[type="number"],
    select {
      width: 100%;
      padding: 8px;
      margin-bottom: 16px;
      box-sizing: border-box;
    }

    input[type="checkbox"],
    input[type="radio"] {
      margin-right: 8px;
    }

    input[type="submit"],
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
    }

    a {
      text-decoration: none;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }
  </style>
</head>

<body>
  <div id="isi">
    <h1>Mode Lalaran</h1>
    <form action="modelalaran.php" method="post">
      <label for="tipe">Tipe :</label>
      <select name="tipe" id="tipe">
        <option value="2TSG" <?php if ($tipe == "2TSG") echo "selected"; ?>>2 TS G</option>
        <option value="umum" <?php if ($tipe == "umum") echo "selected"; ?>>UMUM</option>
      </select>
      <br>
      <div id="2TSG" <?php if ($tipe == "umum") echo 'style="display:none;'; ?>>
        <label for="2tsginput">Nama :</label>
        <select name="2tsginput" id="2tsginput">
          <?php foreach ($siswa as $anak) : ?>
            <option value="<?= $anak; ?>" <?php if ($name == $anak) echo "selected"; ?>><?= $anak; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div id="umum" <?php if ($tipe == "2TSG") echo 'style="display:none;'; ?>>
        <label for="umumInput">Nama :</label>
        <input type="text" id="umumInput" name="umumInput" value="<?php if ($tipe == "umum") echo $name; ?>">
      </div>



      <label for="room">Kamar:</label>
      <input type="text" id="room" name="room" value="<?= $room ?>">

      <label for="start_bait">Mulai dari Bait:</label>
      <input type="number" id="start_bait" name="start_bait" value="<?= $start_bait ?>" min="1">

      <label for="end_bait">Sampai Bait:</label>
      <input type="number" id="end_bait" name="end_bait" value="<?= $end_bait ?>" max="500" required>

      <label for="mode">Tipe :</label>
      <select name="mode" id="mode">
        <option value="satar_awal" <?php if ($mode == "satar_awal") echo "selected"; ?>>Satar Awwal</option>
        <option value="full_bait" <?php if ($mode == "full_bait") echo "selected"; ?>>Full Bait</option>
        <option value="satar_tsani" <?php if ($mode == "satar_tsani") echo "selected"; ?>>Satar Tsani</option>
      </select>
      <label for="timer">Gunakan Timer:</label>
      <input type="checkbox" id="timer" name="timer" value="1" <?php if ($timer == 1) echo "checked"; ?>>

      <label>Waktu Timer:</label>
      <br>
      <input type="radio" id="time_5" name="time" value="5" <?php if ($time == 5) echo "checked"; ?> required>
      <label for="time_5">5 Detik</label>

      <input type="radio" id="time_10" name="time" value="10" <?php if ($time == 10) echo "checked"; ?>>
      <label for="time_10">10 Detik</label>

      <input type="radio" id="time_15" name="time" value="15" <?php if ($time == 15) echo "checked"; ?>>
      <label for="time_15">15 Detik</label>


      <input type="submit" value="Mulai Lalaran">
      <a href="index.php" id="menu">Kembali Ke Menu</a>
    </form>
  </div>
</body>

<script>
  document.getElementById('tipe').addEventListener('change', function() {
    var selectedValue = this.value;

    // Menampilkan atau menyembunyikan elemen-elemen sesuai dengan nilai yang dipilih
    if (selectedValue === 'umum') {
      document.getElementById('umum').style.display = 'block';
      document.getElementById('umumInput').setAttribute('required', true);
      document.getElementById('2TSG').style.display = 'none';
      document.getElementById('2tsginput').removeAttribute('required');
    } else if (selectedValue === '2TSG') {
      document.getElementById('umum').style.display = 'none';
      document.getElementById('umumInput').removeAttribute('required');
      document.getElementById('2TSG').style.display = 'block';
      document.getElementById('2tsginput').setAttribute('required', true)
    }
  });
</script>

</html>