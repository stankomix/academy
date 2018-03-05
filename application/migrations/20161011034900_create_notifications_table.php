<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_notifications_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'timesheet_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'sent' => array(
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => true,
                'default' => 0,
            ),
            'notification_type_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'created_at timestamp NULL DEFAULT current_timestamp',
            'sent_at' => array(
            	'type' => 'TIMESTAMP',
                'null' => true,
            ),
        ));

        $this->dbforge->create_table('notifications');
    }

    public function down()
    {
        $this->dbforge->drop_table('notifications');
    }
}
