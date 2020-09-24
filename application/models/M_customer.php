<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_customer extends CI_Model
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

	function insert($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
        
    }

	function update($table, $data, $id){
        $this->db->where('id', $id);        
        $this->db->update($table, $data);
        return $this->db->affected_rows();
        
    }

    // Produk 

    function findSponsoredProductFirst()
    {
        $this->db->select('a.*, b.gambar');
        $this->db->from('produk a');
        $this->db->join('gambar_produk b', 'a.id = b.produk_id', 'left');
        $this->db->where('b.urutan', '1');
        // $this->db->where('sponsored_date >=', date('Y-m-d'));
        $this->db->where('a.del', '0');
        $this->db->limit('12', '0');
        return $this->db->get();
    }

    function findLatestProductFirst()
    {
        $this->db->select('a.*, b.gambar');
        $this->db->from('produk a');
        $this->db->join('gambar_produk b', 'a.id = b.produk_id', 'left');
        $this->db->where('b.urutan', '1');
        $this->db->where('a.del', '0');
        $this->db->order_by('created_date', 'desc');
        $this->db->limit('12', '0');
        return $this->db->get();
    }

    function findProductByCategory($category, $sub_category, $limit, $offset)
    {
        $this->db->select('a.*, b.gambar');
        $this->db->from('produk a');
        $this->db->join('gambar_produk b', 'a.id = b.produk_id', 'left');
        $this->db->where('a.kategori_id', $category);
        if ($sub_category) {
            $this->db->where('a.sub_kategori_id', $sub_category);
        }
        $this->db->where('b.urutan', '1');
        $this->db->where('a.del', '0');
        $this->db->order_by('a.rating', 'desc');
        $this->db->order_by('a.created_date', 'desc');
        $this->db->limit($limit, $offset);
        return $this->db->get();
    }

    function findProductByKeyAndCategoryAndSubCategory($keyword, $category, $sub_category, $limit, $offset)
    {
        $this->db->select('a.*, b.gambar');
        $this->db->from('produk a');
        $this->db->join('gambar_produk b', 'a.id = b.produk_id', 'left');
        $this->db->where('a.nama like', '%' . $keyword . '%');
        if ($category) {
            $this->db->where('a.kategori_id', $category);
        }
        if ($sub_category) {
            $this->db->where('a.sub_kategori_id', $sub_category);
        }
        $this->db->where('b.urutan', '1');
        $this->db->where('a.del', '0');
        $this->db->order_by('a.rating', 'desc');
        $this->db->order_by('a.created_date', 'desc');
        $this->db->limit($limit, $offset);
        return $this->db->get();
    }

    // Customer registered

    function findCartByUserIdAndNotTransactionId($user_id)
    {
        $this->db->select('a.*, b.nama as produk, b.harga_disc as harga, b.rating, c.gambar, d.nama as toko');
        $this->db->from('keranjang a');
        $this->db->join('produk b','a.produk_id = b.id');
        $this->db->join('gambar_produk c','b.id = c.produk_id');
        $this->db->join('toko d','d.id = b.toko_id');
        $this->db->where('a.user_id', $user_id);
        $this->db->where('a.transaksi_id is null');
        $this->db->where('b.del', 0);
        $this->db->where('c.urutan', 1);
        return $this->db->get();
    }

    function findAddressByUserId($user_id)
    {
        $this->db->select('a.*, b.nama as prov, c.nama as kab, d.nama as kec, e.nama as kel');
        $this->db->from('alamat a');
        $this->db->join('provinsi b','a.provinsi = b.id_prov');
        $this->db->join('kabupaten c','a.kota = c.id_kab');
        $this->db->join('kecamatan d','a.kecamatan = d.id_kec');
        $this->db->join('kelurahan e','a.kelurahan = e.id_kel');
        $this->db->where('a.user_id', $user_id);
        return $this->db->get();
    }

    function findOrderByMerchantIdAndStatusGroupByTransaction($user_id)
    {
        $this->db->select('a.*, b.harga, b.qty, c.nama as produk');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b','a.id = b.transaksi_id');
        $this->db->join('produk c','b.produk_id = c.id');
        $this->db->where('a.status !=', 9);
        $this->db->where('b.user_id', $user_id);
        $this->db->order_by('a.created_date','DESC');
        $this->db->group_by('a.id');
        return $this->db->get();
    }

    function findOrderByMerchantIdAndStatusAndTransactionId($user_id, $tansaksi_id)
    {
        $this->db->select('a.*, b.harga, b.qty, c.nama as produk');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b','a.id = b.transaksi_id');
        $this->db->join('produk c','b.produk_id = c.id');
        $this->db->where('a.id', $tansaksi_id);
        $this->db->where('a.status !=', 9);
        $this->db->where('b.user_id', $user_id);
        $this->db->order_by('a.created_date','DESC');
        return $this->db->get();
    }

    function findCompleteOrderByMerchantIdAndStatusGroupByTransaction($user_id)
    {
        $this->db->select('a.*, b.harga, b.qty, c.nama as produk');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b','a.id = b.transaksi_id');
        $this->db->join('produk c','b.produk_id = c.id');
        $this->db->where('a.status', 9);
        $this->db->where('b.user_id', $user_id);
        $this->db->order_by('a.created_date','DESC');
        $this->db->group_by('a.id');
        return $this->db->get();
    }

    function findCompleteOrderByMerchantIdAndStatusAndTransactionId($user_id, $tansaksi_id)
    {
        $this->db->select('a.*, b.harga, b.qty, c.nama as produk');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b','a.id = b.transaksi_id');
        $this->db->join('produk c','b.produk_id = c.id');
        $this->db->where('a.id', $tansaksi_id);
        $this->db->where('a.status', 9);
        $this->db->where('b.user_id', $user_id);
        $this->db->order_by('a.created_date','DESC');
        return $this->db->get();
    }
}

/* End of file M_core.php */
/* Location: ./application/models/M_core.php */
