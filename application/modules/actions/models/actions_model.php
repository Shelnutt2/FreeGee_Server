<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Actions_model extends BF_Model {

	protected $dependecies_table_name = "action_dependencies";
	protected $table_name	= "actions";
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
			"field"		=> "actions_name",
			"label"		=> "Name",
			"rules"		=> "required"
		),
		array(
			"field"		=> "actions_description",
			"label"		=> "Description",
			"rules"		=> "required"
		),
		array(
			"field"		=> "actions_minapiversion",
			"label"		=> "Minimum API Version",
			"rules"		=> "required|is_natural"
		),
		array(
			"field"		=> "actions_zipfile",
			"label"		=> "Zip File Name",
			"rules"		=> "required"
		),
		array(
			"field"		=> "actions_zipfilelocation",
			"label"		=> "Zip File Location",
			"rules"		=> "required"
		),
		array(
			"field"		=> "actions_md5sum",
			"label"		=> "md5sum",
			"rules"		=> "required|max_length[32]"
		),
		array(
			"field"		=> "actions_stockonly",
			"label"		=> "Stock Only",
			"rules"		=> "required"
		),
		array(
			"field"		=> "actions_hidden",
			"label"		=> "Hidden",
			"rules"		=> "required"
		),
		array(
			"field"		=> "actions_priority",
			"label"		=> "Priority",
			"rules"		=> "required|integer"
		),
		array(
			"field"		=> "actions_dependencies",
			"label"		=> "Action Dependencies",
		),
		array(
			"field"		=> "actions_successmessage",
			"label"		=> "Success Message",
		),
		array(
			"field"		=> "actions_rebootrecovery",
			"label"		=> "Reboot to Recovery Required for action",
			"rules"		=> "required"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------

	public function objectToArray($d) {
		if (is_object($d)) {
			// Gets the properties of the given object
			// with get_object_vars function
			$d = get_object_vars($d);
		}
	
		if (is_array($d)) {
			/*
			 * Return array converted to object
			* Using __FUNCTION__ (Magic constant)
			* for recursive call
			*/
			return array_map(__FUNCTION__, $d);
		}
		else {
			// Return array
			return $d;
		}
	}
	
	/**
	 * Finds an individual action.
	 *
	 * @access public
	 *
	 * @param int $id An INT with the acions id.
	 *
	 * @return bool|object An object with the action.
	 */
	public function find_by_id($id=null)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name . '.*, id');
		}
	
		return parent::find($id);
	
	}//end find_by_id()
	
	/**
	 * Finds an individual action.
	 *
	 * @access public
	 *
	 * @param int $id An INT with the acions id.
	 *
	 * @return bool|object An object with the action.
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
			$this->select($this->table_name . '.*, name');
		}
	
		return parent::find_all();
	
	}//end find_by_name()
	
	public function get_dependencies_by_id($id=null){
		
		if (empty($this->selects))
		{
			$this->select($this->dependecies_table_name . '.*, base_id');
		}
		
		return parent::find($id);
	}
	
	public function get_dependencies_by_name($name=null)
	{
		if (empty($this->selects))
		{
			$this->select($this->dependecies_table_name . '.*, base_name');
		}
	
		return parent::find_by('base_name',$name,'and');
	
	}//end find_by_name()
	
	
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
		if(count($valuesArray)!=count($labelsArray))
			$valuesArray=$labelsArray;
		if ($fieldType === 'checkbox') {
			for ($i=0;$i<count($labelsArray);$i++) {
				$returnString.='&nbsp&nbsp&nbsp<input type="checkbox" name=' . $fieldName.' value='.$valuesArray[$i].' id='.$valuesArray[$i];
				if(in_array($valuesArray[$i], $selectedOption)){
					$returnString.=' checked="checked" ';
				}
				$returnString.=' />&nbsp&nbsp<label>'.$labelsArray[$i].'</label>';
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
