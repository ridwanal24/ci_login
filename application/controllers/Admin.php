<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		is_logged_in();
		$this->load->library('form_validation');
	}

	public function index()
	{
		
		$email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('user',['email' => $email])->row_array();

		$data['title'] = 'Dashboard';
		$this->load->view('_templates/header',$data);
		$this->load->view('_templates/sidebar');
		$this->load->view('_templates/topbar');
		$this->load->view('admin/index');
		$this->load->view('_templates/footer');
	}

	public function rule()
	{		
		$email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('user',['email' => $email])->row_array();

		$data['rule'] = $this->db->get('user_rule')->result_array();

		$data['title'] = 'Role';
		$this->load->view('_templates/header',$data);
		$this->load->view('_templates/sidebar');
		$this->load->view('_templates/topbar');
		$this->load->view('admin/rule');
		$this->load->view('_templates/footer');
	}

	public function addrule()
	{
		$email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('user',['email' => $email])->row_array();
		$data['rule'] = $this->db->get('user_rule')->result_array();
		$data['title'] = 'Role';

		$this->form_validation->set_rules('rule','Rule','trim|required');
		$rule = htmlspecialchars($this->input->post('rule', TRUE));

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('_templates/header',$data);
			$this->load->view('_templates/sidebar');
			$this->load->view('_templates/topbar');
			$this->load->view('admin/rule');
			$this->load->view('_templates/footer');
		} else {
			$data = [
				'rule' => $rule
			];
			$this->db->insert('user_rule',$data);

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Rule has been added</div>');
			redirect('admin/rule');
		}
	}

	public function editrule($id)
	{
		
		$email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('user',['email' => $email])->row_array();
		$data['rule'] = $this->db->get('user_rule')->result_array();
		$data['title'] = 'Role';

		$this->form_validation->set_rules('rule','Rule','trim|required');
		$rule = htmlspecialchars($this->input->post('rule', TRUE));

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('_templates/header',$data);
			$this->load->view('_templates/sidebar');
			$this->load->view('_templates/topbar');
			$this->load->view('admin/rule');
			$this->load->view('_templates/footer');
		} else {
			$data =['rule' => $rule];
			$this->db->update('user_rule',$data,['id' => $id]);

			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Rule has been update</div>');
			redirect('admin/rule');
		}
	}

	public function deleterule($id)
	{
		$query = $this->db->get_where('user_rule',['id'=>$id])->row_array();
		$rule = $query['rule'];

		$delete = $this->db->delete('user_rule', ['id' => $id]);
		if ($delete) {
			$message = '<div class="alert alert-success" role="alert">Rule '.$rule.' has been deleted</div>';
			$this->session->set_flashdata('message', $message);
			redirect('admin/rule');
		}
	}

	public function ruleaccess($rule_id)
	{
		$email = $this->session->userdata('email');
		$data['user'] = $this->db->get_where('user',['email' => $email])->row_array();
		$data['rule'] = $this->db->get_where('user_rule',['id' => $rule_id])->row_array();
		$this->db->where('id !=', 1);
		$data['menu'] = $this->db->get('user_menu')->result_array();

		$data['title'] = 'Rule Access';
		$this->load->view('_templates/header',$data);
		$this->load->view('_templates/sidebar');
		$this->load->view('_templates/topbar');
		$this->load->view('admin/rule-access',$data);
		$this->load->view('_templates/footer');
	}

	public function changeaccess()
	{
		$menu_id = $this->input->post('menu_id');
		$rule_id = $this->input->post('rule_id');

		$data = [
			'rule_id' => $rule_id,
			'menu_id' =>$menu_id
		];

		$result = $this->db->get_where('user_access_menu', $data);

		if ($result->num_rows() < 1) {
			$this->db->insert('user_access_menu', $data);
		} else {
			$this->db->delete('user_access_menu', $data);
		}

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Rule has been update</div>'); 

	}

}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */