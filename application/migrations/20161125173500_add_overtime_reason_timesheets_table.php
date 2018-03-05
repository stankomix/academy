<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_overtime_reason_timesheets_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('timesheets', [
            'overtime_reason' => array(
                'type' => 'TEXT',
                'null' => true,
            ),
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('timesheets', 'overtime_reason');
    }
}
