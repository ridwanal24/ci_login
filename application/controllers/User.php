<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}

	public function index()
	{
		$email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('user',['email' => $email])->row_array();

		if ($data['user']) {
			$data['title'] = 'My Profile';
			$this->load->view('_templates/header',$data);
			$this->load->view('_templates/sidebar');
			$this->load->view('_templates/topbar');
			$this->load->view('user/index');
			$this->load->view('_templates/footer');
		}
	}

	public function verify()
	{
		if ($this->session->userdata('email') == NULL) {
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Please login as Administrator!</div>');
			redirect('auth');			
		}
	}
}

/* End of file User.php */
/* Location: ./application/controllers/User.php */