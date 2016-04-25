<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins_model extends CI_Model
{
	var $table = 'admins';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function is_user_name_exist($user_name)
	{
		$this->load->database();
		$this->db->select('*');
		$this->db->where('user_name', $user_name);
		$result = $this->db->get($this->table)->result();
		$this->db->close();
		
		return (1 === count($result));
	}
	
	function add($admin)
	{
		if($this->is_user_name_exist($admin['user_name']))
		{
			return FALSE;
		}
			
		$data = array(
				'user_name' => $admin['user_name'],
				'password' => encrypt_password($admin['password']),
				'type' => 1,
				'create_time' => get_datetime(),
		);
			
		$this->load->database();
		$this->db->insert($this->table, $data);
		$this->db->close();
		
		return TRUE;
	}
	
	function update_password($admin)
	{
		$data = array(
				'password' => encrypt_password($admin['password']),
		);

		$this->load->database();
		$this->db->where('user_name', $admin['user_name']);
		$this->db->update($this->table, $data);
		$this->db->close();
	}
	
	function delete($user_name)
	{
		$this->load->database();
		$this->db->where('user_name', $user_name);
		$this->db->delete($this->table);
		$this->db->close();
		
		return TRUE;
	}
	
	function verify_password($user_name, $password)
	{
		$this->load->database();
		$this->db->select('password');
		$this->db->where('user_name', $user_name);
		$result = $this->db->get($this->table)->row_array();
		$this->db->close();
		
		return (0 === strcmp($result['password'], encrypt_password($password)));
	}
	
	function get_all()
	{
		$this->load->database();
		$result = $this->db->get($this->table)->result_array();
		$this->db->close();
		
		return $result;
	}
	
	function log_login_time($user_name)
	{
		$this->load->database();
		$this->db->where('user_name', $user_name);
		$this->db->update($this->table, array('last_login_time' => get_datetime()));
		$this->db->close();
	}
	
	function update_nickname($user_name, $nick_name)
	{
		$this->load->database();
		$this->db->where('user_name', $user_name);
		$this->db->update($this->table, array('nick_name' => $nick_name));
		$this->db->close();
	}
	
	function get_nick_name($user_name)
	{
		$this->load->database();
		$this->db->select('nick_name');
		$this->db->where('user_name', $user_name);
		$data = $this->db->get($this->table)->row_array();
		$this->db->close();
		
		return $data['nick_name'];
	}
}
