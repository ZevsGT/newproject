<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/data/head.php';
$db->deleteInterview($_POST[id]);
?>
