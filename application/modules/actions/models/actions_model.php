<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Actions_model extends BF_Model {

	protected $dependencies_table_name = "actions_dependencies";
	protected $table_name	= "actions";
	public $temp_name = "actions";
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

	function setDependencies($id,$action_dependencies){
		echo "setDependencies called".PHP_EOL;
		//First check to see if this action already has a list of dependecies
			$currentDependencies = $this->find_dependencies_by_id($id);
			if($currentDependencies){
				$currentDependencies = array_filter(json_decode(json_encode($currentDependencies), true));			
			//If the action does have dependencies check to see if any differ from whats already in the database
				if(!empty($currentDependencies)){
					foreach($currentDependencies as $depAction_key => $depAction_value){
						$index = array_search($depAction_value["base_name"], $action_dependencies);
						if($index)
							unset($action_dependencies[$index]);
						else{
							//drop the current dependency from the table it's no longer there
							$where = array("base_id"=>$if,"dependency_id"=>$depAction_value['dependency_id']);
							$this->delete_dependency_where($where);
						}
					}
				}
			}
			echo "finding action array".PHP_EOL;
			$actionArray = json_decode(json_encode($this->find_by_id($id)), true);
			echo "Size of selected actions is:" .count($action_dependencies).PHP_EOL;
			foreach($action_dependencies as $actionDeps){
				echo "looping now".PHP_EOL;
				$depActionArray = $json_decode(json_encode($this->find_by_name($actionDeps)), true);
				$dataArray = array($id,$actionArray['name'],$depActionArray['id'],$depActionArray['name']);
				$this->insert_dependency($dataArray);
			}
			echo "done!".PHP_EOL;
	}
	
	/**
	 * Finds an individual action's dependencies.
	 *
	 * @access public
	 *
	 * @param String $name An String with the acions base name.
	 *
	 * @return bool|object An object with the action.
	 */
	public function find_dependencies_by_name($name=null)
	{
		if (empty($this->selects))
		{
			$this->select($this->dependencies_table_name . '.*, base_name');
		}
		$this->table_name = $this->dependencies_table_name;
		$data = parent::find_by('base_name',$name,'and');
		$this->table_name = $this->temp_name;
		return $data;
	
	}//end find_dependencies_by_name()
	
	/**
	 * Finds an individual action's dependencies.
	 *
	 * @access public
	 *
	 * @param int $baseid An INT with the acions id.
	 *
	 * @return bool|object An object with the action.
	 */
	public function find_dependencies_by_id($baseid=null)
	{
		if (empty($this->selects))
		{
			$this->select($this->dependencies_table_name . '.*, base_id');
		}
		$this->table_name = $this->dependencies_table_name;
		$data = parent::find_by('base_id',$baseid,'and');
		$this->table_name = $this->temp_name;
		return $data;
	
	}//end find_dependencies_by_name()
	
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
	 * @param string $name An String with the acions name.
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
	
	public function find_all_names(){
		if (empty($this->selects))
		{
			$this->select($this->table_name . '.*, name');
		}
		$array = parent::find_all();
		$array = json_decode(json_encode($array), true);
		$namesarray = array();
		foreach($array as $action){
			$namesarray[$action['id']] = $action['name'];
		}
		return $namesarray;
	}
	
	public function get_dependencies_by_id($id=null){
		
		if (empty($this->selects))
		{
			$this->select($this->dependencies_table_name . '.*, base_id');
		}
		$this->table_name = $this->dependencies_table_name;
		$data = parent::find_by('base_id',$id,'and');
		$this->table_name = $this->temp_name;
		return $data;
	}
	
	public function get_dependencies_by_name($name=null)
	{
		if (empty($this->selects))
		{
			$this->select($this->dependencies_table_name . '.*, base_name');
		}
		$this->table_name = $this->dependencies_table_name;
		$data = parent::find_by('base_name',$name,'and');
		$this->table_name = $this->temp_name;
		return $data;	
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
		$valuesArray = array_values($valuesArray);
		$labelsArray = array_values($labelsArray);
		if(count($valuesArray)!=count($labelsArray))
			$valuesArray=$labelsArray;
		if ($fieldType === 'checkbox') {
			for ($i=0;$i<count($labelsArray);$i++) {
				$returnString.='<label for="'.$valuesArray[$i].'">';
				$returnString.='&nbsp&nbsp&nbsp<input type="checkbox" name=' . $fieldName.' value='.$valuesArray[$i].' id='.$valuesArray[$i].' />&nbsp';
				if(in_array($valuesArray[$i], $selectedOption)){
					$returnString.=' checked="checked" ';
				}
				$returnString.=$labelsArray[$i].'</label>';
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
	
	public function insert_dependency($data=null)
	{
		if ($this->skip_validation === false) {
			$data = $this->validate($data, 'insert');
			if ($data === false) {
				return false;
			}
		}
	
		$data = $this->trigger('before_insert', $data);
	
		if ($this->set_created === true && $this->log_user === true
				&& ! array_key_exists($this->created_by_field, $data)
		) {
			$data[$this->created_by_field] = $this->auth->user_id();
		}
	
		// Insert it
		$status = $this->db->insert($this->dependencies_table_name, $data);
	
		if ($status == false) {
			$this->error = $this->get_db_error_message();
		} elseif ($this->return_insert_id) {
			$id = $this->db->insert_id();
	
			$status = $this->trigger('after_insert', $id);
		}
	
		return $status;
	
	}//end insert()
	
	/**
	 * Performs a delete using any field/value pair(s) as the 'where'
	 * portion of your delete statement. If $this->soft_deletes is
	 * TRUE, it will attempt to set $this->deleted_field on the current
	 * record to '1', to allow the data to remain in the database.
	 *
	 * @param mixed/array $data key/value pairs accepts an associative array or a string
	 *
	 * @example 1) array( 'key' => 'value', 'key2' => 'value2' )
	 * @example 2) ' (`key` = "value" AND `key2` = "value2") '
	 *
	 * @return bool TRUE/FALSE
	 */
	public function delete_dependency_where($where=NULL)
	{
		$where = $this->trigger('before_delete', $where);
	
		// set the where clause to be used in the update/delete below
		$this->db->where($where);
	
		if ($this->soft_deletes === TRUE)
		{
			$data = array(
					$this->deleted_field => 1,
			);
	
			if ($this->log_user === TRUE)
			{
				$data[$this->deleted_by_field] = $this->auth->user_id();
			}
	
			$this->db->update($this->dependency_table_name, $data);
		}
		else
		{
			$this->db->delete($this->dependency_table_name);
		}
	
		$result = $this->db->affected_rows();
	
		if ($result)
		{
			$this->trigger('after_delete', $result);
	
			return $result;
		}
	
		$this->error = lang('bf_model_db_error') . $this->get_db_error_message();
	
		return FALSE;
	
	}//end delete_where()
}
