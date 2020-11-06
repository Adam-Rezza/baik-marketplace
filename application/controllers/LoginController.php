<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(['cookie', 'string']);
	}

	public function index()
	{
		$cookies = get_cookie(COOK);

		if ($cookies != NULL) {
			$check_cookies = $this->mcore->get(TABLE_ADMINS, '*', ['cookies' => $cookies]);

			if ($check_cookies->num_rows() == 1) {
				$id       = $check_cookies->row()->id;
				$username = $check_cookies->row()->username;

				$this->_set_session($id, $username);
				$this->session->set_flashdata('first_login', FIRST_LOGIN_MSG);
				redirect(site_url() . 'dashboard');
			} else {
				delete_cookie(COOK);
				$this->session->set_flashdata('expired', EXPIRED_MSG);
				redirect(site_url(), 'refresh');
			}
		} else {
			$this->form_validation->set_rules('username', 'Username', 'callback_username_check');
			$this->form_validation->set_rules('password', 'Password', 'callback_password_check');

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('login');
			} else {
				$username = $this->input->post('username');

				$where = [
					'username'   => $username,
					'deleted_at' => NULL
				];
				$arr = $this->mcore->get(TABLE_ADMINS, '*', $where);

				$id       = $arr->row()->id;
				$username = $arr->row()->username;
				$this->_set_session($id, $username);

				$remember = $this->input->post('remember');
				if ($remember == 'on') {
					$key_cookies = random_string('alnum', 64);
					set_cookie(COOK, $key_cookies, 3600 * 24 * 30);
					$this->mcore->update(TABLE_ADMINS, ['cookies' => $key_cookies, 'remember' => 'yes'], ['id' => $id]);
				}

				redirect(site_url('dashboard'));
			}
		}
	}

	public function username_check($str)
	{
		$where = [
			'username'   => $str,
			'deleted_at' => NULL
		];
		$arr = $this->mcore->get(TABLE_ADMINS, '*', $where);

		if ($arr->num_rows() == 0) {
			$this->form_validation->set_message('username_check', USERNAME_SALAH_MSG);
			return FALSE;
		}
		return TRUE;
	}

	public function password_check($str)
	{
		$username = $this->input->post('username');
		$password = $str . UYAH;

		$where = [
			'username'   => $username,
			'deleted_at' => NULL
		];
		$arr = $this->mcore->get(TABLE_ADMINS, '*', $where);

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

	public function _set_session($id, $username)
	{
		$this->session->set_userdata(SESS . 'id', $id);
		$this->session->set_userdata(SESS . 'username', $username);
	}

	public function logout()
	{
		delete_cookie(COOK);
		$this->session->unset_userdata(SESS . 'id');
		$this->session->unset_userdata(SESS . 'username');
		$this->session->set_flashdata('logout', LOGOUT_MSG);
		redirect(site_url('login'), 'refresh');
	}

	public function change_password()
	{
		$id               = $this->session->userdata(SESS . 'id');
		$current_password = $this->input->post('current_pass') . UYAH;
		$new_password     = $this->input->post('new_pass');

		if ($id == NULL) {
			echo json_encode(['code' => 404]);
			exit;
		}
		$admin = $this->mcore->get('admins', '*', ['id' => $id]);

		if ($admin->num_rows() == 0) {
			echo json_encode(['code' => 404]);
			exit;
		}

		$password_db = $admin->row()->password;

		if (!password_verify($current_password, $password_db)) {
			echo json_encode(['code' => 501, 'id' => $id, 'current_password' => $current_password]);
			exit;
		}

		$new_password = password_hash($new_password . UYAH, PASSWORD_BCRYPT);

		$exec = $this->mcore->update('admins', ['password' => $new_password], ['id' => $id]);

		if (!$exec) {
			echo json_encode(['code' => 500]);
			exit;
		}

		echo json_encode(['code' => 200]);
		exit;
	}
}

/* End of file LoginController.php */
/* Location: ./application/controllers/LoginController.php */
