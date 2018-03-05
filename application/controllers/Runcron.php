<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Runcron extends CI_Controller
{

	public function index()
	{
		$endpoint = $this->config->item('base_url') . 'Cron/timeout_reminders';

		//Initialize CURL, setup, and send data.
		$ch = curl_init($endpoint);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		curl_close($ch);
	}

}
