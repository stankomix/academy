<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_payrate_users_table extends CI_Migration
{
    public function up()
    {
		$this->dbforge->add_column('users', array('payrate' => array('type' => 'DECIMAL', 'constraint' => '5,2', 'null' => TRUE) ) );
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'payrate');
    }
}
