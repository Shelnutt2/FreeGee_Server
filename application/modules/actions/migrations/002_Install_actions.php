<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_actions extends Migration
{
	/**
	 * The name of the database table
	 *
	 * @var String
	 */
	private $table_name = 'actions';

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
		'description' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'minapiversion' => array(
			'type' => 'INT',
			'null' => FALSE,
		),
		'zipfile' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'zipfilelocation' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'md5sum' => array(
			'type' => 'VARCHAR',
			'constraint' => 32,
			'null' => FALSE,
		),
		'stockonly' => array(
			'type' => 'BOOL',
			'null' => FALSE,
		),
		'hidden' => array(
			'type' => 'BOOL',
			'null' => FALSE,
		),
		'swversions' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'androidsdkversion' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'priority' => array(
			'type' => 'INT',
			'null' => FALSE,
		),
		'dependencies' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'successmessage' => array(
			'type' => 'TEXT',
			'null' => FALSE,
		),
		'rebootrecovery' => array(
			'type' => 'BOOL',
			'null' => FALSE,
		),
		'betaonly' => array(
				'type' => 'BOOL',
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