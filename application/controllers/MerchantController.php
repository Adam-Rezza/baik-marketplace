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
		$where_category = ['active' => 1, 'del' => 0];
		$data['category'] = $this->merchant->get('kategori', '*', $where_category, 'urutan', 'ASC')->result();
		foreach ($data['category'] as $f) {
			$where_sub_category = ['active' => 1, 'del' => 0, 'parent' => $f->id];
			$data['sub_category'][$f->id] = $this->merchant->get('sub_kategori', '*', $where_sub_category, 'urutan', 'ASC')->result();
		}
		$data['keyword'] = '';
		$data['search_category'] = null;
		$data['search_sub_category'] = null;
		return $data;
	}

	public function index()
	{
		$this->auth();
	}

	public function auth()
	{
		if ($this->session->userdata(SESS . 'merchant_id') === null) {
			$data = $this->init();
			$data['title']   = 'Daftar Toko';
			$data['content'] = 'auth/index';
			$data['vitamin'] = 'auth/index_vitamin';

			// var_dump($this->session->userdata());
			$this->customer_template->template($data);
		} else {
			$this->my_product();
		}
	}

	public function my_product()
	{
		$data = $this->init();
		$data['title']   = 'Produk Saya';
		$data['content'] = 'my_product/index';
		$data['vitamin'] = 'my_product/index_vitamin';

		$data['product'] = $this->merchant->findProductByTokoId($this->session->userdata(SESS . 'merchant_id'))->result();
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
		$data['transaction'] = $this->merchant->findOrderByMerchantIdAndStatusGroupByTransaction($this->session->userdata(SESS . 'merchant_id'), $status)->result();
		foreach ($data['transaction'] as $f) {
			$data['order'][$f->id] = $this->merchant->findOrderByMerchantIdAndStatusAndTransactionId($this->session->userdata(SESS . 'merchant_id'), $status, $f->id)->result();
		}
		// var_dump($data['transaction']);
		$this->template->template($data);
	}

	public function get_product_detail($id)
	{
		$result = $this->merchant->findProductById($id)->row();
		echo json_encode($result);
	}

	public function on_change_category($category_id)
	{
		$where_sub_category = ['active' => 1, 'del' => 0, 'parent' => $category_id];
		$sub_category = $this->merchant->get('sub_kategori', '*', $where_sub_category, 'urutan', 'ASC')->result();
		// $sub_category = $this->merchant->findSubCategoriByParent($CategoriId)->result();
		echo json_encode($sub_category);
	}

	public function get_images_product($product_id)
	{
		$where_images = ['del' => 0, 'produk_id' => $product_id];
		$images = $this->merchant->get('gambar_produk', '*', $where_images, 'urutan', 'ASC')->result();
		// $images = $this->merchant->findImagesByProductId($product_id)->result();
		echo json_encode($images);
	}

	public function insert_update_product()
	{
		$id = $this->input->post('produk_id');
		$data['toko_id'] = $this->session->userdata(SESS . 'merchant_id');
		$data['nama'] = $this->input->post('nama');
		$data['harga_asli'] = str_replace('.', '', $this->input->post('harga_asli'));
		$data['disc'] = $this->input->post('disc');
		$data['harga_disc'] = str_replace('.', '', $this->input->post('harga_disc'));
		$data['kategori_id'] = $this->input->post('kategori');
		$data['sub_kategori_id'] = $this->input->post('sub_kategori');
		$data['desc'] = $this->input->post('desc');
		if ($id) {
			$data['modified_date'] = date('Y-m-d h:i:s');
			if ($result = $this->merchant->update('produk', $data, $id) > 0) {
				echo "true";
			} else {
				echo 'false';
			}
		} else {
			$data['created_date'] = date('Y-m-d h:i:s');
			if ($result = $this->merchant->insert('produk', $data) > 0) {
				$data['id'] = $result;
				echo "true";
			} else {
				echo 'false';
			}
		}
	}

	public function upload_image_product()
	{
		$id = $this->input->post('gambar_id');
		$product_id = $this->input->post('produk_id');
		$urutan = $this->input->post('urutan');
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
				'urutan' => $urutan,
			];
			if ($id) {
				$data['id'] = $id;
				$result = $this->merchant->update('gambar_produk', $data, $id);
				if ($result) {
					echo json_encode($data);
				} else {
					echo 'false';
				}
			} else {
				$result = $this->merchant->insert('gambar_produk', $data);
				if ($result) {
					$data['id'] = $result;
					echo json_encode($data);
				} else {
					echo 'false';
				}
			}
		} else {
			echo 'false';
		}

		// if ($result = $this->merchant->insert('produk', $data) > 0) {
		// 	$data['id'] = $result;
		// 	echo "true";
		// } else {
		// 	echo 'false';
		// }
	}
}

/* End of file DashboardController.php */
/* Location: ./application/controllers/DashboardController.php */