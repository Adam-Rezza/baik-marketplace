<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('TemplateAdmin', NULL, 'template');
	}

	public function index()
	{
		$data['title']   = 'Dashboard';
		$data['content'] = 'dashboard/index';
		$data['vitamin'] = 'dashboard/index_vitamin';

		$data['admin_count'] = $this->mcore->count("admins", ['deleted_at' => NULL]);
		$data['user_count']  = $this->mcore->count("user", ['active' => TRUE, 'ban' => FALSE]);
		$data['toko_count']  = $this->mcore->count("toko", ['active' => TRUE, 'ban' => FALSE]);

		$this->template->template($data);
	}
}

/* End of file DashboardController.php */
/* Location: ./application/controllers/DashboardController.php */