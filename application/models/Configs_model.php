<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Configs_model extends CI_Model
{
	var $table = 'configs';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function update($item)
	{
		$this->load->database();
		$this->db->where('key_d', $item['key_d']);
		$this->db->update($this->table, array('value_d' => $item['value_d']));
		$this->db->close();
	}
	
	function get($key)
	{
		$this->load->database();
		$this->db->where('key_d', $key);
		$data = $this->db->get($this->table)->row_array();
		$this->db->close();
		
		return $data['value'];
	}
	
	function get_all()
	{
		$this->load->database();
		$data = $this->db->get($this->table)->result_array();
		$this->db->close();
		foreach ($data as $item)
		{
			$configs[$item['key_d']] = $item['value_d'];
		}
		
		return $configs;
	}
}