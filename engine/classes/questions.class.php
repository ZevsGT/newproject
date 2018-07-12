<?php

class questions extends interview{

	private $questions_list;
	private $question;
	private $answers ;

	function loadQuests($interviewID){ // загружаем все вопросы из опроса
		$db = new database('testtitle', 'questions', 'answers' ,'users');
		
		$this->interview = $db->loadInterview($interviewID);
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

	function loadQuest($QustID){ // загружает 1 вопрос с ответами по id
		$db = new database('testtitle', 'questions', 'answers' ,'users');
		$Qust = $db->loadQustion($QustID);

		$quest['id'] = $Qust->id; //в RedBeanPHP есть функция которая преобразует оюъект класса в массив (название не смог найти)
		$quest['name'] = $Qust->name;

		$answers = R::getAll('SELECT id, name, flag FROM answers WHERE questions_id=?', array($QustID));
		foreach ($answers as $key2 ){
				$list[] = $key2;
		}
		$this->question = array('quest' => $quest, 'answers' => $list);
	}

	function loadAnswers($name, $flag){//добавляет списк ответов в класс, для получения использовать метдот getQuestionsList(), flag может быть true или false (верный не верный ответ)
		$this->answers[] =  array('name' => $name, 'flag' => $flag); 
	}

	function getQuestionsList(){//возврашает массив со списком вопросов и ответов
		return $this->questions_list;
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
		
		$db = new database('testtitle', 'questions', 'answers' ,'users');
		
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
								if($data[key($data)] != '') $this->loadAnswers($data[key($data)], 0);//не верные ответы
								$count++;
								next($data);
						}
				} else {
						$this->loadAnswers($data[key($data)], 1);//верные ответы
						$count++;
						next($data);
				}
			}
			$db->addQustion($interviewID, $data['name'], $this->answers);
			//$return= array('id' => $interviewID, 'name' => $data['name'], 'answers' => $this->answers);
			return;
			//end в цикле записываем  ответы
		}elseif($flag == 'edit'){

			$db->editQustionName($data[id], $data[name]);
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
									if($str[2] != null) $db->editAnswerName($str[2], $data[key($data)]);//обновление уже существующего в бд
									else $this->loadAnswers($data[key($data)], 0);
								}
								$count++;
								next($data);
						}
				} else {
						$str = explode('_', key($data));
						if($str[2] != null) $db->editAnswerName($str[2], $data[key($data)]);//обновление уже существующего в бд
						else $this->loadAnswers($data[key($data)], 1);//верные ответы
						$count++;
						next($data);
				}
			}
			if($this->answers != null) $db->addAnswer($data[id], $this->answers);//проверяем есть ли новые ответы если да то add
			//end редактирование существующего вопроса
		}
	}

}
?>
