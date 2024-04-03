<?php
include("koneksi.php");
// cek kontak
if (isset($_POST['kontak'])) {
  $kontak = $_POST['kontak'];
} else {
  $kontak = "";
}
$comment = [];
// cek nama dan komentar
if (
  isset($_POST['nama']) &&
  isset($_POST['komentar'])
) {
  // mulai insert data
  $sql = "INSERT INTO komentar (nama, komentar, kontak) VALUES (?, ?, ?)";
  $stmt = mysqli_prepare($conn, $sql);
  if ($stmt) {
    mysqli_stmt_bind_param(
      $stmt,
      "sss",
      $_POST['nama'],
      $_POST['komentar'],
      $kontak
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
}

$sqlkomemtar = "SELECT * FROM komentar order by tanggal desc limit 50";
$hasilkomentar = mysqli_query($conn, $sqlkomemtar);

if ($hasilkomentar && mysqli_num_rows($hasilkomentar) > 0) {
  while ($row = mysqli_fetch_assoc($hasilkomentar)) {
    $comment[] = $row;
  }
}
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/favicon.png" type="image/x-icon">
  <title>Kritik dan saran</title>
  <style>
    form {
      width: 100%;
      margin: 10px;
      padding: 5px;
      border-radius: 5px;
      background-color: antiquewhite;
      display: flex;
      align-items: center;
      flex-direction: column;
    }

    form>div {
      display: flex;
      width: 90%;
      margin: 5px;
    }

    form>div>label {
      min-width: 100px;
    }

    form>div>input {
      width: 100%;
      border: 2px solid #ccc;
      border-radius: 4px;
      background-color: #f8f8f8;
      font-size: 16px;
    }

    form>div>input[type='textarea'] {
      width: 100%;
      height: 150px;
      padding: 12px 20px;
      resize: horizontal;
      word-wrap: normal;
    }

    a {
      background-color: #ffb459;
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

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }
  </style>
</head>

<body>
  <p>Silahkan tuliskan laporan (bug), kritik ataupun saran :</p>
  <form action="saran.php" method="post">
    <div>
      <label for="nama">Nama</label>:
      <input type="text" name="nama" id="nama" placeholder="nama" required>
    </div>
    <div>
      <label for="komentar">Komentar</label>:
      <input type="textarea" name="komentar" id="komentar" placeholder="komentar" required>
    </div>
    <div>
      <label for="kontak">Kontak</label>:
      <input type="text" name="kontak" id="kontak" placeholder="kontak (jika ingin di hubungi)">
    </div>
    <h6>*tidak wajib di isi</h6>
    <button>Kirim</button>
  </form>
  <a href="index.php" id="menu">Kembali ke menu utama</a>
  <table>
    <thead>
      <tr>
        <th>Nama</th>
        <th>Komentar</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <?php foreach ($comment as $komentar) : ?>
      <tbody>
        <tr>
          <td><?= $komentar['nama']; ?></td>
          <td><?= $komentar['komentar']; ?></td>
          <td><?= $komentar['tanggal']; ?></td>
        </tr>
      </tbody>
    <?php endforeach; ?>
  </table>



</body>

</html>