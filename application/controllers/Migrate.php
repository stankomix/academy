<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Migrate extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
        $this->load->library('migration');
		is_cli() or die('Execute via command line: php index.php migrate' . PHP_EOL);
	}

	/**
	 * Migrates up to the latest version
	 *
	 * run with: php index.php migrate`
	 *
	 * @return void
	 */
	public function index()
	{
		$this->load->library('migration');

        if ($this->migration->latest() === FALSE)
        {
            show_error($this->migration->error_string());
        } else {
        	echo 'Migration(s) done' . PHP_EOL;
        }
	}

	/**
	 * Migrates up or down to specified version
	 *
	 * For example, to rollback all migrations run: php index.php migrate version 0
	 *
	 * @param string $version Version
	 * @return void
	 */
	public function version($version)
	{		
		$this->load->library('migration');
		$migration = $this->migration->version($version);

		if (!$migration) {
	    	echo $this->migration->error_string();
		} else {
	    	echo 'Migration(s) done' . PHP_EOL;
		}

	}

}
