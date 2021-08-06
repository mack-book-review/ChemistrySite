<?php

//Get the html for displaying a QuizQuestion object in an HTML form
/class QuestionTemplate{

// public static CreateQuestion($u_question_text,$u_correct_answer, $u_choices ,$u_img = null){

// 	//determine $u_question_id from database automatically from database

// 	//determine $u_choice_id from database automatically from database
// 	$u_choice_set = new ChoiceSet(1);

// 	foreach($u_choices as $letter=>$choice){
// 		$u_choice_set.set_choice($letter,$choice);
// 	}

// 	return new Question($u_question_id, $u_question_text,$u_correct_answer, $u_choice_set ,$u_img);

// }

// private QuizQuestion $question;

// public function __construct($u_question){
// 	$this->question = $u_question;

// }

// public function save($db, $table_name){
// 	$sql = "INSERT INTO " . $table_name . "VALUES()";

// }

// public function get_html(){

// 	$html = "<p>";
//    $html .= "<b>(" . $this->question->get_question_id() . ")</b> ";

// 	$html .= $this->question->get_question_text();
// 	$html .= "</p>";

// 	$html .= "<br>";

// if (isset($this->question->get_question_img())) {
// 	$html .= "<img src='" . $$this->question->get_question_img() . "'>";
// 	$html .= "<br>";
// }

// $html .= "<label for='user_answer'>Choose the correct answer: </label>";

// $html .= "<select name='user_answer" . $this->question->get_question_id() . "'" . " id='user_answer'>";

// $html .= "<option value='A'>" . $this->choice_set->get_choices()['A'] . "</option>";

// $html .= "<option value='B'>" . $this->choice_set->get_choices()['B'] . "</option>";

// $html .= "<option value='C'>" . $this->choice_set->get_choices()['C'] . "</option>";

// $html .= "<option value='D'>". $this->choice_set->get_choices()['D'] . "</option>";

// if (isset($this->choice_set->get_choices()['E'])) {
// 	echo "<option value='E'>" . $this->choice_set->get_choices()['D'] . "</option>";
// }

// 	$html .= "</select>";

// 	$html .= "<br>";
// 	$html .= "<br>";

// 	$html .= "<input type='hidden' name='correct_answer" . $this->question->get_question_id() . "' value='" . $this->question->get_correct_answer() . "'>";

// 		return $html;
// 	}

// }

// class QuizMaker{

// 	$questions = [];
// 	;

// 	function __construct($question_set){

// 	}

// 	public function check_answer($user_answer,$correct_answer){

// 		if((gettype($user_answer) == "double" || gettype($user_answer) == "integer") && (gettype($correct_answer) == "double" || gettype($correct_answer) == "integer")){
// 			return abs($user_answer - $correct_answer) <= 1.0;
// 		} else {
// 			return $user_answer == $correct_answer;
// 		}

// 	}
}