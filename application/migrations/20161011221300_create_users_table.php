<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_users_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'name_surname' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'job' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'birthday' => array(
                'type' => 'DATE',
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'default' => null,
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 1,
            ),
        ));

        $this->dbforge->create_table('users');
    }

    public function down()
    {
        $this->dbforge->drop_table('users');
    }
}
