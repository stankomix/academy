<?php

/**
 * Tests Controller class file.
 *
 * @author 		Sam Takunda <sam.takunda@gmail.com>
 * @copyright 	(c) 2016, Commercial Fire Protection
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tests extends MY_Controller {

	public function index()
	{
		$this->load->model('test_model', '', TRUE);

		$this->arViewData['progress'] = $this->test_model->progress($this->session->user_id);
		
		$this->arViewData['all_tests'] = $this->test_model->all();
	
		$this->_layout('tests/index');
	}

	public function startTest($test_id){
		
		$this->load->model('test_questions_model', '', TRUE);
		$this->load->model('test_model', '', TRUE);
		
				
		$this->arViewData['all_questions'] = $this->test_questions_model->get($test_id);
		$this->arViewData['current_test'] = $this->test_model->get($test_id);
	
		$this->_layout('tests/start_test');
		
	}
	
	public function testResult(){
		if($this->input->post()){
			
			$this->load->model('test_questions_model', '', TRUE);
			$allAnswers = $this->test_questions_model->get($this->input->post("test_id"));
			$currentAnwers = $this->input->post();
			
			$currentIndex = 0;
			$totalAnswers = 0;
			$correctAnswers = 0;
			$wrongAnswer = 0;
			$passingPercentage = 50;
			 foreach($currentAnwers["fields"] as $answers){
				
				
				if($answers['value'] == $allAnswers[$currentIndex]->correct_answer){
					$correctAnswers++;
					
				}else{
					$wrongAnswer++;
				}
				
				$totalAnswers++;
				$currentIndex++;
			} 
			
			
			
			$passOrfail = $correctAnswers / $totalAnswers * 100;
			
			if($passOrfail >= $passingPercentage){
				$passOrfail = "Pass";
			}else{
				$passOrfail = "Fail";
			}
			
			$result = array(
			'correct' => $correctAnswers,
			'wrong' => $wrongAnswer,
			'total' => $totalAnswers,
			'passOrfail' => $passOrfail
			);	

			print_r(json_encode($result));
		}
	}
	
}
