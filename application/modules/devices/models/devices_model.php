<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Devices_model extends BF_Model {

	protected $table_name	= "devices";
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
			"field"		=> "devices_name",
			"label"		=> "Name",
			"rules"		=> "required"
		),
		array(
			"field"		=> "devices_model",
			"label"		=> "Model Number",
			"rules"		=> "required|unique[bf_devices.model,bf_devices.id]"
		),
		array(
			"field"		=> "devices_image",
			"label"		=> "Device Image",
			"rules"		=> ""
		),
		array(
			"field"		=> "devices_carrier",
			"label"		=> "Carrier",
			"rules"		=> "required"
		),
		array(
			"field"		=> "devices_firmware",
			"label"		=> "Stock Software Version",
			"rules"		=> ""
		),
		array(
			"field"		=> "devices_bootloader_exploit",
			"label"		=> "Bootloader Exploit",
			"rules"		=> ""
		),
		array(
			"field"		=> "devices_partition_map",
			"label"		=> "Partition Map",
			"rules"		=> ""
		),
		array(
			"field"		=> "devices_maintainers",
			"label"		=> "Freegee Maintainers",
			"rules"		=> "required"
		),
		array(
			"field"		=> "devices_actions",
			"label"		=> "Actions",
			"rules"		=> ""
		),
		array(
			"field"		=> "devices_buildprop_id",
			"label"		=> "Build.prop Device ID",
			"rules"		=> "required"
		),
		array(
			"field"		=> "devices_buildprop_sw_id",
			"label"		=> "Build.prop Software ID",
			"rules"		=> ""
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------
	
	/**
	 * Finds an individual device.
	 *
	 * @access public
	 *
	 * @param string $id A string with the device model.
	 *
	 * @return bool|object An object with the device.
	 */
	public function find_by_model($model=null)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name . '.*, model');
		}
	
		return parent::find_by('model',$model,'and');
	
	}//end find_by_id()
	
	/**
	 * Finds an individual device.
	 *
	 * @access public
	 *
	 * @param string $name A String with the device name.
	 *
	 * @return bool|object An object with the device.
	 */
	public function find_by_name($name=null)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name . '.*, name');
		}
	
		return parent::find_by('name',$name,'and');
	
	}//end find_by_name()
	
	/**
	 * Finds an individual device.
	 *
	 * @access public
	 *
	 * @param int id An ID with the device id.
	 *
	 * @return bool|object An object with the device.
	 */
	public function find_by_id($id=null)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name . '.*, id');
		}
	
		return parent::find_by('id',$id,'and');
	
	}//end find_by_id()
	
	/**
	 * Finds all actions
	 * @see BF_Model::find_all()
	 *
	 * @access public
	 *
	 * @param none
	 *
	 * @return bool|object An object of all actions
	 */
	public function find_all()
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name . '.*, model');
		}
		return parent::find_all();
	
	}//end find_by_name()
	
	public function find_all_names(){
		if (empty($this->selects))
		{
			$this->select($this->table_name . '.*, name');
		}
		$array = parent::find_all();
		$array = json_decode(json_encode($array), true);
		$namesarray = array();
		foreach($array as $action){
			$namesarray[$action['model']] = $action['name'];
		}
		return $namesarray;
	}
	
	public function setActions($model,&$actions){
		$device = json_decode(json_encode($this->find_by_model($model)), true);
		$this->load->model('device_actions/device_actions_model');
		var_dump($model);
		return $this->device_actions_model->setActions($device,$actions);
	}
	
	public function get_actions_by_model($model=null){
		$this->load->model('device_actions/device_actions_model');
		return $this->device_actions_model->find_by_model($model);
	}
	
	public function get_actions_by_name($name=null)
	{
		$this->load->model('device_actions/device_actions_model');
		return $this->device_actions_model->find_by_name($name);
	}//end find_by_name()
	
	public function setParentDeviceForExport(&$device){
		if($device->parent_device != 0){
			$parent = $this->find_by_id($device->parent_device);
			$device->parent_device = $parent;
		}
	}
	
	public function getActions(&$device){
		if($device->actions == 0)
			return;
		$this->load->model('device_actions/device_actions_model');
		$this->load->model('actions/actions_model');
		$actions = $this->device_actions_model->find_by_model($device->model);
		//error_log(var_dump($actions));
		$actions_array = array();
		foreach($actions as $action){
			$action_object = $this->actions_model->find_by_id($action->action_id);
			$actions_array[$action_object->name] = $action_object;
		}
		
		$device->actions = $actions_array;
	}
	
	public function matchDevice($build_prop){
	
		$devices = parent::find_all();
		foreach($devices as $key => $value){
			$ids = explode(',',$value->buildprop_id);
			$buildProp_ids = array();
			
			foreach ($ids as $line) {
				$line = explode('=', $line);
				$buildProp_ids[trim(array_shift($line))] = trim(array_shift($line));
			}
//			error_log(var_dump($value));
//			error_log(var_dump($ids));
//			error_log(var_dump($buildProp_ids));
			$count = 0;
//			error_log("here");
			foreach($buildProp_ids as $id => $id_value){
//				error_log("looking");
//				error_log("id: $id");
//				error_log("id_value: $id_value");
//				error_log("posted: ".$build_prop[str_replace('.','_',$id)]);
//				error_log("posted_id: ".str_replace('.','_',$id));
				if(array_key_exists(str_replace('.','_',$id),$build_prop) && strcasecmp($build_prop[str_replace('.','_',$id)],$id_value) == 0){
//					error_log("matched");
					$count++;
				}
			}
			if($count >= 2){
				$device = $devices[$key];
				$this->setParentDeviceForExport($device);
				$this->getActions($device);
				return $device;
			}
		}
		
		return null;
	}
	
	/**
	 *
	 * @param string $fieldName Name of the checkbox or radio buttons field
	 * @param array $labelsArray labels array
	 * @param array $selectedOption labels which are prechecked
	 * @param string $fieldType Specify if its 'checkbox' or 'radio'
	 * @param array $valuesArray Option values array, if not given values will be labels
	 * @return string
	 */
	function createOptions($fieldName, $labelsArray=array(), $selectedOption, $fieldType,$valuesArray = array()) {
		$returnString = '';
		$valuesArray = array_values($valuesArray);
		$labelsArray = array_values($labelsArray);
		if(count($valuesArray)!=count($labelsArray))
			$valuesArray=$labelsArray;
		if ($fieldType === 'checkbox') {
			for ($i=0;$i<count($labelsArray);$i++) {
				$returnString.='<label for="'.$valuesArray[$i].'">';
				$returnString.='&nbsp&nbsp&nbsp<input type="checkbox" name=' . $fieldName.' value='.$valuesArray[$i].' id='.$valuesArray[$i].' ';
				if(in_array($valuesArray[$i], $selectedOption)){
					$returnString.=' checked="checked" ';
				}
				$returnString.='/>&nbsp'.$labelsArray[$i].'</label>';
			}
		}
		if ($fieldType === 'radio') {
			for ($i=0;$i<count($labelsArray);$i++) {
				$returnString.='&nbsp&nbsp<input type="radio" name=' . $fieldName.' value='.$valuesArray[$i].' id='.$valuesArray[$i];
				if($valuesArray[$i]== $selectedOption)
					$returnString.=' checked="checked" ';
				$returnString.=' /><label>'.$labelsArray[$i].'</label>';
			}
		}
		return $returnString;
	}
}
