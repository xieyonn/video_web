<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles_model extends CI_Model
{
	var $table = 'articles';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function add($article)
	{
		$this->load->database();
		$this->db->insert($this->table, $article);
		$this->db->close();
	}
	
	function delete($article_id)
	{
		$this->load->database();
		$this->db->delete($this->table, array('id' => $article_id));
		$this->db->close();
	}
	
	function update($article)
	{
		$this->load->database();
		$this->db->where('id', $article['id']);
		$this->db->update($this->table, $article);
	}
	
	function add_clicks($article_id)
	{
		$this->load->database();
		$this->db->query('UPDATE '.$this->table.' SET clicks = clicks + 1 WHERE id = '.$article_id);
		$this->db->close();
	}
	
	function get_by_id($article_id)
	{
		$this->load->database();
		$this->db->where('id', $article_id);
		$data = $this->db->get($this->table)->row_array();
		$this->db->close();
		
		return $data;
	}
	
	function get($page_index = 1, $items_per_page = 5)
	{
		$this->load->database();
		$this->db->limit($items_per_page, ($page_index - 1) * $items_per_page);
		$this->db->order_by('update_time', 'DESC');
		$data = $this->db->get($this->table)->result_array();
		$this->db->close();
		
		return $data;
	}
	
	function get_by_search($search, $page_index = 1, $items_per_page = 10)
	{
		$this->load->database();
		$this->db->order_by('indexing', 'DESC');
		$this->db->limit($items_per_page, (($page_index - 1) * $items_per_page));
		$this->db->like('title', $search);
		$data = $this->db->get($this->table)->result_array();
		$this->db->close();
		
		return $data;
	}
	
	function count_all_articles()
	{
		$this->load->database();
		$count = $this->db->count_all_results($this->table);
		$this->db->close();
		return $count;
	}
}