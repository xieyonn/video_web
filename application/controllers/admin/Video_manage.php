<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video_manage extends CI_Controller
{
	var $items_per_page = 5;
	
	function __construct()
	{
		parent::__construct();
	
		session_start();
		if(! isset($_SESSION['admin_user_name']))
		{
			redirect(base_url('index.php/admin/login'));
		}
	}
	
	public function index()
	{
		$this->load->model('Series_model');
		$series = $this->Series_model->get_series(1, $this->items_per_page);
		$series_count = $this->Series_model->count_all_series();
		
		$param = array(
				'page_index' => 1,
				'page_num' => ceil($series_count / $this->items_per_page),
				'series' => $series,
				'series_count' => $series_count,
				'option' => 'paging',
		);
		
		$this->load->view('admin/series', $param);
	}
	
	public function paging()
	{
		$this->load->model('Series_model');	
		$series_count = $this->Series_model->count_all_series();
		$page_index = $this->uri->segment(4, 1);
		$page_num = ceil($series_count / $this->items_per_page);
		$series = $this->Series_model->get_series($page_index, $this->items_per_page);
		
		$param = array(
				'page_index' => $page_index,
				'page_num' => $page_num,
				'series' => $series,
				'series_count' => $series_count,
				'option' => 'paging',
		);
		
		$this->load->view('admin/series', $param);
	}
	
	public function search()
	{
		$search = urldecode($this->uri->segment(4, ''));
		$this->load->model('Series_model');		
		$page_index = $this->uri->segment(5, 1);
		if($page_index < 1)
		{
			$page_index = 1;
		}
		$series = $this->Series_model->get_series_by_search($search, $page_index, $this->items_per_page);
		$series_count = count($series);
		$page_num = ceil($series_count / $this->items_per_page);
		
		$param = array(
				'page_index' => $page_index,
				'page_num' => $page_num,
				'series' => $series,
				'series_count' => $series_count,
				'search' => $search,
				'option' => 'search',
		);
		
		$this->load->view('admin/series', $param);
	}
	
	public function delete_series()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		
		$post = $this->input->post(NULL, TRUE);
		if(isset($post['id']) && !empty($post['id']))
		{
			$this->load->model('Series_model');
			$series = $this->Series_model->get_series_by_id($post['id']);
			$series_dir = './'.$this->config->item('video_dir_name').'/'.$series['series_name'];
			if(file_exists($series_dir))
			{
				remove_dir($series_dir);
			}
			$this->Series_model->delete_series($post['id']);
			echo json_encode('删除成功');
		}
		else
		{
			echo json_encode('传入数据为空');
		}
	}
	
	public function add_series()
	{
		$post = $_POST;
		if(isset($post['title']) && !empty($post['title']) && isset($post['file_type']))
		{
			if(! in_array($post['file_type'], $this->config->item('picture_types')))
			{
				echo json_encode('不支持的文件类型');
				return;
			}
			
			if($_FILES['cover']['error'] == UPLOAD_ERR_OK && $_FILES['cover']['size'] > 0)
			{
				$video_path = './'.$this->config->item('video_dir_name');
				if(! file_exists($video_path))
				{
					mkdir($video_path);
				}
				$series_name = get_rand_char(30);
				$series_path = $video_path.'/'.$series_name;
				if(! mkdir($series_path))
				{
					log_message('error', '创建series文件失败');
				}
				$file_name = get_rand_char(30).'.'.$post['file_type'];
				$file_path = $series_path.'/'.$file_name;
				if(move_uploaded_file($_FILES['cover']['tmp_name'], $file_path))
				{
					$series = array(
							'title' => $post['title'],
							'brief' => (isset($post['brief']))? $post['brief'] : '',
							'admin' => $_SESSION['admin_user_name'],
							'amount' => 0,
							'cover_name' => $file_name,
							'series_name' => $series_name,
							'status' => $post['status'],
					);
					$this->load->model('Series_model');
					$this->Series_model->add_series($series);
					
					echo json_encode('上传成功');
				}
				else 
				{
					echo json_encode('保存失败');
				}
			}
			else
			{
				echo json_encode('上传失败');
				log_message('error', __FUNCTION__.__LINE__.$_FILES['cover']['error']);
			}
		}
		else
		{
			echo json_encode('传输失败，部分内容为空');
		}
	}
	
	public function edit_series()
	{
		$post = $_POST;
		$this->load->model('Series_model');
		if(!empty($post['file_type']) && $_FILES['cover']['error'] == UPLOAD_ERR_OK && $_FILES['cover']['size'] > 0)
		{
			if(! in_array($post['file_type'], $this->config->item('picture_types')))
			{
				echo json_encode('不支持的文件类型');
				return;
			}
			
			$series = $this->Series_model->get_series_by_id($post['id']);
			$series_path = './'.$this->config->item('video_dir_name').'/'.$series['series_name'];
			$old_cover = $series_path.'/'.$series['cover_name'];
			if(file_exists($old_cover))
			{
				unlink($old_cover);
			}
			$file_name = get_rand_char(30).'.'.$post['file_type'];
			$file_path = $series_path.'/'.$file_name;
			if(move_uploaded_file($_FILES['cover']['tmp_name'], $file_path))
			{
				$update_series = array(
						'id' => $post['id'],
						'title' => $post['title'],
						'brief' => $post['brief'],
						'amount' => $post['amount'],
						'cover_name' => $file_name,
						'update_time' => get_datetime(),
						'status' => $post['status'],
				);
				$this->Series_model->edit_series($update_series);
				echo json_encode('修改成功');
			}
			else 
			{
				echo json_encode('图片保存失败');
			}
		}
		else
		{
			$update_series = array(
					'id' => $post['id'],
					'title' => $post['title'],
					'brief' => $post['brief'],
					'amount' => $post['amount'],
					'update_time' => get_datetime(),
					'status' => $post['status'],
			);
			$this->Series_model->edit_series($update_series);
			
			echo json_encode('修改成功');
		}
	}
	
	public function video_list()
	{
		$series_id = $this->uri->segment(4);
		if(! is_numeric($series_id))
		{
			show_error('错误请求');
		}
		
		$this->load->model('Videos_model');
		$videos = $this->Videos_model->get_by_series_id($series_id);
		$this->load->model('Series_model');
		$series = $this->Series_model->get_series_by_id($series_id);
		
		$param = array(
				'videos' => $videos,
				'series' => $series,
		);
		$this->load->view('admin/video_list', $param);
	}
	
	public function add_video()
	{
		$post = $this->input->post(NULL, TRUE);
		
		if(!empty($post['file_type']) && $_FILES['video_file']['error'] == UPLOAD_ERR_OK && $_FILES['video_file']['size'] > 0)
		{
			//处理图片
			if($_FILES['cover']['error'] == UPLOAD_ERR_OK && $_FILES['cover']['size'] > 0)
			{
				$file_name = $_FILES['cover']['name'];
				$temp_arr = explode(".", $file_name);
				$file_ext = array_pop($temp_arr);
				$file_ext = trim($file_ext);
				$file_ext = strtolower($file_ext);
				$cover_name = get_rand_char(30).'.'.$file_ext;
				if(! in_array($file_ext, $this->config->item('picture_types')))
				{
					echo json_encode('不支持的图片类型');
					return;
				}
			}else{
				$cover_name = '';
			}
			
			//处理视频
			if(! in_array($post['file_type'], $this->config->item('video_types')))
			{
				echo json_encode('不支持的文件类型');
				return;
			}
			
			$this->load->model('Series_model');
			$this->load->model('Videos_model');
			$series = $this->Series_model->get_series_by_id($post['series_id']);
			$series_path = './'.$this->config->item('video_dir_name').'/'.$series['series_name'];
			if(! file_exists($series_path))
			{
				mkdir($series_path);
			}
			$video_name = get_rand_char(30).'.'.$post['file_type'];
			$video_path = $series_path.'/'.$video_name;
			if(move_uploaded_file($_FILES['video_file']['tmp_name'], $video_path))
			{
				if(!empty($cover_name))
				{
					$cover_path = $series_path.'/'.$cover_name;
					if(! move_uploaded_file($_FILES['cover']['tmp_name'], $cover_path))
					{
						echo json_encode('保存图片失败');
						return;
					}
				}
				
				$video = array(
						'series_id' => $post['series_id'],
						'file_name' => $video_name,
						'create_time' => get_datetime(),
						'admin' => $_SESSION['admin_user_name'],
						'indexing' => $post['index'],
						'status' => $post['status'],
						'update_time' => get_datetime(),	
						'title' => $post['title'],
				);
				
				if(!empty($cover_name))
				{
					$video['cover'] = $cover_name;
					$video['has_cover'] = 1;
				}else 
				{
					$video['cover'] = $series['cover_name'];
					$video['has_cover'] = 0;
				}
				
				$this->Videos_model->add($video);
				echo json_encode('上传成功');
			}
			else
			{
				echo json_encode('文件保存失败');				
			}
		}
		else
		{
			echo json_encode('文件传输失败  php_error:'.$_FILES['video_file']['error']);
		}
	}
	
	public function series()
	{
		$series_id = $this->uri->segment(4);
		if(! is_numeric($series_id))
		{
			show_error('请求错误');
		}
		
		$this->load->model('Series_model');
		$series = $this->Series_model->get_series_by_id($series_id);
		$array = array(0 => $series);
		$series_count = $this->Series_model->count_all_series();
		
		$param = array(
				'page_index' => 1,
				'page_num' => 1,
				'series' => $array,
				'series_count' => $series_count,
				'option' => 'paging',
		);
		
		$this->load->view('admin/series', $param);
	}
	
	public function delete_video()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		
		$post = $this->input->post(NULL, TRUE);
		if(isset($post['series_id']) && isset($post['video_id']))
		{
			$this->load->model('Videos_model');
			$video = $this->Videos_model->get_video_by_id($post['video_id']);
			$this->load->model('Series_model');
			$series = $this->Series_model->get_series_by_id($video['series_id']);
			
			$file_path = './'.$this->config->item('video_dir_name').'/'.$series['series_name'].'/'.$video['file_name'];
			if(file_exists($file_path))
			{
				unlink($file_path);
			}
			$this->Videos_model->delete(array(
					'id' => $post['video_id'],
					'series_id' => $series['id'],		
			));
			echo json_encode('删除成功');
		}
		else
		{
			echo json_encode('传输出错');
		}
	}
	
	public function edit_video()
	{
		$post = $this->input->post(NULL, TRUE);
		
		$video = array(
				'id' => $post['video_id'],
				'admin' => $_SESSION['admin_user_name'],
				'indexing' => $post['index'],
				'status' => $post['status'],
				'update_time' => get_datetime(),
		);
		
		//有视频上传
		if(!empty($post['file_type']) && $_FILES['video_file']['error'] == UPLOAD_ERR_OK && $_FILES['video_file']['size'] > 0)
		{			
			if(! in_array($post['file_type'], $this->config->item('video_types')))
			{
				echo json_encode('不支持的文件类型');
				return;
			}
			
			$this->load->model('Series_model');
			$this->load->model('Videos_model');
			$series = $this->Series_model->get_series_by_id($post['series_id']);
			$series_path = './'.$this->config->item('video_dir_name').'/'.$series['series_name'];
			if(! file_exists($series_path))
			{
				mkdir($series_path);
			}
			$video_name = get_rand_char(30).'.'.$post['file_type'];
			$video_path = $series_path.'/'.$video_name;
			if(move_uploaded_file($_FILES['video_file']['tmp_name'], $video_path))
			{
				$video['file_name'] = $video_name;
				
				$old_video = $this->Videos_model->get_video_by_id($post['video_id']);
				$old_file = $series_path.'/'.$old_video['file_name'];
				if(file_exists($old_file))
				{
					unlink($old_file);
				}
			}
			else
			{
				echo json_encode('保存视频失败');
			}
		}
		
		//有图片上传
		if($_FILES['cover']['error'] == UPLOAD_ERR_OK && $_FILES['cover']['size'] > 0)
		{
			$file_name = $_FILES['cover']['name'];
			$temp_arr = explode(".", $file_name);
			$file_ext = array_pop($temp_arr);
			$file_ext = trim($file_ext);
			$file_ext = strtolower($file_ext);
			if(! in_array($file_ext, $this->config->item('picture_types')))
			{
				echo json_encode('不支持的图片类型');
				return;
			}
			
			$this->load->model('Series_model');
			$this->load->model('Videos_model');
			$series = $this->Series_model->get_series_by_id($post['series_id']);
			$series_path = './'.$this->config->item('video_dir_name').'/'.$series['series_name'];
			if(! file_exists($series_path))
			{
				mkdir($series_path);
			}
			$cover_name = get_rand_char(30).'.'.$file_ext;
			$cover_path = $series_path.'/'.$cover_name;
			if(move_uploaded_file($_FILES['cover']['tmp_name'], $cover_path))
			{
				$old_video = $this->Videos_model->get_video_by_id($post['video_id']);
				if($old_video['has_cover'] == 1)
				{
					$old_file = $series_path.'/'.$old_video['cover'];
					if(file_exists($old_file))
					{
						unlink($old_file);
					}
				}
				$video['cover']= $cover_name;
				$video['has_cover'] = 1;
			}
			else 
			{
				echo json_encode('保存图片失败');
			}
		}
		$this->load->model('Videos_model');
		$this->Videos_model->edit($video);
		echo json_encode('修改成功');
	}
	
	public function get_series()
	{
		$post = $this->input->post(NULL, TRUE);
		if(! empty($post['id']))
		{
			$this->load->model('Series_model');
			$data = $this->Series_model->get_series_by_id($post['id']);
			$json_data = json_encode($data);
			header('Content-Length: '.strlen($json_data));
			echo $json_data;
		}
		else 
		{
			echo json_encode("请求为空");
		}
	}
}