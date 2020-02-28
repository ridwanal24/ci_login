<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		is_logged_in();
	}

	public function index()
	{
		$email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('user',['email' => $email])->row_array();

		$data['title'] = 'My Profile';
		$this->load->view('_templates/header',$data);
		$this->load->view('_templates/sidebar');
		$this->load->view('_templates/topbar');
		$this->load->view('user/index');
		$this->load->view('_templates/footer');
	}

	public function editprofile()
	{
		$email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('user',['email' => $email])->row_array();

		$data['title'] = 'Edit Profile';
		$this->form_validation->set_rules('name','Name','trim|required');
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('_templates/header',$data);
			$this->load->view('_templates/sidebar');
			$this->load->view('_templates/topbar');
			$this->load->view('user/edit');
			$this->load->view('_templates/footer');
		} else {
			$name = $this->input->post('name');
			$email = $this->input->post('email');

			/*if image changed*/
			$upload_image = $_FILES['image']['name'];
			if ($upload_image) {
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '2048';
				$config['upload_path'] = './assets/img/profile/';

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('image')) {
					$old_image = $data['user']['image'];
					if ( $old_image != 'default.jpg' ) {
						unlink(FCPATH . 'assets/img/profile/' . $old_image);
					}

					$new_image = $this->upload->data('file_name');
					$this->db->set('image', $new_image);
				} else {
					echo 'error';
				}
			}

			$this->db->set('name',$name);
			$this->db->where('email', $email);
			$this->db->update('user');
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Congratulations! Your account has been updated.</div>');
			redirect('user');
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