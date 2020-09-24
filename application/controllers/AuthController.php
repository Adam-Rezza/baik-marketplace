<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->ci = &get_instance();
		$this->load->helper(['cookie', 'string']);
		$this->ci->load->model('m_auth', 'authorized');
	}

	public function index()
	{
		$cookies = get_cookie(COOK);
		echo $cookies;

		$this->form_validation->set_rules('username', 'Username', 'callback_username_check');
		$this->form_validation->set_rules('password', 'Password', 'callback_password_check');
		if ($this->form_validation->run() === FALSE) {
			// $this->load->view('login');
			echo 'false';
		} else {
			$username = $this->input->post('username');
			$where = [
				'username' => $username,
				'active' => 1,
				'ban' => 0
			];
			$arr 	  = $this->authorized->get('user', '*', $where);
			$this->_set_session($arr->row());
			$this->login_merchant($arr->row()->id);
			echo 'true';
		}
	}

	public function username_check($str)
	{
		$where = [
			'username' => $str,
			'active' => 1,
			'ban' => 0
		];
		$arr = $this->authorized->get('user', '*', $where);
		if ($arr->num_rows() == 0) {
			$this->form_validation->set_message('username_check', USERNAME_SALAH_MSG);
			return FALSE;
		}
		return TRUE;
	}

	public function password_check($str)
	{
		$username = $this->input->post('username');
		$password = $str;
		$where = [
			'username'   => $username,
			'active' => 1,
			'ban' => 0
		];
		$arr = $this->authorized->get('user', '*', $where);
		if ($arr->num_rows() == 1) {
			$db_pass  = $arr->row()->password;
			if (password_verify($password, $db_pass)) {
				return TRUE;
			}
			$this->form_validation->set_message('password_check', PASSWORD_SALAH_MSG);
			return FALSE;
		}
		return FALSE;
	}

	private function _set_session($data)
	{
		$this->session->set_userdata(SESS . 'id', $data->id);
		$this->session->set_userdata(SESS . 'nama', $data->nama);
		$this->session->set_userdata(SESS . 'username', $data->username);
		$this->session->set_userdata(SESS . 'telp', $data->telp);
	}

	public function logout()
	{
		delete_cookie(COOK);
		$this->session->unset_userdata(SESS . 'id');
		$this->session->unset_userdata(SESS . 'merchant_id');
		$this->session->unset_userdata(SESS . 'username');
		$this->session->set_flashdata('logout', LOGOUT_MSG);
		redirect(site_url(), 'refresh');
	}

	public function register()
	{
		$data['nama'] = $this->input->post('name_r');
		$data['username'] = $this->input->post('username_r');
		$data['telp'] = $this->input->post('phone_r');
		$data['active'] = 1;
		$data['ban'] = 0;
		$data['password'] = password_hash($this->input->post('password_r'), PASSWORD_BCRYPT);
		$result = $this->ci->authorized->insert('user', $data);
		if ($result > 0) {
			$data['id'] = $result;
			$this->_set_session_r($data);
			echo "true";
		} else {
			echo 'false';
		}
	}

	public function unique_username()
	{
		$username = $this->input->post('username_r');
		$where = ['username'   => $username];
		$arr = $this->authorized->get('user', '*', $where);
		if ($arr->num_rows() > 0) {
			echo 'false';
		} else {
			echo 'true';
		}
	}

	private function _set_session_r($data)
	{
		$this->session->set_userdata(SESS . 'id', $data['id']);
		$this->session->set_userdata(SESS . 'username', $data['username']);
		$this->session->set_userdata(SESS . 'nama', $data['nama']);
		$this->session->set_userdata(SESS . 'telp', $data['telp']);
	}

	// ################--------Merchant--------##############################################

	public function login_merchant($user_id)
	{
		$where = [
			'user_id' => $user_id
		];
		$data = $this->authorized->get('toko', '*', $where);
		if ($data->num_rows() > 0) {
			$this->_set_session_merchant($data->row());
		}
	}

	public function register_merchant()
	{
		$data['nama'] = $this->input->post('nama');
		$data['telp'] = $this->input->post('telp');
		$data['alamat'] = $this->input->post('alamat');
		$data['user_id'] = $this->session->userdata(SESS . 'id');
		$data['active'] = 1;
		$data['ban'] = 0;
		$result = $this->ci->authorized->insert('toko', $data);
		if ($result > 0) {
			$data['id'] = strval($result);
			$this->_set_session_r_merchant($data);
			echo json_encode($result);
			// echo "true";
		} else {
			echo 'false';
		}
	}

	public function unique_name_merchant()
	{
		$username = $this->input->post('username_r');
		$where = ['username' => $username];
		$arr = $this->authorized->get('toko', '*', $where);
		if ($arr->num_rows() > 0) {
			echo 'false';
		} else {
			echo 'true';
		}
	}

	private function _set_session_merchant($data)
	{
		$this->session->set_userdata(SESS . 'merchant_id', $data->id);
		$this->session->set_userdata(SESS . 'merchant_nama', $data->nama);
		$this->session->set_userdata(SESS . 'merchant_telp', $data->telp);
	}

	private function _set_session_r_merchant($data)
	{
		$this->session->set_userdata(SESS . 'merchant_id', $data['id']);
		$this->session->set_userdata(SESS . 'merchant_nama', $data['nama']);
		$this->session->set_userdata(SESS . 'merchant_telp', $data['telp']);
	}
}

/* End of file LoginController.php */
/* Location: ./application/controllers/LoginController.php */