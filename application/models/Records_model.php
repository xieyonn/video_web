<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Records_model extends CI_Model
{
	var $table = 'records';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function log_record($record)
	{
		$this->load->database();
		$this->db->where('user_name', $record['user_name']);
		$this->db->where('video_id', $record['video_id']);
		$data = $this->db->get($this->table)->row_array();
		if(empty($data))
		{
			$this->db->insert($this->table, $record);
		}
		else 
		{
			$this->db->where('user_name', $record['user_name']);
			$this->db->where('video_id', $record['video_id']);
			$this->db->update($this->table, $record);
		}
		$this->db->close();
	}
	
	function get_by_user_name($user_name)
	{
		$this->load->database();
		$this->db->where('user_name', $user_name);
		$this->db->order_by('indexing', 'ASC');
		$this->db->order_by('series_id', 'ASC');			
		$data = $this->db->get($this->table)->result_array();
		$this->db->close();
		
		if(! empty($data))
		{
			$series_id = $data[0]['series_id'];
			foreach ($data as $item)
			{			
				$retval[$series_id][$item['video_id']] = $item;
				$series_id = $item['series_id'];
			}
		}else{
			return;
		}
		
		return $retval;
	}
}