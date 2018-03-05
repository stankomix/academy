<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_driving_time_timesheets_table extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('timesheets', [
            'driving_time' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
                'default' => 0,
            ),
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('timesheets', 'driving_time');
    }

}
