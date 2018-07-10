<?php
require_once "engine/data/session.php";
require_once "engine/data/db.php"; // подключение бд + конфиг 
require_once 'engine/lib/Twig/Autoloader.php';
require_once 'engine/class.php';
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

 		if(isset($_SESSION['Title_Test'])){//если название теста было заполнено, выводим форму с вопросами

 			$template = $admin->loadTemplate('addQustions.tpl');
			echo $template->render(array());
			//unset($_SESSION['Title_Test']);

 		}else{// форма с названием теста

			$template = $admin->loadTemplate('addTitleTest.tpl');
			echo $template->render(array('error' => $_SESSION['error']));
			unset($_SESSION['error']);

 		}

 	}else{//главная страница со списком тестов
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