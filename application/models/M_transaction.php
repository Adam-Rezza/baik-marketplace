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

    function updateKeranjangByUserId($data, $user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('transaksi_id is null');
        $this->db->update('keranjang', $data);
        return $this->db->affected_rows();
    }







    

    function findAllBanner()
    {
        $this->db->select('*');
        $this->db->from('banner');
        $this->db->where('active', '1');
        $this->db->where('del', '0');
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

    function findProductByCategory($category, $sub_category)
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
        $this->db->limit('20', '0');
        return $this->db->get();
    }

    function findProductByKey($keyword, $category, $sub_category)
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
        $this->db->limit('20', '0');
        return $this->db->get();
    }

    function findCategoryById($id)
    {
        $this->db->select('*');
        $this->db->from('kategori');
        $this->db->where('id', $id);
        $this->db->where('active', '1');
        $this->db->where('del', '0');
        return $this->db->get();
    }

    function findSubCategoryById($id)
    {
        $this->db->select('*');
        $this->db->from('sub_kategori');
        $this->db->where('id', $id);
        $this->db->where('active', '1');
        $this->db->where('del', '0');
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

    function findProductPicturesByProductId($idProduct)
    {
        $this->db->select('*');
        $this->db->from('gambar_produk a');
        $this->db->where('a.produk_id', $idProduct);
        $this->db->where('a.del', '0');
        $this->db->order_by('a.urutan', 'asc');
        return $this->db->get();
    }
}

/* End of file M_core.php */
/* Location: ./application/models/M_core.php */
