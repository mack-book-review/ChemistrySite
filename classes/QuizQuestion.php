<?php

//Should be able to generate randomized choices along with erroneous answers
abstract class QuizQuestion {

	protected int $question_id;
	protected string $correct_choice;
	protected array $choices;

	abstract public function get_question_id();
	abstract public function get_question_text();
	abstract protected function get_erroneous_answers();

	public function get_correct_choice() {
		return $this->correct_choice;
	}
	public function get_choices(): array{
		return $this->choices;
	}

	//generate erroneous and correct choices
	protected function generate_choices() {

		$this->randomly_assign_correct_answer();

		$erroneous_answers = $this->get_erroneous_answers();

		$this->randomly_assign_erroneous_answers($erroneous_answers);
	}

	protected function randomly_assign_correct_answer() {
		$rand_key = array_rand(array_keys($this->choices), 1);
		$this->correct_choice = array_keys($this->choices)[$rand_key];

		$this->choices[$this->correct_choice] = $this->get_correct_answer();
	}

	protected function randomly_assign_erroneous_answers($erroneous_answers) {

		shuffle($erroneous_answers);

		$i = 0;

		foreach ($this->choices as $letter => $choice) {
			if ($choice == null) {

				$this->choices[$letter] = $erroneous_answers[$i];

				$i += 1;
			}
		}
	}

}