<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_employee_position_id_users_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('users', [
            'employee_position_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ),
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'employee_position_id');
    }
}
