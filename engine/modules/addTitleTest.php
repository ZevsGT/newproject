<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/class.php';

if(isset($_POST[further])){
	//if(R::count('testtitle', 'name = ?', array($_POST[name])) > 0){
		//$_SESSION['error'] = 'тест с таким названием уже существует';
		//header('location: /admin.php?mod=addtest');
	///}else{
		$addI = new interview('testtitle', 'questions', 'answers' ,'users');
		$addI->addInterviewName($_POST[name], $_SESSION['logged_user']['id']);
		$_SESSION['Title_Test']['id'] = $addI->getInterview();

		header('location: /admin.php?mod=addtest');
	//}
}
?>