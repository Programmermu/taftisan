<?php
session_start();

// Hapus semua data session
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login atau halaman lainnya jika diperlukan
header("Location: index.php");
exit();
