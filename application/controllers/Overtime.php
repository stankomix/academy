<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Overtime extends CI_Controller{

	/**
	 * Processes responses from the Slack service to an overtime request
	 *
	 * @return void
	 */
	public function response_to_request()
	{
		$this->load->library('overtime_library');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->form_validation->set_rules('request', 'Request ID', 'required');
		$this->form_validation->set_rules('decision', 'Decision', 'required');
		$this->form_validation->set_rules('token', 'Token', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->output->set_status_header(422);
			return;
		}

		log_message('debug', 'Slack dispatch received. Not authenticated yet');

		if ($this->input->post('token') !== $this->config->item('cfpslack_token')) {
			$this->output->set_status_header(403);
			return;
		}

		log_message('debug', 'Slack dispatch received. Authenticated');

		if ($this->input->post('decision') == 'approve') {

			$this->form_validation->set_rules('hours', 'Hours', 'required|integer');			

			if ($this->form_validation->run() == FALSE)
			{
				$this->output->set_status_header(422);
				return;
			}

		}

		$this->overtime_library->process_response(
			$this->input->post('request'),
			$this->input->post('decision'),
			$this->input->post('hours') ?: null
		);
	}
}
