<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/data/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/data/session.php';

if(isset($_POST[further])){

		
		$idInter = $db->addInterviewName($_POST[name], $_SESSION['logged_user']['id']);
		$_SESSION['Title_Test']['id'] = $idInter[id];

		header('location: /admin.php?mod=addtest');
}
?>