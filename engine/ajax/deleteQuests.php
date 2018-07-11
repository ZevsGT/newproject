<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/class.php';

$del = new interview('testtitle', 'questions', 'answers' ,'users');
$del->deleteQustion($_POST[id]);
?>
