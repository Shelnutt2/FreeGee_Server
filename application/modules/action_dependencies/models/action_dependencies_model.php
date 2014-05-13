<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Action_dependencies_model extends BF_Model {

	protected $table_name	= "action_dependencies";
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
			"field"		=> "action_dependencies_base_id",
			"label"		=> "Base Action ID",
		),
		array(
			"field"		=> "action_dependencies_base_name",
			"label"		=> "Base Action Name",
		),
		array(
			"field"		=> "action_dependencies_dependency_id",
			"label"		=> "Dependency Action ID",
		),
		array(
			"field"		=> "action_dependencies_dependency_name",
			"label"		=> "Dependency Action Name",
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------

	public function setDependencies(&$base_action,&$action_dependencies){
		echo "setDependencies called".PHP_EOL;
		echo "Size of selected actions is:" .count($action_dependencies).PHP_EOL;
		echo "Type ofAcion Deps is: ".gettype($action_dependencies).PHP_EOL;
		foreach($action_dependencies as $ad){
			echo $ad.PHP_EOL;
		}
		if(!is_array($base_action)){
			echo "base action isn't an array";
			return false;
		}
		$id = $base_action['id'];
		//First check to see if this action already has a list of dependecies
		$currentDependencies = $this->find_by_id($id);
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
		foreach($action_dependencies as $actionDeps){
			echo "looping now".PHP_EOL;
			$this->load->model('actions/actions_model');
			$depActionArray = json_decode(json_encode($this->actions_model->find_by_name($actionDeps)), true);
			$dataArray = array();
			$dataArray['base_id'] = $id;
			$dataArray['base_name'] = $base_action['name'];
			$dataArray['dependency_id'] = $depActionArray['id'];
			$dataArray['dependency_name'] = $depActionArray['name'];
			$this->action_dependencies_model->insert($dataArray);
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
	public function find_by_name($name=null)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name . '.*, base_name');
		}
		return parent::find_by('base_name',$name,'and');	
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
	public function find_by_id($baseid=null)
	{
		if (empty($this->selects))
		{
			$this->select($this->table_name . '.*, base_id');
		}
		return parent::find_by('base_id',$baseid,'and');
	}//end find_dependencies_by_name()
}