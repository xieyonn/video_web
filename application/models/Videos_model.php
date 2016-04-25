<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Videos_model extends CI_Model
{
	var $table = 'videos';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function add($video)
	{
		$this->load->database();
		$this->db->insert($this->table, $video);
		
		$this->Series_model->add_videos_amount($video['series_id'], 1);
		$this->db->close();
	}
	
	function delete($video)
	{
		$this->load->database();
		$this->db->delete($this->table, array('id' => $video['id']));
		
		$this->Series_model->add_videos_amount($video['series_id'], -1);
		$this->db->close();
	}
	
	function edit($video)
	{
		$this->load->database();
		$this->db->where('id', $video['id']);
		$this->db->update($this->table, $video);
		$this->db->close();
	}
	
	function get_by_series_id($series_id)
	{
		$this->load->database();
		$this->db->where('series_id', $series_id);
		$this->db->order_by('indexing', 'ASC');
		$data = $this->db->get($this->table)->result_array();
		$this->db->close();
		
		return $data;
	}
	
	function get_video_by_id($video_id)
	{
		$this->load->database();
		$this->db->where('id', $video_id);
		$data = $this->db->get($this->table)->row_array();
		$this->db->close();
		
		return $data;
	}
	
	function get_videos_by_series_id($series_id)
	{
		$this->load->database();
		$this->db->where('series_id', $series_id);
		$this->db->order_by('indexing', 'ASC');
		$data = $this->db->get($this->table)->result_array();
		$this->db->close();
		
		return $data;
	}
	
	function get_video_by_name($video_name)
	{
		$this->load->database();
		$this->db->where('file_name', $video_name);
		$data = $this->db->get($this->table)->row_array();
		$this->db->close();
		
		return $data;
	}
}