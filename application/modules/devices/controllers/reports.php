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

		$this->auth->restrict('Devices.Reports.View');
		$this->load->model('devices_model', null, true);
		$this->lang->load('devices');
		
		Template::set_block('sub_nav', 'reports/_sub_nav');

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

		// Deleting anything?
		if (isset($_POST['delete']))
		{
			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				$result = FALSE;
				foreach ($checked as $pid)
				{
					$result = $this->devices_model->delete($pid);
				}

				if ($result)
				{
					Template::set_message(count($checked) .' '. lang('devices_delete_success'), 'success');
				}
				else
				{
					Template::set_message(lang('devices_delete_failure') . $this->devices_model->error, 'error');
				}
			}
		}

		$records = $this->devices_model->find_all();

		Template::set('records', $records);
		Template::set('toolbar_title', 'Manage Devices');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Creates a Devices object.
	 *
	 * @return void
	 */
	public function create()
	{
		$this->auth->restrict('Devices.Reports.Create');

		if (isset($_POST['save']))
		{
			if ($insert_id = $this->save_devices())
			{
				// Log the activity
				log_activity($this->current_user->id, lang('devices_act_create_record') .': '. $insert_id .' : '. $this->input->ip_address(), 'devices');

				Template::set_message(lang('devices_create_success'), 'success');
				redirect(SITE_AREA .'/reports/devices');
			}
			else
			{
				Template::set_message(lang('devices_create_failure') . $this->devices_model->error, 'error');
			}
		}
		Assets::add_module_js('devices', 'devices.js');

		Template::set('toolbar_title', lang('devices_create') . ' Devices');
		Template::render();
	}

	//--------------------------------------------------------------------


	/**
	 * Allows editing of Devices data.
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('devices_invalid_id'), 'error');
			redirect(SITE_AREA .'/reports/devices');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('Devices.Reports.Edit');

			if ($this->save_devices('update', $id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('devices_act_edit_record') .': '. $id .' : '. $this->input->ip_address(), 'devices');

				Template::set_message(lang('devices_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('devices_edit_failure') . $this->devices_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('Devices.Reports.Delete');

			if ($this->devices_model->delete($id))
			{
				// Log the activity
				log_activity($this->current_user->id, lang('devices_act_delete_record') .': '. $id .' : '. $this->input->ip_address(), 'devices');

				Template::set_message(lang('devices_delete_success'), 'success');

				redirect(SITE_AREA .'/reports/devices');
			}
			else
			{
				Template::set_message(lang('devices_delete_failure') . $this->devices_model->error, 'error');
			}
		}
		Template::set('devices', $this->devices_model->find($id));
		Template::set('toolbar_title', lang('devices_edit') .' Devices');
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
	private function save_devices($type='insert', $id=0)
	{
		if ($type == 'update')
		{
			$_POST['id'] = $id;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['name']        = $this->input->post('devices_name');
		$data['model']        = $this->input->post('devices_model');
		$data['image']        = $this->input->post('devices_image');
		$data['carrier']        = $this->input->post('devices_carrier');
		$data['firmware']        = $this->input->post('devices_firmware');
		$data['bootloader_exploit']        = $this->input->post('devices_bootloader_exploit');
		$data['partition_map']        = $this->input->post('devices_partition_map');
		$data['maintainers']        = $this->input->post('devices_maintainers');
		$data['actions']        = $this->input->post('devices_actions');
		$data['buildprop_id']        = $this->input->post('devices_buildprop_id');
		$data['buildprop_sw_id']        = $this->input->post('devices_buildprop_sw_id');

		if ($type == 'insert')
		{
			$id = $this->devices_model->insert($data);

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
			$return = $this->devices_model->update($id, $data);
		}

		return $return;
	}

	//--------------------------------------------------------------------


}