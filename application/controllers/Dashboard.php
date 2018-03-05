<?PHP 
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function index()
	{
		$percent2=0;
		$mandatorysay=0;

		//need to use TRUE first model load
		$this->load->model('user_model', '', TRUE);
		$this->load->model('bulletinboard_model');
		$this->load->model('file_model');
		$this->load->model('test_model');

		$this->arViewData['categoryNames'] = [
			'1' => 'News',
			'2' => 'New Hires',
			'3' => 'Birthday',
			'4' => 'Event',
		];

		$this->arViewData['tests'] = $this->test_model->progress($this->session->user_id);
		$this->arViewData['bulletins'] = $this->bulletinboard_model->recent(null, '3');
		$this->arViewData['files'] = $this->file_model->recent();
		$this->arViewData['birthdays'] = $this->bulletinboard_model->get_birthdays();
		//check bonus progress
		$this->arViewData['bonus_progress'] = $this->user_model->get_bonus_progress($this->session->user_id);
		$this->arViewData['bonus_month1'] = $this->user_model->get_bonus_progress($this->session->user_id, 1);
		$this->arViewData['bonus_month2'] = $this->user_model->get_bonus_progress($this->session->user_id, 2);
		//if progress is 100% + 10% (so we cover in case there are errors)
		//then display bonus amount potential
           log_message('debug', '------------------------> DASHBOARD bonus_progress :' . print_r($this->arViewData['bonus_progress'], TRUE));
           log_message('debug', '------------------------> DASHBOARD bonus_month1 :' . print_r($this->arViewData['bonus_month1'], TRUE));
           log_message('debug', '------------------------> DASHBOARD bonus_month2 :' . print_r($this->arViewData['bonus_month2'], TRUE));
		if ( $this->arViewData['bonus_progress'] >= 100 )
			$this->arViewData['bonuses'] = $this->user_model->get_bonus_status($this->session->user_id);
		else
			$this->arViewData['bonuses'] = $this->arViewData['bonus_progress'];

		// Another way is to detect login redirect with $this->agent->is_referral() and $this->agent->referrer()
		//make sure user has not already turned in
		$this->arViewData['prompt_turn_in'] = ($this->input->get('prompt_turn_in') === 'true');

		$this->_layout('dashboard');
	}

}
