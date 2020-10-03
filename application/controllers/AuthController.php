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
		$result = $this->authorized->insert('user', $data);
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

	################--------Change_Password--------##############################################

	public function change_password()
	{
		$password_old = $this->input->post('password_old_u');
		$password_new = $this->input->post('password_u');
		$where = [
			'id'   => $this->session->userdata(SESS . 'id'),
		];
		$arr = $this->authorized->get('user', 'password', $where);
		if ($arr->num_rows() == 1) {
			$db_pass  = $arr->row()->password;
			if (password_verify($password_old, $db_pass)) {
				$data = [
					'password' => password_hash($password_new, PASSWORD_BCRYPT)
				];
				$result = $this->authorized->update('user', $data, $this->session->userdata(SESS . 'id'));
				echo json_encode($result > 0 ? 'true' : 'false');
			} else {
				echo json_encode('false');
			}
		} else {
			echo json_encode('false');
		}
	}

	################--------Basic_Info--------##############################################

	public function save_basic_info()
	{
		$data = [
			'nama' => $this->input->post('name_u'),
			'telp' => $this->input->post('phone_u'),
		];
		if ($this->session->userdata(SESS . 'id')) {
			$result = $this->authorized->update('user', $data, $this->session->userdata(SESS . 'id'));
			echo json_encode($result > 0 ? 'true' : 'false');
		}
	}

	################--------Alamat--------##############################################

	public function save_address()
	{
		$data = [
			'user_id' => $this->session->userdata(SESS . 'id'),
			'alamat' => $this->input->post('alamat'),
			'provinsi' => $this->input->post('provinsi'),
			'kota' => $this->input->post('kabupaten'),
			'kecamatan' => $this->input->post('kecamatan'),
			'kelurahan' => $this->input->post('kelurahan'),
			'def' => 1,
			'del' => 0
		];
		$id = $this->input->post('alamat_id');
		if ($id) {
			$result = $this->authorized->update('alamat', $data, $id);
			echo $this->session->userdata('checkout') ? 'checkout' : ($result ? 'true' : 'false');
		} else {
			$result = $this->authorized->insert('alamat', $data);
			echo $this->session->userdata('checkout') ? 'checkout' : ($result ? 'true' : 'false');
		}
	}

	public function get_kabupaten($id_prov)
	{
		$where = ['id_prov' => $id_prov];
		$result = $this->authorized->get('kabupaten', '*', $where)->result();
		echo json_encode($result);
	}

	public function get_kecamatan($id_kab)
	{
		$where = ['id_kab' => $id_kab];
		$result = $this->authorized->get('kecamatan', '*', $where)->result();
		echo json_encode($result);
	}

	public function get_kelurahan($id_kec)
	{
		$where = ['id_kec' => $id_kec];
		$result = $this->authorized->get('kelurahan', '*', $where)->result();
		echo json_encode($result);
	}

	################--------Merchant--------##############################################

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
		$data['provinsi'] = $this->input->post('provinsi');
		$data['kota'] = $this->input->post('kabupaten');
		$data['kecamatan'] = $this->input->post('kecamatan');
		$data['kelurahan'] = $this->input->post('kelurahan');
		$data['user_id'] = $this->session->userdata(SESS . 'id');
		$data['active'] = 1;
		$data['ban'] = 0;
		$result = $this->authorized->insert('toko', $data);
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
		$this->session->set_userdata(SESS . 'merchant_active', $data->active);
		$this->session->set_userdata(SESS . 'merchant_nama', $data->nama);
		$this->session->set_userdata(SESS . 'merchant_telp', $data->telp);
	}

	private function _set_session_r_merchant($data)
	{
		$this->session->set_userdata(SESS . 'merchant_id', $data['id']);
		$this->session->set_userdata(SESS . 'merchant_active', $data['active']);
		$this->session->set_userdata(SESS . 'merchant_nama', $data['nama']);
		$this->session->set_userdata(SESS . 'merchant_telp', $data['telp']);
	}

	public function save_profile_merchant()
	{
		if ($this->session->userdata(SESS . 'merchant_id')) {
			$data['nama'] = $this->input->post('name_t');
			$data['telp'] = $this->input->post('phone_t');
			$data['desc'] = $this->input->post('desc_t');
			// var_dump($this->input->post());
			$result = $this->authorized->update('toko', $data, $this->session->userdata(SESS . 'merchant_id'));
			if ($result > 0) {
				$this->session->set_userdata(SESS . 'merchant_nama', $data['nama']);
				$this->session->set_userdata(SESS . 'merchant_telp', $data['telp']);
				echo json_encode("true");
			} else {
				echo json_encode("false");
			}
		}
	}

	public function save_address_merchant()
	{
		if ($this->session->userdata(SESS . 'merchant_id')) {
			$data['alamat'] = $this->input->post('alamat');
			$data['provinsi'] = $this->input->post('provinsi');
			$data['kota'] = $this->input->post('kabupaten');
			$data['kecamatan'] = $this->input->post('kecamatan');
			$data['kelurahan'] = $this->input->post('kelurahan');
			$result = $this->authorized->update('toko', $data, $this->session->userdata(SESS . 'merchant_id'));
			if ($result > 0) {
				echo json_encode("true");
			} else {
				echo json_encode("false");
			}
		}
	}

	################--------Foto_Profil--------##############################################

	public function upload_image_profile()
	{
		$modul = $this->input->post('modul');
		$image = $this->input->post('image');
		$filename = $this->session->userdata(SESS . 'id') . uniqid() . '.png';

		if ($modul == 'user') {
			$folderPath = 'public/img/profile/';
			$id = $this->session->userdata(SESS . 'id');
		} else if ($modul == 'toko') {
			$folderPath = 'public/img/profile_toko/';
			$id = $this->session->userdata(SESS . 'merchant_id');
		}
		$image_parts = explode(";base64,", $image);
		$image_type_aux = explode("image/", $image_parts[0]);
		$image_type = $image_type_aux[1];
		$image_base64 = base64_decode($image_parts[1]);
		$file = $folderPath . $filename;

		if (file_put_contents($file, $image_base64)) {
			$data = [
				'gambar' => $filename,
			];
			$result = $this->authorized->update($modul, $data, $id);
			echo json_encode($result > 0 ? 'true' : 'false');
		} else {
			echo json_encode('false');
		}
	}
}

/* End of file LoginController.php */
/* Location: ./application/controllers/LoginController.php */