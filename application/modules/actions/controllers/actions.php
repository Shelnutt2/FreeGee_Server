<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * actions controller
 */
class actions extends Front_Controller
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
		$this->load->model('actions_model', null, true);
		$this->lang->load('actions');
		

		Assets::add_module_js('actions', 'actions.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{

		$records = $this->actions_model->find_all();

		Template::set('records', $records);
		Template::render();
	}

	//--------------------------------------------------------------------



}