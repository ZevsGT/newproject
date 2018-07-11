<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/class.php';

if(isset($_POST[further])){

		$addI = new interview('testtitle', 'questions', 'answers' ,'users');
		$addI->editInterviewName($_POST[id], $_POST[name]);
		
		echo "Название опроса было отредактировано <br><br><a href=\"/admin.php?mod=editinterview&id=".$_SESSION['Title_Test'][id]."\">Продолжить редактирование</a>";
}
?>