<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_performance_bonus_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(array(
            'user_id' => array(
				'type' => 'INT',
                'constraint' => 16,
                'unsigned' => TRUE,
            ),
            'workorder_id' => array(
				'type' => 'INT',
                'constraint' => 16,
                'unsigned' => TRUE,
            ),
            'billed' => array(
				'type' => 'VARCHAR',
                'constraint' => 64,
            ),
        ));

        $this->dbforge->create_table('performance_bonus');
    }

    public function down()
    {
        $this->dbforge->drop_table('performance_bonus');
    }
}
