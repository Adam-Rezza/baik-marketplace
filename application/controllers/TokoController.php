<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TokoController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('TemplateAdmin', NULL, 'template');
		$this->load->model('M_toko_less', 'mless');
	}

	public function index()
	{
		$data['title']   = 'Toko Management';
		$data['content'] = 'toko/index';
		$data['vitamin'] = 'toko/index_vitamin';
		$this->template->template($data);
	}

	public function change_status($tipe = null)
	{
		if ($tipe == null) {
			return show_404();
		}

		$id = $this->input->post('id');
		$status = $this->input->post('status');

		if (!$id && !$status) {
			return show_404();
		}

		if ($status == '1') {
			$status = '0';
		} else {
			$status = '1';
		}

		if ($tipe == 'status_toko') {
			$object = ['active' => $status];
		} else {
			$object = ['ban' => $status];
		}

		$where = ['id' => $id];
		$exec = $this->mcore->update(TABLE_TOKO, $object, $where);

		if ($exec) {
			$return['code'] = 200;
		} else {
			$return['code'] = 500;
		}

		$return['sql'] = $this->db->last_query();
		$return['status'] = $status;

		echo json_encode($return);
	}

	public function datatables()
	{
		$list = $this->mless->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$row = array();
			$no++;
			$row['no']     = $no;
			$row['id']     = $field->id;
			$row['nama']   = $field->nama;
			$row['alamat'] = $field->alamat;
			$row['telp']   = $field->telp;
			$row['gambar'] = $field->gambar;
			$row['active'] = $field->active;
			$row['ban']    = $field->ban;

			$data[] = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->mless->count_all(),
			"recordsFiltered" => $this->mless->count_filtered(),
			"data"            => $data,
			"sql"            => $this->db->last_query(),
		);

		echo json_encode($output);
	}

	public function show()
	{
		$id = $this->input->get('id');

		if ($id == NULL) {
			$code = 404;
		}

		$where = [
			'toko_id' => $id,
			'del' => null
		];
		$exec = $this->mcore->get(TABLE_PRODUK, '*', $where, 'id', 'DESC');

		if ($exec) {
			$code = 200;
		}

		$produk = [];
		foreach ($exec->result() as $key) {
			$id           = $key->id;
			$toko_id      = $key->toko_id;
			$kategori_id  = $key->kategori_id;
			$nama_produk  = $key->nama;
			$harga_asli   = $key->harga_asli;
			$harga_disc   = $key->harga_disc;
			$terjual      = $key->terjual;
			$rating       = $key->rating;
			$created_date = $key->created_date;

			$exec_toko = $this->mcore->get(TABLE_TOKO, '*', ['id' => $toko_id]);
			$nama_toko = $exec_toko->row()->nama;

			$exec_kategori      = $this->mcore->get(TABLE_KATEGORI, '*', ['id' => $kategori_id]);
			$parent_id_kategori = $exec_kategori->row()->parent;
			$parent_kategori    = NULL;
			$child_kategori     = $exec_kategori->row()->nama;


			if ($parent_id_kategori != NULL) {
				$exec_parent_kategori = $this->mcore->get(TABLE_KATEGORI, '*', ['id' => $parent_id_kategori]);
				$parent_kategori = $exec_parent_kategori->row()->nama;
			}

			if ($parent_kategori != NULL) {
				$nama_kategori = $parent_kategori . " > " . $child_kategori;
			} else {
				$nama_kategori = $child_kategori;
			}

			$nested = [
				'id'            => $id,
				'toko_id'       => $toko_id,
				'kategori_id'   => $kategori_id,
				'nama_produk'   => $nama_produk,
				'harga_asli'    => number_format($harga_asli, 0),
				'harga_disc'    => number_format($harga_disc, 0),
				'terjual'       => number_format($terjual, 0),
				'rating'        => number_format($rating, 0),
				'created_date'  => $created_date,
				'nama_toko'     => $nama_toko,
				'nama_kategori' => $nama_kategori,
			];

			array_push($produk, $nested);
		}

		echo json_encode([
			'code'       => $code,
			'data'       => $produk,
			'total_data' => $exec->num_rows()
		]);
	}
}
        
    /* End of file  TokoController.php */
