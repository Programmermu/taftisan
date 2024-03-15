<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Settings</title>
</head>

<body>

  <form action="test.php" method="post">
    <label for="name">Nama:</label>
    <input type="text" id="name" name="name" required>
    <br>

    <label for="room">Kamar:</label>
    <input type="text" id="room" name="room" required>
    <br>

    <label for="start_bait">Mulai dari Bait:</label>
    <input type="number" id="start_bait" name="start_bait" required>
    <br>

    <label for="end_bait">Sampai Bait:</label>
    <input type="number" id="end_bait" name="end_bait" required>
    <br>

    <label for="timer">Gunakan Timer:</label>
    <input type="checkbox" id="timer" name="timer" value="1">
    <br>

    <label>Waktu Timer:</label>
    <br>
    <input type="radio" id="time_5" name="time" value="50" required>
    <label for="time_5">5 Detik</label>

    <input type="radio" id="time_10" name="time" value="100">
    <label for="time_10">10 Detik</label>

    <input type="radio" id="time_15" name="time" value="150">
    <label for="time_15">15 Detik</label>
    <br>

    <input type="submit" value="Simpan Pengaturan">
  </form>

</body>

</html>