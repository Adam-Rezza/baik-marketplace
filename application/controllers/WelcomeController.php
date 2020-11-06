<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WelcomeController extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->helper('directory');
		$this->load->helper('file');
	}


	public function index()
	{
		$truncate = $this->_truncate();
		($truncate) ? $text = "Truncate Berhasil <br />" : $text = "Truncate Berhasil <br />";
		echo $text;

		$init_admin = $this->_init_admin();
		($init_admin) ? $text = "Init Admin Berhasil <br />" : $text = "Init Admin gagal <br />";
		echo $text;

		$init_user = $this->_init_user();
		($init_user) ? $text = "Init User Berhasil <br />" : $text = "Init User gagal <br />";
		echo $text;

		$init_banner = $this->_init_banner();
		($init_banner) ? $text = "Init Banner Berhasil <br />" : $text = "Init Banner gagal <br />";
		echo $text;

		$init_ekspedisi = $this->_init_ekspedisi();
		($init_ekspedisi) ? $text = "Init Ekspedisi Berhasil <br />" : $text = "Init Ekspedisi gagal <br />";
		echo $text;

		$init_kategori = $this->_init_kategori();
		($init_kategori) ? $text = "Init Kategori Berhasil <br />" : $text = "Init Kategori gagal <br />";
		echo $text;

		$init_sub_kategori = $this->_init_sub_kategori();
		($init_sub_kategori) ? $text = "Init Sub Kategori Berhasil <br />" : $text = "Init Sub Kategori gagal <br />";
		echo $text;

		$init_toko = $this->_init_toko();
		($init_toko) ? $text = "Init toko Berhasil <br />" : $text = "Init toko gagal <br />";
		echo $text;

		$init_produk = $this->_init_produk();
		($init_produk) ? $text = "Init produk Berhasil <br />" : $text = "Init produk gagal <br />";
		echo $text;

		$init_review = $this->_init_review();
		($init_review) ? $text = "Init review Berhasil <br />" : $text = "Init review gagal <br />";
		echo $text;
		$this->output->enable_profiler(TRUE);
	}

	public function _truncate()
	{
		$this->db->trans_begin();
		$this->db->truncate('admins');
		$this->db->truncate('alamat');
		$this->db->truncate('banner');
		$this->db->truncate('ekspedisi');
		$this->db->truncate('gambar_produk');
		$this->db->truncate('jurnal');
		$this->db->truncate('kategori');
		$this->db->truncate('keranjang');
		$this->db->truncate('list_variasi_produk');
		$this->db->truncate('notifikasi');
		$this->db->truncate('produk');
		$this->db->truncate('qna');
		$this->db->truncate('review');
		$this->db->truncate('sub_kategori');
		$this->db->truncate('toko');
		$this->db->truncate('transaksi');
		$this->db->truncate('user');
		$this->db->truncate('variasi_produk');
		$this->db->query('ALTER TABLE variasi_produk AUTO_INCREMENT = 1000');

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return FALSE;
		} else {
			$this->db->trans_commit();
			return TRUE;
		}
	}

	public function _init_admin()
	{
		$now      = new DateTime();
		$password = password_hash('admin123)' . UYAH, PASSWORD_BCRYPT);

		# INIT ADMIN
		##################################################################
		$object = [
			'username'   => 'admin',
			'password'   => $password,
			'created_at' => $now->format('Y-m-d H:i:s'),
			'updated_at' => $now->format('Y-m-d H:i:s'),
			'deleted_at' => NULL
		];

		$exec = $this->mcore->store('admins', $object);
		##################################################################

		if ($exec === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _init_user()
	{
		$path = './public/img/profile/';
		$map = directory_map($path);

		foreach ($map as $m => $v) {
			// print_r($v) . '<br>';
			if (in_array($v, ['user.png']) === FALSE) {
				$file = $path . $v;
				unlink($file);
			}
		}

		$now      = new DateTime();
		$password = password_hash('test123)' . UYAH, PASSWORD_BCRYPT);
		$checker  = [];

		# INIT USER
		##################################################################
		$object = [
			'id'       => '1',
			'nama'     => 'BAIK MIDDLEMAN',
			'email'    => 'koperasi.baik@gmail.com',
			'telp'     => '02518311342',
			'gambar'   => 'baik_logo.png',
			'username' => 'baik',
			'password' => $password,
			'active'   => TRUE,
			'ban'      => FALSE,
			'saldo'    => '0',
		];
		$last_id = $this->mcore->store('user', $object, TRUE);

		$object = [
			'user_id'   => $last_id,
			'alamat'    => 'Komplek Pertanian, Jl. Siaga Kecamatan No.25, RT.02/RW.10, Loji, Kec. Bogor Bar., Kota Bogor, Jawa Barat 16117',
			'kelurahan' => '3271041016',
			'kecamatan' => '327104',
			'kota'      => '3271',
			'provinsi'  => '32',
			'def'       => TRUE,
			'del'       => FALSE,
		];
		$exec = $this->mcore->store('alamat', $object);

		($exec) ? array_push($checker, TRUE) : array_push($checker, FALSE);

		##################################################################
		$object = [
			'nama'     => 'Dummy 1',
			'email'    => 'dummy1@example.com',
			'telp'     => '081234567890',
			'gambar'   => 'user-o.png',
			'username' => 'dummy1',
			'password' => $password,
			'active'   => TRUE,
			'ban'      => FALSE,
			'saldo'    => '0',
		];

		$last_id = $this->mcore->store('user', $object, TRUE);

		$object = [
			'user_id'   => $last_id,
			'alamat'    => 'Komplek Pertanian, Jl. Siaga Kecamatan No.25, RT.02/RW.10, Loji, Kec. Bogor Bar., Kota Bogor, Jawa Barat 16117',
			'kelurahan' => '3271041016',
			'kecamatan' => '327104',
			'kota'      => '3271',
			'provinsi'  => '32',
			'def'       => TRUE,
			'del'       => FALSE,
		];

		$exec = $this->mcore->store('alamat', $object);

		($exec) ? array_push($checker, TRUE) : array_push($checker, FALSE);
		##################################################################
		##################################################################
		$object = [
			'nama'     => 'DUMMY 2',
			'email'    => 'dummy2@example.com',
			'telp'     => '081234567890',
			'gambar'   => 'user-o.png',
			'username' => 'test2',
			'password' => $password,
			'active'   => TRUE,
			'ban'      => FALSE,
			'saldo'    => '0',
		];

		$exec = $this->mcore->store('user', $object);

		$object = [
			'user_id'   => $last_id,
			'alamat'    => 'Komplek Pertanian, Jl. Siaga Kecamatan No.25, RT.02/RW.10, Loji, Kec. Bogor Bar., Kota Bogor, Jawa Barat 16117',
			'kelurahan' => '3271041016',
			'kecamatan' => '327104',
			'kota'      => '3271',
			'provinsi'  => '32',
			'def'       => TRUE,
			'del'       => FALSE,
		];

		$exec = $this->mcore->store('alamat', $object);

		($exec) ? array_push($checker, TRUE) : array_push($checker, FALSE);
		##################################################################
		##################################################################
		$object = [
			'nama'     => 'DUMMY3',
			'email'    => 'dummy3@example.com',
			'telp'     => '081234567890',
			'gambar'   => 'user-o.png',
			'username' => 'test3',
			'password' => $password,
			'active'   => TRUE,
			'ban'      => FALSE,
			'saldo'    => '0',
		];

		$last_id = $this->mcore->store('user', $object, TRUE);
		$object = [
			'user_id'   => $last_id,
			'alamat'    => 'Komplek Pertanian, Jl. Siaga Kecamatan No.25, RT.02/RW.10, Loji, Kec. Bogor Bar., Kota Bogor, Jawa Barat 16117',
			'kelurahan' => '3271041016',
			'kecamatan' => '327104',
			'kota'      => '3271',
			'provinsi'  => '32',
			'def'       => TRUE,
			'del'       => FALSE,
		];

		$exec = $this->mcore->store('alamat', $object);

		($exec) ? array_push($checker, TRUE) : array_push($checker, FALSE);
		##################################################################

		if (in_array(FALSE, $checker) === TRUE) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function _init_banner()
	{
		$path = './public/img/banner/';
		$map = directory_map($path);

		foreach ($map as $m => $v) {
			// print_r($v) . '<br>';
			if (in_array($v, ['banner_1.jpg', 'banner_2.jpg', 'banner_3.jpg']) === FALSE) {
				$file = $path . $v;
				unlink($file);
			}
		}
		# INIT
		##################################################################
		$object[1] = [
			'gambar' => 'banner_1.jpg',
			'url'    => '#',
			'urutan' => '1',
			'active' => TRUE,
			'del'    => FALSE
		];

		$object[2] = [
			'gambar' => 'banner_2.jpg',
			'url'    => '#',
			'urutan' => '2',
			'active' => TRUE,
			'del'    => FALSE
		];

		$object[3] = [
			'gambar' => 'banner_3.jpg',
			'url'    => '#',
			'urutan' => '3',
			'active' => TRUE,
			'del'    => FALSE
		];

		$exec = $this->mcore->store_batch('banner', $object);

		return $exec;
	}

	public function _init_ekspedisi()
	{
		# INIT
		##################################################################
		$nested[1] = [
			'id'   => 'pos',
			'nama' => 'POS - POS Indonesia',
		];

		$nested[2] = [
			'id'   => 'lion',
			'nama' => 'LION - Lion Parcel',
		];

		$nested[3] = [
			'id'   => 'ninja',
			'nama' => 'NINJA - Ninja Xpress',
		];

		$nested[4] = [
			'id'   => 'sicepat',
			'nama' => 'SICEPAT - SiCepat Express',
		];

		$nested[5] = [
			'id'   => 'jne',
			'nama' => 'JNE - Jalur Nugraha Ekakurir',
		];

		$nested[6] = [
			'id'   => 'tiki',
			'nama' => 'TIKI - Citra Van Titipan Kilat',
		];

		$nested[7] = [
			'id'   => 'pandu',
			'nama' => 'PANDU - Pandu Logistics',
		];

		$nested[8] = [
			'id'   => 'wahana',
			'nama' => 'WAHANA - Wahana Prestasi Logistik',
		];

		$nested[9] = [
			'id'   => 'j&t',
			'nama' => 'J&T - J&T Express',
		];

		$nested[10] = [
			'id'   => 'pahala',
			'nama' => 'PAHALA - Pahala Kencana Express',
		];

		$exec = $this->mcore->store_batch('ekspedisi', $nested);

		return $exec;
	}

	public function _init_kategori()
	{
		$path = './public/img/kategori/';
		$map = directory_map($path);

		foreach ($map as $m => $v) {
			// print_r($v) . '<br>';
			$arrnya = [
				'atk.jpg',
				'handymade.jpg',
				'makanan_dan_kue.jpg',
				'pakaian_busana.jpg',
				'peralatan_rumah_tangga.jpg',
				'pob.jpg',
				'sayur_dan_buah.jpg',
				'sembako.jpg',
			];
			if (in_array($v, $arrnya) === FALSE) {
				$file = $path . $v;
				unlink($file);
			}
		}

		$object = [];
		# INIT
		##################################################################
		$nested = [
			'nama'         => 'Sembako',
			'urutan'       => '1',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'sembako.jpg',
		];
		array_push($object, $nested);

		$nested = [
			'nama'         => 'Sayur Dan Buah',
			'urutan'       => '2',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'sayur_dan_buah.jpg',
		];
		array_push($object, $nested);

		$nested = [
			'nama'         => 'Makanan Dan Kue',
			'urutan'       => '3',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'makanan_dan_kue.jpg',
		];
		array_push($object, $nested);

		$nested = [
			'nama'         => 'Peralatan Rumah Tangga',
			'urutan'       => '4',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'peralatan_rumah_tangga.jpg',
		];
		array_push($object, $nested);

		$nested = [
			'nama'         => 'Pakaian / Busana',
			'urutan'       => '5',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'pakaian_busana.jpg',
		];
		array_push($object, $nested);

		$nested = [
			'nama'         => 'Peralatan Sekolah dan Kantor',
			'urutan'       => '6',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'atk.jpg',
		];
		array_push($object, $nested);

		$nested = [
			'nama'         => 'Handymade',
			'urutan'       => '7',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'handymade.jpg',
		];
		array_push($object, $nested);

		$nested = [
			'nama'         => 'Top Up Dan Tagihan',
			'urutan'       => '8',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'pob.jpg',
		];
		array_push($object, $nested);

		$exec = $this->mcore->store_batch('kategori', $object);
		return $exec;
	}

	public function _init_sub_kategori()
	{
		# INIT
		##################################################################
		$object[1] = [
			'parent'       => '3',
			'nama'         => 'Olahan',
			'urutan'       => '1',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[2] = [
			'parent'       => '3',
			'nama'         => 'Kue Kering',
			'urutan'       => '2',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[3] = [
			'parent'       => '4',
			'nama'         => 'Mebel',
			'urutan'       => '1',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[4] = [
			'parent'       => '4',
			'nama'         => 'Peralatan',
			'urutan'       => '2',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[5] = [
			'parent'       => '4',
			'nama'         => 'Elektronik',
			'urutan'       => '3',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[6] = [
			'parent'       => '5',
			'nama'         => 'Busana Pria',
			'urutan'       => '1',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[7] = [
			'parent'       => '5',
			'nama'         => 'Busana Wanita',
			'urutan'       => '2',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[8] = [
			'parent'       => '5',
			'nama'         => 'Busana Anak-anak',
			'urutan'       => '3',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[9] = [
			'parent'       => '7',
			'nama'         => 'Token dan Tagihan Listrik',
			'urutan'       => '1',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[10] = [
			'parent'       => '7',
			'nama'         => 'Tagihan Air',
			'urutan'       => '2',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$exec = $this->mcore->store_batch('sub_kategori', $object);
		return $exec;
	}

	public function _init_toko()
	{
		$path = './public/img/profile_toko/';
		$map = directory_map($path);

		foreach ($map as $m => $v) {
			// print_r($v) . '<br>';
			if (in_array($v, ['merchant.png']) === FALSE) {
				$file = $path . $v;
				unlink($file);
			}
		}

		$ekspedisi = json_encode(['jne', 'tiki']);

		# INIT TOKO
		##################################################################
		$x = 1;

		for ($i = 0; $i < 3; $i++) {
			$object[$i] = [
				'user_id'   => $x,
				'nama'      => 'Toko Dummy ' . $x,
				'telp'      => '081234567890',
				'alamat'    => 'Jl. Dummy No. ' . $x . ' Rt.' . $x . ' Rw.' . $x,
				'kelurahan' => '3201291003',
				'kecamatan' => '320129',
				'kota'      => '3201',
				'provinsi'  => '32',
				'ekspedisi' => $ekspedisi,
				'kode_pos'  => NULL,
				'desc'      => 'Ini Deskripsi Untuk Toko Dummy ' . $x,
				'gambar'    => 'merchant.png',
				'active'    => TRUE,
				'ban'       => FALSE,
			];
			$x++;
		}

		$exec = $this->mcore->store_batch('toko', $object);
		return $exec;
	}

	public function _init_produk()
	{
		$path = './public/img/produk/';
		$exec = delete_files($path);
		return $exec;
	}

	public function _init_review()
	{
		$path = './public/img/review/';
		$exec = delete_files($path);
		return $exec;
	}
}

/* End of file WelcomeController.php */
/* Location: ./application/controllers/WelcomeController.php */
