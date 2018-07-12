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
