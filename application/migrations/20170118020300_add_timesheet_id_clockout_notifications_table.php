<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_timesheet_id_clockout_notifications_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('clockout_notifications', [
			'timesheet_id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'after' => 'notification_name',
                'null' => true,
            ),
        ]);

 		$this->dbforge->drop_column('clockout_notifications', 'workorder_id');
    }

    public function down()
    {
        $this->dbforge->drop_column('clockout_notifications', 'timesheet_id');

        $this->dbforge->add_field(array(
			'workorder_id' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
        ));
    }
}
