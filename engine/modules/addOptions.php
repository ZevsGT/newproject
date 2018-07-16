<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/head.php';

if($_POST[passing] <= ($_POST[num] - 2)){
	
	$db->addOptions($_POST[num], $_POST[passing], $_POST[id]);

	echo "Добавленно";

}else echo "Проходной балл должен быть меньше чем количество вопросов (минимум на два)";
?>


