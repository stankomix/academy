<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_files_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'file_name' => array(
                'type' => 'TEXT',
            ),

            'file_type' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'file_size' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'embed_code' => array(
                'type' => 'TEXT',
            ),
            'category' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'clicks' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'create_date' => array(
                'type' => 'DATETIME',
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 1,
            ),
        ));

        $this->dbforge->create_table('files');
    }

    public function down()
    {
        $this->dbforge->drop_table('files');
    }
}
