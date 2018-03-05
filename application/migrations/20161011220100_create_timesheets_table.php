<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_timesheets_table extends CI_Migration
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
            'start_hour' => array(
                'type' => 'VARCHAR',
                'constraint' => 10,
            ),
            'start_min' => array(
                'type' => 'VARCHAR',
                'constraint' => 10,
            ),
            'start_pmam' => array(
                'type' => 'VARCHAR',
                'constraint' => 10,
            ),
            'stop_hour' => array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
                'default' => null,
            ),
            'stop_min' => array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
                'default' => null,
            ),
            'stop_pmam' => array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
                'default' => null,
            ),
            'date' => array(
                'type' => 'DATE',
            ),
            'submit_time' => array(
                'type' => 'DATETIME',
            ),
        ));

        $this->dbforge->create_table('timesheets');
    }

    public function down()
    {
        $this->dbforge->drop_table('timesheets');
    }
}
