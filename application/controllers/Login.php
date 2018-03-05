<?PHP 
defined('BASEPATH') OR exit('No direct script access allowed');

use Carbon\Carbon;

class Login extends CI_Controller {

    public function __construct()
    {
		parent::__construct();
	}

	public function index()
	{
		if ( $this->session->nrmlkullanici == "" && $this->session->nrmlstatus == "" ) {
			//need to include headers
			//(we are forced to use a login controller and that allows MY_Controller to check against login/auth for all controllers that inherit)
			$this->load->view('common/_header');
			$this->load->view('login', [ 'failed' => isset($_GET['failed']) ]);
			return;
		}

		$this->load->library('submission_library');
		$can_turn_in = $this->submission_library->can_turn_in($this->session->user_id);

		$redirect_url = base_url() . 'dashboard';
		if ($can_turn_in && Carbon::now()->isMonday()) {
			$redirect_url .= '?prompt_turn_in=true';
		}

		redirect($redirect_url);
		exit;
	}

	public function enter()
	{
		//user posting login
		if ( $this->input->post(array('login', 'email', 'password')) )
		{
			$this->load->model('user_model', '', TRUE);
			$this->load->model('admin_model');
			$objUser = $this->user_model->login( $this->input->post('email'), $this->input->post('password'));

            log_message('debug', 'objuser ' . print_r($objUser, TRUE));
			if ( $objUser != null )
			{
				$this->session->nrmlstatus = 'Girildi';
				$this->session->nrmlkullanici = $objUser->email;
				$this->session->nrmluser_id = $objUser->id;
				$this->session->user_id = $objUser->id;
				$this->session->cfpname = current(explode(" ", $objUser->name_surname));
				$this->session->cfpfullname = $objUser->name_surname;
				$this->session->is_admin = $this->admin_model->is_admin($objUser->id);
			}

			redirect(base_url() . 'login?failed');
			exit();
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
		exit;
	}

	public function recover ()
	{
		if (!( $this->session->nrmlkullanici == "" && $this->session->nrmlstatus == "" ))
		{
			redirect(base_url() . 'dashboard');
			exit;
		}

		// Show form
		if (!$this->input->post('email') ) {
			$this->load->view('common/_header');
			$this->load->view('password_reset');
			return;
		}

		// Process POST
		$this->load->model('user_model', '', TRUE);
		$this->load->library('cfpslack_library');

		$user = $this->user_model->find_by_email($this->input->post('email'));

		if ($user)
		{
			// Compose email
			$message = $this->load->view(
				'password_recovery_email',
				[
					'name' => current(explode(" ", $user->name_surname)),
					'password' => $user->password,
				],
				TRUE
			);

			//$sent = mail($user->email, 'Your password for Academy', $message);
			//            log_message('debug', 'PASSWORD RECOVERY > ' . $message);
			$this->load->library('email');

			$this->email->from('CFPAcademy_server@fireprotected.com', 'CFPAcademy');
			$this->email->to($user->email);                                                                                                                                                         
			$this->email->subject('Your password for Academy');
			$this->email->message($message);

			$sent = $this->email->send();


			//            log_message('debug', 'PASSWORD RECOVERY > ' . $message);

			if (!$sent) {
				$message = "Failed to send password recovery email to user ". $user->id . "\n\n" . $message;
				$this->cfpslack_library->notify($message);
			}
		}

		redirect(base_url() . 'login/password_sent');
		exit();
	}

	public function password_sent()
	{
		if ( $this->session->nrmlkullanici == "" && $this->session->nrmlstatus == "" )
		{
			$this->load->view('common/_header');
			$this->load->view('password_sent');
			return;
		}

		redirect(base_url() . 'dashboard');
		exit;
	}

}
