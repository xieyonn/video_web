<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_manage extends CI_Controller
{
	var $items_per_page = 10;
	
	function __construct()
	{
		parent::__construct();
		
		session_start();
		if(!isset($_SESSION['admin_user_name']))
		{
			redirect(base_url('index.php/admin/login'));
		}
		$this->load->model('Articles_model');
	}
	
	public function index()
	{
		$articles = $this->Articles_model->get(1, $this->items_per_page);
		$articles_count = $this->Articles_model->count_all_articles();
		$page_num = ceil($articles_count / $this->items_per_page);
		
		$param = array(
				'page_index' => 1,
				'page_num' => $page_num,
				'articles' => $articles,
				'articles_count' => $articles_count,
				'option' => 'paging',
		);
		$this->load->view('admin/articles', $param);
	}
	
	public function add()
	{
		$post = $_POST;
		if(isset($post['title']) && isset($post['indexing']) && isset($post['content']) && isset($post['status']))
		{		
			$article = array(
					'title' => $post['title'],
					'content' => $post['content'],
					'indexing' => $post['indexing'],
					'create_time' => get_datetime(),
					'update_time' => get_datetime(),
					'clicks' => 0,
					'status' => $post['status'],
			);

			$this->Articles_model->add($article);
			echo json_encode('添加成功');
		}
		else 
		{
			echo json_encode('接收数据为空');
		}
	}
	
	public function delete()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		
		$post = $this->input->post(NULL, TRUE);
		if(isset($post['id']) && !empty($post['id']))
		{
			$this->Articles_model->delete($post['id']);
			echo json_encode('删除成功');
		}
		else 
		{
			echo json_encode('接收数据为空');
		}
	}
	
	public function update()
	{	
		$post = $_POST;
		$article = array(
				'id' => $post['id'],
				'title' => $post['title'],
				'indexing' => $post['indexing'],
				'content' => $post['content'],
				'status' => $post['status'],
		);
		$this->Articles_model->update($article);
		echo json_encode('修改成功');
	}
	
	public function get_article()
	{
		$post = $this->input->post(NULL, TRUE);
		if(isset($post['id']) && !empty($post['id']))
		{
			$data = $this->Articles_model->get_by_id($post['id']);
			$json_data = json_encode($data);
			header('Content-Length: '.strlen($json_data));
			echo $json_data;
		}
		else 
		{
			echo json_encode('接收请求为空');
		}
	}
	
	public function get_content()
	{
		$post = $this->input->post(NULL, TRUE);
		$data = $this->Articles_model->get_by_id($post['id']);
		header('Content-Length: '.strlen($data['content']));
		echo json_encode($data['content']);
	}
	
	public function upload_file()
	{
		$articles_path = './'.$this->config->item('articles_dir_name');
		if(! file_exists($articles_path))
		{
			mkdir($articles_path);
		}
		
		if($_FILES['imgFile']['error'] == UPLOAD_ERR_OK && $_FILES['imgFile']['size'] > 0)
		{
			$file_name = $_FILES['imgFile']['name'];
			$temp_arr = explode(".", $file_name);
			$file_ext = array_pop($temp_arr);
			$file_ext = trim($file_ext);
			$file_ext = strtolower($file_ext);
			
			if(in_array($file_ext, $this->config->item('picture_types')))
			{
				//保存图片
				$image_path = $articles_path.'/images/';
				if(! file_exists($image_path))
				{
					mkdir($image_path);
				}
				$save_name = date("YmdHis",time()).get_rand_char(5).'.'.$file_ext;
				$image_path .= $save_name;
				if(move_uploaded_file($_FILES['imgFile']['tmp_name'], $image_path))
				{
					echo json_encode(array('error' => 0, 'url' => base_url($this->config->item('articles_dir_name').'/images/'.$save_name)));
				}
				else
				{
					echo $json->encode(array('error' => 1, 'message' => '保存失败'));
				}
			}else if(in_array($file_ext, $this->config->item('file_types')))
			{
				$file_path = $articles_path.'/files/';
				if(! file_exists($file_path))
				{
					mkdir($file_path);
				}
				$save_name = date("YmdHis",time()).get_rand_char(5).'.'.$file_ext;
				$file_path .= $save_name;
				if(move_uploaded_file($_FILES['imgFile']['tmp_name'], $file_path))
				{
					echo json_encode(array('error' => 0, 'url' => base_url('index.php/articles/download/'.$save_name)));
				}
				else
				{
					echo $json->encode(array('error' => 1, 'message' => '保存失败'));
				}
			}else{
				echo json_encode(array('error' => 1, 'message' => '不支持的文件类型'));
				return;
			}		
		}
	}
	
	public function search()
	{
		$search = urldecode($this->uri->segment(4, ''));
		$page_index = $this->uri->segment(5, 1);
		if($page_index < 1)
		{
			$page_index = 1;
		}
		$articles = $this->Articles_model->get_by_search($search, $page_index, $this->items_per_page);
		$articles_count = count($articles);
		$page_num = ceil($articles_count / $this->items_per_page);
		
		$param = array(
				'page_index' => $page_index,
				'page_num' => $page_num,
				'articles' => $articles,
				'articles_count' => $articles_count,
				'search' => $search,
				'option' => 'search',
		);
		
		$this->load->view('admin/articles', $param);
	}
	
	public function paging()
	{
		$articles_count = $this->Articles_model->count_all_articles();
		$page_index = $this->uri->segment(4, 1);
		$page_num = ceil($articles_count / $this->items_per_page);
		$articles = $this->Articles_model->get($page_index, $this->items_per_page);
		
		$param = array(
				'page_index' => $page_index,
				'page_num' => $page_num,
				'articles' => $articles,
				'articles_count' => $articles_count,
				'option' => 'paging',
		);
		
		$this->load->view('admin/articles', $param);
	}
}