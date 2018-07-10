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
	private $num_quest;
	private $answers;
	private $passing_score;


function __construct($Tname_interview, $Tname_Qustion, $Tname_answers ,$Tname_user) {//названия таблиц таблиц: 'Таблица с Опросами', 'таблица с вопросоми', 'Таблица с ответами', 'таблица с пользователями'
	$this->Tname_interview = $Tname_interview;
	$this->Tname_Qustion = $Tname_Qustion;
	$this->Tname_answers = $Tname_answers;
	$this->Tname_user = $Tname_user;
}


	function addOptions($num_quest, $passing_score, $interviewID){//добавляет количество вопросов на один тест и проходной балл
		$this->num_quest = $num_quest;
		$this->passing_score = $passing_score;

		$interview = R::load($this->Tname_interview, $interviewID);
		$interview->num_quest = $num_quest;
		$interview->passing_score = $passing_score;
		R::store( $interview );
	}

	function addInterview($interviewID) {//записываенм опрос по id
		$interview = R::load($this->Tname_interview, $interviewID);
		$this->interview = $interview;
	}

	function addInterviewName($name, $userid){//добавление нового опроса
		$user = R::load($this->Tname_user, $userid);
		
		$test = R::dispense($this->Tname_interview);
		$test->name = $name;

		$user->ownAdminEmail[] = $test;
		R::store( $user );
		$this->interview = $test;
	}

	function addQustion($interviewID, $name, $questions_list){//добавление нового вопроса в опрос по id
		$test = R::load($this->Tname_interview, $interviewID);
		$questions = R::dispense($this->Tname_Qustion);
		$questions->name = $name;

		foreach ($questions_list as $key) {
			$answers = R::dispense($this->Tname_answers);
			$answers->name = $key[name];
			$answers->flag = $key[flag];
			$questions->ownAnswerList[] = $answers;
		}

		$test->ownQuestionsList[] = $questions;
		R::store( $test );
	}

	function addQustionList($name, $flag){//добавляет списк ответов в класс, для получения использовать метдот getQuestionsList(), flag может быть true или false (верный не верный ответ)
		$this->questions_list[] =  array('name' => $name, 'flag' => $flag); 
	}

	function deleteInterview($interviewID){//удаление опроса
		$test = R::load($this->Tname_interview, $interviewID);
		R::trash($test);
	}

	function getInterview(){//возвращает id опроса
		return $this->interview->id;
	}

	function getQuestionsList(){//возврашает массив со списком ответов
		return $this->questions_list;
	}

	function getNumQuest($interviewID){//возвращает количество вопросов у опроса по id
		$count = R::count($this->Tname_Qustion, 'testtitle_id = ?', array($interviewID));//поле ключа на таблицу testtitle_id
		$num_quest = $count;
		return $count;
	}

}
?>
