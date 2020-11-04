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

        if ($orderBy != NULL) {
            $this->db->order_by($orderBy, $orderOrien);
        }

        if ($groupBy != NULL) {
            $this->db->group_by($groupBy);
        }

        return $this->db->get($table, $limit, $offset);
    }

    function insert($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function insert_batch($table, $data)
    {
        $this->db->insert_batch($table, $data);
        return $this->db->affected_rows();
    }

    function update($table, $data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    function delete($table, $where)
    {
        $this->db->delete($table, $where);
        return $this->db->affected_rows();
    }

    function update_product($table, $data, $id, $merchant_id)
    {
        $this->db->where('id', $id);
        $this->db->where('toko_id', $merchant_id);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    function findProductByMerhanctIdAndProductId($merchant_id, $product_id, $limit = null)
    {
        $this->db->select('a.*, b.urutan');
        $this->db->from('produk a');
        $this->db->join('gambar_produk b', 'a.id = b.produk_id', 'left');
        $this->db->where('a.toko_id', $merchant_id);
        $this->db->where('a.id', $product_id);
        $this->db->order_by('b.urutan', 'desc');
        $this->db->limit($limit);
        return $this->db->get();
    }

    function findMerchantByMerchantId($merchant_id)
    {
        $this->db->select('a.*, b.nama as prov, c.nama as kab, d.nama as kec, e.nama as kel');
        $this->db->from('toko a');
        $this->db->join('provinsi b', 'a.provinsi = b.id_prov', 'left');
        $this->db->join('kabupaten c', 'a.kota = c.id_kab', 'left');
        $this->db->join('kecamatan d', 'a.kecamatan = d.id_kec', 'left');
        $this->db->join('kelurahan e', 'a.kelurahan = e.id_kel', 'left');
        $this->db->where('a.id', $merchant_id);
        return $this->db->get();
    }

    function findProductByMerchantId($merchant_id)
    {
        $this->db->select('a.*, b.gambar');
        $this->db->from('produk a');
        $this->db->where('a.toko_id', $merchant_id);
        $this->db->join('gambar_produk b', 'a.id = b.produk_id and b.urutan = 1', 'left');
        $this->db->where('a.del', '0');
        $this->db->order_by('case when a.modified_date > a.created_date then a.modified_date ELSE a.created_date END DESC', '', false);
        return $this->db->get();
    }

    function findTransactionByMerchantIdAndStatusGroupByTransaction($merchant_id, $status)
    {
        $this->db->select('a.*, sum(b.harga * b.qty) as total_harga');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b', 'a.id = b.transaksi_id');
        $this->db->where('a.status', $status);
        $this->db->where('a.toko_id', $merchant_id);
        $this->db->order_by('a.created_date', 'DESC');
        $this->db->group_by('a.id');
        return $this->db->get();
    }

    function findTransactionByMerchantIdAndStatusAndTransactionId($merchant_id, $status, $tansaksi_id)
    {
        $this->db->select('a.*, b.id as cart_id, b.harga, b.qty, b.variasi_id, c.nama as produk, c.id as produk_id');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b', 'a.id = b.transaksi_id');
        $this->db->join('produk c', 'b.produk_id = c.id');
        $this->db->where('a.id', $tansaksi_id);
        $this->db->where('a.status', $status);
        $this->db->where('c.toko_id', $merchant_id);
        $this->db->order_by('a.created_date', 'DESC');
        return $this->db->get();
    }

    function findTransactionByMerchantIdAndTransactionId($merchant_id, $tansaksi_id)
    {
        $this->db->select('a.*, b.id as cart_id, b.harga, b.qty, b.variasi_id, c.nama as produk, c.id as produk_id');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b', 'a.id = b.transaksi_id');
        $this->db->join('produk c', 'b.produk_id = c.id');
        $this->db->where('a.id', $tansaksi_id);
        $this->db->where('c.toko_id', $merchant_id);
        $this->db->order_by('a.created_date', 'DESC');
        return $this->db->get();
    }
}

/* End of file M_core.php */
/* Location: ./application/models/M_core.php */
