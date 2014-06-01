<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * device_actions controller
 */
class device_actions extends Front_Controller
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
		$this->load->model('device_actions_model', null, true);
		$this->lang->load('device_actions');
		

		Assets::add_module_js('device_actions', 'device_actions.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{

		$records = $this->device_actions_model->find_all();

		Template::set('records', $records);
		Template::render();
	}

	//--------------------------------------------------------------------



}