<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/data/head.php';


if(isset($_POST[further])){
	$addQ = new questions();
	$addQ->eFormHandler($_POST,'add', $_SESSION['Title_Test']['id']);
	header('location: /admin.php?mod=addtest');
	exit;
}elseif($_POST[close]) {
	$addQ = new questions();
	$addQ->eFormHandler($_POST,'add', $_SESSION['Title_Test']['id']);
	include $_SERVER['DOCUMENT_ROOT'].'/engine/skins/options.tpl';
}
?>


