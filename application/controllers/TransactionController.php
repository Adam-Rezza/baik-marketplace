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
		$user_id = $this->session->userdata(SESSUSER . 'id');
		$cart = $this->ci->transaction->findCartByUserIdAndNotTransactionId($user_id)->row();
		if ($user_id && $cart) {
			echo json_encode($cart);
		} else {
			echo 'false';
		}
	}

	public function add_to_cart($product_id, $qty)
	{
		$user_id = $this->session->userdata(SESSUSER . 'id');
		$where_product = ['id' => $product_id, 'del' => 0, 'ban' => 0];
		$product = $this->ci->transaction->get('produk', '*', $where_product)->row();
		$cart = $this->ci->transaction->findCartByUserIdAndProductIdAndNotTransactionId($user_id, $product_id)->row();
		if (!($product->toko_id == $this->session->userdata(SESSUSER . 'merchant_id'))) {
			if ($user_id && $cart && $product) {
				$data = [
					'user_id' => $user_id,
					'produk_id' => $product->id,
					'harga' => $product->harga_disc,
					'qty' => $cart->qty + intval($qty),
					'created_date' => date('Y-m-d H:i:s')
				];
				$result = $this->ci->transaction->update('keranjang', $data, $cart->id);
				echo $result ? 'true' : 'false';
			} else if ($user_id && $product) {
				$data = [
					'user_id' => $user_id,
					'produk_id' => $product->id,
					'harga' => $product->harga_disc,
					'qty' => $qty,
					'created_date' => date('Y-m-d H:i:s')
				];
				$result = $this->ci->transaction->insert('keranjang', $data);
				echo $result ? 'true' : 'false';
			} else {
				echo 'false';
			}
		} else {
			echo 'merchant';
		}
	}

	public function update_product_cart($product_id, $qty)
	{
		$user_id = $this->session->userdata(SESSUSER . 'id');
		$where_product = ['id' => $product_id, 'del' => 0, 'ban' => 0];
		$product = $this->ci->transaction->get('produk', '*', $where_product)->row();
		$cart = $this->ci->transaction->findCartByUserIdAndProductIdAndNotTransactionId($user_id, $product_id)->row();
		if ($user_id && $cart && $product) {
			$data = [
				'user_id' => $user_id,
				'produk_id' => $product->id,
				'harga' => $product->harga_disc,
				'qty' => $qty,
				'created_date' => date('Y-m-d H:i:s')
			];
			$result = $this->ci->transaction->update('keranjang', $data, $cart->id);
			echo $result ? 'true' : 'false';
		} else if ($user_id && $product) {
			$data = [
				'user_id' => $user_id,
				'produk_id' => $product->id,
				'harga' => $product->harga_disc,
				'qty' => $qty,
				'created_date' => date('Y-m-d H:i:s')
			];
			$result = $this->ci->transaction->insert('keranjang', $data);
			echo $result ? 'true' : 'false';
		} else {
			echo 'false';
		}
	}

	public function delete_cart($cart_id)
	{
		$user_id = $this->session->userdata(SESSUSER . 'id');
		$cart = $this->ci->transaction->findCartByUserIdAndCartIdAndNotTransactionId($user_id, $cart_id)->row();
		if ($user_id && $cart) {
			$where = [
				'id' => $cart_id,
			];
			$result = $this->ci->transaction->delete('keranjang', $where);
			if ($result) {
				redirect(base_url('checkout'));
			} else {
				show_404();
			}
		}
	}

	public function checkout_transaction()
	{
		$user_id = $this->session->userdata(SESSUSER . 'id');
		$alamat  = $this->ci->transaction->findAddressByUserId($user_id)->row();
		$this->db->trans_begin();
		if ($user_id && $alamat) {
			$toko_pemilik_keranjang = $this->ci->transaction->findMerchantOwnerCartByUserIdGroupByMerchantId($user_id)->result();
			$status = true;
			$i = 0;
			foreach ($toko_pemilik_keranjang as $f) {
				$alamat_lengkap = $alamat->alamat . ", " . $alamat->kel . ", " . $alamat->kec . ", " . $alamat->kab . ", " . $alamat->prov;
				$id_ekspedisi = NULL;
				foreach ($this->input->post('id_toko') as $x => $y) {
					if ($this->input->post('id_toko')[$x] == $f->id) {
						$id_ekspedisi = $this->input->post('id_ekspedisi')[$x];
					}
				}

				$data = [
					'toko_id'       => $f->id,
					'pengirim'      => $f->nama,
					'telp_pengirim' => $f->telp,
					'user_id'       => $this->session->userdata(SESSUSER . 'id'),
					'penerima'      => $this->session->userdata(SESSUSER . 'nama'),
					'telp_penerima' => $this->session->userdata(SESSUSER . 'telp'),
					'alamat'        => $alamat_lengkap,
					'kelurahan'     => $alamat->kelurahan,
					'kecamatan'     => $alamat->kecamatan,
					'kota'          => $alamat->kota,
					'provinsi'      => $alamat->provinsi,
					'status'        => 1,
					'created_date'  => date('Y-m-d H:i:s'),
					'id_ekspedisi'  => $id_ekspedisi,
				];
				$transaction = $this->ci->transaction->insert('transaksi', $data);
				if ($transaction) {
					$data = ['transaksi_id' => $transaction];
					$keranjang = $this->ci->transaction->updateKeranjangByUserIdAndMerchantId($transaction, $user_id, $f->id);
					$invoice = ['invoice' => $f->id . date('dmYHis') . $transaction];
					$this->ci->transaction->update('transaksi', $invoice, $transaction);
					$msg = "Pesanan anda di teruskan ke <b>" . $f->nama . "</b>";
					$url = "my_order";
					$this->create_notification($user_id, $msg, $url);
					$status = ($status && $keranjang) ? true : false;
				} else {
					$this->db->trans_rollback();
					$status = false;
					echo json_encode($status ? 'true' : '1'); // 1 => transaksi gagal 
					exit;
				}
				$i++;
			}
			$this->db->trans_commit();
			echo json_encode($status ? 'true' : '1'); // 1 => transaksi gagal 
		} else {
			echo json_encode('2'); // 1 => blm ada alamat 
		}
	}

	public function process_order($transaction_id)
	{
		$data = ['status' => 2, 'proccess_date' => date('Y-m-d H:i:s')];
		$result = $this->transaction->update('transaksi', $data, $transaction_id);
		if ($result) {
			$transaction = $this->transaction->get('transaksi', '*', ['id' => $transaction_id])->row();
			$msg = "Pesanan anda sedang di proses oleh <b>" . $transaction->pengirim . "</b>";
			$url = "my_order";
			$this->create_notification($transaction->user_id, $msg, $url);
		}
		echo json_encode($result ? 'true' : 'false');
	}

	public function send_order($transaction_id)
	{
		$resi = $this->input->post('resi');
		$data = ['status' => 3, 'shipment_date' => date('Y-m-d H:i:s'), 'resi' => $resi];
		$result = $this->transaction->update('transaksi', $data, $transaction_id);
		if ($result) {
			$transaction = $this->transaction->get('transaksi', '*', ['id' => $transaction_id])->row();
			$msg = "Pesanan anda sedang dikirimkan oleh <b>" . $transaction->pengirim . "</b>";
			$url = "my_order";
			$this->create_notification($transaction->user_id, $msg, $url);
		}
		echo json_encode($result ? 'true' : 'false');
	}

	public function delivered_order($transaction_id)
	{
		$data = ['status' => 9, 'delivery_date' => date('Y-m-d H:i:s')];
		$result = $this->transaction->update('transaksi', $data, $transaction_id);
		$result2 = true;
		if ($result) {
			$product = $this->transaction->findProductByUserIdAndTransactionId($this->session->userdata(SESSUSER . 'id'), $transaction_id)->result();
			foreach ($product as $f) {
				$qty_produk = ['terjual' => $f->terjual + $f->qty];
				$update = $this->transaction->update('produk', $qty_produk, $f->produk_id);
				$result2 = $result2 && $update ? true : false;
			}
			$transaction = $this->transaction->get('transaksi', '*', ['id' => $transaction_id])->row();
			$msg = "Pesanan anda pada <b>" . $transaction->pengirim . "</b> sudah selesai";
			$url = "my_recent_order";
			$this->create_notification($transaction->user_id, $msg, $url);
		}
		echo json_encode($result && $result2 ? 'true' : 'false');
	}

	public function cancel_order($transaction_id)
	{
		$data = [
			'status' => 10,
			'failed_date' => date('Y-m-d H:i:s'),
			'failed_reason' => $this->input->post('alasan')
		];
		$result = $this->transaction->update('transaksi', $data, $transaction_id);
		if ($result) {
			$transaction = $this->transaction->get('transaksi', '*', ['id' => $transaction_id])->row();
			$msg = "Pesanan anda pada <b>" . $transaction->pengirim . "</b> dibatalkan";
			$url = "my_recent_order";
			$this->create_notification($transaction->user_id, $msg, $url);
		}
		echo json_encode($result ? 'true' : 'false');
	}

	// NOTIFIKASI

	private function create_notification($for_user_id, $msg, $url)
	{
		$data = [
			'user_id' => $for_user_id,
			'msg' => $msg,
			'url' => $url,
			'read' => 0,
			'datetime' => Date('Y-m-d H:i:s')
		];
		$result = $this->transaction->insert('notifikasi', $data);
		return $result ? true : false;
	}

	public function read_notification($notification_id)
	{
		$data = ['read' => 1];
		$result = $this->transaction->update('notifikasi', $data, $notification_id);
		echo $result ? 'true' : 'false';
	}
}

/* End of file DashboardController.php */
/* Location: ./application/controllers/DashboardController.php */