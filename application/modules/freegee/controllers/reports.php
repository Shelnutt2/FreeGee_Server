<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * reports controller
 */
class reports extends Admin_Controller
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

		$this->auth->restrict('FreeGee.Reports.View');
		$this->load->model('freegee_model', null, true);
		$this->lang->load('freegee');
		
		Template::set_block('sub_nav', 'reports/_sub_nav');

		Assets::add_module_js('freegee', 'freegee.js');
	}

	//--------------------------------------------------------------------


	/**
	 * Displays a list of form data.
	 *
	 * @return void
	 */
	public function index()
	{

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->freegee_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('freegee_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('freegee_delete_failure') . $this->freegee_model->error, 'error');
				}
			}
		}

		$records = $this->freegee_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage FreeGee');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a FreeGee object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('FreeGee.Reports.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_freegee())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('freegee_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'freegee');

				Template::set_message(lang('freegee_create_success'), 'success');
				redirect(SITE_AREA .'/reports/freegee');
			}
			else
			{
				Template::set_message(lang('freegee_create_failure') . $this->freegee_model->error, 'error');
			}
		}
		Assets::add_module_js('freegee', 'freegee.js');

		Template::set('toolbar_title', lang('freegee_create') . ' FreeGee');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of FreeGee data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('freegee_invalid_id'), 'error');
			redirect(SITE_AREA .'/reports/freegee');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('FreeGee.Reports.Edit');

			if ($this->save_freegee('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('freegee_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'freegee');

				Template::set_message(lang('freegee_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('freegee_edit_failure') . $this->freegee_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('FreeGee.Reports.Delete');

			if ($this->freegee_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('freegee_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'freegee');

				Template::set_message(lang('freegee_delete_success'), 'success');

				redirect(SITE_AREA .'/reports/freegee');
			}
			else
			{
				Template::set_message(lang('freegee_delete_failure') . $this->freegee_model->error, 'error');
			}
		}
		Template::set('freegee', $this->freegee_model->find($id));
		Template::set('toolbar_title', lang('freegee_edit') .' FreeGee');
		Template::render();
	}

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Summary
	 *
	 * @param String $type Either "insert" or "update"
	 * @param Int	 $id	The ID of the record to update, ignored on inserts
	 *
	 * @return Mixed    An INT id for successful inserts, TRUE for successful updates, else FALSE
	 */
	private function save_freegee($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['api_version']        = $this->input->post('freegee_api_version');
		$data['min_client']        = $this->input->post('freegee_min_client');

		if ($type == 'insert')
		{
			$id = $this->freegee_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			}
			else
			{
				$return = FALSE;
			}
		}
		elseif ($type == 'update')
		{
			$return = $this->freegee_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}