<?php

require(APPPATH.'/libraries/REST_Controller.php');

class Api extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('actions/actions_model');
		#$this->load->library('users/auth');
		#$this->lang->load('actions_model');
		#$this->load->library('form_validation');
	}
	function test_get(){
		$data['status'] = 'ok';
		$data['result'] = 'test';
		$this->response($data, 200);
	}
	function action_get() {
		if(!$this->get('id') && !$this->get('name')) {
			$data['status'] = 'error';
			$data['message'] = 'Missing parameter: id or name';
			$this->response($data, 400);
			return;
		}
		if($this->get('id')) {
			$action = $this->actions_model->find_by_id( $this->get('id') );
		}
		else if($this->get('name')) {
			$action = $this->actions_model->find_by_name( $this->get('name') );
		}
		 if($action) {
		 	echo $this->actions_model->objectToArray($action);
		 	$data['status'] = 'ok';
		 	$data['result'] = $action;
		 	$this->response($data, 200);
		 }
		 else
		 	$this->response(NULL, 404);
	}

	function actions_get(){
		$actions = $this->actions_model->find_all();
		#echo $this->actions_model->objectToArray($actions[0]);
		if($actions) {
			$data['status'] = 'ok';
			$data['result'] = $actions;
			$this->response($data, 200);
		}
		else
			$this->response(NULL, 404);
	}
}