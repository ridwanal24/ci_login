<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		login_status();
		$this->login();
	}

	public function login()
	{
		$this->form_validation->set_rules('email','Email','required|trim|valid_email');
		$this->form_validation->set_rules('password','Password','required|trim');
		
		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'User Login';
			$this->load->view('_templates/auth_header',$data);
			$this->load->view('auth/login');
			$this->load->view('_templates/auth_footer');
		} else {
			$email = htmlspecialchars($this->input->post('email', TRUE));
			$password = $this->input->post('password');

			$user = $this->db->get_where('user',['email' => $email])->row_array();

			//Jika user ada
			if ($user) {

				//Jika user aktif
				if ($user['is_active'] == 1) {
					
					//Jika password cocok
					if (password_verify($password, $user['password'])) {
						$data = [
							'email' => $user['email'],
							'rule_id' => $user['rule_id']
						];

						$this->session->set_userdata($data);
						
						if ( $user['rule_id'] == 1 ) {
							redirect('admin');
						} else {
							redirect('user');
						}
					} else {
						$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Your password is wrong!</div>');
						redirect('auth/login');
					}
				} else {
					$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Please check your email to activated</div>');
					redirect('auth/login');
				}
			} else {
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Email not registered</div>');
				redirect('auth/login');
			}
		}


	}

	public function registration()
	{
		login_status();
		$this->form_validation->set_rules('name','Name','required|trim');
		$this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[4]|matches[password2]',[
			'matches' => 'Password must matches!',
			'min_length' => 'Password too short!'
		]);
		$this->form_validation->set_rules('password2', 'Password', 'trim|required|matches[password1]');

		if ( $this->form_validation->run() == FALSE ) {
			$data['title'] = 'User Registration';
			$this->load->view('_templates/auth_header',$data);
			$this->load->view('auth/registration');
			$this->load->view('_templates/auth_footer');
		} else {
			$data = [
				'name' => htmlspecialchars( $this->input->post('name', TRUE) ),
				'email' => htmlspecialchars( $this->input->post('email', TRUE) ),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'rule_id' => 2,
				'is_active' => 1,
				'date_created' => time()
			];

			$this->db->insert('user',$data);
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Congratulations! Your account has been created successfully.</div>');
			redirect('auth/login');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('rule_id');

		$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">You has been logout!</div>');

		redirect('auth/login');
	}

	public function blocked()
	{
		$email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('user',['email' => $email])->row_array();
		$data['title'] = 'Permission Denied';
		$this->load->view('_templates/header',$data);
		$this->load->view('_templates/sidebar');
		$this->load->view('_templates/topbar');
		$this->load->view('auth/blocked');
		$this->load->view('_templates/footer');
	}

}

/* End of file Auth */
/* Location: ./application/controllers/Auth */