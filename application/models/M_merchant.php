<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_merchant extends CI_Model
{

	public function get($table, $select = '*', $where = NULL, $orderBy = NULL, $orderOrien = 'ASC', $limit = NULL, $offset = NULL, $groupBy = NULL)
	{
		$this->db->select($select);
		if ($where != NULL) {
			$this->db->where($where);
		}

		if($orderBy != NULL){
			$this->db->order_by($orderBy, $orderOrien);
		}

		if($groupBy != NULL){
			$this->db->group_by($groupBy);
		}

		return $this->db->get($table, $limit, $offset);
	}

    function insert($tabel, $data)
    {
        $this->db->insert($tabel, $data);
        return $this->db->insert_id();
    }

    function update($tabel, $data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($tabel, $data);
        return $this->db->affected_rows();
    }

    function findProductByTokoId($toko_id)
    {
        $this->db->select('a.*, b.gambar');
        $this->db->from('produk a');
        $this->db->where('a.toko_id', $toko_id);
        $this->db->join('gambar_produk b', 'a.id = b.produk_id and b.urutan = 1', 'left');
        $this->db->where('a.del', '0');
        $this->db->order_by('case when a.modified_date >  a.created_date then a.modified_date ELSE a.created_date END DESC','', false);
        return $this->db->get();
    }

    function findProductById($id)
    {
        $this->db->select('*');
        $this->db->from('produk a');
        $this->db->where('a.id', $id);
        $this->db->where('a.del', '0');
        return $this->db->get();
    }

    function findAllCategory()
    {
        $this->db->select('*');
        $this->db->from('kategori');
        $this->db->where('active', '1');
        $this->db->where('del', '0');
        return $this->db->get();
    }

    function findSubCategoriByParent($id)
    {
        $this->db->select('*');
        $this->db->from('sub_kategori');
        $this->db->where('parent', $id);
        $this->db->where('active', '1');
        $this->db->where('del', '0');
        return $this->db->get();
    }

    function findImagesByProductId($id)
    {
        $this->db->select('*');
        $this->db->from('gambar_produk');
        $this->db->where('produk_id', $id);
        return $this->db->get();
    }

    function findOrderByMerchantIdAndStatusGroupByTransaction($toko_id, $status)
    {
        $this->db->select('a.*, b.harga, b.qty, c.nama as produk');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b','a.id = b.transaksi_id');
        $this->db->join('produk c','b.produk_id = c.id');
        $this->db->where('a.status', $status);
        $this->db->where('c.toko_id', $toko_id);
        $this->db->order_by('a.created_date','DESC');
        $this->db->group_by('a.id');
        return $this->db->get();
    }

    function findOrderByMerchantIdAndStatusAndTransactionId($toko_id, $status, $tansaksi_id)
    {
        $this->db->select('a.*, b.harga, b.qty, c.nama as produk');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b','a.id = b.transaksi_id');
        $this->db->join('produk c','b.produk_id = c.id');
        $this->db->where('a.id', $tansaksi_id);
        $this->db->where('a.status', $status);
        $this->db->where('c.toko_id', $toko_id);
        $this->db->order_by('a.created_date','DESC');
        return $this->db->get();
    }

}

/* End of file M_core.php */
/* Location: ./application/models/M_core.php */
