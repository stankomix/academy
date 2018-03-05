<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_photos_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'file_id' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'large_url' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'small_url' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'description' => array(
                'type' => 'TEXT',
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 1,
            ),
        ));

        $this->dbforge->create_table('photos');
    }

    public function down()
    {
        $this->dbforge->drop_table('photos');
    }
}
