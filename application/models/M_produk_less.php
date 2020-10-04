<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_produk_less extends CI_Model
{

	var $table         = 'produk';
	var $column_order  = array('produk.toko_id', 'produk.nama', 'produk.harga_asli', 'produk.harga_disc', 'produk.terjual', 'produk.rating', 'produk.ban');
	var $column_search = array('toko.nama', 'produk.nama', 'produk.harga_asli', 'produk.harga_disc', 'produk.terjual', 'produk.rating', 'produk.ban');
	var $order         = array('produk.id' => 'desc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->select('
		produk.id,
		produk.toko_id,
		toko.nama as nama_toko,
		produk.kategori_id,
		kategori.nama as nama_kategori,
		produk.sub_kategori_id,
		sub_kategori.nama as nama_sub_kategori,
		produk.nama,
		produk.desc,
		produk.harga_asli,
		produk.harga_disc,
		produk.terjual,
		produk.rating,
		produk.ban 
		');

		$this->db->from($this->table);
		$this->db->join('toko', 'toko.id = produk.toko_id', 'left');
		$this->db->join('kategori', 'kategori.id = produk.kategori_id', 'left');
		$this->db->join('sub_kategori', 'sub_kategori.id = produk.sub_kategori_id', 'left');

		$i = 0;

		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {
				$keyword = $_POST['search']['value'];
				if (in_array($keyword, ['aktif', 'Aktif', 'AKTIF'])) {
					$keyword = 1;
				} elseif (in_array($keyword, ['tidak aktif', 'Tidak Aktif', 'TIDAK AKTIF'])) {
					$keyword = 0;
				}
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $keyword);
				} else {
					$this->db->or_like($item, $keyword);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}

		$this->db->where('produk.del', '0');
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		$this->db->where('produk.del', '0');
		return $this->db->count_all_results();
	}
}

/* End of file M_admins_less.php */
