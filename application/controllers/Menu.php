<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Menu_model', 'menu', TRUE);
		is_logged_in();
	}

	public function index()
	{
		$email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
		$data['menu'] = $this->db->get('user_menu')->result_array();

		if (!$this->add()) {
			$data['title'] = 'Menu Management';
			$this->load->view('_templates/header', $data);
			$this->load->view('_templates/sidebar');
			$this->load->view('_templates/topbar');
			$this->load->view('menu/index');
			$this->load->view('_templates/footer');
		} else {
			$menu = $this->input->post('menu');
			$this->db->insert('user_menu', ['menu' => $menu]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu has been added</div>');
			redirect('menu');
		}
	}

	private function add()
	{
		$this->form_validation->set_rules('menu', 'Menu', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function delete($id)
	{
		$delete = $this->db->delete('user_menu', ['id' => $id]);
		if ($delete) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu has been deleted</div>');
			redirect('menu');
		}
	}

	public function edit($id)
	{
		$this->form_validation->set_rules('menu', 'Menu', 'required|trim');
		if ($this->form_validation->run() == TRUE) {
			$menu = $this->input->post('menu');
			$edit = $this->db->update('user_menu', ['menu' => $menu], ['id' => $id]);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu has been edited</div>');
			redirect('menu');
		}
	}

	public function submenu()
	{
		$data['title'] = 'Sub Menu Management';
		$email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('user', ['email' => $email])->row_array();
		$data['submenu'] = $this->menu->get_sub_menu();
		$data['menu'] = $this->menu->get_menu_id();

		$this->form_validation->set_rules('title', 'Title', 'trim|required');
		$this->form_validation->set_rules('menu_id', 'Select Menu', 'trim|required');
		$this->form_validation->set_rules('url', 'Url', 'trim|required');
		$this->form_validation->set_rules('icon', 'Icon', 'trim|required');

		if ($this->form_validation->run() == FALSE) {	
			$this->load->view('_templates/header', $data);
			$this->load->view('_templates/sidebar');
			$this->load->view('_templates/topbar');
			$this->load->view('menu/submenu');
			$this->load->view('_templates/footer');
		} else {
			$data = [
				'title' => $this->input->post('title'),
				'menu_id' => $this->input->post('menu_id'),
				'url' => $this->input->post('url'),
				'icon' => $this->input->post('icon'),
				'is_active' => $this->input->post('is_active')
			];

			$this->db->insert('user_sub_menu',$data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sub Menu has been added</div>');
			redirect('menu/submenu');
		}

	}

}

/* End of file Menu.php */
/* Location: ./application/controllers/Menu.php */
