<?php
include("koneksi.php");
// Mulai sesi PHP
session_start();

if (!isset($_SESSION['settings'])) {
  $_SESSION['settings'] = $_POST;
  $_SESSION['score'] = 0;
  $_SESSION['wrong_answers'] = 0;
  $_SESSION['settings']['start_bait'] = $_POST['start_bait'];
  $_SESSION['settings']['end_bait'] = $_POST['end_bait'];
  $_SESSION['settings']['mode'] = $_POST['mode'];
  $_SESSION['settings']['tipe'] = $_POST['tipe'];
  if ($_POST['tipe'] === 'umum') {
    $_SESSION['settings']['name'] = strtoupper($_POST['umumInput']);
  } elseif ($_POST['tipe'] === '2TSG') {
    $_SESSION['settings']['name'] = strtoupper($_POST['2tsginput']);
  }
  $_SESSION['settings']['room'] = strtoupper($_POST['room']);
  if (isset($_POST['timer'])) {
    $_SESSION['settings']['timer'] = $_POST['timer'];
  }
  if (isset($_POST['time'])) {
    $_SESSION['settings']['time'] = $_POST['time'];
  }
} else {
  if (isset($_POST['answer'])) {
    if ($_POST['answer'] == $_SESSION['settings']['correctAnswer']) {
      $_SESSION['score'] += 10;
    } else {
      $_SESSION['score'] -= 5;
      $_SESSION['wrong_answers'] += 1;
    }

    if ($_SESSION['wrong_answers'] >= 5) {
      header("Location: hasil.php");
      exit(); // Pastikan untuk keluar setelah melakukan redirect
    }
  } else {
    if (isset($_POST['tipe'])) {
      $_SESSION['settings'] = $_POST;
      $_SESSION['score'] = 0;
      $_SESSION['wrong_answers'] = 0;
      $_SESSION['settings']['start_bait'] = $_POST['start_bait'];
      $_SESSION['settings']['end_bait'] = $_POST['end_bait'];
      $_SESSION['settings']['tipe'] = $_POST['tipe'];
      if ($_POST['tipe'] === 'umum') {
        $_SESSION['settings']['name'] = strtoupper($_POST['umumInput']);
      } elseif ($_POST['tipe'] === '2TSG') {
        $_SESSION['settings']['name'] = strtoupper($_POST['2tsginput']);
      }
      $_SESSION['settings']['room'] = strtoupper($_POST['room']);
      if (isset($_POST['timer'])) {
        $_SESSION['settings']['timer'] = $_POST['timer'];
      } else {
        if (isset($_SESSION['settings']['timer'])) {
          unset($_SESSION['settings']['timer']);
        }
      }
    } else {
      $_SESSION['score'] -= 5;
      $_SESSION['wrong_answers'] += 1;
      if ($_SESSION['wrong_answers'] >= 5) {
        header("Location: hasil.php");
        exit(); // Pastikan untuk keluar setelah melakukan redirect
      }
    }
  }
}

/// Mendapatkan 4 pertanyaan acak
$randomQuestions = [];
$answers = [];

// Mendapatkan 4 pertanyaan acak
for ($i = 0; $i < 4; $i++) {
  $randomQuestions[] = rand($_SESSION['settings']['start_bait'], $_SESSION['settings']['end_bait']);
}

// Mendapatkan correct answer
$correctQuestion = $randomQuestions[0];
array_shift($randomQuestions);
$_SESSION['settings']['correctAnswer'] = $correctQuestion + 1;

// setting satar untuk jawaban
if ($_SESSION['settings']['mode'] == "satar_awal") {
  $satar = 'satar_awal';
} elseif ($_SESSION['settings']['mode'] == "satar_tsani") {
  $satar = 'satar_awal';
} else {
  $satar = 'satar_awal, satar_tsani';
}

// index soal acak
$sql = "SELECT " . $satar . " FROM bait WHERE no_bait IN (" . implode(",", $randomQuestions) . ")";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    if ($_SESSION['settings']['mode'] == "satar_awal") {
      $answers[] = $row['satar_awal'];
    } elseif ($_SESSION['settings']['mode'] == "satar_tsani") {
      $answers[] = $row['satar_awal'];
    } else {
      $answers[] = "#" . $row['satar_awal'] . "<br>" . $row['satar_tsani'];
    }
  }
}

// Mendapatkan correct answer dari database
$sqlcorrectanswers = "SELECT " . $satar . " FROM bait WHERE no_bait = {$_SESSION['settings']['correctAnswer']}";
$resultcorrect = mysqli_query($conn, $sqlcorrectanswers);

if ($resultcorrect && mysqli_num_rows($resultcorrect) > 0) {
  while ($row = mysqli_fetch_assoc($resultcorrect)) {
    if ($_SESSION['settings']['mode'] == "satar_awal") {
      $_SESSION['settings']['correctAnswer'] = $row['satar_awal'];
    } elseif ($_SESSION['settings']['mode'] == "satar_tsani") {
      $_SESSION['settings']['correctAnswer'] = $row['satar_awal'];
    } else {
      $_SESSION['settings']['correctAnswer'] = "#" . $row['satar_awal'] . "<br>" . $row['satar_tsani'];
    }
    $answers[] = $_SESSION['settings']['correctAnswer'];
  }
}

// setting satar untuk soal
if ($_SESSION['settings']['mode'] == "satar_awal") {
  $satar = 'satar_awal';
} elseif ($_SESSION['settings']['mode'] == "satar_tsani") {
  $satar = 'satar_tsani';
} else {
  $satar = 'satar_awal, satar_tsani';
}
// Mendapatkan bait soal dari database
$sqlsoal = "SELECT " . $satar . " FROM bait WHERE no_bait = {$correctQuestion}";
$resultsoal = mysqli_query($conn, $sqlsoal);

if ($resultsoal && mysqli_num_rows($resultsoal) > 0) {
  while ($row = mysqli_fetch_assoc($resultsoal)) {
    if ($_SESSION['settings']['mode'] == "satar_awal") {
      $_SESSION['settings']['soal'] = $row['satar_awal'];
    } elseif ($_SESSION['settings']['mode'] == "satar_tsani") {
      $_SESSION['settings']['soal'] = $row['satar_tsani'];
    } else {
      $_SESSION['settings']['soal'] = "#" . $row['satar_awal'] . "<br>" . $row['satar_tsani'];
    }
  }
}



// Shuffle jawaban
shuffle($answers);

// Tutup koneksi
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="/favicon.png" type="image/x-icon">
  <title>Quiz Alfiyyah Alfalah Ploso</title>
</head>

<style>
  body {
    font-family: Arial, sans-serif;
    margin: 20px;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  #quizForm {
    margin-top: 20px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    width: 300px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  #quizForm p {
    margin: 10px 0;
  }

  #quizForm label {
    display: inline-block;
    margin-bottom: 8px;
    margin-left: auto;
    width: 250px;
    height: 100%;
  }

  #quizForm input[type="radio"] {
    margin-right: 5px
  }

  #quizForm input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  #quizForm input[type="submit"]:hover {
    background-color: #45a049;
  }

  #results p {
    width: 300px;
    margin: 0px;
  }

  #logout,
  #backToStart,
  #cek {
    margin-top: 10px;
    text-decoration: none;
    padding: 8px 8px;
    background-color: #ccc;
    color: black;
    border-radius: 4px;
    margin-right: 10px;
  }

  .navigation {
    display: inline-block;
    margin-top: 20px;
  }

  #timer {
    font-size: 20px;
    font-weight: bold;
    color: #4CAF50;
  }

  div[name='answerContainer'] {
    background-color: rgb(174, 214, 241);
    border-radius: 5px;
    margin: 2px;
    padding: 10px 2px 0px 0px;
  }

  input[type="radio"]:checked+label {
    font-weight: bold;
  }
</style>
</head>

<body>
  <form id="quizForm" action="test.php" method="post">
    <?php if (isset($_SESSION['settings'])) : ?>
      <p>Pertanyaan: Yang manakah bait setelah bait ini?</p>
      <p> <?php if ($_SESSION['settings']['mode'] == 'satar_awal') echo '... ' ?>
        <?php echo $_SESSION['settings']['soal']; ?>
        <?php if ($_SESSION['settings']['mode'] == 'satar_tsani') echo '... ' ?>
      </p>

      <?php foreach ($answers as $answer) : ?>
        <div name="answerContainer">
          <input type="radio" name="answer" id="<?php echo $answer; ?>" value="<?php echo $answer; ?>" required>
          <label for="<?php echo $answer; ?>">
            ...
            <?php echo $answer; ?>
          </label>
        </div>
      <?php endforeach; ?>
      <input id="kirim" type="submit" value="Kirim Jawaban" hidden>
      <button type="button" id="cek" onclick="tampilkanHasil()">Cek Jawaban</button>
    <?php else : ?>
      <p>Quiz telah selesai atau tidak ada pengaturan yang diatur.</p>
    <?php endif; ?>
  </form>

  <div id="results">
    <p>Skor: <span id="score"><?php echo $_SESSION['score']; ?></span></p>
    <p>Jawaban Salah: <span id="jawabansalah"><?php echo $_SESSION['wrong_answers']; ?></span></p>
    <p <?php if (!isset($_SESSION['settings']['timer'])) echo "hidden"; ?>>Waktu Tersisa:
      <strong id="timer">
        <?php echo $_SESSION['settings']['time'] . " Detik" ?>
      </strong>
    </p>
    <!-- <button onclick="togglemode()">Mode</button> -->
  </div>
  <div class="navigation">
    <a href="logout.php" id="logout">Logout</a>
    <a href="index.php" id="backToStart">Kembali ke Awal</a>
  </div>

  <script>
    let time = <?php echo $_SESSION['settings']['time'] ?>;
    let waktu = <?php if (isset($_SESSION['settings']['timer'])) echo 1;
                else echo 0; ?>;

    let jawabanYangBenar = "<?php echo $_SESSION['settings']['correctAnswer']; ?>"
    var radioButtons = document.getElementsByName('answer');
    var answerContainer = document.getElementsByName('answerContainer');

    var answer = <?php echo json_encode($answers) ?>;
    var full = true;

    // Mendefinisikan variabel untuk menyimpan nilai jawaban yang dipilih
    var jawabanYangDipilih = "";

    // function togglemode() {
    //   if (full) {
    //     radioButtons.forEach((button, index) => {
    //       button.nextElementSibling.innerHTML = `... ${answer[index]}`;
    //     });
    //   } else {
    //     radioButtons.forEach((button, index) => {
    //       button.nextElementSibling.innerHTML = `... ${answer[index].split(' ').slice(0,3).join(' ')}`;
    //     });
    //   }
    //   full = !full;
    // }

    function timer() {
      if (waktu == 1) {
        if (time > 0) {
          time--;
          document.getElementById('timer').innerHTML = time + " Detik";
        } else {
          document.getElementById('timer').innerHTML = "Waktu Habis";
          tampilkanHasil();
        }
      }
    }

    function tampilkanHasil() {
      document.getElementById('cek').hidden = true;
      document.getElementById('kirim').hidden = false;
      // Mendapatkan semua elemen radio button dengan nama 'answer'
      for (var i = 0; i < radioButtons.length; i++) {
        if (radioButtons[i].checked) {
          // Menyimpan nilai jawaban yang dipilih
          jawabanYangDipilih = radioButtons[i].value;
          if (radioButtons[i].value !== jawabanYangBenar) {
            answerContainer[i].style.backgroundColor = "rgb(241, 148, 138)";
          } else {
            answerContainer[i].style.backgroundColor = 'aquamarine';
          }
        } else {
          radioButtons[i].setAttribute('disabled', true);
          if (radioButtons[i].value == jawabanYangBenar) {
            answerContainer[i].style.backgroundColor = 'aquamarine';
          }
        }
      }

      // Membandingkan jawaban yang dipilih dengan jawaban yang benar
      if (jawabanYangDipilih !== jawabanYangBenar) {
        document.getElementById('score').innerHTML = <?php echo $_SESSION['score'] ?> - 5;
        document.getElementById('jawabansalah').innerHTML = <?php echo $_SESSION['wrong_answers'] ?> + 1;
      } else {
        document.getElementById('score').innerHTML = <?php echo $_SESSION['score'] ?> + 10;
      }

    }

    // Panggil fungsi timer setiap 1 detik
    setInterval(timer, 1000);
  </script>
</body>