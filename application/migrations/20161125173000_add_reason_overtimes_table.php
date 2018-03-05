<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_reason_overtimes_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_column('overtimes', [
            'reason' => array(
                'type' => 'TEXT',
                'null' => false,
            ),
        ]);
    }

    public function down()
    {
        $this->dbforge->drop_column('overtimes', 'reason');
    }
}
