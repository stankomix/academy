<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_admins_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 40,
            ),
            'last_login' => array(
                'type' => 'DATETIME',
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 1,
            ),
        ));

        $this->dbforge->create_table('admins');
    }

    public function down()
    {
        $this->dbforge->drop_table('admins');
    }
}
