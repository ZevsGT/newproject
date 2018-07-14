<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/head.php';

if(isset($_POST[further])){
	//$addO = new interview('testtitle', 'questions', 'answers' ,'users');
	$db->addOptions($_POST[num], $_POST[passing], $_POST[id]);

	header('location: /admin.php');
}
?>


