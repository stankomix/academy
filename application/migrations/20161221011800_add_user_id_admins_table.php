<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_user_id_admins_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('admins', [
			'user_id' => array(
                'type' => 'INT',
                'constraint' => 10,
                'after' => 'id',
            ),
        ]);

 		$this->dbforge->drop_column('admins', 'email');

 		$this->dbforge->drop_column('admins', 'password');
    }

    public function down()
    {
        $this->dbforge->drop_column('admins', 'user_id');

        $this->dbforge->add_field(array(
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => 40,
            ),
        ));
    }
}
