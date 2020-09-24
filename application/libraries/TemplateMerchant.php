<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TemplateMerchant
{
	protected $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->load->model('M_merchant', 'merchant');
		$this->ci->load->helper(['cookie', 'string']);
	}

	public function template($data)
	{
		// $check_cookies = $this->check_cookies();

		// if($check_cookies === TRUE){

			$this->render_view($data);

		// }else{

		// 	$check_session = $this->check_session();

		// 	if($check_session === TRUE){
		// 		$this->render_view($data);
		// 	}else{
		// 		$this->reject();
		// 	}

		// }
	}

	public function check_cookies()
	{
		$cookies = get_cookie(COOK);

		if($cookies === NULL){
			return FALSE;
		}else{
			$arr        = $this->ci->mcore->get(TABLE_ADMINS, '*', ['cookies' => $cookies]);
			$id         = $arr->row()->id;
			$username   = $arr->row()->username;
			$remember   = $arr->row()->remember;
			$cookies_db = $arr->row()->cookies;

			if($remember == 'yes'){
				if($cookies == $cookies_db){
					$this->reset_session($id, $username);
					return TRUE;
				}
				return FALSE;
			}
			return FALSE;
		}
	}

	public function check_session()
	{
		$id       = $this->ci->session->userdata(SESS.'id');
		$username = $this->ci->session->userdata(SESS.'username');

		if($id && $username){
			return TRUE;
		}
		return FALSE;
	}

	public function render_view($data)
	{
		if(file_exists(APPPATH.'views/merchant/'.$data['content'].'.php')){
			$this->ci->load->view('merchant/layouts/app', $data, FALSE);
		}else{
			show_404();
		}
	}

	public function reject()
	{
		$this->session->set_flashdata('expired', EXPIRED_MSG);
		redirect('logout/admin');
		exit;
	}

	public function reset_session($id, $username)
	{
		$this->ci->session->set_userdata(SESS.'id', $id);
		$this->ci->session->set_userdata(SESS.'username', $username);
	}

}

/* End of file TemplateAdmin.php */
/* Location: ./application/libraries/TemplateAdmin.php */
