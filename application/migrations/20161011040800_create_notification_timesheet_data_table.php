<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_notification_timesheet_data_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'job_id' => array(
				'type' => 'INT',
                'constraint' => 16,
                'unsigned' => TRUE,
            ),
            'user_id' => array(
				'type' => 'INT',
                'constraint' => 16,
                'unsigned' => TRUE,
            ),
            'timecard_id' => array(
				'type' => 'INT',
                'constraint' => 16,
                'unsigned' => TRUE,
            ),
            'workorder_id' => array(
				'type' => 'INT',
                'constraint' => 16,
                'unsigned' => TRUE,
            ),
        ));

        $this->dbforge->create_table('notification_timesheet_data');
    }

    public function down()
    {
        $this->dbforge->drop_table('notification_timesheet_data');
    }
}
