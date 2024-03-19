<?php
session_start();
include("koneksi.php");
if (isset($_POST['start_bait'])) {
  $_SESSION['settings']['start_bait'] = $_POST['start_bait'];
  $_SESSION['settings']['end_bait'] = $_POST['end_bait'];
} else {
  if (!isset($_SESSION['settings']['start_bait'])) {
    $_SESSION['settings']['start_bait'] = 100;
    $_SESSION['settings']['end_bait'] = 300;
  }
}

$randomQuestions = rand($_SESSION['settings']['start_bait'], $_SESSION['settings']['end_bait']);
$question = array($randomQuestions, $randomQuestions + 1, $randomQuestions + 2, $randomQuestions + 3, $randomQuestions + 4);
$sql = "SELECT * from bait where no_bait in (" . implode(",", $question) . ")";
$result = mysqli_query($conn, $sql);


if ($result && mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array($row['satar_awal'], $row['satar_tsani'], $row['no_bait']);
  }
} else {
  $gagal = "belum ada hasil";
}

// Tutup koneksi
mysqli_close($conn);

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mode Mumarrin</title>
  <style>
    p {
      display: inline-block;
      width: 100%;
      margin: 1px;
      text-align: center;
    }

    .no_bait {
      width: 20px;
    }

    p span {
      width: 40%;
      display: inline-block;
      max-width: 300PX;
      font-size: 12px;
    }

    body {
      align-items: center;
    }

    input[type="number"] {
      text-align: center;
      width: 40%;
      margin: 2px;
    }

    a {
      position: fixed;
      bottom: 20px;
      /* Jarak dari bawah */
      right: 20px;
      /* Jarak dari kanan */
      padding: 10px 20px;
      background-color: #007bff;
      /* Warna latar */
      color: #fff;
      /* Warna teks */
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    progress {
      width: 100%;
      height: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      overflow: hidden;
    }

    /* Gaya untuk value di dalam progress bar */
    progress::-webkit-progress-value {
      background-color: green;
      /* Warna value saat progress */
      border-radius: 5px;
    }

    /* Gaya untuk background di dalam progress bar */
    progress::-webkit-progress-bar {
      background-color: lightgray;
      border-radius: 5px;
    }

    form {
      display: flex;
      justify-content: space-around;
    }
  </style>
</head>

<body>
  <p>
    <a href="mumarrin.php">Refresh</a>
  </p>
  <form action="mumarrin.php" method="post">
    <input type="number" name="start_bait" id="start_bait" placeholder="Mulai Dari Bait" value="<?php if (isset($_SESSION['settings']['start_bait'])) echo $_SESSION['settings']['start_bait'] ?>">
    <input type="number" name="end_bait" id="end_bait" max="500" placeholder="Sampai Dari Bait" value="<?php if (isset($_SESSION['settings']['end_bait'])) echo $_SESSION['settings']['end_bait'] ?>">
    <button>Kirim</button>
  </form>

  <progress value="<?= $_SESSION['settings']['end_bait']; ?>" max="500"></progress>
  <?php foreach ($data as $bait) { ?>
    <p>
      <span>
        <?php echo $bait[1] ?>
      </span>
      #
      <span>
        <?php echo $bait[0] ?>
      </span> :
      <span class="no_bait">
        <?php echo $bait[2] ?>
      </span>
    </p>
  <?php } ?>

</body>

</html>