<?php
include("koneksi.php");

// Query untuk mengambil data dari tabel
$sql = "SELECT * from bait where nama_nadhom ='ALFIYYAH' order by  no_bait asc";
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
    text-align: right;
    width: 88%;
    transition: opacity 2s ease-in-out;
  }

  .genap {
    border-bottom-style: ridge;

  }

  .satar_tsani,
  .satar_awal {
    transition: opacity 0.5s ease-in-out;
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

  #footer {
    position: sticky;
    bottom: 0;
    padding: 10px;
    display: flex;
    justify-content: center;
    z-index: 100;
    width: 100%;
    background-color: azure;
  }

  button {
    padding: 3px;
    background-color: aquamarine;
    border-radius: 5px;
  }

  #toggle {
    padding: 10px;
  }

  #backheader {
    width: auto;
  }
</style>

<body>
  <div id="header">
    <label>Loncat :
    </label>
    <input type="number" name="nobait" id="nobait" max="500">
    <button onclick="focusElement()" id="loncat">Loncat</button>
    <a href="index.php" id="backheader">Kembali ke Awal</a>
  </div>
  <div class="data">
    <?php foreach ($data as $bait) { ?>
      <p>
      <div class="satar <?php if ($bait['no_bait'] % 2 == 0) {
                          echo "genap";
                        } ?>">
        <span class="satar_awal">
          <?= $bait['satar_awal']; ?>
        </span>
        <span class="satar_tsani">
          # <?= $bait['satar_tsani']; ?>
        </span>
      </div>
      <span id="<?= $bait['no_bait']; ?>" tabindex="0"> :
        <?= $bait['no_bait']; ?>
      </span>
      <?php if ($bait['no_bait'] % 100 == 0) { ?>
        <a href="index.php" id="backToStart">Kembali ke Awal</a>
      <?php } ?>
      </p>
    <?php } ?>
  </div>
  <div id="footer">
    <button onclick="toggleMode()" id="toggle">Ubah Mode</button>
  </div>

</body>
<script>
  let bait = <?php echo json_encode($data) ?>;
  let mode = true;
  let satar_awal = document.getElementsByClassName("satar_awal");
  let satar_tsani = document.getElementsByClassName("satar_tsani");

  function toggleMode() {
    for (let i = 0; i < satar_awal.length; i++) {
      if (mode) {
        satar_awal[i].textContent = "..." + bait[i].satar_awal.split(' ').slice(0, 3).join(' ');
        satar_tsani[i].hidden = true;
      } else {
        satar_awal[i].textContent = bait[i].satar_awal;
        satar_tsani[i].style.opacity = 0;
        satar_tsani[i].hidden = false;
        setTimeout(function() {
          satar_tsani[i].style.opacity = 1;
        }, 200);
      }
    }
    mode = !mode;
  }

  function focusElement() {
    var nomor = document.getElementById("nobait");
    if (nomor.value > 0) {
      var inputElement = document.getElementById(nomor.value);
      inputElement.focus();
    } else {
      alert("masukkan angka terlebih dahulu")
    }
  }
  document.getElementById('nobait').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
      focusElement();
    }
  });
</script>

</html>