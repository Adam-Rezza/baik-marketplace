<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomerController extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->library('TemplateCustomer', NULL, 'template');
	}

	public function session_check()
	{
		if (!$this->session->userdata(SESS . 'id')) {
			redirect(base_url());
		}
	}

	public function init()
	{
		$where_category = ['active' => 1, 'del' => 0];
		$data['category'] = $this->customer->get('kategori', '*', $where_category, 'urutan', 'ASC')->result();
		foreach ($data['category'] as $f) {
			$where_sub_category = ['active' => 1, 'del' => 0, 'parent' => $f->id];
			$data['sub_category'][$f->id] = $this->customer->get('sub_kategori', '*', $where_sub_category, 'urutan', 'ASC')->result();
		}
		$data['keyword'] = '';
		$data['search_category'] = null;
		$data['search_sub_category'] = null;
		if (($this->session->userdata(SESS . 'id'))) {
			$data['cart'] = $this->customer->findCartByUserIdAndNotTransactionId($this->session->userdata(SESS . 'id'))->result();
		}
		return $data;
	}

	public function index()
	{
		$data = $this->init();
		$data['title'] = 'Pasar Online Baik';
		$data['content'] = 'main/index';
		$data['vitamin'] = 'main/index_vitamin';

		$where_banner = ['active' => 1, 'del' => 0];
		$data['banner'] = $this->customer->get('banner', '*', $where_banner, 'urutan', 'ASC')->result();
		// $data['banner'] = $this->customer->findAllBanner()->result();
		$data['sponsored'] = $this->customer->findSponsoredProductFirst()->result();
		$data['latest'] = $this->customer->findLatestProductFirst()->result();
		// var_dump($this->session->userdata());
		// var_dump($data['sponsored']);
		$this->template->template($data);
	}

	public function category($category, $sub_category = null, $page = 1)
	{
		$data = $this->init();
		$data['title']   = 'Produk berdasarkan kategori';
		$data['content'] = 'category/index';
		$data['vitamin'] = 'category/index_vitamin';

		$where_category = ['id' => $category];
		$data['search_category'] = $this->customer->get('kategori', '*', $where_category)->row();
		
		$where_sub_category = ['id' => $sub_category, 'parent' => $category];
		$data['search_sub_category'] =  $sub_category ? $this->customer->get('sub_kategori', '*', $where_sub_category)->row() : null;

		if ($data['search_category'] != null && ($sub_category == null || $data['search_sub_category'] != null)) {
			$data['url'] = base_url();
			$data['url'] .= 'category=' . $category;
			$data['url'] .= $sub_category ? '%26sub_category=' . $sub_category : "";

			$data['page'] = $page;
			$data['page_max'] = round($this->customer->findProductByCategory($category, $sub_category, 20, ($page - 1)*20)->num_rows() / 20) + 1;
			$data['product'] = $this->customer->findProductByCategory($category, $sub_category, 20, ($page - 1)*20)->result();

			$this->template->template($data);
		} else {
			show_404();
		}
	}

	public function search($keyword, $category = null, $sub_category = null, $page = 1)
	{
		$data = $this->init();
		$data['title']   = 'Pencarian ' . $keyword . '...';
		$data['content'] = 'search/index';
		$data['vitamin'] = 'search/index_vitamin';

		$data['keyword'] = urldecode($keyword);

		$where_category = ['id' => $category];
		$data['search_category'] = $this->customer->get('kategori', '*', $where_category)->row();
		
		$where_sub_category = ['id' => $sub_category, 'parent' => $category];
		$data['search_sub_category'] =  $sub_category ? $this->customer->get('sub_kategori', '*', $where_sub_category)->row() : null;

		if (($category == null || $data['search_category'] != null) && ($sub_category == null || $data['search_sub_category'] != null)) {
			$data['url'] = base_url();
			$data['url'] .= 'search=' . urlencode($keyword);
			$data['url'] .= $category ? '%26category=' . $category : "";
			$data['url'] .= $sub_category ? '%26sub_category=' . $sub_category : "";

			$data['page'] = $page;
			$data['page_max'] = round($this->customer->findProductByKeyAndCategoryAndSubCategory(urldecode($keyword), $category, $sub_category, 20, ($page - 1)*20)->num_rows() / 20) + 1;
			$data['product'] = $this->customer->findProductByKeyAndCategoryAndSubCategory(urldecode($keyword), $category, $sub_category, 20, ($page - 1)*20)->result();
			// var_dump($data['page_max']);
			$this->template->template($data);
		} else {
			show_404();
		}
	}

	public function product($id)
	{
		$data = $this->init();
		$data['title']   = 'Detail Produk';
		$data['content'] = 'product/index';
		$data['vitamin'] = 'product/index_vitamin';

		$where_product_pictures = ['del' => 0, 'ban' => 0, 'id' => $id];
		$data['product'] = $this->customer->get('produk', '*', $where_product_pictures)->row();

		$where_product_pictures = ['del' => 0, 'produk_id' => $id];
		$data['product_pictures'] = $this->customer->get('gambar_produk', '*', $where_product_pictures, 'urutan', 'ASC')->result();

		$this->template->template($data);
	}

	// Registered User

	public function checkout()
	{
		$this->session_check();
		$data = $this->init();
		$data['title']   = 'Checkout';
		$data['content'] = 'checkout/index';
		$data['vitamin'] = 'checkout/index_vitamin';

		$this->template->template($data);
	}

	public function my_account()
	{
		$this->session_check();
		$data = $this->init();
		$data['title']   = 'Akun Saya';
		$data['content'] = 'account/index';
		$data['vitamin'] = 'account/index_vitamin';
		$data['address'] = $this->customer->findAddressByUserId($this->session->userdata(SESS . 'id'))->row();
		$data['province'] = $this->customer->get('provinsi', '*')->result();
		// print_r($data['address']);

		$this->template->template($data);
	}

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
			$result = $this->customer->update('alamat', $data, $id);
			echo $result ? 'true' : 'false';
		} else {
			$result = $this->customer->insert('alamat', $data);
			echo $result ? 'true' : 'false';
		}
	}

	public function my_order()
	{
		$data = $this->init();
		$data['title']   = 'Pesanan Saya';
		$data['content'] = 'order/index';
		$data['vitamin'] = 'order/index_vitamin';

		$data['transaction'] = $this->customer->findOrderByMerchantIdAndStatusGroupByTransaction($this->session->userdata(SESS . 'id'))->result();
		foreach ($data['transaction'] as $f) {
			$data['order'][$f->id] = $this->customer->findOrderByMerchantIdAndStatusAndTransactionId($this->session->userdata(SESS . 'id'), $f->id)->result();
		}
		// var_dump($data['transaction']);
		$this->template->template($data);
	}

	public function my_recent_order()
	{
		$data = $this->init();
		$data['title']   = 'Pesanan Saya';
		$data['content'] = 'order/index';
		$data['vitamin'] = 'order/index_vitamin';

		$data['transaction'] = $this->customer->findCompleteOrderByMerchantIdAndStatusGroupByTransaction($this->session->userdata(SESS . 'id'))->result();
		foreach ($data['transaction'] as $f) {
			$data['order'][$f->id] = $this->customer->findCompleteOrderByMerchantIdAndStatusAndTransactionId($this->session->userdata(SESS . 'id'), $f->id)->result();
		}
		// var_dump($data['transaction']);
		$this->template->template($data);
	}

	public function get_kabupaten($id_prov)
	{
		$where = ['id_prov' => $id_prov];
		$result = $this->customer->get('kabupaten', '*', $where)->result();
		echo json_encode($result);
	}

	public function get_kecamatan($id_kab)
	{
		$where = ['id_kab' => $id_kab];
		$result = $this->customer->get('kecamatan', '*', $where)->result();
		echo json_encode($result);
	}

	public function get_kelurahan($id_kec)
	{
		$where = ['id_kec' => $id_kec];
		$result = $this->customer->get('kelurahan', '*', $where)->result();
		echo json_encode($result);
	}
}

/* End of file DashboardController.php */
/* Location: ./application/controllers/DashboardController.php */