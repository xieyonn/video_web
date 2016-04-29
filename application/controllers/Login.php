<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		session_start();
	}
	
	public function index()
	{		
		if(! isset($_SESSION['user_name']))
		{
			$code = get_rand_char(4);
			$_SESSION['login_code'] = $code;
			
			$this->load->model('Configs_model');
			$this->load->model('Articles_model');
			$configs = $this->Configs_model->get_all();
			$articles = $this->Articles_model->get(1, 5);
		
			$param = array(
					'code' => $code,
					'configs' => $configs,
					'articles' => $articles,
			);
			$this->load->view('login', $param);
		}
		else
		{
			redirect(base_url('index.php/home'));
		}
	}
	
	public function ajax_login()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		
		$form = $this->input->post(NULL, TRUE);
		if(isset($form['user_name']) && isset($form['password']) && isset($form['code']))
		{
			if('' == $form['user_name'])
			{
				echo json_encode('用户名为空');
				return;
			}else if('' == $form['password'])
			{
				echo json_encode('密码为空');
				return;
			}else if(! (0 == strcasecmp($_SESSION['login_code'], $form['code'])))
			{
				echo json_encode('验证码错误');
				return;
			}
				
			$this->load->model('Users_model');
			if($this->Users_model->verify_password($form['user_name'], $form['password']))
			{
				$_SESSION['user_name'] = $form['user_name'];
				$this->Users_model->log_login_time($form['user_name']);
				echo json_encode('yes');
			}
			else
			{
				echo json_encode('用户名或密码错误');
			}
		}
		else
		{
			echo json_encode('传入的部分数据为空');
		}
	}
	
	public function get_code()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		else
		{
			$code = get_rand_char(4);
			$_SESSION['login_code'] = $code;
			echo json_encode($code);
		}
	}
	
	public function password()
	{
		$param = array(
				'title' => '修改密码',
		);
		$this->load->view('password');
	}
	
	public function logout()
	{
		session_destroy();
		$this->load->view('logout');
	}
	
	public function ajax_password()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
	
		$post = $this->input->post(NULL, TRUE);
		if(isset($post['user_name']) && isset($post['old_password']) && isset($post['new_password']))
		{
			$this->load->model('Users_model');
			if($this->Users_model->verify_password($post['user_name'], $post['old_password']))
			{
				$this->Users_model->update_password($post['user_name'], $post['new_password']);
				echo json_encode('修改成功');
			}	
		}
		else
		{
			echo json_encode('传输数据部分为空');
		}
	}
}