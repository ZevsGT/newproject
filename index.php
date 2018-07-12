<?php
require_once "engine/head.php"; // подключение бд + конфиг + шаблонизатор
require_once 'engine/lib/Twig/Autoloader.php';
Twig_Autoloader::register();

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    //'cache'       => 'engine/cache',
    //'auto_reload' => true
 ));

if($_GET[mod] == 'quest' && isset($_GET[id])){

	//unset($_SESSION[question_data]);

	if(isset($_POST[start])){//оброботчик начальной формы
		$test = new questions();
		$test->loadQuests($_GET[id]);
		$data = $db->loadInterview($_GET[id]);
		$test->load_interview($data);
		$data = $test->data_preparation();
		$_SESSION[question_data] = $data;
	}

	if(isset($_POST[reply])){//оброботчик формы с вопросами
		$test = new questions();
		$test->loadQuests($_GET[id]);
		$test->data_load($_SESSION[question_data]);
		$data = $db->loadInterview($_GET[id]);
		$test->data_processing($_POST);
		$_SESSION[question_data] = $test->get_data();
	}

	if($_SESSION[question_data] == null){// если данные пусты рендерим начальную форму
		$test = new questions();
		$test->loadQuests($_GET[id]);
		$data = $db->loadInterview($_GET[id]);
		$test->load_interview($data);
		$render = $test->start_poll();
	}else{//если данные не пусты рендерим форму с вопросами
		
			$test = new questions();
			$test->loadQuests($_GET[id]);
			$data = $db->loadInterview($_GET[id]);
			$test->load_interview($data);
			$interview = $test->getInterview();
			

		if($_SESSION[question_data][user_num] < $interview[num_quest]){//проверка на количество пройденных вопросов
			$test->data_load($_SESSION[question_data]);
			$render = $test->start_question();
		}else{//тут форма с результатами опроса
			$render = "тут форму с результатами и ввода контактных данных для отправки<br> чтобы начать заного нужно обновить страницу";
			//unset($_SESSION[question_data]);
		}
	}

	$template = $twig->loadTemplate('quest.tpl');
	echo $template->render(array('render' => $render));

}else{
	unset($_SESSION[question_data]);
	$tests = R::findAll('testtitle');
	$template = $twig->loadTemplate('general.tpl');
	echo $template->render(array('tests' => $tests));
}
?>