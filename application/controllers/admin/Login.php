<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		session_start();
		if(isset($_SESSION['admin_user_name']))
		{
			redirect(base_url('index.php/admin/configs'));
		}
		$this->load->view('admin/login');
	}
	
	public function ajax_login()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		
		$form = $this->input->post(NULL, TRUE);
		if(isset($form['user_name']) && !empty($form['user_name']) && isset($form['password']))
		{
			$this->load->model('Admins_model');
			if($this->Admins_model->verify_password($form['user_name'], $form['password']))
			{
				session_start();
				$_SESSION['admin_user_name'] = $form['user_name'];
				$_SESSION['admin_nick_name'] = $this->Admins_model->get_nick_name($form['user_name']);
				$this->Admins_model->log_login_time($form['user_name']);
				
				echo json_encode(TRUE);
			}
			else 
			{
				echo json_encode(FALSE);
			}
		}
		else
		{
			echo json_encode(FALSE);
		}
	}
}
