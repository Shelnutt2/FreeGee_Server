<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_devices extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'devices';

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
		'name' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'model' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'image' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'carrier' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'firmware' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'bootloader_exploit' => array(
			'type' => 'INT',
			'null' => FALSE,
		),
		'partition_map' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'maintainers' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'actions' => array(
			'type' => 'BOOL',
			'null' => FALSE,
		),
		'buildprop_id' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'buildprop_sw_id' => array(
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