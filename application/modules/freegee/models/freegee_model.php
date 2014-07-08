<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Freegee_model extends BF_Model {

	protected $table_name	= "freegee";
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
			"field"		=> "freegee_api_version",
			"label"		=> "API Version",
			"rules"		=> "required"
		),
		array(
			"field"		=> "freegee_min_client",
			"label"		=> "Minimum Supported Client Version",
			"rules"		=> "required|max_length[32]"
		),
	);
	protected $insert_validation_rules 	= array();
	protected $skip_validation 			= FALSE;

	//--------------------------------------------------------------------

	/**
	 * Finds all api version
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
		return parent::find_all();
	
	}//end find_by_name()
	
	/**
	 * Matches highest api verison supported by client
	 * 
	 * @see BF_Model::find_all()
	 *
	 * @access public
	 *
	 * @param none
	 *
	 * @return bool| API versin
	 */
	public function get_api_by_version($client_version)
	{
		$api_versions = json_decode(json_encode($this->find_all()),true);
		$api_version = 1;
		foreach($api_versions as $api){
			if(version_compare($client_version,$api['min_client'],'>=')){
				if($api['api_version'] > $api_version){
					$api_version + $api['api_version'];
				}
			}
		}
		return $api_version;

	}//end get_api_by_version()
}
