<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_test_offline_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'test_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'test_date' => array(
                'type' => 'DATE',
            ),
            'hour' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'minute' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'pmam' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'score' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'create_date' => array(
                'type' => 'DATETIME',
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 1,
            ),
        ));

        $this->dbforge->create_table('test_offline');
    }

    public function down()
    {
        $this->dbforge->drop_table('test_offline');
    }
}
