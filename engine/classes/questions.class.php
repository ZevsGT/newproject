<?php

class questions extends interview{

	protected $questions_list;
	protected $question;
	protected $answers ;
	protected $questions_rand_key;

	function __construct(){
		$this->db = new database('testtitle', 'questions', 'answers' ,'users');
	}

	function loadQuests($interviewID){ // загружаем все вопросы из опроса
	
		$this->interview = $this->db->loadInterview($interviewID);
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
		
		$Qust = $this->db->loadQustion($QustID);

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

	function getQuest(){//возврашает массив с данными вопроса и списком ответов
		return $this->question;
	}


# Оброботка опроса пользователя при прохождении опроса

	function data_preparation(){//формирует стартовые данные
		if($this->questions_list != null && $this->interview != null){
			if($this->interview[num_quest] != null){
				if(count($this->questions_list) >= $this->interview[num_quest]){
					$key = array_rand($this->questions_list, $this->interview[num_quest]);
					$data['interview_id'] =  $this->interview[id];
					$data['questions_rand_key'] =  $key;
					$data['user_num'] = 0;
					$data['user_question'] = null;
					return $data;
				}else echo "error: Number of questions in the database is less than in the survey";
			}else echo "error: The database did not record the number of questions";
		}else echo 'error: Survey data not uploaded';

	}

	function data_load($data){// загружает данные вопроса которые были свормированы в функции data_preparation() или get_data()
		
		$question = $this->questions_list[$data['questions_rand_key'][$data['user_num']]];
		if($question[answers] != null){
			shuffle($question[answers]);
		}
		$this->question = $question;
		$this->user_num = $data['user_num'];
		$this->questions_rand_key = $data['questions_rand_key'];
		$this->user_question = $data['user_question'];
	}

	function get_data(){
		$data['interview_id'] =  $this->interview[id];
		$data['questions_rand_key'] =  $this->questions_rand_key;
		$data['user_num'] = $this->user_num;
		$data['user_question'] = $this->user_question;
		
		return $data;
	}

	function data_processing($answer){// обработка данных из формы ответа на вопрос
		$this->user_question[] = array('id' => $answer[id], 'answer_id' => $answer[answer_id]);
		$this->user_num++;
	}
# end Оброботка опроса пользователя при прохождении опроса
	
	function renderEditor($options = null){
		
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

	function eFormHandler($data, $flag, $interviewID = null){//функция обработки данных с формы || ее можно оптимизировать, а именно ветви add и edit объеденить в одну
		
		
		if($flag == 'add'){// добавлнеие нового вопроса
			// в цикле записываем ответы
			$count = 0;
			while (count($data) != $count) {
				$pos = strpos(key($data), 'true');//проверка данных на встречающийся вопросы с индикатором true (верный ответ)
				if ($pos === false) {  //если ничего не найденно  
				    $pos = strpos(key($data), 'false');//проверка данных на встречающийся вопросы с индикатором false (не верный ответ)
						if ($pos === false) {//если ничего не найденно
						    $count++;
								next($data);
						} else {//если найден не верный ответ
								if($data[key($data)] != '') $this->loadAnswers($data[key($data)], 0);//не верные ответы
								$count++;
								next($data);
						}
				} else {//если найден верный ответ
						$this->loadAnswers($data[key($data)], 1);//верные ответы
						$count++;
						next($data);
				}
			}
			$this->db->addQustion($interviewID, $data['name'], $this->answers);
			//$return= array('id' => $interviewID, 'name' => $data['name'], 'answers' => $this->answers);
			return;
			//end в цикле записываем  ответы
		}elseif($flag == 'edit'){// редактирование существующего вопроса

			$this->db->editQustionName($data[id], $data[name]);
			//редактирование существующего вопроса
			$count = 0;
			while (count($data) != $count) {
				$pos = strpos(key($data), 'true');//проверка данных на встречающийся вопросы с индикатором true (верный ответ)
				if ($pos === false) {  //если ничего не найденно 
				    $pos = strpos(key($data), 'false');//проверка данных на встречающийся вопросы с индикатором false (не верный ответ)
						if ($pos === false) {//если ничего не найденно
						    $count++;
								next($data);
						} else {//если найден не верный ответ
								if($data[key($data)] != '') {
									$str = explode('_', key($data));
									if($str[2] != null) $this->db->editAnswerName($str[2], $data[key($data)]);//обновление уже существующего в бд
									else $this->loadAnswers($data[key($data)], 0);//новые не верные ответы
								}
								$count++;
								next($data);
						}
				} else {//если найден верный ответ
						$str = explode('_', key($data));
						if($str[2] != null) $this->db->editAnswerName($str[2], $data[key($data)]);//обновление уже существующего в бд
						else $this->loadAnswers($data[key($data)], 1);//новые верные ответы
						$count++;
						next($data);
				}
			}
			if($this->answers != null) $this->db->addAnswer($data[id], $this->answers);//проверяем есть ли новые ответы если да то add
			//end редактирование существующего вопроса
		}
	}

	function start_question($options = null){//рендерит форму на прохождение теста
		$option = array(
										'action' => '', 
										'method' => 'post', 
										'enctype' => 'multipart/form-data',
										'Fclass' => '',
										'Iclass' => '',
										'Itype' => 'radio',
									  'submit' => array(
									  									array(
									  													'value' => 'Следующий вопрос',
									  													'name' => 'reply',
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

		if($this->question !=null){
			$render = "<form class=\"$option[Fclass]\" action=\"$option[action]\" method=\"$option[method]\" enctype=\"$option[enctype]\">";
			$render .= "<input type=\"hidden\" name=\"id\" value=\"". $this->question[quest][id] ."\">";
			$render .= "<h2>".$this->question[quest][name]."</h2>";

			foreach ($this->question[answers] as $key ) {
				$render .= "<p><input name=\"answer_id\" type=\"$option[Itype]\" value=\"$key[id]\">$key[name]</p>";
			}

			foreach ($option[submit] as $key) { //кнопки
						$render .= "<input class=\"$key[class]\" value=\"$key[value]\" type=\"submit\" name=\"$key[name]\">";
			}
			$render .="</form>";
			return $render;
		}else return "error: The question was not uploaded";
	}

}
?>