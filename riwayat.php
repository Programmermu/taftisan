<?php
include("koneksi.php");
session_start();
// Query untuk mengambil data dari tabel
$sql = "SELECT * FROM hasil where nama ='" . $_SESSION['settings']['name'] . "' ORDER BY score DESC LIMIT 10";

// Eksekusi query
$result = mysqli_query($conn, $sql);

// Periksa apakah query berhasil dieksekusi
if ($result && mysqli_num_rows($result) > 0) {
  // Output data dari setiap baris
  while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
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
  <title>Hasil Test Keseluruhan</title>
  <style>
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

    .link-container {
      display: flex;
      justify-content: space-between;
      max-width: 300px;
      margin: 0 auto;
      margin-top: 20px;
    }

    .link-container a {
      text-decoration: none;
      padding: 10px 20px;
      border: 2px solid #a6c5e0;
      border-radius: 5px;
      color: #a6c5e0;
      transition: all 0.3s ease;
    }

    .link-container a:hover {
      background-color: #a6c5e0;
      color: #fff;
    }
  </style>
</head>

<body>
  <h2>Hasil Quiz</h2>
  <table <?php if (!isset($data)) {
            echo "hidden";
          } ?>>
    <thead>
      <tr>
        <th>Nama</th>
        <th>Kamar</th>
        <th>Mulai Bait</th>
        <th>Sampai Bait</th>
        <th>Timer</th>
        <th>Waktu</th>
        <th>Skor</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      <?php if (isset($data)) {
        foreach ($data as $row) : ?>
          <tr>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['kamar']; ?></td>
            <td><?php echo $row['start_bait']; ?></td>
            <td><?php echo $row['end_bait']; ?></td>
            <td> <?php if ($row['timer'] == 0) {
                    echo "Non ";
                  } ?>Aktif</td>
            <td><?php if ($row['timer'] == 1) {
                  echo $row['time'] . " Detik";
                } else {
                  echo "-";
                } ?></td>
            <td><?php echo $row['score']; ?></td>
            <td><?php echo $row['tanggal']; ?></td>
          </tr>
      <?php endforeach;
      } ?>
    </tbody>
  </table>
  <div class="link-container">
    <a href="index.php">Kembali ke Awal</a>
    <a href="logout.php">Logout</a>
  </div>
</body>

</html>