<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{

	public function get_sub_menu()
	{
		$this->db->join('user_menu', 'user_menu.id = user_sub_menu.menu_id');
		$sub_menu = $this->db->get('user_sub_menu')->result_array();
		return $sub_menu;
	}

	public function get_menu_id()
	{
		return $this->db->get('user_menu')->result_array();
	}
}

/* End of file Menu_model.php */
/* Location: ./application/models/Menu_model.php */
