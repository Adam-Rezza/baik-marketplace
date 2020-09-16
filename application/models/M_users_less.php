<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_users_less extends CI_Model
{

	var $table         = 'user';
	var $column_order  = array('user.id', 'user.nama', 'alamat.alamat', 'user.email', 'user.telp', 'user.gambar', 'user.username', 'user.password', 'toko.nama', 'user.ban');
	var $column_search = array('user.nama', 'alamat.alamat', 'user.email', 'user.telp', 'user.username', 'toko.nama', 'user.ban');
	var $order         = array('user.id' => 'asc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		$this->db->select([
			'user.id',
			'user.nama',
			'alamat.alamat',
			'user.email',
			'user.telp',
			'user.gambar',
			'user.username',
			'user.password',
			'toko.nama as nama_toko',
			'user.ban'
		]);
		$this->db->from($this->table);
		$this->db->join('alamat', 'alamat.user_id = user.id', 'left');
		$this->db->join('toko', 'toko.user_id = user.id', 'left');

		$i = 0;

		if ($_POST['search']['value']) {
			$keyword = $_POST['search']['value'];
			if (in_array($keyword, ['aktif', 'Aktif', 'AKTIF']) === TRUE) {
				$keyword = '0';
				$this->db->where('user.ban', $keyword);
			} elseif (in_array($keyword, ['non aktif', 'Non Aktif', 'NON AKTIF']) === TRUE) {
				$keyword = '1';
				$this->db->where('user.ban', $keyword);
			} else {
				foreach ($this->column_search as $item) {
					if ($i === 0) {
						$this->db->group_start();
						$this->db->like($item, $_POST['search']['value']);
					} else {
						$this->db->or_like($item, $_POST['search']['value']);
					}

					if (count($this->column_search) - 1 == $i) {
						$this->db->group_end();
					}
					$i++;
				}
			}
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$this->db->where('user.active', '1');
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function last_query()
	{
		$this->_get_datatables_query();
		$query = $this->db->last_query();
		return $query;
	}

	public function count_all()
	{
		$this->db->from($this->table);
		$this->db->where('user.active', '1');
		return $this->db->count_all_results();
	}
}

/* End of file M_admins_less.php */
