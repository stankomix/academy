<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_overtimes_table extends CI_Migration
{
    public function up()
    {
		$this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'user_id' => array(
				'type' => 'INT',
                'constraint' => 11,
            ),
            'workorder_id' => array(
				'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            'start_hour' => array(
				'type' => 'VARCHAR',
                'constraint' => 10,
            ),
            'start_min' => array(
				'type' => 'VARCHAR',
                'constraint' => 10,
            ),
            'start_pmam' => array(
				'type' => 'VARCHAR',
                'constraint' => 10,
            ),
            'timecard_date' => array(
				'type' => 'DATE',
            ),
            'requested timestamp NULL DEFAULT current_timestamp',
        ));

        $this->dbforge->create_table('overtimes');
    }

    public function down()
    {
        $this->dbforge->drop_table('overtimes');
    }
}
