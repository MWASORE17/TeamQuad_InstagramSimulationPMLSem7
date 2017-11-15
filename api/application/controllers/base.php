<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends MY_Controller{
	
	function __construct(){
		parent::__construct();
	}
	
	public function index(){
		echo "<h2>WELCOME TO INSTAGRAM</h2>";
	}
}
