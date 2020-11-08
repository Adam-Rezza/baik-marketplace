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
		if ($this->input->post('variasi')) {
			$variasi = count($this->input->post('variasi')) > 0 ? json_encode($this->input->post('variasi')) : null;
		} else {
			$variasi = null;
		}
		$where_product = ['id' => $product_id, 'del' => 0, 'ban' => 0];
		$product = $this->ci->transaction->get('produk', '*', $where_product)->row();
		$cart = $this->ci->transaction->findCartByUserIdAndProductIdAndVariasiIdAndNotTransactionId($user_id, $product_id, $variasi)->row();
		if (!($product->toko_id == $this->session->userdata(SESSUSER . 'merchant_id'))) {
			if ($user_id && $cart && $product) {
				$data = [
					'user_id'      => $user_id,
					'produk_id'    => $product->id,
					'variasi_id'   => $variasi,
					'harga'        => $product->harga_disc,
					'qty'          => $cart->qty + intval($qty),
					'created_date' => date('Y-m-d H:i:s')
				];
				$result = $this->ci->transaction->update('keranjang', $data, $cart->id);
				echo json_encode($result ? 'true' : 'false');
			} else if ($user_id && $product) {
				$data = [
					'user_id'      => $user_id,
					'produk_id'    => $product->id,
					'variasi_id'   => $variasi,
					'harga'        => $product->harga_disc,
					'qty'          => $qty,
					'created_date' => date('Y-m-d H:i:s')
				];
				$result = $this->ci->transaction->insert('keranjang', $data);
				echo json_encode($result ? 'true' : 'false');
			} else {
				echo json_encode('false');
			}
		} else {
			echo json_encode('merchant');
		}
	}

	public function update_product_cart($product_id, $qty)
	{
		$user_id = $this->session->userdata(SESSUSER . 'id');
		if ($this->input->post('variasi')) {
			$variasi = $this->input->post('variasi');
		} else {
			$variasi = null;
		}
		$where_product = ['id' => $product_id, 'del' => 0, 'ban' => 0];
		$product = $this->ci->transaction->get('produk', '*', $where_product)->row();
		$cart = $this->ci->transaction->findCartByUserIdAndProductIdAndVariasiIdAndNotTransactionId($user_id, $product_id, $variasi)->row();
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
		$saldo = $this->_get_saldo($user_id);

		if ($saldo['code'] == 500) {
			echo json_encode('3');
			exit;
		}

		if ($saldo['code'] == 404) {
			echo json_encode('4');
			exit;
		}

		if ($saldo['code'] == 200) {
			$saldo = $saldo['saldo'];
		}

		$total_keranjang = $this->_get_total_keranjang($user_id);

		if ($total_keranjang['code'] == 500) {
			echo json_encode('3');
			exit;
		}

		if ($total_keranjang['code'] == 404) {
			echo json_encode('5');
			exit;
		}

		if ($total_keranjang['code'] == 200) {
			$total_keranjang = $total_keranjang['total'];
		}

		if ($saldo < $total_keranjang) {
			echo json_encode('6');
			exit;
		}

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

				$invoice = date('dmYHis');

				$grand_total = 0;

				$grand_total = $this->ci->transaction->getSumHargaByUserIdAndTokoId($user_id, $f->id)->row()->sum_harga;

				$data = [
					'invoice'       => $invoice,
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
					'grand_total'   => $grand_total,
				];
				$transaction = $this->ci->transaction->insert('transaksi', $data);
				if ($transaction) {
					$data = ['transaksi_id' => $transaction];
					$keranjang = $this->ci->transaction->updateKeranjangByUserIdAndMerchantId($transaction, $user_id, $f->id);

					$jurnal = $this->_jurnal($transaction, $grand_total, $user_id);
					if ($jurnal === FALSE) {
						echo json_encode('3');
						exit;
					}

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
			if($status){
				$this->db->trans_commit();
				echo json_encode('true'); // 1 => transaksi gagal 
			} else {
				$this->db->trans_rollback();
				$status = false;
				echo json_encode('1'); // 1 => transaksi gagal 
				exit;
			}
		} else {
			echo json_encode('2'); // 1 => blm ada alamat 
		}
	}

	public function _get_saldo($id_user)
	{
		$arr_saldo = $this->mcore->get('user', 'saldo', ['id' => $id_user]);

		if (!$arr_saldo) {
			return ['code' => 500];
		}

		if ($arr_saldo->num_rows() == 0) {
			return ['code' => 404];
		}

		if ($arr_saldo->row()->saldo == 0) {
			return ['code' => 404];
		}

		return ['code' => 200, 'saldo' => $arr_saldo->row()->saldo];
	}

	public function _get_total_keranjang($id_user)
	{
		// $arr_keranjang = $this->mcore->get('keranjang', 'harga', ['user_id' => $id_user, 'transaksi_id' => NULL]);
		$total = $this->ci->transaction->getSumHargaTotal($id_user)->row()->sum_harga;

		// if (!$arr_keranjang) {
		// 	return ['code' => 500];
		// }

		// if ($arr_keranjang->num_rows() == 0) {
		// 	return ['code' => 404];
		// }

		// $total = 0;
		// foreach ($arr_keranjang->result() as $key) {
		// 	$total += $key->harga;
		// }

		if ($total == 0) {
			return ['code' => 404];
		}

		return ['code' => 200, 'total' => $total];
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
		$user_id       = $this->session->userdata(SESSUSER . 'id');
		$grand_total   = 0;
		$id_toko       = NULL;
		$id_user_toko  = NULL;
		$arr_transaksi = $this->mcore->get('transaksi', 'toko_id, grand_total', ['id' => $transaction_id]);

		if ($arr_transaksi) {
			if ($arr_transaksi->num_rows() == 1) {
				$grand_total = $arr_transaksi->row()->grand_total;
				$id_toko     = $arr_transaksi->row()->toko_id;

				$arr_toko = $this->mcore->get('toko', 'user_id', ['id' => $id_toko]);

				if ($arr_toko) {
					if ($arr_toko->num_rows() == 1) {
						$id_user_toko = $arr_toko->row()->user_id;
					}
				}
			}
		}

		if ($id_user_toko != NULL && $id_toko != NULL) {
			$jurnal = $this->_jurnal_selesai($transaction_id, $grand_total, $id_user_toko);
		} else {
			echo json_encode(FALSE);
			exit;
		}


		if (!$jurnal) {
			echo json_encode(FALSE);
			exit;
		}

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

	public function _jurnal($id_transaksi, $grand_total, $id_user)
	{
		$data = [
			'id_user'        => $id_user,
			'id_transaksi'   => $id_transaksi,
			'tipe'           => 'kredit',
			'total'          => $grand_total,
			'kode_transaksi' => 'pembelian',
			'created_at'     => date('Y-m-d H:i:s'),
		];
		$exec = $this->mcore->store_uuid('jurnal', $data);

		$data = [
			'id_user'        => '1',
			'id_transaksi'   => $id_transaksi,
			'tipe'           => 'debit',
			'total'          => $grand_total,
			'kode_transaksi' => 'pembelian',
			'created_at'     => date('Y-m-d H:i:s'),
		];
		$exec = $this->mcore->store_uuid('jurnal', $data);

		if (!$exec) {
			return FALSE;
		}

		$pengurangan_saldo = $this->ci->transaction->penguranganSaldo($id_user, $grand_total);
		$penambahan_saldo = $this->ci->transaction->penambahanSaldo('1', $grand_total);

		return TRUE;
	}

	public function _jurnal_selesai($id_transaksi, $grand_total, $id_user)
	{
		$data = [
			'id_user'        => '1',
			'id_transaksi'   => $id_transaksi,
			'tipe'           => 'kredit',
			'total'          => $grand_total,
			'kode_transaksi' => 'penjualan',
			'created_at'     => date('Y-m-d H:i:s'),
		];
		$exec = $this->mcore->store_uuid('jurnal', $data);

		$data = [
			'id_user'        => $id_user,
			'id_transaksi'   => $id_transaksi,
			'tipe'           => 'debit',
			'total'          => $grand_total,
			'kode_transaksi' => 'penjualan',
			'created_at'     => date('Y-m-d H:i:s'),
		];
		$exec = $this->mcore->store_uuid('jurnal', $data);

		if (!$exec) {
			return FALSE;
		}

		$pengurangan_saldo = $this->ci->transaction->penguranganSaldo('1', $grand_total);
		$penambahan_saldo = $this->ci->transaction->penambahanSaldo($id_user, $grand_total);

		return TRUE;
	}
}

/* End of file DashboardController.php */
/* Location: ./application/controllers/DashboardController.php */