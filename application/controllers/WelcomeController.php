<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WelcomeController extends CI_Controller
{
	private $table = 'admins';

	public function index()
	{
		$this->load->view('welcome');
	}

	public function init_admin()
	{
		$now      = new DateTime();
		$password = password_hash('admin123)'.UYAH, PASSWORD_DEFAULT);

		# INIT ROLE
		##################################################################
		$object = [
			'username'   => 'admin',
			'password'   => $password,
			'created_at' => $now->format('Y-m-d H:i:s'),
			'updated_at' => $now->format('Y-m-d H:i:s'),
			'deleted_at' => NULL
		];

		$exec = $this->mcore->store($this->table, $object);
		##################################################################
		
		if($exec === TRUE){ echo "berhasil"; }else{ echo "gagal"; }
	}
}

/* End of file WelcomeController.php */
/* Location: ./application/controllers/WelcomeController.php */
