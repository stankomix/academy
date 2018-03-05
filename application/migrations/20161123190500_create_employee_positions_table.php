<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_employee_positions_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(

            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),

        ));

        $this->dbforge->create_table('employee_positions');
    }

    public function down()
    {
        $this->dbforge->drop_table('employee_positions');
    }
}
