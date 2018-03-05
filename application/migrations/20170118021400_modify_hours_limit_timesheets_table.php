<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Modify_hours_limit_timesheets_table extends CI_Migration
{

    public function up()
    {
        $this->dbforge->modify_column('timesheets', [
            'hours_limit' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ),
        ]);
    }

    public function down()
    {
        $this->dbforge->modify_column('timesheets', [
            'hours_limit' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ),
        ]);
    }

}
