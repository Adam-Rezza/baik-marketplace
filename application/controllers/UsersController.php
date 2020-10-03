<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UsersController extends CI_Controller
{
	private $msg_password_beda     = "{field} tidak sama dengan field Password";
	private $msg_username_duplikat = "{field} sama ditemukan, silahkan gunakan username lain";

	public function __construct()
	{
		parent::__construct();
		$this->load->library('TemplateAdmin', NULL, 'template');
		$this->load->model('M_users_less', 'mless');
	}

	public function index()
	{
		$data['title']   = 'User Management';
		$data['content'] = 'user/index';
		$data['vitamin'] = 'user/index_vitamin';
		$this->template->template($data);
	}

	public function datatables()
	{
		$list = $this->mless->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row = array();

			if ($field->gambar == NULL) {
				$gambar = 'avatar_default.png';
			}

			$row['no']        = $no;
			$row['id']        = $field->id;
			$row['nama']      = $field->nama;
			$row['alamat']    = $field->alamat;
			$row['email']     = $field->email;
			$row['telp']      = $field->telp;
			$row['gambar']    = $gambar;
			$row['username']  = $field->username;
			$row['nama_toko'] = $field->nama_toko;
			$row['ban']       = $field->ban;
			$data[]           = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->mless->count_all(),
			"recordsFiltered" => $this->mless->count_filtered(),
			"data"            => $data,
			"lq"              => $this->mless->last_query()
		);

		echo json_encode($output);
	}

	public function change_status()
	{

		$id     = $this->input->post('id');
		$status = $this->input->post('status');

		if (!$id && !$status) {
			return show_404();
		}

		if ($status == '1') {
			$status = FALSE;
		} else {
			$status = TRUE;
		}

		$object = ['ban' => $status];
		$where  = ['id' => $id];
		$exec   = $this->mcore->update('user', $object, $where);

		if ($exec) {
			$return['code'] = 200;
		} else {
			$return['code'] = 500;
		}

		$return['sql'] = $this->db->last_query();
		$return['status'] = $status;

		echo json_encode($return);
	}

	public function reset_password()
	{
		$id       = $this->input->post('id');
		$password = password_hash($this->input->post('new_password') . UYAH, PASSWORD_DEFAULT);

		$object = ['password' => $password];
		$where  = ['id' => $id];
		$exec   = $this->mcore->update('user', $object, $where);

		if ($exec) {
			$ret = ['code' => 200];
		} else {
			$ret = ['code' => 500];
		}

		echo json_encode($ret);
	}
}

/* End of file  UsersController.php */
