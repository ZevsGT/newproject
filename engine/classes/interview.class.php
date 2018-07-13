<?php

class interview {
	protected $interview;
	protected $user_results;
	protected $user_question;
	protected $user_num;

	function load_interview($interviewID){
			$this->interview = $interviewID;
	}

	function getInterview(){//возвращает данные опроса
		return $this->interview;
	}

	function getUser_num(){
		return $this->user_num;
	}

	function getUser_results(){
		return $this->user_results;
	}

	function get_string_mail(){//возвращает строку для почты
		$string = "Название опроса: ".$this->interview[name]."\r\n";
		$score = 0;
		foreach ($this->user_results as $key) {
			if($key[answer][flag] == true) {
				$answer = 'верный';
				$score++;
			}
			else $answer = 'не верный';
			$string .= "Вопрос: ".$key[quest]."\n - Ответ: ".$key[answer][name]."/ $answer\r\n";
		}
		$string .= "Набранный балл: $score\r\n";
		return $string;
	}

	function interview_result(){
		$db = new database('testtitle', 'questions', 'answers' ,'users');
		foreach ($this->user_question as $key) {
			$Qustion = $db->loadQustion($key[id]);
			$Answer = $db->loadAnswer($key[answer_id]);
			$this->user_results[] = array('quest' => $Qustion[name], 'answer' => array('name' => $Answer[name], 'flag' => $Answer[flag]));
		}	
	}

	function formation_contact_data($options = null){//генерация формы обратной связи
		$option = array(
										'action' => '', 
										'method' => 'post', 
										'enctype' => 'multipart/form-data',
										'Fclass' => '',
										'Iclass' => '',
										'result' => 'off',
									  'submit' => array(
									  									array(
									  													'value' => 'Отправить',
									  													'name' => 'submit',
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

		if($option[result] == 'on'){//вывод статистики
				$render = "<h1>Название опроса: ".$this->interview[name]."</h1>";
				$score = 0;
				foreach ($this->user_results as $key) {
				if($key[answer][flag] == true) {
					$answer = 'верный';
					$score++;
				}
				else $answer = 'не верный';
				$render .= "<h3>Вопрос: $key[quest] </h3>";
				$render .= "<p>Ответ: ".$key[answer][name]."/ $answer</p>";
			}
			$render .= "<h2>Набранный балл: $score</h2>";
		}

		$render .= "<form id=\"form\" class=\"$option[Fclass]\" action=\"$option[action]\" method=\"$option[method]\" enctype=\"$option[enctype]\">";
		$render .= "<input type=\"text\" name=\"name\" required placeholder=\"ФИО\" class=\"$option[Iclass]\" value=\"\"><br>";
		$render .= "<input type=\"text\" name=\"contacts\" required placeholder=\"E-mail или номер телефона\" class=\"$option[Iclass]\" value=\"\"><br>";
		foreach ($option[submit] as $key){ //кнопки
			$render .= "<input class=\"$key[class]\" value=\"$key[value]\" type=\"submit\" name=\"$key[name]\">";
		}
		$render .="</form>";

		return $render;
	}

	function start_poll($options = null){//рендерит форму с информацией вопроса
		$option = array(
										'action' => '', 
										'method' => 'post', 
										'enctype' => 'multipart/form-data',
										'Fclass' => '',
										'Iclass' => '',
									  'submit' => array(
									  									array(
									  													'value' => 'Начать тестирование',
									  													'name' => 'start',
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

		if($this->interview != null){
				$render = "<form class=\"$option[Fclass]\" action=\"$option[action]\" method=\"$option[method]\" enctype=\"$option[enctype]\">";
				$render .= "<h2>".$this->interview['name']."</h2>
										<p>Количество вопросов в тесте: ".$this->interview[num_quest]."</p>
										<p>Проходной балл: ".$this->interview[num_quest]."</p>";
				foreach ($option[submit] as $key) { //кнопки
							$render .= "<input class=\"$key[class]\" value=\"$key[value]\" type=\"submit\" name=\"$key[name]\">";
				}
				$render .="</form>";
				return $render;
		}else return 'error: The poll was not uploaded';
	}


}
?>
