<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Device_actions_model extends BF_Model {

	protected $table_name	= "device_actions";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";

	protected $log_user 	= FALSE;

	protected $set_created	= false;
	protected $set_modified = false;

	/*
		Customize the operations of the model without recreating the insert, update,
		etc methods by adding the method names to act as callbacks here.
	 */
	protected $before_insert 	= array();
	protected $after_insert 	= array();
	protected $before_update 	= array();
	protected $after_update 	= array();
	protected $before_find 		= array();
	protected $after_find 		= array();
	protected $before_delete 	= array();
	protected $after_delete 	= array();

	/*
		For performance reasons, you may require your model to NOT return the
		id of the last inserted row as it is a bit of a slow method. This is
		primarily helpful when running big loops over data.
	 */
	protected $return_insert_id 	= TRUE;

	// The default type of element data is returned as.
	protected $return_type 			= "object";

	// Items that are always removed from data arrays prior to
	// any inserts or updates.
	protected $protected_attributes = array();

	/*
		You may need to move certain rules (like required) into the
		$insert_validation_rules array and out of the standard validation array.
		That way it is only required during inserts, not updates which may only
		be updating a portion of the data.
	 */
	protected $validation_rules 		= array(
		array(
			"field"		=> "device_actions_device_model",
			"label"		=> "Device Model"
		),
		array(
			"field"		=> "device_actions_device_name",
			"label"		=> "Device Name"
		),
		array(
			"field"		=> "device_actions_action_id",
			"label"		=> "Action ID"
		),
		array(
			"field"		=> "device_actions_action_name",
			"label"		=> "Action Name"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	
	public function setActions(&$device,&$actions){
		if(!is_array($device)){
			return false;
		}
		$model = $device['model'];
		//First check to see if this action already has a list of dependecies
		$currentActions = $this->find_by_model($model);
		if($currentActions){
			$currentActions = json_decode(json_encode($currentActions), true);
			//If the action does have dependencies check to see if any differ from whats already in the database
			if(!empty($currentActions)){
				foreach($currentActions as $Action_key => $Action_value){
					$index = array_search($Action_value["action_name"], $actions);
					if($index)
						unset($actions[$index]);
					else{
						//drop the current dependency from the table it's no longer there
						$where = array("device_model"=>$model,"action_name"=>$Action_value["action_name"]);
						$this->delete_where($where);
					}
				}
			}
		}
		foreach($actions as $action){
			echo "Looping through actions".PHP_EOL;
			$this->load->model('actions/actions_model');
			$ActionArray = json_decode(json_encode($this->actions_model->find_by_name($action)), true);
			$dataArray = array();
			$dataArray['device_model'] = $model;
			$dataArray['device_name'] = $device['name'];
			$dataArray['action_id'] = $ActionArray['id'];
			$dataArray['action_name'] = $ActionArray['name'];
			$this->device_actions_model->insert($dataArray);
		}
	}
	
	/**
	 * Finds an individual device actions by name.
	 *
	 * @access public
	 *
	 * @param String $name An String with the devices' name.
	 *
	 * @return bool|object An object with the action.
	 */
	public function find_by_name($name=null)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name . '.*, device_name');
		}
		return parent::find_all_by('device_name',$name,'and');
	}//end find_dependencies_by_name()
	
	/**
	 * Finds an individual device actions by model.
	 *
	 * @access public
	 *
	 * @param int $baseid An INT with the device model.
	 *
	 * @return bool|object An object with the action.
	 */
	public function find_by_model($model=null)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name . '.*, device_model');
		}
		return parent::find_all_by('device_model',$model,'and');
	}//end find_dependencies_by_name()
}
