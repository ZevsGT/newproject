<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/head.php';
$db->deleteInterview($_POST[id]);
?>
