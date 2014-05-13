<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_action_dependencies extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'action_dependencies';

	/**
	 * The table's fields
	 *
	 * @var Array
	 */
	private $fields = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 11,
			'auto_increment' => TRUE,
		),
		'base_id' => array(
			'type' => 'INT',
			'null' => FALSE,
		),
		'base_name' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'dependency_id' => array(
			'type' => 'INT',
			'null' => FALSE,
		),
		'dependency_name' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
	);

	/**
	 * Install this migration
	 *
	 * @return void
	 */
	public function up()
	{
		$this->dbforge->add_field($this->fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table($this->table_name);
	}

	//--------------------------------------------------------------------

	/**
	 * Uninstall this migration
	 *
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_table($this->table_name);
	}

	//--------------------------------------------------------------------

}