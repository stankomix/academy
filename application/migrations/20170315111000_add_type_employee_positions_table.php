<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_type_employee_positions_table extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('employee_positions', [
            'type' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ),
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('employee_positions', 'type');
    }

}
