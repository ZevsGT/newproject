<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/head.php';

if(isset($_POST[further])){
	
	$editQ = new questions();
	$editQ->eFormHandler($_POST,'edit');

	
	echo "Вопрос был отредактирован <br><br><a href=\"/admin.php?mod=editinterview&id=".$_SESSION['Title_Test'][id]."\">Продолжить редактирование</a>";
	
}
?>