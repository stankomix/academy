<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_test_questions_table extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field('id');

        $this->dbforge->add_field(array(
            'test_id' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'question' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
			'options' => array(
                'type' => 'TEXT'
            ),
            'correct_answer' => array(
                'type' => 'VARCHAR',
                'constraint' => 255,
            ),
            
            'status' => array(
                'type' => 'INT',
                'constraint' => 1,
            ),
        ));

        $this->dbforge->create_table('test_questions');
    }

    public function down()
    {
        $this->dbforge->drop_table('test_questions');
    }
}
