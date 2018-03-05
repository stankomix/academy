<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_clockout_notifications_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(

            'user_id' => array(
                'type' => 'INT',
                'constraint' => 10,
            ),

            'workorder_id' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),

            'notification_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),

			'created_at timestamp NULL DEFAULT current_timestamp',

        ));

        $this->dbforge->create_table('clockout_notifications');
    }

    public function down()
    {
        $this->dbforge->drop_table('clockout_notifications');
    }
}
