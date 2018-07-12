<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/data/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/engine/data/session.php';

class interview {
	private $Tname_interview;
	private $Tname_Qustion;
	private $Tname_user;
	private $Tname_answers;

	private $interview;
	private $questions_list;
	private $question;
	private $num_quest;
	private $answers;
	private $bad_answers;
	private $passing_score;


	function __construct($Tname_interview, $Tname_Qustion, $Tname_answers ,$Tname_user) {//названия таблиц таблиц: 'Таблица с Опросами', 'таблица с вопросоми', 'Таблица с ответами', 'таблица с пользователями'
		$this->Tname_interview = $Tname_interview;
		$this->Tname_Qustion = $Tname_Qustion;
		$this->Tname_answers = $Tname_answers;
		$this->Tname_user = $Tname_user;
	}


	function addOptions($num_quest, $passing_score, $interviewID){//добавляет количество вопросов на один тест и проходной балл
		$interview = R::load($this->Tname_interview, $interviewID);
		$interview->num_quest = $num_quest;
		$interview->passing_score = $passing_score;
		R::store( $interview );
	}

	function addinterview($interviewID){ // записывает все id вопросов и ответов в класс 
		$interview = R::load($this->Tname_interview, $interviewID);
		$this->interview = $interview;
		$interview = R::getAll('SELECT id, name FROM questions WHERE testtitle_id=?', array($interviewID));
		
		foreach ($interview as $key ) {
			$answers = R::getAll('SELECT id, name, flag FROM answers WHERE questions_id=?', array($key[id]));
			foreach ($answers as $key2 ){
					$list[] = $key2;
			}
			$this->questions_list[] = array('quest' => $key, 'answers' => $list);
			unset($list);
		}
	}

	function addQust($QustID){ // записывает id вопроса и ответы в класс 
		$Qust = R::load($this->Tname_Qustion, $QustID);
		$quest['id'] = $Qust->id; //в RedBeanPHP есть функция которая преобразует оюъект класса в массив (название не смог найти)
		$quest['name'] = $Qust->name;

		$answers = R::getAll('SELECT id, name, flag FROM answers WHERE questions_id=?', array($QustID));
		foreach ($answers as $key2 ){
				$list[] = $key2;
		}
		$this->question = array('quest' => $quest, 'answers' => $list);
	}


	function addInterviewName($name, $userid){//добавление нового опроса
		$user = R::load($this->Tname_user, $userid);
		
		$test = R::dispense($this->Tname_interview);
		$test->name = $name;

		$user->ownAdminEmail[] = $test;
		R::store( $user );
		$this->interview = $test;
	}

	function addQustion($interviewID, $name){//добавление нового вопроса в опрос по id в бд
		$test = R::load($this->Tname_interview, $interviewID);
		$questions = R::dispense($this->Tname_Qustion);
		$questions->name = $name;

		foreach ($this->questions_list as $key) {
			$answers = R::dispense($this->Tname_answers);
			$answers->name = $key[name];
			$answers->flag = $key[flag];
			$questions->ownAnswerList[] = $answers;
		}

		$test->ownQuestionsList[] = $questions;
		R::store( $test );
	}

	function addAnswer($questionsID){//add новых ответов в вопрос
		$questions = R::load($this->Tname_Qustion, $questionsID);

		foreach ($this->questions_list as $key){
			$answers = R::dispense($this->Tname_answers);
			$answers->name = $key[name];
			$answers->flag = $key[flag];
			$questions->ownAnswerList[] = $answers;
		}

		R::store( $questions );
	}

	function addQustionList($name, $flag){//добавляет списк ответов в класс, для получения использовать метдот getQuestionsList(), flag может быть true или false (верный не верный ответ)
		$this->questions_list[] =  array('name' => $name, 'flag' => $flag); 
	}

	function deleteInterview($interviewID){//удаление опроса
		$test = R::load($this->Tname_interview, $interviewID);
		R::trash($test);
	}

	function deleteQustion($qustionID){
			$qust = R::load($this->Tname_Qustion, $qustionID);
			R::trash($qust);
	}

	function editInterviewName($interviewID, $name){// изменение названия опроса
		$test = R::load($this->Tname_interview, $interviewID);
		$test->name = $name;
		R::store( $test );
	}

	function editQustionName($qustionID, $name){//изменение названия вопроса
		$qustion = R::load($this->Tname_Qustion, $qustionID);
		$qustion->name = $name;
		R::store( $qustion );
	}

	function editAnswerName($answerID, $name){// изменение ответа
		$answer = R::load($this->Tname_answers, $answerID);
		$answer->name = $name;
		R::store( $answer );
	}

	function getInterview(){//возвращает данные опроса
		return $this->interview;
	}

	function getQuestionsList(){//возврашает массив со списком вопросов и ответов
		return $this->questions_list;
	}

	function getQuest(){//возврашает массив с данными вопроса и списком ответов
		return $this->question;
	}

	function getNumQuest($interviewID){//возвращает количество вопросов у опроса по id
		$count = R::count($this->Tname_Qustion, 'testtitle_id = ?', array($interviewID));//поле ключа на таблицу testtitle_id
		$num_quest = $count;
		return $count;
	}

	function renderEditor($options){
		
		$option = array(
										'action' => '', 
										'method' => 'post', 
										'enctype' => 'multipart/form-data',
										'Fclass' => '',
										'Iclass' => '',
									  'num_quest' => '9',
									  'num_true' => '1',
									  'submit' => array(
									  									array(
									  													'value' => 'Следующий вопрос',
									  													'name' => 'further',
									  													'class' => ''
									  												), 
									  									array(
									  													'value' => 'Закончить опрос',
									  													'name' => 'close',
									  													'class' => ''
									  												)
									  								),
									);

		if($options != null) {
			$count = 0;
			while (count($options) != $count) {
				$option[key($options)] = $options[key($options)];
				$count++;
				next($options);
			}
		}

		if($this->question == null){//выводим форму без значений, если небыло подключен вопрос
				$render = "<form class=\"$option[Fclass]\" action=\"$option[action]\" method=\"$option[method]\" enctype=\"$option[enctype]\">";
				$render .= "<input type=\"hidden\" name=\"id\" value=\"\">";
				$render .= "<input type=\"text\" name=\"name\" required placeholder=\"Название вопроса\" class=\"$option[Iclass]\" value=\"\"><br>";

				for ($i=0; $i < $option[num_true]; $i++) {//верные вопросы
					$render .= "<input type=\"text\" name=\"true_$i\" required placeholder=\"Правильный ответ\" class=\"$option[Iclass]\" value=\"\"><br>";
				}

				for ($i=0; $i < $option[num_quest]-$option[num_true]; $i++) {//не верные вопросы
					if($i == 0) $required = 'required';
					else $required = '';
					$render .= "<input type=\"text\" name=\"false_$i\" $required placeholder=\"Варинат ответа\" class=\"$option[Iclass]\" value=\"\"><br>";
				}

				foreach ($option[submit] as $key) { //кнопки
					$render .= "<input class=\"$key[class]\" value=\"$key[value]\" type=\"submit\" name=\"$key[name]\">";
				}

				$render .="</form>";
		}else{// выводим форму со значениями, если подключен вопрос
				$render = "<form class=\"$option[Fclass]\" action=\"$option[action]\" method=\"$option[method]\" enctype=\"$option[enctype]\">";
				$render .= "<input type=\"hidden\" name=\"id\" value=\"". $this->question[quest][id] ."\">";
				$render .= "<input type=\"text\" name=\"name\" required placeholder=\"Название вопроса\" class=\"$option[Iclass]\" value=\"". $this->question[quest][name] ."\"><br>";

				for ($i=0; $i < $option[num_true]; $i++) {//верные вопросы со значениями
					if($this->question[answers][$i][flag] == true){
						$id = $this->question[answers][$i][id];
						$value = $this->question[answers][$i][name];
						$render .= "<input type=\"text\" name=\"true_".$i."_".$id."\" required placeholder=\"Правильный ответ\" class=\"$option[Iclass]\" value=\"$value\"><br>";
					}
				}

				for ($i = $option[num_true]; $i < $option[num_quest]; $i++) {// не верные вопросы со значениями
					if($this->question[answers][$i][flag] == false && $this->question[answers][$i] != null){

						if($i == 0) $required = 'required';// добавление первому полю флаг опязательное заполнение
						else $required = '';

						$id = $this->question[answers][$i][id];
						$value = $this->question[answers][$i][name];
						$render .= "<input type=\"text\" name=\"false_".$i."_".$id."\" $required placeholder=\"Варинат ответа\" class=\"$option[Iclass]\" value=\"$value\"><br>";
					}else{// выводим не заполненые поля
						$render .= "<input type=\"text\" name=\"false_$i\" $required placeholder=\"Варинат ответа\" class=\"$option[Iclass]\" value=\"\"><br>";
					}
				}

				foreach ($option[submit] as $key) { //кнопки
					$render .= "<input class=\"$key[class]\" value=\"$key[value]\" type=\"submit\" name=\"$key[name]\">";
				}

				$render .="</form>";
		}

		return  $render;
	}

	function eFormHandler($data, $flag, $interviewID = null){//функция обработки данных с формы || ее можно оптимизировать
		if($flag == 'add'){
			// в цикле записываем ответы
			$count = 0;
			while (count($data) != $count) {
				$pos = strpos(key($data), 'true');
				if ($pos === false) {   
				    $pos = strpos(key($data), 'false');
						if ($pos === false) {
						    $count++;
								next($data);
						} else {
								if($data[key($data)] != '') $this->addQustionList($data[key($data)], 0);//не верные ответы
								$count++;
								next($data);
						}
				} else {
						$this->addQustionList($data[key($data)], 1);//верные ответы
						$count++;
						next($data);
				}
			}
			$this->addQustion($interviewID, $data['name']);
			return;
			//end в цикле записываем  ответы
		}elseif($flag == 'edit'){

			$this->editQustionName($data[id], $data[name]);
			//редактирование существующего вопроса
			$count = 0;
			while (count($data) != $count) {
				$pos = strpos(key($data), 'true');
				if ($pos === false) {   
				    $pos = strpos(key($data), 'false');
						if ($pos === false) {
						    $count++;
								next($data);
						} else {
								if($data[key($data)] != '') {
									$str = explode('_', key($data));
									if($str[2] != null) $this->editAnswerName($str[2], $data[key($data)]);//обновление уже существующего в бд
									else $this->addQustionList($data[key($data)], 0);
								}
								$count++;
								next($data);
						}
				} else {
						$str = explode('_', key($data));
						if($str[2] != null) $this->editAnswerName($str[2], $data[key($data)]);//обновление уже существующего в бд
						else $this->addQustionList($data[key($data)], 1);//верные ответы
						$count++;
						next($data);
				}
			}
			if($this->getQuestionsList() != null) $this->addAnswer($data[id]);//проверяем есть ли новые ответы если да то add
			//end редактирование существующего вопроса
		}
	}

}
?>
