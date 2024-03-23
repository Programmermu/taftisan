<?php
include("koneksi.php");

// Query untuk mengambil data dari tabel
$sql = "SELECT * from bait";
$result = mysqli_query($conn, $sql);

// Periksa apakah query berhasil dieksekusi
if (mysqli_num_rows($result) > 0) {
  // Output data dari setiap baris
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
  }
} else {
  echo "0 hasil";
}

// Tutup koneksi
mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BAIT ALFIYAH LENGKAP</title>
</head>
<style>
  .satar {
    display: inline-block;
    margin: 0;
    border-bottom: 2px dashed gainsboro;
    text-align: center;
    width: 85%;
  }

  a {
    display: inline-block;
    width: 90%;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    padding: 5px;
    border: 2px dashed yellowgreen;
    background-color: honeydew;
    margin-left: auto;
    margin-right: auto;
  }

  #header {
    position: sticky;
    top: 0;
    padding: 10px;
    background-color: aliceblue;
  }

  #backheader {
    width: auto;
  }
</style>

<body>
  <div id="header">
    <label>Loncat :
    </label>
    <input type="number" name="nobait" id="nobait">
    <button onclick="focusElement()">Loncat</button>
    <a href="index.php" id="backheader">Kembali ke Awal</a>
  </div>
  <div class="data">
    <?php foreach ($data as $bait) { ?>
      <p>
      <div class="satar">
        <span class="satar_awal">
          <?= $bait['satar_awal']; ?>
        </span> #
        <span class="satar_tsani">
          <?= $bait['satar_tsani']; ?>
        </span>
      </div>
      <span id="<?= $bait['no_bait']; ?>" tabindex="0"> :
        <?= $bait['no_bait']; ?>
      </span>
      </p>
      <?php if ($bait['no_bait'] % 100 == 0) { ?>
        <a href="index.php" id="backToStart">Kembali ke Awal</a>
      <?php } ?>
    <?php } ?>
  </div>

</body>
<script>
  let bait = <?php echo json_encode($data) ?>;
  let mode = true;
  let satar_awal = document.getElementsByClassName("satar_awal");
  let satar_tsani = document.getElementsByClassName("satar_tsani");

  function toggleMode() {
    mode = !mode;
  }

  function focusElement() {
    var nomor = document.getElementById("nobait");
    var inputElement = document.getElementById(nomor.value);
    inputElement.focus();
  }
</script>

</html>