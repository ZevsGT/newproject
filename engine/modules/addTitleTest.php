<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/class.php';

if(isset($_POST[further])){

		$addI = new interview('testtitle', 'questions', 'answers' ,'users');
		$addI->addInterviewName($_POST[name], $_SESSION['logged_user']['id']);
		$idInter = $addI->getInterview();
		$_SESSION['Title_Test']['id'] = $idInter[id];

		header('location: /admin.php?mod=addtest');
}
?>