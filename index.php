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

	if(isset($_POST[start])){//оброботчик начальной формы
		$test = new questions();
		$test->loadQuests($_GET[id]);
		$data = $db->loadInterview($_GET[id]);//запрос г базе данных
		$test->load_interview($data);
		$data = $test->data_preparation();
		$_SESSION[question_data] = $data;
	}

	if(isset($_POST[reply])){//оброботчик формы с вопросами
		$test = new questions();
		$test->loadQuests($_GET[id]);
		$test->data_load($_SESSION[question_data]);
		$test->data_processing($_POST);
		$_SESSION[question_data] = $test->get_data();
	}

	if($_SESSION[question_data] == null){// если данные пусты рендерим начальную форму
		$test = new questions();
		$data = $db->loadInterview($_GET[id]);//запрос г базе данных
		$test->load_interview($data);
		$render = $test->start_poll();
	}else{//если данные не пусты рендерим форму с вопросами
		
			$test = new questions();
			$test->loadQuests($_GET[id]);
			$data = $db->loadInterview($_GET[id]);//запрос г базе данных
			$test->load_interview($data);
			$interview = $test->getInterview();
			$test->data_load($_SESSION[question_data]);

		if($_SESSION[question_data][user_num] < $interview[num_quest]){//проверка на количество пройденных вопросов	
			$count = $_SESSION[question_data][user_num]+1;
			$count = $count.' по счету вопрос из '.$interview[num_quest];//счет вопросаов на вывод

			//$test->data_load($_SESSION[question_data]);
			$render = $test->start_question();
		}else{//тут форма с результатами опроса
			//$test->data_load($_SESSION[question_data]);
			$test->interview_result();
			$_SESSION[user_data_result] = $test->get_string_mail();
			$render = $test->formation_contact_data(array(
																										'Iclass' => 'w100 border', 
																										'result' => 'off',//включает вывод результатов
																										'h1class' => 'h1inter',
																										'trueclass' => 'true',
																										'falseclass' => 'false',
																										'questclass' => 'quest',
																										'scoreclass' => 'score',
																									));
		}
	}

	$template = $twig->loadTemplate('quest.tpl');
	echo $template->render(array('render' => $render, 'count' => $count));

}else{
	unset($_SESSION[question_data]);
	$tests = R::findAll('testtitle');
	$template = $twig->loadTemplate('general.tpl');
	echo $template->render(array('tests' => $tests));
}
?>