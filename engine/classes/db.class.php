<?php
require_once 'rb.php';
	
class database {
	private $Tname_interview;
	protected $Tname_Qustion;
	private $Tname_user;
	private $Tname_answers;


	function __construct($Tname_interview, $Tname_Qustion, $Tname_answers ,$Tname_user) {//названия таблиц таблиц: 'Таблица с Опросами', 'таблица с вопросоми', 'Таблица с ответами', 'таблица с пользователями'
		$this->Tname_interview = $Tname_interview;
		$this->Tname_Qustion = $Tname_Qustion;
		$this->Tname_answers = $Tname_answers;
		$this->Tname_user = $Tname_user;
	}

	function loadInterview($interviewID){
		return R::load($this->Tname_interview, $interviewID);
	}

	function loadUser($userID){
		return R::load($this->Tname_user, $userID);
	}

	function loadQustion($QustID){
		return R::load($this->Tname_Qustion, $QustID);
	}

	function loadAnswer($AnswerID){
		return R::load($this->Tname_answers, $AnswerID);
	}

	function addOptions($num_quest, $passing_score, $interviewID){//добавляет количество вопросов на один тест и проходной балл
		$interview = R::load($this->Tname_interview, $interviewID);
		$interview->num_quest = $num_quest;
		$interview->passing_score = $passing_score;
		R::store( $interview );
	}

	function addInterviewName($name, $userid){//добавление нового опроса
		$user = R::load($this->Tname_user, $userid);
		
		$test = R::dispense($this->Tname_interview);
		$test->name = $name;

		$user->ownAdminEmail[] = $test;
		R::store( $user );
		return $test;
	}

	function addQustion($interviewID, $name, $Answers){//добавление нового вопроса в опрос по id в бд
		$test = R::load($this->Tname_interview, $interviewID);
		$questions = R::dispense($this->Tname_Qustion);
		$questions->name = $name;

		foreach ($Answers as $key) {
			$answers = R::dispense($this->Tname_answers);
			$answers->name = $key[name];
			$answers->flag = $key[flag];
			$questions->ownAnswerList[] = $answers;
		}

		$test->ownQuestionsList[] = $questions;
		R::store( $test );
	}

	function addAnswer($questionsID, $Answers){//add новых ответов в вопрос
		$questions = R::load($this->Tname_Qustion, $questionsID);

		foreach ($Answers as $key){
			$answers = R::dispense($this->Tname_answers);
			$answers->name = $key[name];
			$answers->flag = $key[flag];
			$questions->ownAnswerList[] = $answers;
		}

		R::store( $questions );
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

	function get_count_Qustion($interviewID){
		R::count($this->Tname_Qustion, 'testtitle_id = ?', array($interviewID));
	}

}
?>
