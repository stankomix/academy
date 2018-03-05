<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller
{

	public function timeout_reminders()
	{
		$this->config->load('notifications');

		$this->load->model('user_model', '', TRUE);
		$this->load->model('timecard_model', '', TRUE);
		$this->load->model('clockout_notifications_model', '', TRUE);

		$this->load->library('sms_library');
		$this->load->library('clockout_library');
		$this->load->library('cfpslack_library');

		$this->clockout_library->run_checks();
	}

	/**
	 * Cron job run at the start of every month.
	 *
	 * @return void
	 */
	public function load_months_birthdays()
	{
		$this->load->model('user_model', '', TRUE);
		$this->load->model('bulletinboard_model');

		$users = $this->user_model->get_birthdays();

		foreach ($users as $user) {
			$this->bulletinboard_model->add_birthday(
				$user->name_surname,
				$user->birthday
			);
		}
	}

	/**
	 * Run every day at 8 am
	 *
	 * @return void
	 */
	public function new_hires()
	{
		$this->load->model('user_model', '', TRUE);
		$this->load->model('bulletinboard_model');

		$users = $this->user_model->new_hires();

		foreach ($users as $user) {

			$this->bulletinboard_model->add_hire(
				$user->name_surname,
				$user->hire_date
			);

		}
	}

	/**
	 * Run every day at 8 am
	 *
	 * @return void
	 */
	public function send_birthday_emails()
	{
		$this->load->model('user_model', '', TRUE);
		$this->load->library('cfpslack_library');

		$users = $this->user_model->users_with_birthdays_today();

		foreach ($users as $user) {

			// Compose email
			$message = $this->load->view(
				'birthday_email',
				[
					'name' => current(explode(" ", $user->name_surname)),
				],
				TRUE
			);

			$to = $user->email;
			$subject = 'Happy birthday, ' . current(explode(" ", $user->name_surname));

			// Set content-type header for sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

			// Additional headers
			$headers .= 'From: ' . $this->config->item('company_email') . "\r\n";

			// Send email
			$sent = mail($to, $subject, $message, $headers);

            if (!$sent) {
            	$message = "Failed to send birthday email to user ". $user->id;
				$this->cfpslack_library->notify($message);
            }
		}
	}

	/**
	 * Run every few minutes
	 *
	 * @return void
	 */
	public function send_queued_managers_sms_notifications()
	{
		$this->load->library('sms_library');
		$this->load->library('overtime_library');

		$this->sms_library->send_queued();
	}

}
