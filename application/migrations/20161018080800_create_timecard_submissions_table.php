<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_timecard_submissions_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(

            'user_id' => array(
                'type' => 'INT',
                'constraint' => 10,
            ),

            'user_signature' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),

            'submit_time' => array(
                'type' => 'DATETIME',
            ),

        ));

        $this->dbforge->create_table('timecard_submissions');
    }

    public function down()
    {
        $this->dbforge->drop_table('timecard_submissions');
    }
}
