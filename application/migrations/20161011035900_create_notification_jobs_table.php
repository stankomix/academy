<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_notification_jobs_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'execute_at' => array(
                'type' => 'DATETIME',
            ),
            'ran_at' => array(
                'type' => 'DATETIME',
            ),
            'job_type_id' => array(
                'type' => 'INT',
                'constraint' => '16',
                'unsigned' => TRUE,
            ),
            'completed' => array(
                'type' => 'TINYINT',
                'constraint' => '1',
                'unsigned' => TRUE,
                'default' => 0,
            ),
        ));

        $this->dbforge->create_table('notification_jobs');
    }

    public function down()
    {
        $this->dbforge->drop_table('notification_jobs');
    }
}
