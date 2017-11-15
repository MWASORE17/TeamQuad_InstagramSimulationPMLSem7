<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_Controller extends MY_Controller{
	
	public function index(){
		
		$this->load->view('user/login');
	}
}