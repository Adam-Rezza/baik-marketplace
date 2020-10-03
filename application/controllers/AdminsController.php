<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminsController extends CI_Controller
{
	private $msg_password_beda     = "{field} tidak sama dengan field Password";
	private $form_delimiter_open   = '<span class="help-block text-red">';
	private $form_delimiter_close  = "</span>";
	private $msg_username_duplikat = "{field} sama ditemukan, silahkan gunakan username lain";

	public function __construct()
	{
		parent::__construct();
		$this->load->library('TemplateAdmin', NULL, 'template');
		$this->load->model('M_admins_less', 'mless');
	}

	public function index()
	{
		$this->form_validation->set_rules(
			'username',
			'Username',
			'callback_username_check'
		);
		$this->form_validation->set_rules(
			'password',
			'Password',
			'required|trim'
		);
		$this->form_validation->set_rules('verify_password', 'Verify Password', 'required|trim|matches[password]', array('matches' => $this->msg_password_beda));

		$this->form_validation->set_error_delimiters($this->form_delimiter_open, $this->form_delimiter_close);

		if ($this->form_validation->run() === FALSE) {
			$data['title']   = 'Admin Management';
			$data['content'] = 'admins/index';
			$data['vitamin'] = 'admins/index_vitamin';
			$this->template->template($data);
		} else {
			$cur_date = new DateTime('now');
			$username = strtolower($this->input->post('username'));
			$password = password_hash($this->input->post('password') . UYAH, PASSWORD_DEFAULT);

			$object = [
				'username'   => $username,
				'password'   => $password,
				'created_at' => $cur_date->format('Y-m-d H:i:s'),
				'updated_at' => $cur_date->format('Y-m-d H:i:s'),
				'deleted_at' => NULL
			];
			$exec = $this->mcore->store(TABLE_ADMINS, $object);

			if ($exec === TRUE) {
				$this->session->set_flashdata('success', TRUE);
			} else {
				$this->session->set_flashdata('error', TRUE);
			}
			redirect(site_url() . 'admins', 'refresh');
		}
	}

	public function destroy()
	{
		$cur_date = new DateTime('now');
		$id = $this->input->post('id');

		$object = ['deleted_at' => $cur_date->format('Y-m-d H:i:s')];
		$where  = ['id' => $id];
		$exec   = $this->mcore->update(TABLE_ADMINS, $object, $where);

		if ($exec) {
			$ret = ['code' => 200];
		} else {
			$ret = ['code' => 500];
		}

		echo json_encode($ret);
	}

	public function reset()
	{
		$id = $this->input->post('id');
		$password = password_hash($this->input->post('password') . UYAH, PASSWORD_DEFAULT);

		$object = ['password' => $password];
		$where  = ['id' => $id];
		$exec   = $this->mcore->update(TABLE_ADMINS, $object, $where);

		if ($exec) {
			$ret = ['code' => 200];
		} else {
			$ret = ['code' => 500];
		}

		echo json_encode($ret);
	}

	public function datatables()
	{
		$list = $this->mless->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row             = array();
			$row['no']       = $no;
			$row['id']       = $field->id;
			$row['username'] = $field->username;
			$data[]          = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->mless->count_all(),
			"recordsFiltered" => $this->mless->count_filtered(),
			"data"            => $data,
		);

		echo json_encode($output);
	}

	public function username_check($str)
	{
		$where = [
			'username'   => $str,
			'deleted_at' => NULL
		];
		$arr = $this->mcore->get(TABLE_ADMINS, '*', $where);

		if ($arr->num_rows() > 0) {
			$this->form_validation->set_message('username_check', $this->msg_username_duplikat);
			return FALSE;
		} else {
			return TRUE;
		}
	}
}

/* End of file  AdminsController.php */
