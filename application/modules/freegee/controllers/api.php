<?php

require(APPPATH.'/libraries/REST_Controller.php');

class Api extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('freegee/freegee_model');
		$this->load->model('devices/devices_model');
		$this->load->helper('url');
		#$this->load->library('users/auth');
		#$this->lang->load('actions_model');
		#$this->load->library('form_validation');
	}
	function handshake_get() {
		if(!$this->get('id')){
			$data['status'] = 'error';
			$data['message'] = 'Missing parameter: id';
			$this->response($data, 400);
			return;
			}
		if(!$this->get('version')) {		
			$data['status'] = 'error';
			$data['message'] = 'Missing parameter: version';
			$this->response($data, 400);
			return;
		}
		$api_version_supported = $this->freegee_model->get_api_by_version($this->get('version'));
		$data['status'] = 'ok';
		$data['message'] = 'API Version: '.$api_version_supported;
		$data['request_file'] = 'build.prop';
		$data['request_location'] = '/freegee/api/build_prop';
		$data['request_type'] = 'post';
		$this->response($data, 200);
	}

	function build_prop_post(){
		$post = $this->post();
		$model = $this->devices_model->matchDevice($post);

		if(isset($model)){
			unset($model->image);
			$data['status'] = 'ok';
			$data['data_type'] = 'device';
			$data['device'] = json_encode($model);
			$this->response($data, 200);
		}
		else{
			$data['status'] = 'failed';
			$data['device'] = 'unkown';
			$this->response($data, 200);
		}
	}
}