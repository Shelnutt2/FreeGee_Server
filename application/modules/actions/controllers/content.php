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

		$this->auth->restrict('Actions.Content.View');
		$this->load->model('actions_model', null, true);
		$this->lang->load('actions');
		
		Template::set_block('sub_nav', 'content/_sub_nav');

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

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->actions_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('actions_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('actions_delete_failure') . $this->actions_model->error, 'error');
				}
			}
		}

		$records = $this->actions_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Actions');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Actions object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Actions.Content.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_actions())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('actions_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'actions');

				Template::set_message(lang('actions_create_success'), 'success');
				redirect(SITE_AREA .'/content/actions');
			}
			else
			{
				Template::set_message(lang('actions_create_failure') . $this->actions_model->error, 'error');
			}
		}
		Assets::add_module_js('actions', 'actions.js');

		Template::set('toolbar_title', lang('actions_create') . ' Actions');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Actions data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('actions_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/actions');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Actions.Content.Edit');

			if ($this->save_actions('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('actions_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'actions');

				Template::set_message(lang('actions_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('actions_edit_failure') . $this->actions_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Actions.Content.Delete');

			if ($this->actions_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('actions_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'actions');

				Template::set_message(lang('actions_delete_success'), 'success');

				redirect(SITE_AREA .'/content/actions');
			}
			else
			{
				Template::set_message(lang('actions_delete_failure') . $this->actions_model->error, 'error');
			}
		}
		Template::set('actions', $this->actions_model->find($id));
		Template::set('toolbar_title', lang('actions_edit') .' Actions');
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
	private function save_actions($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		$dependencies = array();
		$data = array();
		$data['name']        = $this->input->post('actions_name');
		$data['description']        = $this->input->post('actions_description');
		$data['minapiversion']        = $this->input->post('actions_minapiversion');
		$data['zipfile']        = $this->input->post('actions_zipfile');
		$data['zipfilelocation']        = $this->input->post('actions_zipfilelocation');
		$data['md5sum']        = $this->input->post('actions_md5sum');
		$data['stockonly']        = $this->input->post('actions_stockonly');
		$data['hidden']        = $this->input->post('actions_hidden');
		$data['priority']        = $this->input->post('actions_priority');
		$data['dependencies']        = $this->setBooleanDependencies($this->input->post('actions_dependencies'));
		$data['successmessage']        = $this->input->post('actions_successmessage');
		$data['rebootrecovery']        = $this->input->post('actions_rebootrecovery');

		if ($type == 'insert')
		{
			$id = $this->actions_model->insert($data);

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
			$return = $this->actions_model->update($id, $data);
		}
		if(is_numeric($id)){
			echo "calling setDependencies".PHP_EOL;
			$this->actions_model->setDependencies($id,$dependencies);
		}
		else
			echo "id wasn't numeric";
		
		return $return;
	}

	//--------------------------------------------------------------------

	private function setBooleanDependencies($action_dependencies){
		if(is_bool($action_dependencies)){
			echo "Actions depends is a boolean".PHP_EOL;
			return $action_dependencies;
		}
		else{
			echo "Actions depends is an array".PHP_EOL;
			if(empty($action_dependencies)){ #Array should never return empty but checking anyway
				echo "Actions depends is empty array".PHP_EOL;
				return 0;
			}
			else{
				$dependencies = $action_dependencies;
				return 1;
			}
		}
	}
}