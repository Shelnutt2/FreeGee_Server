<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_device_actions extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'device_actions';

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
		'device_model' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'device_name' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'action_id' => array(
			'type' => 'INT',
			'null' => FALSE,
		),
		'action_name' => array(
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