<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/class.php';

$addQ = new interview('testtitle', 'questions', 'answers' ,'users');

if(isset($_POST[further])){
	$addQ->eFormHandler($_POST,'add', $_SESSION['Title_Test']['id']);
	header('location: /admin.php?mod=addtest');
	exit;
}elseif($_POST[close]) {
	$addQ->eFormHandler($_POST,'add', $_SESSION['Title_Test']['id']);
	include $_SERVER['DOCUMENT_ROOT'].'/engine/skins/options.tpl';
}
?>


