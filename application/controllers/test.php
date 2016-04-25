<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{

		session_start();
		$this->load->model('Configs_model');
		$this->load->model('Videos_model');
		$this->load->model('Records_model');

		$record = array(
				'user_name' => $_SESSION['user_name'],
				'video_id' => 1,
				'update_time' => get_datetime(),
				'played_percent' => 60,
		);
		echo '<pre>';
		var_dump('aaa' == 'aaa');
		echo '</pre>';
	}
}