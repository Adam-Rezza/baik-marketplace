<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomerController extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->ci = &get_instance();
		$this->load->helper(['cookie', 'string']);
		$this->ci->load->model('m_transaction', 'transaction');
		$this->load->library('TemplateCustomer', NULL, 'template');
	}

	public function session_check()
	{
		if (!$this->session->userdata(SESSUSER . 'id')) {
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
		if (($this->session->userdata(SESSUSER . 'id'))) {
			$data['cart'] = $this->customer->findCartByUserIdAndNotTransactionId($this->session->userdata(SESSUSER . 'id'))->result();
			foreach ($data['cart'] as $f) {
				$data['varians_cart'][$f->id] = [];
				if ($f->variasi_id) {
					$variasi_id = json_decode($f->variasi_id);
					for ($i = 0; $i < count($variasi_id); $i++) {
						array_push($data['varians_cart'][$f->id], $this->customer->findListVarianByListVarianId($variasi_id[$i])->row()->nama);
					}
				}
			}
			$data['notification'] = $this->customer->get('notifikasi', '*', ['user_id' => $this->session->userdata(SESSUSER . 'id')], 'datetime', 'desc', 100, 0)->result();
			$data['unread_notification'] = $this->customer->get('notifikasi', '*', ['user_id' => $this->session->userdata(SESSUSER . 'id'), 'read' => 0], 'datetime', 'desc', 100, 0)->num_rows();
		}
		return $data;
	}

	public function index()
	{
		$data = $this->init();
		$data['title']   = 'Pasar Online Baik';
		$data['content'] = 'main/index';
		$data['vitamin'] = 'main/index_vitamin';

		$where_banner = ['active' => 1, 'del' => 0];
		$data['banner'] = $this->customer->get('banner', '*', $where_banner, 'urutan', 'ASC')->result();
		// $data['banner'] = $this->customer->findAllBanner()->result();
		$data['sponsored'] = $this->customer->findSponsoredProduct()->result();
		// echo $this->db->last_query();
		$data['latest'] = $this->customer->findLatestProduct()->result();
		// var_dump($this->session->userdata());
		// var_dump($data['sponsored']);
		$this->template->template($data);
	}

	public function discount($page = 1)
	{
		$data = $this->init();
		$data['title']   = 'Produk berdasarkan kategori';
		$data['content'] = 'search/index';
		$data['vitamin'] = 'search/index_vitamin';

		$data['breadcrumb'] = "Produk dengan diskon terbaik";

		$data['url'] = base_url('discount');

		$data['page'] = $page;
		$data['page_max'] = floor($this->customer->findSponsoredProduct(null, 0)->num_rows() / 20) + 1;
		$data['product'] = $this->customer->findSponsoredProduct(20, ($page - 1) * 20)->result();
		$this->template->template($data);
	}

	public function latest($page = 1)
	{
		$data = $this->init();
		$data['title']   = 'Produk berdasarkan kategori';
		$data['content'] = 'search/index';
		$data['vitamin'] = 'search/index_vitamin';

		$data['breadcrumb'] = "Produk terbaru";

		$data['url'] = base_url('discount');

		$data['page'] = $page;
		$data['page_max'] = floor($this->customer->findLatestProduct(null, 0)->num_rows() / 20) + 1;
		$data['product'] = $this->customer->findLatestProduct(20, ($page - 1) * 20)->result();

		$this->template->template($data);
	}

	public function category($category, $sub_category = null, $page = 1)
	{
		$data = $this->init();
		$data['title']   = 'Produk berdasarkan kategori';
		$data['content'] = 'search/index';
		$data['vitamin'] = 'search/index_vitamin';

		$where_category = ['id' => $category];
		$data['search_category'] = $this->customer->get('kategori', '*', $where_category)->row();

		$where_sub_category = ['id' => $sub_category, 'parent' => $category];
		$data['search_sub_category'] =  $sub_category ? $this->customer->get('sub_kategori', '*', $where_sub_category)->row() : null;

		$category_info = "";
		$category_info .= $category ? $data['search_category']->nama : "Semua Kategori";
		$category_info .= $sub_category ? " > " . $data['search_sub_category']->nama : "";
		$data['breadcrumb'] = "Produk di Kategori " . $category_info;

		if ($data['search_category'] != null && ($sub_category == null || $data['search_sub_category'] != null)) {
			$data['url'] = base_url();
			$data['url'] .= 'category=' . $category;
			$data['url'] .= $sub_category ? '%26sub_category=' . $sub_category : "";

			$data['page'] = $page;
			$data['page_max'] = floor($this->customer->findProductByCategory($category, $sub_category, null, 0)->num_rows() / 20) + 1;
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

		$category_info = "";
		$category_info .= $category ? $data['search_category']->nama : "Semua Kategori";
		$category_info .= $sub_category ? " > " . $data['search_sub_category']->nama : "";
		$data['breadcrumb'] = "Pencarian \"" . $keyword . "\" di " . $category_info;

		if (($category == null || $data['search_category'] != null) && ($sub_category == null || $data['search_sub_category'] != null)) {
			$data['url'] = base_url();
			$data['url'] .= 'search=' . urlencode($keyword);
			$data['url'] .= $category ? '%26category=' . $category : "";
			$data['url'] .= $sub_category ? '%26sub_category=' . $sub_category : "";

			$data['page'] = $page;
			$data['page_max'] = floor($this->customer->findProductByKeyAndCategoryAndSubCategory(urldecode($keyword), $category, $sub_category, null, 0)->num_rows() / 20) + 1;
			$data['product'] = $this->customer->findProductByKeyAndCategoryAndSubCategory(urldecode($keyword), $category, $sub_category, 20, ($page - 1) * 20)->result();

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

		// $where_product = ['del' => 0, 'ban' => 0, 'id' => $id];
		// $data['product'] = $this->customer->get('produk', '*', $where_product)->row();
		$where_product = ['produk.del' => 0, 'produk.ban' => 0, 'produk.id' => $id];
		$data['product'] = $this->customer->getProdukComplete($where_product)->row();
		// var_dump($data['product']);

		$where_varians = ['produk_id' => $id, 'del' => '0'];
		$data['varians'] = $this->customer->get('variasi_produk', '*', $where_varians)->result();
		foreach ($data['varians'] as $f) {
			$where_list_varians = ['produk_id' => $id, 'parent' => $f->id, 'del' => '0'];
			$data['list_varians'][$f->id] = $this->customer->get('list_variasi_produk', '*', $where_list_varians)->result();
		}


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
		$data['review_qualified'] = $this->review_qualified($this->session->userdata(SESSUSER . 'id'), $id);

		$this->template->template($data);
	}

	public function merchant_detail($id)
	{
		$data = $this->init();
		if ($id == $this->session->userdata(SESSUSER . 'merchant_id')) {
			redirect(base_url('my_profile'));
		} else {
			$data['title']   = 'Detail toko';
			$data['content'] = 'merchant_detail/index';
			$data['vitamin'] = 'merchant_detail/index_vitamin';

			$data['toko'] = $this->customer->getToko(['id' => $id])->row();

			$data['url'] = base_url('merchant_product/' . $id);

			$data['page'] = 1;
			$data['page_max'] = floor($this->customer->findMerchantProduct($id, null, 0)->num_rows() / 20) + 1;
			$data['product'] = $this->customer->findMerchantProduct($id, 20, (1 - 1) * 20)->result();

			$this->template->template($data);
		}
	}

	public function merchant_product($id, $page = 1)
	{
		$data = $this->init();
		$data['title']   = 'Produk berdasarkan kategori';
		$data['content'] = 'search/index';
		$data['vitamin'] = 'search/index_vitamin';

		$data['toko'] = $this->customer->getToko(['id' => $id])->row();

		if ($data['toko']) {
			$data['breadcrumb'] = "Produk dari toko <b>" . $data['toko']->nama . "</b>";
		} else {
			$data['breadcrumb'] = "Toko tidak ditemukan";
		}

		$data['url'] = base_url('merchant_product/' . $id);

		$data['page'] = $page;
		$data['page_max'] = floor($this->customer->findMerchantProduct($id, null, 0)->num_rows() / 20) + 1;
		$data['product'] = $this->customer->findMerchantProduct($id, 20, ($page - 1) * 20)->result();
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

		$user_id = $this->session->userdata(SESSUSER . 'id');
		$arr_toko = $this->customer->getEkspedisiTokoByKeranjangUser($user_id);

		$arr_ekspedisi = array();
		if ($arr_toko->num_rows() > 0) {
			foreach ($arr_toko->result() as $key) {
				$toko_id            = $key->toko_id;
				$nama_toko          = $key->nama_toko;
				$arr_ekspedisi_toko = json_decode($key->ekspedisi);

				$nested = [
					'toko_id'   => $toko_id,
					'nama_toko' => $nama_toko,
					'ekspedisi' => array(),
				];

				if (count($arr_ekspedisi_toko) > 0) {
					foreach ($arr_ekspedisi_toko as $key2 => $val2) {
						$id_ekspedisi = $val2;

						$arr_nama_ekspedisi = $this->mcore->get('ekspedisi', 'nama', ['id' => $id_ekspedisi]);

						$nama_ekspedisi = "";
						if ($arr_nama_ekspedisi->num_rows() == 1) {
							$nama_ekspedisi = $arr_nama_ekspedisi->row()->nama;
						}

						$sub_nested = [
							'id_ekspedisi'   => $id_ekspedisi,
							'nama_ekspedisi' => $nama_ekspedisi,
						];

						array_push($nested['ekspedisi'], $sub_nested);
						// echo $id_ekspedisi . '<br>';
					}
				}
				array_push($arr_ekspedisi, $nested);
			}
		}

		$data['arr_ekspedisi'] = $arr_ekspedisi;

		$this->template->template($data);
	}

	public function my_account($on_shopping = null)
	{
		$this->session_check();
		$data = $this->init();

		$data['title']       = 'Akun Saya';
		$data['content']     = 'account/index';
		$data['vitamin']     = 'account/index_vitamin';
		$data['address']     = $this->customer->findAddressByUserId($this->session->userdata(SESSUSER . 'id'))->row();
		$data['province']    = $this->customer->get('provinsi', '*')->result();
		$data['user']        = $this->customer->get('user', 'id, username, nama, telp, gambar', ['id' => $this->session->userdata(SESSUSER . 'id')])->row();
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

		$data['transaction'] = $this->customer->findTransactionByUserIdAndStatusGroupByTransaction($this->session->userdata(SESSUSER . 'id'))->result();
		foreach ($data['transaction'] as $f) {
			$data['order'][$f->id] = $this->customer->findTransactionByUserIdAndStatusAndTransactionId($this->session->userdata(SESSUSER . 'id'), $f->id)->result();
			foreach ($data['order'][$f->id] as $g) {
				$data['varians_order'][$g->cart_id] = [];
				if ($g->variasi_id) {
					$variasi_id = json_decode($g->variasi_id);
					for ($i = 0; $i < count($variasi_id); $i++) {
						array_push($data['varians_order'][$g->cart_id], $this->customer->findListVarianByListVarianId($variasi_id[$i])->row()->nama);
					}
				}
			}
		}
		$data['user'] = $this->customer->get('user', 'id, username, nama, telp, gambar', ['id' => $this->session->userdata(SESSUSER . 'id')])->row();
		// var_dump($data['transaction']);
		// var_dump($data['varians_order']);
		$this->template->template($data);
	}

	public function my_recent_order()
	{
		$data = $this->init();
		$data['title']   = 'Pesanan Saya';
		$data['content'] = 'order/index';
		$data['vitamin'] = 'order/index_vitamin';

		$data['transaction'] = $this->customer->findCompleteTransactionByUserIdAndStatusGroupByTransaction($this->session->userdata(SESSUSER . 'id'))->result();
		foreach ($data['transaction'] as $f) {
			$data['review_qualified'][$f->id] = strtotime($f->delivery_date) < strtotime('+7 days');
			$data['order'][$f->id] = $this->customer->findCompleteTransactionByUserIdAndStatusAndTransactionId($this->session->userdata(SESSUSER . 'id'), $f->id)->result();
			foreach ($data['order'][$f->id] as $g) {
				$data['varians_order'][$g->cart_id] = [];
				if ($g->variasi_id) {
					$variasi_id = json_decode($g->variasi_id);
					for ($i = 0; $i < count($variasi_id); $i++) {
						array_push($data['varians_order'][$g->cart_id], $this->customer->findListVarianByListVarianId($variasi_id[$i])->row()->nama);
					}
				}
			}
		}
		$data['user'] = $this->customer->get('user', 'id, username, nama, telp, gambar', ['id' => $this->session->userdata(SESSUSER . 'id')])->row();
		// var_dump($data['transaction']);
		$this->template->template($data);
	}

	//QNA and REVIEW

	public function insert_qna($product_id)
	{
		if ($this->session->userdata(SESSUSER . 'id')) {
			$data = [
				'user_id' => $this->session->userdata(SESSUSER . 'id'),
				'produk_id' => $product_id,
				'created' => date('Y-m-d H:i:s'),
				'msg' => $this->input->post('discuss-input'),
			];
			if ($this->session->userdata(SESSUSER . 'id')) {
				$product = $this->customer->get('produk', '*', ['id' => $product_id])->row();
				if ($this->session->userdata(SESSUSER . 'merchant_id') == $product->toko_id) {
					$data['toko_id'] = $this->session->userdata(SESSUSER . 'merchant_id');
				}
				$this->customer->insert('qna', $data);
			}
			redirect(base_url('product/' . $product_id));
		}
	}

	public function reply_qna($product_id, $qna_id)
	{
		if ($this->session->userdata(SESSUSER . 'id')) {
			$data = [
				'user_id' => $this->session->userdata(SESSUSER . 'id'),
				'produk_id' => $product_id,
				'created' => date('Y-m-d H:i:s'),
				'msg' => $this->input->post('discuss-input'),
				'parent' => $qna_id,
			];
			if ($this->session->userdata(SESSUSER . 'id')) {
				$product = $this->customer->get('produk', '*', ['id' => $product_id])->row();
				if ($this->session->userdata(SESSUSER . 'merchant_id') == $product->toko_id) {
					$data['toko_id'] = $this->session->userdata(SESSUSER . 'merchant_id');
				}
				$this->customer->insert('qna', $data);
			}
			redirect(base_url('product/' . $product_id));
		}
	}

	public function edit_qna($product_id, $qna_id)
	{
		if ($this->session->userdata(SESSUSER . 'id')) {
			$data = [
				'msg' => $this->input->post('discuss-input'),
			];
			$verifUser = $this->customer->get('qna', 'user_id', ['id' => $qna_id])->row();
			if ($this->session->userdata(SESSUSER . 'id') == $verifUser->user_id) {
				$this->customer->update('qna', $data, $qna_id);
			}
			redirect(base_url('product/' . $product_id));
		}
	}

	public function insert_review($product_id)
	{
		$review_qualified = $this->review_qualified($this->session->userdata(SESSUSER . 'id'), $product_id);
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
				'user_id' => $this->session->userdata(SESSUSER . 'id'),
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

	public function review_transaction($transaction_id)
	{
		$where_cart = [
			'user_id' => $this->session->userdata(SESSUSER . 'id'),
			'transaksi_id' => $transaction_id
		];
		$cart = $this->customer->getProductCart($where_cart)->result();
		echo json_encode($cart);
	}

	public function mutasi_dompet($on_shopping = NULL)
	{
		$this->session_check();

		$data = $this->init();
		$id   = $this->session->userdata(SESSUSER . 'id');

		$data['title']   = 'Mutasi Saldo';
		$data['content'] = 'mutasi_saldo/index';
		$data['vitamin'] = 'mutasi_saldo/index_vitamin';

		$data['user']    = $this->customer->get('user', 'id, username, nama, telp, gambar', ['id' => $this->session->userdata(SESSUSER . 'id')])->row();

		$data['on_shopping'] = $on_shopping != null ? true : false;
		$this->session->set_flashdata('checkout', $on_shopping != null ? true : false);

		$this->template->template($data);
	}

	public function get_data_mutasi_dompet()
	{
		$tgl_obj_from    = new DateTime();
		$tgl_obj_to      = new DateTime();
		$tgl_obj_created = new DateTime();
		$id_user         = $this->session->userdata(SESSUSER . 'id');
		$from            = $this->input->get('from');
		$to              = $this->input->get('to');

		$from = $tgl_obj_from->createFromFormat('d/m/Y', $from)->format('Y-m-d');
		$to   = $tgl_obj_to->createFromFormat('d/m/Y', $to)->format('Y-m-d');

		$arr = $this->mcore->get('jurnal', '*', ['id_user' => $id_user, 'DATE(created_at) >=' => $from, 'DATE(created_at) <=' => $to], 'created_at', 'ASC');


		if (!$arr) {
			echo json_encode(['code' => 500]);
			exit;
		}

		if ($arr->num_rows() == 0) {
			echo json_encode(['code' => 404]);
			exit;
		}

		$arr_genesis = $this->mcore->get('jurnal', 'created_at', ['id_user' => $id_user, 'DATE(created_at) <' => $from], 'created_at', 'ASC', '1');


		if (!$arr_genesis) {
			echo json_encode(['code' => 500]);
			exit;
		}

		$init_saldo = 0;
		if ($arr_genesis->num_rows() == 1) {
			$where_init_saldo = [
				'id_user'       => $id_user,
				'DATE(created_at) >=' => $arr_genesis->row()->created_at,
				'DATE(created_at) <'  => $from
			];
			$arr_init_saldo = $this->mcore->get('jurnal', 'tipe, total', $where_init_saldo, 'created_at', 'ASC');

			if (!$arr_init_saldo) {
				echo json_encode(['code' => 500]);
				exit;
			}

			if ($arr_init_saldo->num_rows() > 0) {
				foreach ($arr_init_saldo->result() as $key) {
					$tipe  = $key->tipe;
					$total = $key->total;

					if ($tipe == 'kredit') {
						$init_saldo -= $total;
					} else {
						$init_saldo += $total;
					}
				}
			}
		}

		$data   = array();
		$debit  = 0;
		$kredit = 0;

		$saldo  = 0;
		if ($init_saldo > 0) {
			$saldo  = $init_saldo;
		}

		$tgl_obj_awal = new DateTime();

		$nested = [
			'tanggal'    => $tgl_obj_awal->createFromFormat('Y-m-d', $from)->format('d/m/Y'),
			'keterangan' => 'Saldo Awal',
			'debit'      => number_format($init_saldo, 0, ',', '.'),
			'kredit'     => number_format(0, 0, ',', '.'),
			'saldo'      => number_format($init_saldo, 0, ',', '.'),
		];

		array_push($data, $nested);

		foreach ($arr->result() as $key) {
			$id             = $key->id;
			$id_transaksi   = $key->id_transaksi;
			$tipe           = $key->tipe;
			$total          = $key->total;
			$kode_transaksi = $key->kode_transaksi;
			$created_at     = $key->created_at;

			$tanggal = $tgl_obj_created->createFromFormat('Y-m-d H:i:s', $created_at)->format('d/m/Y H:i');

			$arr_anggota = $this->mcore->get('user', 'nama', ['id' => $id_user]);
			$nama_anggota = $arr_anggota->row()->nama;

			$keterangan = '';

			if ($kode_transaksi == 'topup dari sukarela') {
				$keterangan = ucfirst($kode_transaksi);
			} elseif ($kode_transaksi == 'topup via petugas') {
				$arr_jurnal_petugas = $this->mcore->get('jurnal', 'id_user', [
					'id'                 => $id,
					'DATE(created_at) >' => $created_at,
					'tipe'               => 'debit',
					'kode_transaksi'     => $kode_transaksi
				], 'created_at', 'asc', '1');
				$arr_petugas = $this->mcore->get('user', 'nama', ['id' => $arr_jurnal_petugas->row()->id_user], 'id', 'asc', '1');
				$nama_petugas = $arr_petugas->row()->nama;

				if ($tipe == 'kredit') {
					$keterangan = ucfirst($kode_transaksi) . " ke $nama_anggota (" . $id_user . ")";
				} else {
					$keterangan = ucfirst($kode_transaksi) . " $nama_petugas (" . $arr_jurnal_petugas->row()->id_user . ")";
				}
			} elseif ($kode_transaksi == 'transfer') {
				$arr_jurnal_anggota_tujuan = $this->mcore->get('jurnal', 'id_user', [
					// 'id'                 => $id,
					// 'DATE(created_at) >' => $created_at,
					'tipe'           => 'debit',
					'kode_transaksi' => $kode_transaksi,
					'id_transaksi'   => $id_transaksi
				], 'created_at', 'asc', '1');
				$arr_anggota_tujuan = $this->mcore->get('user', 'nama', ['id' => $arr_jurnal_anggota_tujuan->row()->id_user], 'id', 'asc', '1');

				$nama_anggota_tujuan = $arr_anggota_tujuan->row()->nama;

				if ($tipe == 'kredit') {
					$keterangan = ucfirst($kode_transaksi) . " ke " . $nama_anggota_tujuan . " (" . $arr_jurnal_anggota_tujuan->row()->id_user . ")";
				} else {
					$keterangan = ucfirst($kode_transaksi) . " dari " . $nama_anggota . " (" . $id_user . ")";
				}
			} elseif (in_array($kode_transaksi, ['penjualan', 'pembelian', 'batal'])) {
				$arr_transaksi = $this->mcore->get('transaksi', 'invoice', ['id' => $id_transaksi]);

				if (!$arr_transaksi) {
					echo json_encode(['code' => 500]);
					exit;
				}

				if ($arr_transaksi->num_rows() == 0) {
					echo json_encode(['code' => 404]);
					exit;
				}

				$invoice = $arr_transaksi->row()->invoice;

				$keterangan = ucfirst($kode_transaksi) . " invoice " . $invoice;
			} elseif ($kode_transaksi == 'tarik tunai via petugas') {
				$arr_jurnal_petugas = $this->mcore->get('jurnal', 'id_user', [
					'id'                 => $id,
					'DATE(created_at) >' => $created_at,
					'tipe'               => 'debit',
					'kode_transaksi'     => $kode_transaksi
				], 'created_at', 'asc', '1');
				$arr_petugas = $this->mcore->get('user', 'nama', ['id' => $arr_jurnal_petugas->row()->id_user], 'id', 'asc', '1');
				$nama_petugas = $arr_petugas->row()->nama;
				$keterangan = ucfirst($kode_transaksi) . " " . $nama_petugas;
			} else {
				$keterangan = '';
			}

			if ($tipe == 'kredit') {
				$debit  = 0;
				$kredit = $total;
			} else {
				$debit  = $total;
				$kredit = 0;
			}

			$saldo = $saldo + $debit - $kredit;

			$nested = [
				'tanggal'    => $tanggal,
				'keterangan' => $keterangan,
				'debit'      => number_format($debit, 0, ',', '.'),
				'kredit'     => number_format($kredit, 0, ',', '.'),
				'saldo'      => number_format($saldo, 0, ',', '.'),
			];

			array_push($data, $nested);
		}

		echo json_encode(['code' => 200, 'data' => $data]);
	}

	public function get_target_info()
	{
		$id_target = $this->input->get('id_target');

		$arr = $this->mcore->get('user', '*', ['id' => $id_target]);

		if (!$arr) {
			echo json_encode(['code' => 500]);
			exit;
		}
		if ($arr->num_rows() == 0) {
			echo json_encode(['code' => 404, 'id_target' => $id_target]);
			exit;
		}

		echo json_encode([
			'code' => 200,
			'nama' => $arr->row()->nama
		]);
	}

	public function proses_transfer()
	{
		$id_pengirim = $this->session->userdata(SESSUSER . 'id');
		$id_tujuan   = $this->input->post('id_tujuan');
		$nominal_tf  = $this->input->post('nominal_tf');

		$find = $this->mcore->get('user', 'saldo', ['id' => $id_pengirim]);
		if (!$find) {
			echo json_encode(['code' => 500]);
			exit;
		}
		if ($find->num_rows() == 0) {
			echo json_encode(['code' => 404]);
			exit;
		}
		$saldo_pengirim = $find->row()->saldo;
		if ($saldo_pengirim < $nominal_tf) {
			echo json_encode(['code' => 401]);
			exit;
		}

		$find = $this->mcore->get('user', 'saldo', ['id' => $id_tujuan]);
		if (!$find) {
			echo json_encode(['code' => 500]);
			exit;
		}
		if ($find->num_rows() == 0) {
			echo json_encode(['code' => 404]);
			exit;
		}

		$exec = $this->customer->prosesTransfer($id_pengirim, $id_tujuan, $nominal_tf);

		if ($exec == 500) {
			echo json_encode(['code' => 500]);
			exit;
		}

		echo json_encode(['code' => 200]);
	}

	public function topup_sukarela()
	{
		$id_user = $this->session->userdata(SESSUSER . 'id');
		$nominal = $this->input->post('nominal');

		$data = [
			'id_user'        => $id_user,
			'id_transaksi'   => NULL,
			'tipe'           => 'debit',
			'total'          => $nominal,
			'kode_transaksi' => 'topup dari sukarela',
			'created_at'     => date('Y-m-d H:i:s'),
		];
		$exec = $this->mcore->store_uuid('jurnal', $data);

		$this->ci->transaction->penambahanSaldo($id_user, $nominal);

		if (!$exec) {
			echo json_encode(['code' => 500]);
			exit();
		}

		echo json_encode(['code' => 200]);
	}
}

/* End of file DashboardController.php */
/* Location: ./application/controllers/DashboardController.php */