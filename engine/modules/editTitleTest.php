<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/head.php';

if(isset($_POST[further])){

		//$addI = new interview('testtitle', 'questions', 'answers' ,'users');
		$db->editInterviewName($_POST[id], $_POST[name]);
		
		echo "Название опроса было отредактировано <br><br><a href=\"/admin.php?mod=editinterview&id=".$_SESSION['Title_Test'][id]."\">Продолжить редактирование</a>";
}
?>