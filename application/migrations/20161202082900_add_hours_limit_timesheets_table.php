<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_hours_limit_timesheets_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('timesheets', [
            'hours_limit' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ),
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('timesheets', 'hours_limit');
    }
}
