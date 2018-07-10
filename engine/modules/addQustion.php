<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/class.php';

if(isset($_POST[further])){
	
	$addQ = new interview('testtitle', 'questions', 'answers' ,'users');

	foreach ($_POST as $key) {
		if($key != $_POST[name] && $key != $_POST[further] && $key !='') {

			if($key == $_POST['true']) $addQ->addQustionList($key, 1); //верный ответ
			else $addQ->addQustionList($key, 0); //не верный ответ
		}
	}

	$list = $addQ->getQuestionsList();
	$addQ->addQustion($_SESSION['Title_Test']['id'], $_POST['name'], $list);

	header('location: /admin.php?mod=addtest');
	
}elseif($_POST[close]) {
	echo "12";
}
?>