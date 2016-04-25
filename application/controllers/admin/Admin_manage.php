<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_manage extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		session_start();
		if(! isset($_SESSION['admin_user_name']))
		{
			redirect(base_url('index.php/admin/login'));
		}
		
		$this->load->model('Admins_model');
	}
	
	public function index()
	{
		$this->load->view('admin/admins');
	}
	
	public function add_admin()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		
		if($_SESSION['admin_user_name'] != 'admin')
		{
			echo json_encode("没有权限");
			return;
		}
		
		$form = $this->input->post(NULL, TRUE);
		if(empty($form['user_name']) || empty($form['password']))
		{
			echo json_encode('用户名或密码为空');
			return;
		}
		$admin = array(
				'user_name' => $form['user_name'],
				'password' => $form['password'],
		);
		if($this->Admins_model->add($admin))
		{
			echo json_encode('添加成功');
		}
		else 
		{
			echo json_encode('用户名已存在');
		}
	}
	
	public function delete_admin()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		
		if($_SESSION['admin_user_name'] != 'admin')
		{
			echo json_encode("没有权限");
			return;
		}
		
		$form = $this->input->post(NULL, TRUE);
		if(isset($form['user_name']) && (0 != strlen($form['user_name'])))
		{
			if('admin' == $post['user_name'])
			{
				return json_encode('不允许删除超级管理员');
			}
			
			$status = $this->Admins_model->delete($form['user_name']);
			echo json_encode($status);
		}
		else
		{
			echo json_encode(FALSE);
		}
	}
	
	public function password()
	{
		$this->load->view('admin/password');
	}
	
	public function ajax_password()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		
		$form = $this->input->post(NULL, TRUE);
		if(isset($form['user_name']) && (0 != strlen($form['user_name'])) && isset($form['old_password']) && isset($form['new_password']))
		{
			$this->load->model('Admins_model');
			if($this->Admins_model->verify_password($form['user_name'], $form['old_password']))
			{
				$admin = array(
					'user_name' => $form['user_name'],
					'password' => $form['new_password'],	
				);
				$this->Admins_model->update_password($admin);
				echo json_encode(TRUE);
			}else {
				echo json_encode(FALSE);
			}
		}
		else
		{
			echo json_encode(FALSE);
		}
	}
	
	public function logout()
	{
		session_destroy();
		$this->load->view('admin/logout');
	}
	
	public function nickname()
	{
		$this->load->view('admin/nickname');
	}

	public function ajax_nickname()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		
		$form = $this->input->post(NULL, TRUE);
		if(isset($form['nick_name']))
		{
			$this->Admins_model->update_nickname($_SESSION['admin_user_name'], $form['nick_name']);
			$_SESSION['admin_nick_name'] = $form['nick_name'];
			echo json_encode('修改成功');
		}
		else
		{
			echo json_encode('修改失败');
		}
	}
}
