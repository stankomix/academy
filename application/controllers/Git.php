<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Git extends CI_Controller {


	public function index()
	{
		//runs git
		log_message('debug', '[ GIT ] -------------- git fetch from bitbucket');
		$git_out = shell_exec("sudo -u jje -S git pull origin slack-overtime-requests 2>&1;");
		log_message('debug', '[ GIT ] -------------- git results: ' . print_r( $git_out, true ) );
	}

}
