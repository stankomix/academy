<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_notification_types_table extends CI_Migration
{
    public function up()
    {
		$this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'type' => array(
				'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'php_file' => array(
				'type' => 'VARCHAR',
                'constraint' => 255,
            ),
        ));

        $this->dbforge->create_table('notification_types');
    }

    public function down()
    {
        $this->dbforge->drop_table('notification_types');
    }
}
