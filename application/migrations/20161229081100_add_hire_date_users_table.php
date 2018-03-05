<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_hire_date_users_table extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('users', [
			'hire_date' => array(
                'type' => 'DATE',
                'null' => true,
                'default' => null,
            ),
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'hire_date');
    }

}
