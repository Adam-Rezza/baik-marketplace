<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WelcomeController extends CI_Controller
{

	public function index()
	{
		$truncate = $this->_truncate();
		if ($truncate) {
			echo "Truncate Berhasil <br />";
		} else {
			echo "Truncate Berhasil <br />";
		}

		$init_admin = $this->_init_admin();
		if ($init_admin) {
			echo "Init Admin Berhasil <br />";
		} else {
			echo "Init Admin Berhasil <br />";
		}

		$init_user = $this->_init_user();
		if ($init_user) {
			echo "Init User Berhasil <br />";
		} else {
			echo "Init User Berhasil <br />";
		}

		$init_banner = $this->_init_banner();
		if ($init_banner) {
			echo "Init Banner Berhasil <br />";
		} else {
			echo "Init Banner Berhasil <br />";
		}

		$init_ekspedisi = $this->_init_ekspedisi();
		if ($init_ekspedisi) {
			echo "Init Ekspedisi Berhasil <br />";
		} else {
			echo "Init Ekspedisi Berhasil <br />";
		}

		$init_kategori = $this->_init_kategori();
		if ($init_kategori) {
			echo "Init Kategori Berhasil <br />";
		} else {
			echo "Init Kategori Berhasil <br />";
		}

		$init_sub_kategori = $this->_init_sub_kategori();
		if ($init_sub_kategori) {
			echo "Init Sub Kategori Berhasil <br />";
		} else {
			echo "Init Sub Kategori Berhasil <br />";
		}
	}

	public function _truncate()
	{
		$exec = $this->db->truncate('admins');
		$exec = $this->db->truncate('user');
		$exec = $this->db->truncate('alamat');
		$exec = $this->db->truncate('banner');
		$exec = $this->db->truncate('ekspedisi');
		$exec = $this->db->truncate('gambar_produk');
		$exec = $this->db->truncate('kategori');
		$exec = $this->db->truncate('keranjang');
		$exec = $this->db->truncate('notifikasi');
		$exec = $this->db->truncate('notifikasi');
		$exec = $this->db->truncate('produk');
		$exec = $this->db->truncate('qna');
		$exec = $this->db->truncate('review');
		$exec = $this->db->truncate('sub_kategori');
		$exec = $this->db->truncate('toko');
		$exec = $this->db->truncate('transaksi');
	}

	public function _init_admin()
	{
		$now      = new DateTime();
		$password = password_hash('admin123)' . UYAH, PASSWORD_DEFAULT);

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
		$now      = new DateTime();
		$password = password_hash('user123)' . UYAH, PASSWORD_DEFAULT);

		# INIT USER
		##################################################################
		$object = [
			'id'       => '0',
			'nama'     => 'BAIK',
			'email'    => 'koperasi.baik@gmail.com',
			'telp'     => '02518311342',
			'gambar'   => 'baik_logo.png',
			'username' => 'baik',
			'password' => $password,
			'active'   => TRUE,
			'ban'      => FALSE,
			'saldo'    => '0',
		];

		$exec = $this->mcore->store('user', $object);

		$object = [
			'id'        => '0',
			'user_id'   => '0',
			'alamat'    => 'Komplek Pertanian, Jl. Siaga Kecamatan No.25, RT.02/RW.10, Loji, Kec. Bogor Bar., Kota Bogor, Jawa Barat 16117',
			'kelurahan' => '3271041016',
			'kecamatan' => '327104',
			'kota'      => '3271',
			'provinsi'  => '32',
			'kodepos'   => '16117',
			'def'       => TRUE,
			'del'       => FALSE,
		];

		$exec = $this->mcore->store('alamat', $object);
		##################################################################
		##################################################################
		$object = [
			'nama'     => 'TEST 1',
			'email'    => 'test1@example.com',
			'telp'     => '081234567890',
			'gambar'   => 'user-o.png',
			'username' => 'test1',
			'password' => $password,
			'active'   => TRUE,
			'ban'      => FALSE,
			'saldo'    => '1000000',
		];

		$exec = $this->mcore->store('user', $object);

		$object = [
			'user_id'   => $exec->id,
			'alamat'    => 'Komplek Pertanian, Jl. Siaga Kecamatan No.25, RT.02/RW.10, Loji, Kec. Bogor Bar., Kota Bogor, Jawa Barat 16117',
			'kelurahan' => '3271041016',
			'kecamatan' => '327104',
			'kota'      => '3271',
			'provinsi'  => '32',
			'kodepos'   => '16117',
			'def'       => TRUE,
			'del'       => FALSE,
		];

		$exec = $this->mcore->store('alamat', $object);
		##################################################################
		##################################################################
		$object = [
			'nama'     => 'TEST 2',
			'email'    => 'test2@example.com',
			'telp'     => '081234567890',
			'gambar'   => 'user-o.png',
			'username' => 'test2',
			'password' => $password,
			'active'   => TRUE,
			'ban'      => FALSE,
			'saldo'    => '1000000',
		];

		$exec = $this->mcore->store('user', $object);

		$object = [
			'user_id'   => $exec->id,
			'alamat'    => 'Komplek Pertanian, Jl. Siaga Kecamatan No.25, RT.02/RW.10, Loji, Kec. Bogor Bar., Kota Bogor, Jawa Barat 16117',
			'kelurahan' => '3271041016',
			'kecamatan' => '327104',
			'kota'      => '3271',
			'provinsi'  => '32',
			'kodepos'   => '16117',
			'def'       => TRUE,
			'del'       => FALSE,
		];

		$exec = $this->mcore->store('alamat', $object);
		##################################################################
		##################################################################
		$object = [
			'nama'     => 'TEST 3',
			'email'    => 'test3@example.com',
			'telp'     => '081234567890',
			'gambar'   => 'user-o.png',
			'username' => 'test3',
			'password' => $password,
			'active'   => TRUE,
			'ban'      => FALSE,
			'saldo'    => '1000000',
		];

		$exec = $this->mcore->store('user', $object);
		$object = [
			'user_id'   => $exec->id,
			'alamat'    => 'Komplek Pertanian, Jl. Siaga Kecamatan No.25, RT.02/RW.10, Loji, Kec. Bogor Bar., Kota Bogor, Jawa Barat 16117',
			'kelurahan' => '3271041016',
			'kecamatan' => '327104',
			'kota'      => '3271',
			'provinsi'  => '32',
			'kodepos'   => '16117',
			'def'       => TRUE,
			'del'       => FALSE,
		];

		$exec = $this->mcore->store('alamat', $object);
		##################################################################

		if ($exec === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _init_banner()
	{
		# INIT
		##################################################################
		$object = [
			'gambar' => 'banner_1.jpg',
			'url'    => '#',
			'urutan' => '1',
			'active' => TRUE,
			'del'    => FALSE
		];

		$exec = $this->mcore->store('banner', $object);
		##################################################################
		##################################################################
		$object = [
			'gambar' => 'banner_2.jpg',
			'url'    => '#',
			'urutan' => '2',
			'active' => TRUE,
			'del'    => FALSE
		];

		$exec = $this->mcore->store('banner', $object);
		##################################################################
		##################################################################
		$object = [
			'gambar' => 'banner_3.jpg',
			'url'    => '#',
			'urutan' => '3',
			'active' => TRUE,
			'del'    => FALSE
		];

		$exec = $this->mcore->store('banner', $object);
		##################################################################

		if ($exec === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _init_ekspedisi()
	{
		$object = [];
		# INIT
		##################################################################
		$nested = [
			'id'   => 'pos',
			'nama' => 'POS Indonesia (POS)',
		];
		array_push($object, $nested);

		$nested = [
			'id'   => 'lion',
			'nama' => 'Lion Parcel (LION)',
		];
		array_push($object, $nested);

		$nested = [
			'id'   => 'ninja',
			'nama' => 'Ninja Xpress (NINJA)',
		];
		array_push($object, $nested);

		$nested = [
			'id'   => 'sicepat',
			'nama' => 'SiCepat Express (SICEPAT)',
		];
		array_push($object, $nested);

		$nested = [
			'id'   => 'jne',
			'nama' => 'Jalur Nugraha Ekakurir (JNE)',
		];
		array_push($object, $nested);

		$nested = [
			'id'   => 'tiki',
			'nama' => 'Citra Van Titipan Kilat (TIKI)',
		];
		array_push($object, $nested);

		$nested = [
			'id'   => 'pandu',
			'nama' => 'Pandu Logistics (PANDU)',
		];
		array_push($object, $nested);

		$nested = [
			'id'   => 'wahana',
			'nama' => 'Wahana Prestasi Logistik (WAHANA)',
		];
		array_push($object, $nested);

		$nested = [
			'id'   => 'j&t',
			'nama' => 'J&T Express (J&T)',
		];
		array_push($object, $nested);

		$nested = [
			'id'   => 'pahala',
			'nama' => 'Pahala Kencana Express (PAHALA)',
		];
		array_push($object, $nested);

		$exec = $this->mcore->store_batch('ekspedisi', $object);
		##################################################################

		if ($exec === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _init_kategori()
	{
		$object = [];
		# INIT
		##################################################################
		$nested = [
			'nama'         => 'Sembako',
			'urutan'       => '1',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'sembako1.jpg',
		];
		array_push($object, $nested);

		$nested = [
			'nama'         => 'Sayur Dan Buah',
			'urutan'       => '2',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'buah_dan_sayur1.jpg',
		];
		array_push($object, $nested);

		$nested = [
			'nama'         => 'Makanan Dan Kue',
			'urutan'       => '3',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'makanan_dan_kue1.jpg',
		];
		array_push($object, $nested);

		$nested = [
			'nama'         => 'Peralatan Rumah Tangga',
			'urutan'       => '4',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'peralatan_rumah_tangga1.jpg',
		];
		array_push($object, $nested);

		$nested = [
			'nama'         => 'Pakaian / Busana',
			'urutan'       => '5',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'pakaian_dan_busana1.jpg',
		];
		array_push($object, $nested);

		$nested = [
			'nama'         => 'Peralatan Sekolah dan Kantor',
			'urutan'       => '6',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'alat_tulis_kantor1.jpg',
		];
		array_push($object, $nested);

		$nested = [
			'nama'         => 'Top Up Dan Tagihan',
			'urutan'       => '7',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
			'gambar'       => 'pob.jpg',
		];
		array_push($object, $nested);

		$exec = $this->mcore->store_batch('kategori', $object);
		##################################################################

		if ($exec === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function _init_sub_kategori()
	{
		$object = [];
		# INIT
		##################################################################
		$object[] = [
			'parent'       => '3',
			'nama'         => 'Olahan',
			'urutan'       => '1',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[] = [
			'parent'       => '3',
			'nama'         => 'Kue Kering',
			'urutan'       => '2',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[] = [
			'parent'       => '4',
			'nama'         => 'Mebel',
			'urutan'       => '1',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[] = [
			'parent'       => '4',
			'nama'         => 'Peralatan',
			'urutan'       => '2',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[] = [
			'parent'       => '4',
			'nama'         => 'Elektronik',
			'urutan'       => '3',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[] = [
			'parent'       => '5',
			'nama'         => 'Busana Pria',
			'urutan'       => '1',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[] = [
			'parent'       => '5',
			'nama'         => 'Busana Wanita',
			'urutan'       => '2',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[] = [
			'parent'       => '5',
			'nama'         => 'Busana Anak-anak',
			'urutan'       => '3',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[] = [
			'parent'       => '7',
			'nama'         => 'Token dan Tagihan Listrik',
			'urutan'       => '1',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$object[] = [
			'parent'       => '7',
			'nama'         => 'Tagihan Air',
			'urutan'       => '2',
			'created_date' => date('Y-m-d H:i:s'),
			'active'       => TRUE,
			'del'          => FALSE,
		];

		$exec = $this->mcore->store_batch('sub_kategori', $object);
		##################################################################

		if ($exec === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

/* End of file WelcomeController.php */
/* Location: ./application/controllers/WelcomeController.php */
