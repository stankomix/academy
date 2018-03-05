<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_bb_photos_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'bb_id' => array(
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

        $this->dbforge->create_table('bb_photos');
    }

    public function down()
    {
        $this->dbforge->drop_table('bb_photos');
    }
}
