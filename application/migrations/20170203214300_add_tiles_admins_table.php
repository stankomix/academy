<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_tiles_admins_table extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('admins', [
            'tiles' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ),
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('admins', 'tiles');
    }

}
