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
			$data['notification'] = $this->customer->get('notifikasi', '*', ['user_id' => $this->session->userdata(SESS . 'id')], 'datetime', 'desc', 100, 0)->result();
			$data['unread_notification'] = $this->customer->get('notifikasi', '*', ['user_id' => $this->session->userdata(SESS . 'id'), 'read' => 0], 'datetime', 'desc', 100, 0)->num_rows();
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
		$data['sponsored'] = $this->customer->findSponsoredProduct()->result();
		$data['latest'] = $this->customer->findLatestProduct()->result();
		// var_dump($this->session->userdata());
		// var_dump($data['sponsored']);
		$this->template->template($data);
	}

	public function discount($page = 1)
	{
		$data = $this->init();
		$data['title']   = 'Produk berdasarkan kategori';
		$data['content'] = 'discount/index';
		$data['vitamin'] = 'discount/index_vitamin';

		$data['url'] = base_url('discount');

		$data['page'] = $page;
		$data['page_max'] = round($this->customer->findSponsoredProduct(null, 0)->num_rows() / 20) + 1;
		$data['product'] = $this->customer->findSponsoredProduct(20, ($page - 1) * 20)->result();
		$this->template->template($data);
	}

	public function latest($page = 1)
	{
		$data = $this->init();
		$data['title']   = 'Produk berdasarkan kategori';
		$data['content'] = 'latest/index';
		$data['vitamin'] = 'latest/index_vitamin';

		$data['url'] = base_url('discount');

		$data['page'] = $page;
		$data['page_max'] = round($this->customer->findLatestProduct(null, 0)->num_rows() / 20) + 1;
		$data['product'] = $this->customer->findLatestProduct(20, ($page - 1) * 20)->result();

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
			$data['page_max'] = round($this->customer->findProductByCategory($category, $sub_category, null, 0)->num_rows() / 20) + 1;
			$data['product'] = $this->customer->findProductByCategory($category, $sub_category, 20, ($page - 1) * 20)->result();

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
			$data['page_max'] = round($this->customer->findProductByKeyAndCategoryAndSubCategory(urldecode($keyword), $category, $sub_category, null, 0)->num_rows() / 20) + 1;
			$data['product'] = $this->customer->findProductByKeyAndCategoryAndSubCategory(urldecode($keyword), $category, $sub_category, 20, ($page - 1) * 20)->result();
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

		$where_qna = ['del' => 0, 'produk_id' => $id, 'parent' => '0'];
		$data['qna'] = $this->customer->getQna($where_qna, 'created', 'DESC')->result();
		foreach ($data['qna'] as $f) {
			$where_reply_qna = ['del' => 0, 'produk_id' => $id, 'parent' => $f->id];
			$data['reply_qna'][$f->id] = $this->customer->getQna($where_reply_qna, 'created', 'ASC')->result();
		}

		$where_review = ['del' => 0, 'produk_id' => $id];
		$data['review'] = $this->customer->getReview($where_review, 'created', 'DESC')->result();
		$data['review_qualified'] = $this->review_qualified($this->session->userdata(SESS . 'id'), $id);

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

	public function my_account($on_shopping = null)
	{
		$this->session_check();
		$data = $this->init();
		$data['title']   = 'Akun Saya';
		$data['content'] = 'account/index';
		$data['vitamin'] = 'account/index_vitamin';
		$data['address'] = $this->customer->findAddressByUserId($this->session->userdata(SESS . 'id'))->row();
		$data['province'] = $this->customer->get('provinsi', '*')->result();
		$data['user'] = $this->customer->get('user', 'id, username, nama, telp, gambar', ['id' => $this->session->userdata(SESS . 'id')])->row();
		$data['on_shopping'] = $on_shopping != null ? true : false;
		$this->session->set_flashdata('checkout', $on_shopping != null ? true : false);
		// print_r($data['address']);
		$this->template->template($data);
	}

	public function my_order()
	{
		$data = $this->init();
		$data['title']   = 'Pesanan Saya';
		$data['content'] = 'order/index';
		$data['vitamin'] = 'order/index_vitamin';

		$data['transaction'] = $this->customer->findTransactionByMerchantIdAndStatusGroupByTransaction($this->session->userdata(SESS . 'id'))->result();
		foreach ($data['transaction'] as $f) {
			$data['order'][$f->id] = $this->customer->findTransactionByMerchantIdAndStatusAndTransactionId($this->session->userdata(SESS . 'id'), $f->id)->result();
		}
		$data['user'] = $this->customer->get('user', 'id, username, nama, telp, gambar', ['id' => $this->session->userdata(SESS . 'id')])->row();
		// var_dump($data['transaction']);
		$this->template->template($data);
	}

	public function my_recent_order()
	{
		$data = $this->init();
		$data['title']   = 'Pesanan Saya';
		$data['content'] = 'order/index';
		$data['vitamin'] = 'order/index_vitamin';

		$data['transaction'] = $this->customer->findCompleteTransactionByMerchantIdAndStatusGroupByTransaction($this->session->userdata(SESS . 'id'))->result();
		foreach ($data['transaction'] as $f) {
			$data['order'][$f->id] = $this->customer->findCompleteTransactionByMerchantIdAndStatusAndTransactionId($this->session->userdata(SESS . 'id'), $f->id)->result();
		}
		$data['user'] = $this->customer->get('user', 'id, username, nama, telp, gambar', ['id' => $this->session->userdata(SESS . 'id')])->row();
		// var_dump($data['transaction']);
		$this->template->template($data);
	}

	//QNA and REVIEW

	public function insert_qna($product_id)
	{
		if ($this->session->userdata(SESS . 'id')) {
			$data = [
				'user_id' => $this->session->userdata(SESS . 'id'),
				'produk_id' => $product_id,
				'created' => date('Y-m-d H:i:s'),
				'msg' => $this->input->post('discuss-input'),
			];
			if ($this->session->userdata(SESS . 'id')) {
				$product = $this->customer->get('produk', '*', ['id' => $product_id])->row();
				if ($this->session->userdata(SESS . 'merchant_id') == $product->toko_id) {
					$data['toko_id'] = $this->session->userdata(SESS . 'merchant_id');
				}
				$this->customer->insert('qna', $data);
			}
			redirect(base_url('product/' . $product_id));
		}
	}

	public function reply_qna($product_id, $qna_id)
	{
		if ($this->session->userdata(SESS . 'id')) {
			$data = [
				'user_id' => $this->session->userdata(SESS . 'id'),
				'produk_id' => $product_id,
				'created' => date('Y-m-d H:i:s'),
				'msg' => $this->input->post('discuss-input'),
				'parent' => $qna_id,
			];
			if ($this->session->userdata(SESS . 'id')) {
				$product = $this->customer->get('produk', '*', ['id' => $product_id])->row();
				if ($this->session->userdata(SESS . 'merchant_id') == $product->toko_id) {
					$data['toko_id'] = $this->session->userdata(SESS . 'merchant_id');
				}
				$this->customer->insert('qna', $data);
			}
			redirect(base_url('product/' . $product_id));
		}
	}

	public function edit_qna($product_id, $qna_id)
	{
		if ($this->session->userdata(SESS . 'id')) {
			$data = [
				'msg' => $this->input->post('discuss-input'),
			];
			$verifUser = $this->customer->get('qna', 'user_id', ['id' => $qna_id])->row();
			if ($this->session->userdata(SESS . 'id') == $verifUser->user_id) {
				$this->customer->update('qna', $data, $qna_id);
			}
			redirect(base_url('product/' . $product_id));
		}
	}

	public function insert_review($product_id)
	{
		$review_qualified = $this->review_qualified($this->session->userdata(SESS . 'id'), $product_id);
		$product = $this->customer->get('produk', '*', ['id' => $product_id])->row();
		// var_dump($review_qualified);
		if ($review_qualified) {
			$config['upload_path']          = './public/img/review/';
			$config['allowed_types']        = 'gif|jpg|png';
			$config['file_name']            = $product_id . uniqid();
			$config['overwrite']			= true;
			$config['max_size']             = 1024; // 1MB
			// $config['max_width']            = 1024;
			// $config['max_height']           = 768;

			$this->load->library('upload', $config);

			$data = [
				'user_id' => $this->session->userdata(SESS . 'id'),
				'produk_id' => $product_id,
				'rating' => $this->input->post('star-review'),
				'msg' => $this->input->post('msg-review'),
				'transaksi_id' => $review_qualified,
				'created' => date('Y-m-d H:i:s'),
			];
			if ($this->upload->do_upload('image-review')) {
				$data['gambar'] = $this->upload->data("file_name");
			}
			$this->customer->insert('review', $data);

			$data_produk = [
				'rating' => ((($product->rating * $product->rating_count) + $this->input->post('star-review')) / ($product->rating_count + 1)),
				'rating_count' => $product->rating_count + 1
			];
			$this->customer->update('produk', $data_produk, $product_id);
			redirect(base_url('product/' . $product_id));
		}
	}

	private function review_qualified($user_id, $product_id)
	{
		$transaksi = $this->customer->findLatestCompleteTransactionByUserIdAndProductIdLastWeek($user_id, $product_id)->row();
		if ($transaksi) {
			$where_review = [
				'user_id' => $user_id,
				'produk_id' => $product_id,
				'transaksi_id' => $transaksi->id
			];
			$review = $this->customer->get('review', '*', $where_review)->num_rows();
			return $review > 0 ? false : $transaksi->id;
		} else {
			return false;
		}
	}
}

/* End of file DashboardController.php */
/* Location: ./application/controllers/DashboardController.php */