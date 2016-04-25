<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Video extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		session_start();
		if(! isset($_SESSION['user_name']))
		{
			redirect(base_url('index.php/login'));
		}
		
		$this->load->model('Series_model');
		$this->load->model('Videos_model');
		$this->load->model('Configs_model');
	}
	
	public function index()
	{
		redirect(base_url('index.php/home/paging'));
	}
	
	public function play()
	{
		$video_name = urldecode($this->uri->segment(3));
		$video = $this->Videos_model->get_video_by_name($video_name);
		if(empty($video)){
			show_404();
		}
		$video['all'] = $this->Videos_model->get_videos_by_series_id($video['series_id']);
		$series = $this->Series_model->get_series_by_id($video['series_id']);
		$configs = $this->Configs_model->get_all();
		
		$param = array(
				'title' => '正在播放',
				'video' => $video,
				'series' => $series,
				'configs' => $configs,
		);
		$this->load->view('video', $param);
	}
	
	public function videos_list()
	{
		$series_id = $this->uri->segment(3);
		if(! is_numeric($series_id))
		{
			show_404();
		}
		
		$series = $this->Series_model->get_series_by_id($series_id);
		$videos = $this->Videos_model->get_videos_by_series_id($series_id);
		$configs = $this->Configs_model->get_all();
		
		$param = array(
				'series' => $series,
				'videos' => $videos,
				'configs' => $configs,
		);
		$this->load->view('vidoes_list', $param);
	}
	
	public function log_record()
	{
		if(! $this->input->is_ajax_request())
		{
			show_error('不允许访问');
		}
		
		$post = $this->input->post(NULL, TRUE);
		$video = $this->Videos_model->get_video_by_id($post['video_id']);
		$record = array(
				'user_name' => $_SESSION['user_name'],
				'video_id' => $video['id'],
				'played_percent' => $post['played_percent'],
				'update_time' => get_datetime(),
				'series_id' => $video['series_id'],
				'indexing' => $video['indexing'],
				'video_name' => $video['file_name'],
				'title' => $video['title'],
		);
		$this->load->model('Records_model');
		$this->Records_model->log_record($record);
	}
}