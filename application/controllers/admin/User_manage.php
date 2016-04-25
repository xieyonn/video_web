<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_manage extends CI_Controller
{
	var $items_per_page = 10;
	
	function __construct()
	{
		parent::__construct();
	
		session_start();
		if(! isset($_SESSION['admin_user_name']))
		{
			redirect(base_url('index.php/admin/login'));
		}
	
		$this->load->model('Users_model');
	}
	
	public function index()
	{
		$users = $this->Users_model->get_users(1, $this->items_per_page);
		$user_count = $this->Users_model->count_all_users();
		
		$param = array(
				'page_index' => 1,
				'page_num' => ceil($user_count / $this->items_per_page),
				'users' => $users,
				'user_count' => $user_count,
				'option' => 'paging',
		);
		
		$this->load->view('admin/users', $param);
	}
	
	public function paging()
	{
		$user_count = $this->Users_model->count_all_users();
		$page_index = $this->uri->segment(4, 1);
		$page_num = ceil($user_count / $this->items_per_page);
		$users = $this->Users_model->get_users($page_index, $this->items_per_page);		
		
		$param = array(
				'page_index' => $page_index,
				'page_num' => $page_num,
				'users' => $users,
				'user_count' => $user_count,
				'option' => 'paging',
		);
		
		$this->load->view('admin/users', $param);
	}
	
	public function add_user()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		
		$form = $this->input->post(NULL, TRUE);
		if(isset($form['user_name']) && isset($form['password']))
		{
			if(0 == strlen($form['user_name']))
			{
				echo json_encode('用户名不能为空');
				return;
			}
			
			if($this->Users_model->is_user_name_exist($form['user_name']))
			{
				echo json_encode('用户名已存在');
			}
			else {
				$this->Users_model->add(array(
						'user_name' => $form['user_name'],
						'password' => $form['password'],
				));
				echo json_encode('添加成功');
			}
		}
		else
		{
			echo json_encode('传入数据为空');
		}
	}
	
	public function delete_user()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		
		$form = $this->input->post(NULL, TRUE);
		if(isset($form['user_name']) && (0 != strlen($form['user_name'])))
		{
			$this->Users_model->delete($form['user_name']);
			echo json_encode('删除成功!');
		}
		else
		{
			echo json_encode('传入数据为空');
		}
	}
	
	public function edit_password()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		
		$form = $this->input->post(NULL, TRUE);
		if(isset($form['user_name']) && isset($form['password']) && (0 != strlen($form['user_name'])) && (0 != strlen($form['password'])))
		{
			$this->Users_model->update_password($form['user_name'], $form['password']);
			echo json_encode('修改成功');
		}
		else
		{
			echo json_encode('传入数据为空');
		}
	}
	
	public function search()
	{
		$search = $this->uri->segment(4, '');
		$page_index = $this->uri->segment(5, 1);
		if($page_index < 1)
		{
			$page_index = 1;
		}		
		$users = $this->Users_model->get_users_by_search($search, $page_index, $this->items_per_page);
		$user_count = count($users);
		$page_num = ceil($user_count / $this->items_per_page);
		
		$param = array(
				'page_index' => $page_index,
				'page_num' => $page_num,
				'users' => $users,
				'user_count' => $user_count,
				'search' => $search,
				'option' => 'search',
		);
		
		$this->load->view('admin/users', $param);
	}
	
	public function show_records()
	{
		$post = $this->input->post(NULL, TRUE);
		$this->load->model('Records_model');
		$records = $this->Records_model->get_by_user_name($post['user_name']);
		$param = array(
				'records' => $records,
		);
		$data = $this->load->view('admin/record', $param, TRUE);
		$json_data = json_encode($data);
		header('Content-Length: '.strlen($json_data));
		echo $json_data;
	}
}