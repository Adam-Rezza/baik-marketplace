<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TransactionController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->ci = &get_instance();
		$this->load->helper(['cookie', 'string']);
		$this->ci->load->model('m_transaction', 'transaction');
	}

	public function index()
	{
		$data['title']   = 'Dashboard';
		$data['content'] = 'dashboard/index';
		$data['vitamin'] = 'dashboard/index_vitamin';

		$data['admin_count'] = $this->mcore->count(TABLE_ADMINS, ['deleted_at' => NULL]);

		$this->template->template($data);
	}

	public function get_cart_detail()
	{
		$user_id = $this->session->userdata(SESS . 'id');
		$cart = $this->ci->transaction->findCartByUserIdAndNotTransactionId($user_id)->row();
		echo json_encode($cart);
	}

	public function add_to_cart($produk_id, $qty)
	{
		$user_id = $this->session->userdata(SESS . 'id');
		$produk = $this->ci->transaction->findProductById($produk_id)->row();
		$cart = $this->ci->transaction->findCartByUserIdAndProductIdAndNotTransactionId($user_id, $produk_id)->row();
		if ($cart && $produk) {
			$data = [
				'user_id' => $user_id,
				'produk_id' => $produk->id,
				'harga' => $produk->harga_disc,
				'qty' => $cart->qty + $qty,
				'created_date' => date('Y-m-d h:i:s')
			];
			$result = $this->ci->transaction->update('keranjang', $data, $cart->id);
			echo $result ? 'true' : 'false';
		} else if ($produk) {
			$data = [
				'user_id' => $user_id,
				'produk_id' => $produk->id,
				'harga' => $produk->harga_disc,
				'qty' => $qty,
				'created_date' => date('Y-m-d h:i:s')
			];
			$result = $this->ci->transaction->insert('keranjang', $data);
			echo $result ? 'true' : 'false';
		} else {
			echo 'false';
		}
	}

	public function update_product_cart($produk_id, $qty)
	{
		$user_id = $this->session->userdata(SESS . 'id');
		$produk = $this->ci->transaction->findProductById($produk_id)->row();
		$cart = $this->ci->transaction->findCartByUserIdAndProductIdAndNotTransactionId($user_id, $produk_id)->row();
		if ($cart && $produk) {
			$data = [
				'user_id' => $user_id,
				'produk_id' => $produk->id,
				'harga' => $produk->harga_disc,
				'qty' => $qty,
				'created_date' => date('Y-m-d h:i:s')
			];
			$result = $this->ci->transaction->update('keranjang', $data, $cart->id);
			echo $result ? 'true' : 'false';
		} else if ($produk) {
			$data = [
				'user_id' => $user_id,
				'produk_id' => $produk->id,
				'harga' => $produk->harga_disc,
				'qty' => $qty,
				'created_date' => date('Y-m-d h:i:s')
			];
			$result = $this->ci->transaction->insert('keranjang', $data);
			echo $result ? 'true' : 'false';
		} else {
			echo 'false';
		}
	}

	public function checkout_transaction()
	{
		$user_id = $this->session->userdata(SESS . 'id');
		$where = ['user_id' => $user_id];
		$alamat = $this->ci->transaction->findAddressByUserId($user_id)->row();
		// $toko_transaksi = $this->ci->transaction->getToko('keranjang', '*', $where, null, null, null, null, 'toko_id');
		// foreach ($toko_transaksi as $f) {
		// }
		if ($alamat) {
			$alamat_lengkap = $alamat->alamat . ", " . $alamat->kel . ", " . $alamat->kec . ", " . $alamat->kab . ", " . $alamat->prov;
			$data = [
				'penerima' => $this->session->userdata(SESS . 'nama'),
				'telp_penerima' => $this->session->userdata(SESS . 'nama'),
				'alamat' => $alamat_lengkap,
				'status' => 1,
				'created_date' => date('Y-m-d h:i:s')
			];
			$transaction = $this->ci->transaction->insert('transaksi', $data);
			if($transaction){
				$data = ['transaksi_id' => $transaction];
				$keranjang = $this->ci->transaction->updateKeranjangByUserId($data, $user_id);
				echo $keranjang ? 'true' : '3';
			} else {
				echo '2';
			}
		} else {
			echo '1';
		}
	}

	public function process_order($transaksi_id)
	{
		$data = ['status' => 2];
		$result = $this->transaction->update('transaksi',$data,$transaksi_id);
		echo $result ? 'true' : 'false';
	}

	public function send_order($transaksi_id)
	{
		$data = ['status' => 3];
		$result = $this->transaction->update('transaksi',$data,$transaksi_id);
		echo $result ? 'true' : 'false';
	}

	public function delivered_order($transaksi_id)
	{
		$data = ['status' => 9];
		$result = $this->transaction->update('transaksi',$data,$transaksi_id);
		echo $result ? 'true' : 'false';
	}
}

/* End of file DashboardController.php */
/* Location: ./application/controllers/DashboardController.php */