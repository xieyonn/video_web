<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Series_model extends CI_Model
{
	var $table = 'series';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function add_series($series)
	{
		if(isset($series['title']) && isset($series['admin']))
		{
			$data = array(
					'title' => $series['title'],
					'brief' => isset($series['brief'])? $series['brief']:'',
					'create_time' => get_datetime(),
					'update_time' => get_datetime(),
					'admin' => $series['admin'],
					'amount' => 0,
					'cover_name' => $series['cover_name'],
					'series_name' => $series['series_name'],
					'status' => $series['status'],
			);
			$this->load->database();
			$this->db->insert($this->table, $data);
			$this->db->close();
		}
		else 
		{
			log_message('error', __FUNCTION__.__LINE__);
		}
	}
	
	function delete_series($id)
	{
		if(isset($id))
		{
			$this->load->database();
			$this->db->delete($this->table, array('id' => $id));
			$this->db->close();
		}
		else
		{
			log_message('error', __FUNCTION__.__LINE__);
		}
	}
	
	function count_all_series()
	{
		$this->load->database();
		$count = $this->db->count_all_results($this->table);
		$this->db->close();
		return $count;
	}
	
	function count_search($search)
	{
		if('' == $search)
		{
			return 0;
		}
		$this->load->database();
		$this->db->select('COUNT(*)');
		$this->db->like('title', $search);
		$data = $this->db->get($this->table)->row_array();
		$this->db->close();
		
		return $data['COUNT(*)'];
	}
	
	function get_series($page_index = 1, $items_per_page = 10)
	{
		if($page_index < 1)
		{
			$page_index = 1;
		}
	
		$this->load->database();
		$this->db->order_by('update_time', 'DESC');
		$this->db->limit($items_per_page, (($page_index - 1) * $items_per_page));
		$data = $this->db->get($this->table)->result_array();
		$this->db->close();
	
		return $data;
	}
	
	function get_series_by_search($search, $page_index = 1, $items_per_page = 10)
	{
		$this->load->database();
		$this->db->order_by('update_time', 'DESC');
		$this->db->limit($items_per_page, (($page_index - 1) * $items_per_page));
		$this->db->like('title', $search);
		$data = $this->db->get($this->table)->result_array();
		$this->db->close();
	
		return $data;
	}
	
	function get_series_by_id($id)
	{
		$this->load->database();
		$this->db->where('id', $id);
		$data = $this->db->get($this->table)->row_array();
		$this->db->close();
		
		return $data;
	}
	
	function edit_series($series)
	{
		$this->load->database();
		$this->db->where('id', $series['id']);
		$this->db->update($this->table, $series);
		$this->db->close();
	}
	
	function add_videos_amount($series_id, $num)
	{
		$this->load->database();
		$this->db->select('amount');
		$this->db->where('id', $series_id);
		$data = $this->db->get($this->table)->row_array();
		$amount = $data['amount'] + $num;
		if($amount < 0)
		{
			$amount = 0;
		}
		$this->db->where('id', $series_id);
		$this->db->update($this->table, array('amount' => $amount));
		$this->db->close();
	}
}