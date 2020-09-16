<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UsersController extends CI_Controller
{
	private $msg_password_beda     = "{field} tidak sama dengan field Password";
	private $form_delimiter_open   = '<span class="help-block text-red">';
	private $form_delimiter_close  = "</span>";
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
		$password = sha1($this->input->post('password') . UYAH);

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

/* End of file  UsersController.php */
