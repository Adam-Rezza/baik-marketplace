<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MerchantController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('TemplateMerchant', NULL, 'template');
		$this->load->library('TemplateCustomer', NULL, 'customer_template');
	}

	public function init()
	{
		if ($this->session->userdata(SESSUSER . 'merchant_id') && $this->session->userdata(SESSUSER . 'merchant_active') == 1 && $this->session->userdata(SESSUSER . 'merchant_ban') == 0) {
			$where_category = ['active' => 1, 'del' => 0];
			$data['category'] = $this->merchant->get('kategori', '*', $where_category, 'urutan', 'ASC')->result();
			foreach ($data['category'] as $f) {
				$where_sub_category = ['active' => 1, 'del' => 0, 'parent' => $f->id];
				$data['sub_category'][$f->id] = $this->merchant->get('sub_kategori', '*', $where_sub_category, 'urutan', 'ASC')->result();
			}
			$data['order_1'] = $this->merchant->get('transaksi', '*', ['toko_id' => $this->session->userdata(SESSUSER . 'merchant_id'), 'status' => 1])->num_rows();
			$data['order_2'] = $this->merchant->get('transaksi', '*', ['toko_id' => $this->session->userdata(SESSUSER . 'merchant_id'), 'status' => 2])->num_rows();
			$data['order_3'] = $this->merchant->get('transaksi', '*', ['toko_id' => $this->session->userdata(SESSUSER . 'merchant_id'), 'status' => 3])->num_rows();
			$data['order_9'] = $this->merchant->get('transaksi', '*', ['toko_id' => $this->session->userdata(SESSUSER . 'merchant_id'), 'status' => 9])->num_rows();
			$data['order_10'] = $this->merchant->get('transaksi', '*', ['toko_id' => $this->session->userdata(SESSUSER . 'merchant_id'), 'status' => 10])->num_rows();

			$data['keyword'] = '';
			$data['search_category'] = null;
			$data['search_sub_category'] = null;

			$data['merchant'] = $this->merchant->get('toko', 'id, user_id, nama, telp, gambar', ['id' => $this->session->userdata(SESSUSER . 'merchant_id')])->row();

			return $data;
		} else {
			redirect(base_url('merchant'));
		}
	}

	public function index()
	{
		$this->auth();
	}

	public function auth()
	{
		if ($this->session->userdata(SESSUSER . 'id')) {
			if ($this->session->userdata(SESSUSER . 'merchant_id') === null) {
				// $data = $this->init();
				$data['title']   = 'Daftar Toko';
				$data['content'] = 'auth/index';
				$data['vitamin'] = 'auth/index_vitamin';
				$data['province'] = $this->customer->get('provinsi', '*')->result();

				$data['keyword'] = '';
				$data['search_category'] = null;
				$data['search_sub_category'] = null;

				$data['cart'] = $this->customer->findCartByUserIdAndNotTransactionId($this->session->userdata(SESSUSER . 'id'))->result();
				$data['notification'] = $this->customer->get('notifikasi', '*', ['user_id' => $this->session->userdata(SESSUSER . 'id')], 'datetime', 'desc', 100, 0)->result();
				$data['unread_notification'] = $this->customer->get('notifikasi', '*', ['user_id' => $this->session->userdata(SESSUSER . 'id'), 'read' => 0], 'datetime', 'desc', 100, 0)->num_rows();

				$where_category = ['active' => 1, 'del' => 0];
				$data['category'] = $this->customer->get('kategori', '*', $where_category, 'urutan', 'ASC')->result();
				foreach ($data['category'] as $f) {
					$where_sub_category = ['active' => 1, 'del' => 0, 'parent' => $f->id];
					$data['sub_category'][$f->id] = $this->customer->get('sub_kategori', '*', $where_sub_category, 'urutan', 'ASC')->result();
				}

				// var_dump($this->session->userdata());
				$this->customer_template->template($data);
			} else {
				$this->my_profile();
			}
		} else {
			redirect(base_url());
		}
	}

	public function my_profile()
	{
		$data = $this->init();
		$data['title']   = 'Produk Saya';
		$data['content'] = 'account/index';
		$data['vitamin'] = 'account/index_vitamin';
		$data['province'] = $this->customer->get('provinsi', '*')->result();

		$data['toko'] = $this->merchant->findMerchantByMerchantId($this->session->userdata(SESSUSER . 'merchant_id'))->row();

		$data['ekspedisi'] = json_decode($data['toko']->ekspedisi);
		$data['list_ekspedisi'] = $this->mcore->get('ekspedisi', '*');

		$this->template->template($data);
	}

	public function my_product()
	{
		$data = $this->init();
		$data['title']   = 'Produk Saya';
		$data['content'] = 'my_product/index';
		$data['vitamin'] = 'my_product/index_vitamin';

		$data['product'] = $this->merchant->findProductByMerchantId($this->session->userdata(SESSUSER . 'merchant_id'))->result();
		// var_dump($this->session->userdata());
		$this->template->template($data);
	}

	public function order($status)
	{
		$data = $this->init();
		$data['title']   = 'Pesanan Saya';
		$data['content'] = 'order/index';
		$data['vitamin'] = 'order/index_vitamin';

		$data['status'] = $status;
		$data['transaction'] = $this->merchant->findTransactionByMerchantIdAndStatusGroupByTransaction($this->session->userdata(SESSUSER . 'merchant_id'), $status)->result();
		foreach ($data['transaction'] as $f) {
			$data['order'][$f->id] = $this->merchant->findTransactionByMerchantIdAndStatusAndTransactionId($this->session->userdata(SESSUSER . 'merchant_id'), $status, $f->id)->result();
		}
		// var_dump($data['transaction']);
		$this->template->template($data);
	}

	public function get_transaction_detail($transaction_id)
	{
		$result = $this->merchant->findTransactionByMerchantIdAndTransactionId($this->session->userdata(SESSUSER . 'merchant_id'), $transaction_id)->result();
		echo json_encode($result);
	}

	public function get_product_detail($id)
	{
		$where_product = ['del' => 0, 'id' => $id];
		$product = $this->merchant->get('produk', '*', $where_product)->row();

		echo json_encode($product);
	}

	public function on_change_category($category_id)
	{
		$where_sub_category = ['active' => 1, 'del' => 0, 'parent' => $category_id];
		$sub_category = $this->merchant->get('sub_kategori', '*', $where_sub_category, 'urutan', 'ASC')->result();

		echo json_encode($sub_category);
	}

	public function get_images_product($product_id)
	{
		$where_images = ['del' => 0, 'produk_id' => $product_id];
		$images = $this->merchant->get('gambar_produk', '*', $where_images, 'urutan', 'ASC')->result();

		echo json_encode($images);
	}

	public function insert_update_product()
	{
		$id = $this->input->post('produk_id');
		$gambar = json_decode($this->input->post('gambar'));
		$data['toko_id'] = $this->session->userdata(SESSUSER . 'merchant_id');
		$data['nama'] = $this->input->post('nama');
		$data['harga_asli'] = str_replace('.', '', $this->input->post('harga_asli'));
		$data['disc'] = $this->input->post('disc');
		$data['harga_disc'] = str_replace('.', '', $this->input->post('harga_disc'));
		$data['kategori_id'] = $this->input->post('kategori') ? $this->input->post('kategori') : null;
		$data['sub_kategori_id'] = $this->input->post('sub_kategori') ? $this->input->post('sub_kategori') : null;
		$data['desc'] = $this->input->post('desc');
		if ($this->session->userdata(SESSUSER . 'merchant_id')) {
			if ($id) {
				$data['modified_date'] = date('Y-m-d h:i:s');
				$result = $this->merchant->update_product('produk', $data, $id, $this->session->userdata(SESSUSER . 'merchant_id'));
				if ($result > 0) {
					echo json_encode('true');
				} else {
					echo json_encode('false');
				}
			} else {
				$data['created_date'] = date('Y-m-d h:i:s');
				$result = $this->merchant->insert('produk', $data);
				if ($result > 0) {
					$data['id'] = $result;
					$this->upload_gambar_new_product($gambar, $result);
					echo json_encode('true');
				} else {
					echo json_encode('false');
				}
			}
		} else {
			echo json_encode('false');
		}
	}

	public function delete_product($product_id)
	{
		$product = $this->merchant->findProductByMerhanctIdAndProductId($this->session->userdata(SESSUSER . 'merchant_id'), $product_id, 1);
		if ($product) {
			$data = [
				"del" => 1
			];
			$result = $this->merchant->update('produk', $data, $product_id);
			echo json_encode($result ? 'true' : 'false');
		}
	}

	public function upload_gambar_new_product($gambar, $product_id)
	{
		$i = 0;
		foreach ($gambar as $image) {
			$i++;
			$product = $this->merchant->findProductByMerhanctIdAndProductId($this->session->userdata(SESSUSER . 'merchant_id'), $product_id, 1);
			if ($product->row()) {
				$filename = $product_id . uniqid() . '.png';
				$folderPath = 'public/img/produk/';
				$image_parts = explode(";base64,", $image);
				$image_type_aux = explode("image/", $image_parts[0]);
				$image_type = $image_type_aux[1];

				$image_base64 = base64_decode($image_parts[1]);
				$file = $folderPath . $filename;

				if (file_put_contents($file, $image_base64)) {
					$data = [
						'produk_id' => $product_id,
						'gambar' => $filename,
						'urutan' => $i,
					];
					$urutan = $product->row()->urutan ? $product->row()->urutan + 1 : 1;
					if ($urutan < 5) {
						$data['urutan'] = $urutan;
						$result = $this->merchant->insert('gambar_produk', $data);
						if ($result) {
							$data['id'] = $result;
							echo json_encode($data);
						} else {
							echo json_encode('false');
						}
					} else {
						echo json_encode('false');
					}
				} else {
					echo json_encode('false');
				}
			} else {
				echo json_encode('false');
			}
		}
	}

	public function upload_image_product()
	{
		$gambar_id = $this->input->post('gambar_id');
		$product_id = $this->input->post('produk_id');
		$product = $this->merchant->findProductByMerhanctIdAndProductId($this->session->userdata(SESSUSER . 'merchant_id'), $product_id, 1);
		if ($product->row()) {
			$image = $this->input->post('image');
			$filename = $product_id . uniqid() . '.png';

			$folderPath = 'public/img/produk/';
			$image_parts = explode(";base64,", $image);
			$image_type_aux = explode("image/", $image_parts[0]);
			$image_type = $image_type_aux[1];

			$image_base64 = base64_decode($image_parts[1]);
			$file = $folderPath . $filename;

			if (file_put_contents($file, $image_base64)) {
				$data = [
					'produk_id' => $product_id,
					'gambar' => $filename,
				];
				$urutan = $product->row()->urutan ? $product->row()->urutan + 1 : 1;
				if ($gambar_id) {
					$data['id'] = $gambar_id;
					$gambar = $this->merchant->get('gambar_produk', '*', ['id' => $gambar_id])->row();
					$result = $this->merchant->update('gambar_produk', $data, $gambar_id);
					if ($result) {
						$data['urutan'] = $gambar->urutan;
						echo json_encode($data);
					} else {
						echo json_encode('false');
					}
				} else if ($urutan < 5) {
					$data['urutan'] = $urutan;
					$result = $this->merchant->insert('gambar_produk', $data);
					if ($result) {
						$data['id'] = $result;
						echo json_encode($data);
					} else {
						echo json_encode('false');
					}
				} else {
					echo json_encode('false');
				}
			} else {
				echo json_encode('false');
			}
		} else {
			echo json_encode('false');
		}
	}

	public function sort_image_product()
	{
		$post = json_decode($this->input->post('data'));
		$result = true;
		foreach ($post as $f) {
			$executed = $this->merchant->update('gambar_produk', ['urutan' => $f->urutan], $f->id);
			$result = ($executed > 0 && $result) ? true : false;
		}
		echo json_encode($result ? 'true' : 'false');
	}

	public function delete_image_product()
	{
		$id = $this->input->post('id');
		$product_id = $this->input->post('produk_id');
		$product = $this->merchant->findProductByMerhanctIdAndProductId($this->session->userdata(SESSUSER . 'merchant_id'), $product_id, 1);
		if ($product->row()) {
			$result = $this->merchant->delete('gambar_produk', ['id' => $id]);
			echo json_encode($result ? 'true' : 'false');
		} else {
			echo json_encode($product->row());
		}
	}
}

/* End of file DashboardController.php */
/* Location: ./application/controllers/DashboardController.php */