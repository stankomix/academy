<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_bulletin_board_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'category' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'content' => array(
                'type' => TEXT,
            ),
            'create_date' => array(
                'type' => 'DATETIME',
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 1,
            ),
        ));

        $this->dbforge->create_table('bulletin_board');
    }

    public function down()
    {
        $this->dbforge->drop_table('bulletin_board');
    }
}
