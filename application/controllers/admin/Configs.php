<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configs extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		session_start();
		if(! isset($_SESSION['admin_user_name']))
		{
			redirect(base_url('index.php/admin/login'));
		}
		
		$this->load->model('Configs_model');
	}
	
	public function index()
	{
		$configs = $this->Configs_model->get_all();
		
		$param = array(
				'configs' => $configs,
		);
		$this->load->view('admin/configs', $param);
	}
	
	public function update()
	{
		$post = $this->input->post(NULL, TRUE);
		$configs = $this->Configs_model->get_all();
		
		if($configs['site_name'] != $post['site_name'])
		{
			$this->Configs_model->update(array(
					'key_d' => 'site_name',
					'value_d' => $post['site_name'],
			));
		}
		
		if($configs['site_title'] != $post['site_title'])
		{
			$this->Configs_model->update(array(
					'key_d' => 'site_title',
					'value_d' => $post['site_title'],
			));
		}
		
		if($_FILES['logo']['error'] == UPLOAD_ERR_OK && $_FILES['logo']['size'] > 0)
		{
			$file_name = $_FILES['logo']['name'];
			$temp_arr = explode(".", $file_name);
			$file_ext = array_pop($temp_arr);
			$file_ext = trim($file_ext);
			$file_ext = strtolower($file_ext);
			if(! in_array($file_ext, $this->config->item('picture_types')))
			{
				echo json_encode('不支持的图片类型');
				return;
			}
			$logo_name = get_rand_char(30).'.'.$file_ext;
			$logo_path = './images';
			if(! file_exists($logo_path))
			{
				mkdir($logo_path);
			}
			$logo_path .= '/'.$logo_name;
			if(move_uploaded_file($_FILES['logo']['tmp_name'], $logo_path))
			{
				$old_file = $configs['logo'];
				$path = './images/'.$old_file;
				if(file_exists($path))
				{
					unlink($path);
				}
				$this->Configs_model->update(array(
						'key_d' => 'logo',
						'value_d' => $logo_name,
				));
			}
			else 
			{
				echo json_encode('保存文件失败');
			}
		}
		
		echo json_encode('保存成功');
	}
}