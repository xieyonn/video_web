<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends CI_Controller
{
	var $items_per_page = 10;
	
	function __construct()
	{
		parent::__construct();
		session_start();
		if(! isset($_SESSION['user_name'])){
			redirect('index.php/login');
		}
		$this->load->model('Configs_model');
		$this->load->model('Articles_model');
	}
	
	public function index()
	{
		$articles = $this->Articles_model->get(1, $this->items_per_page);
		$configs = $this->Configs_model->get_all();
		$articles_count = $this->Articles_model->count_all_articles();
		$page_num = ceil($articles_count / $this->items_per_page);
		
		$param = array(
				'configs' => $configs,
				'articles' => $articles,
				'articles_count' => $articles_count,
				'page_index' => 1,
				'page_num' => $page_num,
				'option' => 'paging',
		);
		$this->load->view('articles_list', $param);
	}
	
	public function paging()
	{
		$page_index = $this->uri->segment(3,1);
		if(! is_numeric($page_index))
		{
			show_404();
		}
		$articles = $this->Articles_model->get($page_index, $this->items_per_page);
		$configs = $this->Configs_model->get_all();
		$articles_count = $this->Articles_model->count_all_articles();
		$page_num = ceil($articles_count / $this->items_per_page);
		
		$param = array(
				'configs' => $configs,
				'articles' => $articles,
				'articles_count' => $articles_count,
				'page_index' => $page_index,
				'page_num' => $page_num,
				'option' => 'paging',
		);
		$this->load->view('articles_list', $param);
	}
	
	public function detail()
	{
		$article_id = $this->uri->segment(3);
		if(! is_numeric($article_id)){
			show_404();
		}
		
		$article = $this->Articles_model->get_by_id($article_id);
		if(empty($article))
		{
			show_404();
		}
		$this->Articles_model->add_clicks($article_id);
		$configs = $this->Configs_model->get_all();
		$param = array(
				'configs' => $configs,
				'title' => $article['title'],
				'article' => $article,
		);
		$this->load->view('article', $param);
	}
	
	public function download()
	{
		$file = $this->uri->segment(3);

		$file_path = './'.$this->config->item('articles_dir_name').'/files/'.$file;
		if(!file_exists($file_path))
		{
			show_error("文件不存在");
		}
		
		$this->load->helper('download');
		force_download($file_path, NULL);
	}
}