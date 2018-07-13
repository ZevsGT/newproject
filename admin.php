
<?php
require_once 'engine/lib/Twig/Autoloader.php';
require_once 'engine/head.php';

Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('engine/skins');
$admin = new Twig_Environment($loader, array(
    //'cache'       => 'engine/admin_cache',
    //'auto_reload' => true
 ));


//авторизация пользователя
if (isset ($_POST['submitFF'])) {
	$user = R::findOne('users', 'login = ?', array($_POST[login]));
	if($user){//если логин существует 
		if($_POST[password] == $user->password){//проверка на совпадение паролей, пароль хранится в открытом виде
				
				$_SESSION['logged_user']['id'] = $user->id;
				$_SESSION['logged_user']['name'] = $user->name;
				$_SESSION['logged_user']['login'] = $user->login;
				$_SESSION['logged_user']['password'] = $user->password;
			
		}else{
			$error = 'Ошибка: Неверный пароль';
		}
	}else {
		$error = 'Ошибка: Пользователь не найден<br>';
	}
}
//end авторизация пользователя


if( isset($_SESSION['logged_user'])){ //если авторизован и группа admin
unset($_POST);
 	if($_GET['mod']=='addtest'){

	 		if(isset($_SESSION['Title_Test']['id'])){//если название теста было заполнено, выводим форму с вопросами
	 			$test = new questions();
	 			$rend = $test->renderEditor(array('Iclass' => 'w100 border', 'action' => '/engine/modules/addQustion.php'));
	 			$template = $admin->loadTemplate('addQustions.tpl');
				echo $template->render(array('rend' => $rend));
	 		}else{// форма с названием теста
				$template = $admin->loadTemplate('addTitleTest.tpl');
				echo $template->render(array('error' => $_SESSION['error']));
				unset($_SESSION['error']);
	 		}

 	}elseif($_GET[mod] == 'editinterview' && isset($_GET[id])){ // страница с редактирвания опроса

 		$_SESSION['Title_Test'][id] = $_GET[id]; // используеться для возврата на страницу с вопросами 
 		$data = $db->loadInterview($_GET[id]);
 		$quest = new questions();
 		$quest->load_interview($data);
 		$quest->loadQuests($data[id]);
 		$interview = $quest->getInterview();
 		$questions = $quest->getQuestionsList();
 		$template = $admin->loadTemplate('editInterview.tpl');
		echo $template->render(array('name' => $interview, 'quests' => $questions));
 		
 	}elseif($_GET[mod] == 'editquestions' && isset($_GET[id])){ // редактирование существующегов вопроса
 				$qust = new questions();
 				$qust->loadQuest($_GET[id]);
 				$rend = $qust->renderEditor(array(
	 																					'Iclass' => 'w100 border', 
	 																					'action' => '/engine/modules/editQustion.php',
	 																					'submit' => array(
										  																				array(
										  																								'value' => 'Готово',
										  																								'name' => 'further',
										  																								'class' => ''
										  																							)
										  																				)
 																					));
	 			$template = $admin->loadTemplate('addQustions.tpl');
				echo $template->render(array('rend' => $rend));
 				
 	}elseif($_GET[mod] == 'editInterviewName' && isset($_GET[id])){ // страница с редактирвания названия опроса

 		
 		$interview = $db->loadInterview($_GET[id]);
 		
 		$template = $admin->loadTemplate('editTitleTest.tpl');
		echo $template->render(array('interv' => $interview));

 	}else{//главная страница со списком опросов
 		unset($_SESSION['Title_Test']);
 		$tests = R::findAll('testtitle');
		$template = $admin->loadTemplate('Ageneral.tpl');
		echo $template->render(array('tests' => $tests));
 	}

}else{ //форма авторизации

	$template = $admin->loadTemplate('login.tpl');
	echo $template->render(array('error' => $error, 'login' => $_POST[login]));

}

?>