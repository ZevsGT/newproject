<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/data/db.php';

unset($_SESSION['logged_user']);
header('location: /admin.php');
?>
