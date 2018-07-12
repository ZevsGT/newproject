<?php

class interview {
	protected $interview;
	protected $num_quest;
	protected $bad_answers;
	protected $passing_score;

	function load_interview($interview){
			$this->interview = $interview;
	}

	function getInterview(){//возвращает данные опроса
		return $this->interview;
	}

	function getQuest(){//возврашает массив с данными вопроса и списком ответов
		return $this->question;
	}


}
?>
