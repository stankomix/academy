<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Migration_Add_timecard_submission_id_field_to_timesheets_table extends CI_Migration {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }
 
    public function up()
    {
        $this->dbforge->add_column('timesheets', [
            'timecard_submission_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'workorder_id',
            ),
        ]);
    }
 
    public function down()
    {
        $this->dbforge->drop_column('timesheets', 'timecard_submission_id');
    }
}
