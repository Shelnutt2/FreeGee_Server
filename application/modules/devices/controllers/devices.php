<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * devices controller
 */
class devices extends Front_Controller
{

	//--------------------------------------------------------------------


	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('devices_model', null, true);
		$this->lang->load('devices');
		

		Assets::add_module_js('devices', 'devices.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{

		$records = $this->devices_model->find_all();

		Template::set('records', $records);
		Template::render();
	}

	//--------------------------------------------------------------------



}