<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_pay_period_timecard_submissions_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('timecard_submissions', [
            'pay_period_number' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ),
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('timecard_submissions', 'pay_period_number');
    }
}
