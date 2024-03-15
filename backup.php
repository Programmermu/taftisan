<?php
session_start();
if (isset($_SESSION['settings'])) {
  $name = $_SESSION['settings']['name'];
  $room = $_SESSION['settings']['room'];
  $start_bait = $_SESSION['settings']['start_bait'];
  $end_bait = $_SESSION['settings']['end_bait'];
  if (isset($_SESSION['settings']['timer'])) {
    $timer = $_SESSION['settings']['timer'];
  } else {
    $timer = 0;
  }
  $time = $_SESSION['settings']['time'];
} else {
  $name = '';
  $room = '';
  $start_bait = "";
  $end_bait = "";
  $timer = 0;
  $time = 0;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Settings</title>
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
    input[type="number"] {
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
      margin: 0 auto;
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

  <form action="test.php" method="post">
    <label for="name">Nama:</label>
    <input type="text" id="name" name="name" value="<?= $name ?>" required>

    <label for="room">Kamar:</label>
    <input type="text" id="room" name="room" value="<?= $room ?>" required>

    <label for="start_bait">Mulai dari Bait:</label>
    <input type="number" id="start_bait" name="start_bait" value="<?= $start_bait ?>" min="1">

    <label for="end_bait">Sampai Bait:</label>
    <input type="number" id="end_bait" name="end_bait" value="<?= $end_bait ?>" max="500" required>

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

    <input type="submit" value="Simpan Pengaturan">
    <a href="baitalfiyah.php" id="baitlengkap">Bait Alfiyah Lengkap</a>
  </form>
</body>

</html>