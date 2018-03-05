<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_managers_sms_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'sms' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'job' => array(
                'type' => 'VARCHAR',
                'constraint' => 40,
                'null' => true
            ),
            'sent' => array(
                'type' => 'INT',
                'constraint' => 1,
                'null' => true,
                'default' => 0
            ),
            'created_at timestamp NULL DEFAULT current_timestamp',
        ));

        $this->dbforge->create_table('managers_sms');
    }

    public function down()
    {
        $this->dbforge->drop_table('managers_sms');
    }
}
