<?php
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Silakan login untuk melanjutkan.";
    header("Location: login.php");
    exit();
}
?>

