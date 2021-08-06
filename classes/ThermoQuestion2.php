<?php

// class ThermoQuestion2 implements QuizQuestion{

// 	private Hydrocarbon $hydrocarbon;

// 	public function __construct($u_hydrocarbon){

// 		$this->hydrocarbon = $u_hydrocarbon;
// 	}

// 	public function get_question_text(){
// 		$html = "<p>What is the standard enthalpy of combustion for " . $this->hydrocarbon . "?</p><br>";

// 		$html .= $this->get_html_for_combustion_reaction();

// 		$html .= "<br>";

// 		return $html;
// 	}

// 	public function get_correct_answer(){
// 		return $this->get_standard_enthalpy_of_combustion();
// 	}

// 	public function get_correct_answer(){
// 		return $this->hydrocarbon->amount_required_to_heat_water($this->vol_water_ml, $this->start_temp, $this->end_temp);
// 	}

// 	//generate erroneous choices
// 	public function get_choices(){

// 	}

// }

// class ChoiceSet{
// 	private $choice_set_id;
// 	private $choices = [
// 		"A" => null,
// 		"B" => null,
// 		"C" => null,
// 		"D" => null,
// 		"E" => null
// 	];

// 	public function __construct($id){
// 		$this->choice_set_id;
// 	}

// 	public function get_choices(){
// 		return $this->choices;
// 	}

// 	public function set_choice($choice_letter,$choice){
// 		if($choice_letter != "A" || $choice_letter != "B" || $choice_letter != "C" || $choice_letter != "D" || $choice_letter != "E"){
// 			echo "Failed to set choice: improper letter option";
// 			return;
// 		}

// 		$this->choices[$choice_letter] = $choice;

// 		return $this;

// 	}
// }
