<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_tests_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'test_type' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'mandatory' => array(
                'type' => 'INT',
                'constraint' => 1,
            ),
            'create_date' => array(
                'type' => 'DATETIME',
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 1,
            ),
        ));

        $this->dbforge->create_table('tests');
    }

    public function down()
    {
        $this->dbforge->drop_table('tests');
    }
}
