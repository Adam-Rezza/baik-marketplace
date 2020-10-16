<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_transaction extends CI_Model
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

    function delete($tabel, $where)
    {
        $this->db->delete($tabel, $where);
        return $this->db->affected_rows();
    }

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
        $this->db->where('b.ban', 0);
        $this->db->where('d.ban', '0');
        $this->db->where('c.urutan', 1);
        $this->db->order_by('a.created_date');
        return $this->db->get();
    }

    function findCartByUserIdAndProductIdAndNotTransactionId($user_id, $produk_id)
    {
        $this->db->select('*');
        $this->db->from('keranjang a');
        $this->db->where('a.user_id', $user_id);
        $this->db->where('a.produk_id', $produk_id);
        $this->db->where('a.transaksi_id is null');
        $this->db->order_by('a.created_date', 'asc');
        return $this->db->get();
    }

    function findCartByUserIdAndCartIdAndNotTransactionId($user_id, $id)
    {
        $this->db->select('*');
        $this->db->from('keranjang a');
        $this->db->where('a.user_id', $user_id);
        $this->db->where('a.id', $id);
        $this->db->where('a.transaksi_id is null');
        $this->db->order_by('a.created_date', 'asc');
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

    function updateKeranjangByUserIdAndMerchantId($transaksi_id, $user_id, $toko_id)
    {
        // $this->db->where('toko_id', $$toko_id);
        // $this->db->where('user_id', $user_id);
        // $this->db->where('transaksi_id is null');
        // $this->db->update('keranjang', $data);
        $this->db->query('UPDATE `keranjang` as `a` '.
                            'JOIN `produk` as `b` on `a`.`produk_id` = `b`.`id` '.
                            'JOIN `toko` as `c` on `b`.`toko_id` = `c`.`id` '.
                            'SET `transaksi_id` = '.$transaksi_id.' '.
                            'WHERE `b`.`toko_id` = '.$toko_id.' '.
                                'AND `a`.`user_id` = '.$user_id.' '.
                                'AND `a`.`transaksi_id` is null '.
                                'AND `b`.`del` = 0 '.
                                'AND `b`.`ban` = 0 '.
                                'AND `c`.`ban` = 0 ');
        return $this->db->affected_rows();
    }

    function findMerchantOwnerCartByUserIdGroupByMerchantId($user_id)
    {
        $this->db->select('c.*');
        $this->db->from('keranjang a');
        $this->db->join('produk b','a.produk_id = b.id');
        $this->db->join('toko c','b.toko_id = c.id');
        $this->db->where('a.transaksi_id is null');
        $this->db->where('b.del', 0);
        $this->db->where('b.ban', 0);
        $this->db->where('c.ban', 0);
        $this->db->group_by('c.id');
        return $this->db->get();
    }

    function findProductByUserIdAndTransactionId($user_id, $tansaksi_id)
    {
        $this->db->select('a.*, b.harga, b.qty, c.nama as produk, c.id as produk_id, c.terjual');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b','a.id = b.transaksi_id');
        $this->db->join('produk c','b.produk_id = c.id');
        $this->db->where('a.id', $tansaksi_id);
        $this->db->where('a.user_id', $user_id);
        $this->db->order_by('a.created_date','DESC');
        return $this->db->get();
    }



}

/* End of file M_core.php */
/* Location: ./application/models/M_core.php */
