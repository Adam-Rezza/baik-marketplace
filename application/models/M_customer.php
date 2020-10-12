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

    function update($table, $data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function getQna($where = NULL, $orderBy = NULL, $orderOrien = 'ASC')
    {
        $this->db->select('a.*');
        $this->db->select('CASE WHEN a.toko_id != 0 THEN c.nama ELSE b.nama END AS nama', false);
        $this->db->from('qna a');
        $this->db->join('user b', 'a.user_id = b.id');
        $this->db->join('toko c', 'a.toko_id = c.id', 'left');
        $this->db->where($where);
        $this->db->order_by($orderBy, $orderOrien);
        return $this->db->get();
    }

    public function getReview($where = NULL, $orderBy = NULL, $orderOrien = 'ASC')
    {
        $this->db->select('a.*, b.nama as user');
        $this->db->from('review a');
        $this->db->join('user b', 'a.user_id = b.id');
        $this->db->where($where);
        $this->db->order_by($orderBy, $orderOrien);
        return $this->db->get();
    }

    // Produk 

    function findSponsoredProduct($limit = 14, $offset = 0)
    {
        $this->db->select('a.*, b.gambar, c.nama as toko');
        $this->db->from('produk a');
        $this->db->join('gambar_produk b', 'a.id = b.produk_id', 'left');
        $this->db->join('toko c', 'a.toko_id = c.id');
        $this->db->where('a.disc >', '0');
        $this->db->where('b.urutan', '1');
        // $this->db->where('sponsored_date >=', date('Y-m-d'));
        $this->db->where('a.del', '0');
        $this->db->where('a.ban', '0');
        $this->db->where('c.ban', '0');
        $this->db->order_by('CASE WHEN a.terjual > 0 THEN a.disc else 0 END', 'desc', false);
        $this->db->order_by('CASE WHEN a.terjual > 0 THEN a.rating else 0 END', 'desc', false);
        $this->db->order_by('CASE WHEN a.modified_date is not null THEN a.modified_date else a.created_date END', 'desc', false);
        $this->db->limit($limit, $offset);
        return $this->db->get();
    }

    function findLatestProduct($limit = 12, $offset = 0)
    {
        $this->db->select('a.*, b.gambar, c.nama as toko');
        $this->db->from('produk a');
        $this->db->join('gambar_produk b', 'a.id = b.produk_id', 'left');
        $this->db->join('toko c', 'a.toko_id = c.id');
        $this->db->where('b.urutan', '1');
        $this->db->where('a.del', '0');
        $this->db->where('a.ban', '0');
        $this->db->where('c.ban', '0');
        $this->db->order_by('created_date', 'desc');
        $this->db->limit($limit, $offset);
        return $this->db->get();
    }

    function findProductByCategory($category, $sub_category, $limit, $offset)
    {
        $this->db->select('a.*, b.gambar, c.nama as toko');
        $this->db->from('produk a');
        $this->db->join('gambar_produk b', 'a.id = b.produk_id', 'left');
        $this->db->join('toko c', 'a.toko_id = c.id');
        $this->db->where('a.kategori_id', $category);
        if ($sub_category) {
            $this->db->where('a.sub_kategori_id', $sub_category);
        }
        $this->db->where('b.urutan', '1');
        $this->db->where('a.del', '0');
        $this->db->where('a.ban', '0');
        $this->db->where('c.ban', '0');
        $this->db->order_by('a.rating', 'desc');
        $this->db->order_by('a.created_date', 'desc');
        $this->db->limit($limit, $offset);
        return $this->db->get();
    }

    function findProductByKeyAndCategoryAndSubCategory($keyword, $category, $sub_category, $limit, $offset)
    {
        $this->db->select('a.*, b.gambar, c.nama as toko');
        $this->db->from('produk a');
        $this->db->join('gambar_produk b', 'a.id = b.produk_id', 'left');
        $this->db->join('toko c', 'a.toko_id = c.id');
        $this->db->where('a.nama like', '%' . $keyword . '%');
        if ($category) {
            $this->db->where('a.kategori_id', $category);
        }
        if ($sub_category) {
            $this->db->where('a.sub_kategori_id', $sub_category);
        }
        $this->db->where('b.urutan', '1');
        $this->db->where('a.del', '0');
        $this->db->where('a.ban', '0');
        $this->db->where('c.ban', '0');
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
        $this->db->join('produk b', 'a.produk_id = b.id');
        $this->db->join('gambar_produk c', 'b.id = c.produk_id');
        $this->db->join('toko d', 'd.id = b.toko_id');
        $this->db->where('a.user_id', $user_id);
        $this->db->where('a.transaksi_id is null');
        $this->db->where('b.del', 0);
        $this->db->where('b.ban', 0);
        $this->db->where('c.urutan', 1);
        return $this->db->get();
    }

    function findAddressByUserId($user_id)
    {
        $this->db->select('a.*, b.nama as prov, c.nama as kab, d.nama as kec, e.nama as kel');
        $this->db->from('alamat a');
        $this->db->join('provinsi b', 'a.provinsi = b.id_prov');
        $this->db->join('kabupaten c', 'a.kota = c.id_kab');
        $this->db->join('kecamatan d', 'a.kecamatan = d.id_kec');
        $this->db->join('kelurahan e', 'a.kelurahan = e.id_kel');
        $this->db->where('a.user_id', $user_id);
        return $this->db->get();
    }

    function findTransactionByMerchantIdAndStatusGroupByTransaction($user_id)
    {
        $this->db->select('a.*, b.harga, b.qty, c.id as produk_id, c.nama as produk, d.nama as toko');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b', 'a.id = b.transaksi_id');
        $this->db->join('produk c', 'b.produk_id = c.id');
        $this->db->join('toko d', 'a.toko_id = d.id');
        $this->db->where('a.status !=', 9);
        $this->db->where('a.status !=', 10);
        $this->db->where('b.user_id', $user_id);
        $this->db->order_by('a.created_date', 'DESC');
        $this->db->group_by('a.id');
        return $this->db->get();
    }

    function findTransactionByMerchantIdAndStatusAndTransactionId($user_id, $transaction_id)
    {
        $this->db->select('a.*, b.harga, b.qty, c.id as produk_id, c.nama as produk, d.nama as toko');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b', 'a.id = b.transaksi_id');
        $this->db->join('produk c', 'b.produk_id = c.id');
        $this->db->join('toko d', 'a.toko_id = d.id');
        $this->db->where('a.id', $transaction_id);
        $this->db->where('a.status !=', 9);
        $this->db->where('a.status !=', 10);
        $this->db->where('b.user_id', $user_id);
        $this->db->order_by('a.created_date', 'DESC');
        return $this->db->get();
    }

    function findCompleteTransactionByMerchantIdAndStatusGroupByTransaction($user_id)
    {
        $this->db->select('a.*, b.harga, b.qty, c.id as produk_id, c.nama as produk, d.nama as toko');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b', 'a.id = b.transaksi_id');
        $this->db->join('produk c', 'b.produk_id = c.id');
        $this->db->join('toko d', 'a.toko_id = d.id');
        $this->db->group_start();
        $this->db->where('a.status', 9);
        $this->db->or_where('a.status', 10);
        $this->db->group_end();
        $this->db->where('b.user_id', $user_id);
        $this->db->order_by('a.created_date', 'DESC');
        $this->db->group_by('a.id');
        return $this->db->get();
    }

    function findCompleteTransactionByMerchantIdAndStatusAndTransactionId($user_id, $transaction_id)
    {
        $this->db->select('a.*, b.harga, b.qty, c.nama as produk, d.nama as toko');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b', 'a.id = b.transaksi_id');
        $this->db->join('produk c', 'b.produk_id = c.id');
        $this->db->join('toko d', 'a.toko_id = d.id');
        $this->db->where('a.id', $transaction_id);
        $this->db->group_start();
        $this->db->where('a.status', 9);
        $this->db->or_where('a.status', 10);
        $this->db->group_end();
        $this->db->where('b.user_id', $user_id);
        $this->db->order_by('a.created_date', 'DESC');
        return $this->db->get();
    }

    function findLatestCompleteTransactionByUserIdAndProductIdLastWeek($user_id, $product_id)
    {
        $this->db->select('a.*, b.harga, b.qty, c.nama as produk, d.nama as toko');
        $this->db->from('transaksi a');
        $this->db->join('keranjang b', 'a.id = b.transaksi_id');
        $this->db->join('produk c', 'b.produk_id = c.id');
        $this->db->join('toko d', 'a.toko_id = d.id');
        $this->db->where('c.id', $product_id);
        $this->db->group_start();
        $this->db->where('a.status', 9);
        $this->db->group_end();
        $this->db->where('b.user_id', $user_id);
        $this->db->where('a.delivery_date > CURDATE() - INTERVAL 7 DAY');
        $this->db->order_by('a.created_date', 'DESC');
        $this->db->limit(1, 0);
        return $this->db->get();
    }

    /**
     * APM
     * 2020-10-12
     */
    public function getProdukComplete($where = NULL)
    {
        $this->db->select([
            'produk.id',
            'produk.toko_id',
            'produk.kategori_id',
            'produk.sub_kategori_id',
            'produk.nama',
            'produk.`desc`',
            'produk.harga_asli',
            'produk.harga_disc',
            'produk.disc',
            'produk.terjual',
            'produk.rating',
            'produk.rating_count',
            'produk.del',
            'produk.ban',
            'produk.created_date',
            'produk.modified_date',
            'toko.nama as nama_toko',
            'kategori.nama as nama_kategori',
            'sub_kategori.nama as nama_sub_kategori'
        ]);
        $this->db->join('toko', 'toko.id = produk.toko_id', 'left');
        $this->db->join('kategori', 'kategori.id = produk.kategori_id', 'left');
        $this->db->join('sub_kategori', 'sub_kategori.id = produk.sub_kategori_id', 'left');

        if ($where != NULL) {
            $this->db->where($where);
        }

        return $this->db->get('produk');
    }

    public function getEkspedisiTokoByKeranjangUser($user_id)
    {
        $this->db->select('
        produk.toko_id,
        toko.nama as nama_toko,
        toko.ekspedisi
        ');
        $this->db->join('produk', 'produk.id = keranjang.produk_id', 'left');
        $this->db->join('toko', 'toko.id = produk.toko_id', 'left');
        $this->db->where('keranjang.user_id', $user_id);
        $this->db->where('keranjang.transaksi_id IS NULL');
        return $this->db->get('keranjang');
    }
}

/* End of file M_core.php */
/* Location: ./application/models/M_core.php */
