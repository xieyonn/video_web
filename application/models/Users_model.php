<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model
{
	var $table = 'users';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function add($user)
	{
		$user = array(
				'user_name' => $user['user_name'],
				'password' => encrypt_password($user['password']),
				'create_time' => get_datetime(),	
		);
		$this->load->database();
		$this->db->insert($this->table, $user);
		$this->db->close();
	}
	
	function is_user_name_exist($user_name)
	{
		$this->load->database();
		$this->db->select('*');
		$this->db->where('user_name', $user_name);
		$data = $this->db->get($this->table)->result_array();
		$this->db->close();
		
		return (1 == count($data));
	}
	
	function verify_password($user_name, $passowrd)
	{
		$this->load->database();
		$this->db->select('password');
		$this->db->where('user_name', $user_name);
		$data = $this->db->get($this->table)->row_array();
		$this->db->close();
		
		return (0 == strcmp($data['password'], encrypt_password($passowrd)));
	}
	
	function delete($user_name)
	{
		$this->load->database();
		$this->db->delete($this->table, array('user_name' => $user_name));
		$this->db->close();
	}
	
	function update_password($user_name, $password)
	{
		$this->load->database();
		$this->db->where('user_name', $user_name);
		$this->db->update($this->table, array('password' => encrypt_password($password)));
		$this->db->close();
	}
	
	function log_login_time($user_name)
	{
		$this->load->database();
		$this->db->where('user_name', $user_name);
		$this->db->update($this->table, array('last_login_time' => get_datetime()));
		$this->db->close();
	}
	
	function get_users($page_index = 1, $items_per_page = 10)
	{
		if($page_index < 1)
		{
			$page_index = 1;
		}
		
		$this->load->database();
		$this->db->select('user_name, create_time, last_login_time');
		$this->db->order_by('user_name', 'ASC');
		$this->db->limit($items_per_page, (($page_index - 1) * $items_per_page));
		$data = $this->db->get($this->table)->result_array();
		$this->db->close();
		
		return $data;
	}
	
	function count_all_users()
	{
		$this->load->database();
		$count = $this->db->count_all_results($this->table);
		$this->db->close();
		
		return $count;
	}
	
	function get_users_by_search($search, $page_index = 1, $items_per_page = 10)
	{
		$this->load->database();
		$this->db->select('user_name, create_time, last_login_time');
		$this->db->order_by('user_name', 'ASC');
		$this->db->limit($items_per_page, (($page_index - 1) * $items_per_page));
		$this->db->like('user_name', $search);
		$data = $this->db->get($this->table)->result_array();
		$this->db->close();
		
		return $data;
	}
	
	function count_search($search)
	{
		if('' == $search)
		{
			return 0;
		}
		$this->load->database();
		$this->db->select('COUNT(*)');
		$this->db->like('user_name', $search);
		$data = $this->db->get($this->table)->row_array();
		$this->db->close();
		
		return $data['COUNT(*)'];
	}
}