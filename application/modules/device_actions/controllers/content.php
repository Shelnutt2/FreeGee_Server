<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * content controller
 */
class content extends Admin_Controller
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

		$this->auth->restrict('Device_Actions.Content.View');
		$this->load->model('device_actions_model', null, true);
		$this->lang->load('device_actions');
		
		Template::set_block('sub_nav', 'content/_sub_nav');

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

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->device_actions_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('device_actions_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('device_actions_delete_failure') . $this->device_actions_model->error, 'error');
				}
			}
		}

		$records = $this->device_actions_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Device Actions');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Device Actions object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Device_Actions.Content.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_device_actions())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('device_actions_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'device_actions');

				Template::set_message(lang('device_actions_create_success'), 'success');
				redirect(SITE_AREA .'/content/device_actions');
			}
			else
			{
				Template::set_message(lang('device_actions_create_failure') . $this->device_actions_model->error, 'error');
			}
		}
		Assets::add_module_js('device_actions', 'device_actions.js');

		Template::set('toolbar_title', lang('device_actions_create') . ' Device Actions');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Device Actions data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('device_actions_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/device_actions');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Device_Actions.Content.Edit');

			if ($this->save_device_actions('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('device_actions_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'device_actions');

				Template::set_message(lang('device_actions_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('device_actions_edit_failure') . $this->device_actions_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Device_Actions.Content.Delete');

			if ($this->device_actions_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('device_actions_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'device_actions');

				Template::set_message(lang('device_actions_delete_success'), 'success');

				redirect(SITE_AREA .'/content/device_actions');
			}
			else
			{
				Template::set_message(lang('device_actions_delete_failure') . $this->device_actions_model->error, 'error');
			}
		}
		Template::set('device_actions', $this->device_actions_model->find($id));
		Template::set('toolbar_title', lang('device_actions_edit') .' Device Actions');
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
	private function save_device_actions($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['device_model']        = $this->input->post('device_actions_device_model');
		$data['device_name']        = $this->input->post('device_actions_device_name');
		$data['action_id']        = $this->input->post('device_actions_action_id');
		$data['action_name']        = $this->input->post('device_actions_action_name');

		if ($type == 'insert')
		{
			$id = $this->device_actions_model->insert($data);

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
			$return = $this->device_actions_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}