<?php

function check_access($rule_id,$menu_id)
{
	$CI = get_instance();
	$result = $CI->db->get_where('user_access_menu',[
		'rule_id' => $rule_id,
		'menu_id' => $menu_id
	])->num_rows();

	if ($result > 0) {
		return 'checked="checked"';
	}
}

function login_status()
{
	$CI = get_instance();
	if ($CI->session->userdata('email')) {
		redirect('user');
	}
}

function is_logged_in()
{
	$CI = get_instance();
	if (!$CI->session->userdata('email')) {
		$CI->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Please login as Administrator!</div>');
		redirect('auth');	
	} else {
		$rule_id = $CI->session->userdata('rule_id');
		
		$menu = $CI->uri->segment(1);
		$query = $CI->db->get_where('user_menu',['menu' => $menu])->row_array();
		
		$menu_id = $query['id'];

		$query = $CI->db->get_where('user_access_menu',[
			'rule_id' => $rule_id,
			'menu_id' => $menu_id
		]);

		if ($query->num_rows() < 1) {
			redirect('auth/blocked');
		}
	}
}