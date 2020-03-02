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

	public function changepassword()
	{
		$email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('user',['email' => $email])->row_array();

		$data['title'] = 'Change Password';

		$this->form_validation->set_rules('current_password','Current Password','required|trim');
		$this->form_validation->set_rules('new_password1','New Password','required|trim|min_length[4]|matches[new_password2]');
		$this->form_validation->set_rules('new_password2','Repeat New Password','required|trim|matches[new_password1]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('_templates/header',$data);
			$this->load->view('_templates/sidebar');
			$this->load->view('_templates/topbar');
			$this->load->view('user/changepassword');
			$this->load->view('_templates/footer');
		} else {
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password1');
			if (! password_verify($current_password,$data['user']['password']) ) {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Current password is wrong</div>');
				redirect('user/changepassword');
			} else {
				if ($current_password == $new_password) {
					$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">New password cannot be same as current password</div>');
					redirect('user/changepassword');
				} else {
					$password_hash = password_hash($new_password, PASSWORD_DEFAULT);

					$this->db->where('email', $data['user']['email']);
					$this->db->set('password', $password_hash);
					$this->db->update('user');

					$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Password has been changed</div>');
					redirect('user/changepassword');
				}
			}
		}

	}

}

/* End of file User.php */
/* Location: ./application/controllers/User.php */