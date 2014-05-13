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

		$this->auth->restrict('Action_Dependencies.Content.View');
		$this->load->model('action_dependencies_model', null, true);
		$this->lang->load('action_dependencies');
		
		Template::set_block('sub_nav', 'content/_sub_nav');

		Assets::add_module_js('action_dependencies', 'action_dependencies.js');
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
					$result = $this->action_dependencies_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('action_dependencies_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('action_dependencies_delete_failure') . $this->action_dependencies_model->error, 'error');
				}
			}
		}

		$records = $this->action_dependencies_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Action Dependencies');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Action Dependencies object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Action_Dependencies.Content.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_action_dependencies())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('action_dependencies_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'action_dependencies');

				Template::set_message(lang('action_dependencies_create_success'), 'success');
				redirect(SITE_AREA .'/content/action_dependencies');
			}
			else
			{
				Template::set_message(lang('action_dependencies_create_failure') . $this->action_dependencies_model->error, 'error');
			}
		}
		Assets::add_module_js('action_dependencies', 'action_dependencies.js');

		Template::set('toolbar_title', lang('action_dependencies_create') . ' Action Dependencies');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Action Dependencies data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('action_dependencies_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/action_dependencies');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Action_Dependencies.Content.Edit');

			if ($this->save_action_dependencies('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('action_dependencies_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'action_dependencies');

				Template::set_message(lang('action_dependencies_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('action_dependencies_edit_failure') . $this->action_dependencies_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Action_Dependencies.Content.Delete');

			if ($this->action_dependencies_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('action_dependencies_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'action_dependencies');

				Template::set_message(lang('action_dependencies_delete_success'), 'success');

				redirect(SITE_AREA .'/content/action_dependencies');
			}
			else
			{
				Template::set_message(lang('action_dependencies_delete_failure') . $this->action_dependencies_model->error, 'error');
			}
		}
		Template::set('action_dependencies', $this->action_dependencies_model->find($id));
		Template::set('toolbar_title', lang('action_dependencies_edit') .' Action Dependencies');
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
	private function save_action_dependencies($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['base_id']        = $this->input->post('action_dependencies_base_id');
		$data['base_name']        = $this->input->post('action_dependencies_base_name');
		$data['dependency_id']        = $this->input->post('action_dependencies_dependency_id');
		$data['dependency_name']        = $this->input->post('action_dependencies_dependency_name');

		if ($type == 'insert')
		{
			$id = $this->action_dependencies_model->insert($data);

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
			$return = $this->action_dependencies_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}