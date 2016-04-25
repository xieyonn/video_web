<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
	var $items_per_page = 5;
	
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
		$series = $this->Series_model->get_series(1, $this->items_per_page);
		foreach ($series as $key => $value)
		{
			$series[$key]['videos'] = $this->Videos_model->get_videos_by_series_id($value['id']);
		}
		$series_count = $this->Series_model->count_all_series();
		$this->load->model('Articles_model');
		$articles = $this->Articles_model->get(1, 5);
		$configs = $this->Configs_model->get_all();
		
		$param = array(
				'title' => 'whu_cs',
				'series' => $series,
				'series_count' => $series_count,
				'page_index' => 1,
				'page_num' => ceil($series_count / $this->items_per_page),
				'option' => 'paging',
				'articles' => $articles,
				'configs' => $configs,
				'show_news' => 1,
		);
		
		$this->load->view('home', $param);
	}

	public function search()
	{
		$search = urldecode($this->uri->segment(3, ''));	
		$page_index = $this->uri->segment(4, 1);
		if($page_index < 1)
		{
			$page_index = 1;
		}
		$series = $this->Series_model->get_series_by_search($search, $page_index, $this->items_per_page);
		$series_count = count($series);
		$page_num = ceil($series_count / $this->items_per_page);
		foreach ($series as $key => $value)
		{
			$series[$key]['videos'] = $this->Videos_model->get_videos_by_series_id($value['id']);
		}
		$configs = $this->Configs_model->get_all();
		
		$param = array(
				'page_index' => $page_index,
				'page_num' => $page_num,
				'series' => $series,
				'series_count' => $series_count,
				'search' => $search,
				'option' => 'search',
				'configs' => $configs,
		);
		
		$this->load->view('home', $param);
	}
	
	public function paging()
	{
		$series_count = $this->Series_model->count_all_series();
		$page_index = $this->uri->segment(3, 1);
		$page_num = ceil($series_count / $this->items_per_page);
		$series = $this->Series_model->get_series($page_index, $this->items_per_page);
		foreach ($series as $key => $value)
		{
			$series[$key]['videos'] = $this->Videos_model->get_videos_by_series_id($value['id']);
		}
		$configs = $this->Configs_model->get_all();
		
		$param = array(
				'page_index' => $page_index,
				'page_num' => $page_num,
				'series' => $series,
				'series_count' => $series_count,
				'option' => 'paging',
				'configs' => $configs,
		);
		
		$this->load->view('home', $param);
	}
	
	public function my_record()
	{
		$user_name = $_SESSION['user_name'];
		$this->load->model('Records_model');
		$records = $this->Records_model->get_by_user_name($user_name);
		$configs = $this->Configs_model->get_all();
		
		$param = array(
				'records' => $records,
				'configs' => $configs,
		);
		$this->load->view('record', $param);
	}
}