<?php

defined('BASEPATH') or exit('No direct script access allowed');

class KategoriController extends CI_Controller
{
	private $form_delimiter_open   = '<span class="help-block text-red">';
	private $form_delimiter_close  = "</span>";
	private $msg_kategori_duplikat = "{field} sama ditemukan, silahkan gunakan username lain";

	public function __construct()
	{
		parent::__construct();
		$this->load->library('TemplateAdmin', NULL, 'template');
		$this->load->model('M_kategori_less', 'mless');
	}

	public function index()
	{
		$data['title']    = 'kategori Management';
		$data['content']  = 'kategori/index';
		$data['vitamin']  = 'kategori/index_vitamin';

		$this->template->template($data);
	}

	public function show()
	{
		$id = $this->input->get('id');
		$exec = $this->mcore->get('kategori', '*', ['id' => $id, 'del' => NULL]);

		if ($exec->num_rows() == 0) {
			echo json_encode([
				'code' => '404',
				'msg' => 'Data tidak ditemukan'
			]);
			exit;
		}

		if ($exec->row()->parent != NULL) {
			$data_parent = $this->mcore->get('kategori', '*', ['parent' => $exec->row()->parent]);
			$nama_parent = $data_parent->row()->nama;
		} else {
			$nama_parent = 'No Parent';
		}

		if ($exec->row()->parent != NULL) {
			$parent = $exec->row()->parent;
		} else {
			$parent = 'no';
		}

		echo json_encode([
			'code'        => 200,
			'id'          => $id,
			'nama'        => $exec->row()->nama,
			'active'      => $exec->row()->active,
			'parent'      => $parent,
			'nama_parent' => $nama_parent,
		]);
	}

	public function store()
	{
		$cur_date = new DateTime('now');
		$nama = $this->input->post('nama');
		$parent = $this->input->post('parent');
		$active = $this->input->post('active');

		if ($parent == 'no') {
			$parent = NULL;
		}

		$check = $this->mcore->count('kategori', ['nama' => $nama, 'del' => NULL, 'parent' => $parent]);

		if ($check > 0) {
			echo json_encode([
				'code' => 500,
				'msg' => 'Kategori telah terdaftar, silahkan gunakan nama kategori lain'
			]);
			exit;
		}

		$last_no_urut = $this->mcore->get('kategori', 'urutan', ['del' => NULL, 'parent' => $parent], 'urutan', 'DESC', 1);

		if ($last_no_urut->num_rows() == 0) {
			$last_no_urut = 1;
		} else {
			$last_no_urut = $last_no_urut->row()->urutan + 1;
		}

		$data = [
			'nama'         => $nama,
			'urutan'       => $last_no_urut,
			'created_date' => $cur_date->format('Y-m-d H:i:s'),
			'active'       => $active,
			'del'          => NULL,
			'parent'       => $parent
		];
		$exec = $this->mcore->store('kategori', $data);

		if ($exec) {
			echo json_encode([
				'code' => 200,
				'msg' => 'Proses Tambah Kategori Berhasil'
			]);
			exit;
		} else {
			echo json_encode([
				'code' => 500,
				'msg' => 'Proses Tambah Kategori Gagal, Gagal terhubung dengan Database'
			]);
			exit;
		}
	}

	public function update()
	{
		$id = $this->input->post('id_edit');
		$nama = $this->input->post('nama_edit');
		$parent = $this->input->post('parent_edit');
		$active = $this->input->post('active_edit');

		$check = $this->mcore->count('kategori', ['id' => $id]);

		if ($check == 0) {
			echo json_encode([
				'code' => 404,
				'msg' => 'Data Kategori Tidak ditemukan, proses update dibatalkan',
			]);
			exit;
		}

		if ($parent == 'no') {
			$parent = NULL;
		}

		$data = [
			'nama'   => $nama,
			'parent' => $parent,
			'active' => $active,
		];

		$exec = $this->mcore->update('kategori', $data, ['id' => $id]);

		if ($exec) {
			$ret = [
				'code' => 200,
				'msg' => 'Update Kategori Berhasil',
			];
		} else {
			$ret = [
				'code' => 500,
				'msg' => 'Update Kategori Gagal',
			];
		}

		echo json_encode($ret);
	}

	public function destroy()
	{
		$id = $this->input->post('id');

		$object = ['del' => '1'];
		$where  = ['id' => $id];
		$exec   = $this->mcore->update('kategori', $object, $where);

		if ($exec) {
			$ret = ['code' => 200, 'msg' => 'Hapus Kategori Berhasil'];
		} else {
			$ret = ['code' => 500, 'msg' => 'Hapus Kategori Gagal'];
		}

		echo json_encode($ret);
	}

	public function sub()
	{
		$id = $this->input->get('id');

		$items = $this->mcore->get('kategori', '*', ['parent' => $id, 'del' => NULL], 'urutan', 'ASC');

		if ($items->num_rows() == 0) {
			$ret = ['code' => 404, 'msg' => 'Tidak memiliki Sub Kategori'];
		} else {
			$data = [];
			foreach ($items->result() as $key) {
				if ($key->active == '1') {
					$aktif = "Aktif";
				} else {
					$aktif = "Tidak Aktif";
				}

				$nested = [
					'id'     => $key->id,
					'nama'   => $key->nama,
					'urutan' => $key->urutan,
					'active' => $aktif
				];

				array_push($data, $nested);
			}
			$ret = ['code' => 200, 'items' => $data];
		}

		echo json_encode($ret);
	}

	public function get_parent()
	{
		$data = $this->mcore->get('kategori', '*', ['parent' => NULL, 'del' => NULL]);

		if ($data->num_rows() == 0) {
			$ret = ['code' => 404];
		} else {
			$ret = ['code' => 200, 'data' => $data->result()];
		}
		echo json_encode($ret);
		exit;
	}

	public function datatables()
	{
		$list = $this->mless->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		foreach ($list as $field) {
			$no++;
			$row             = array();

			$row['no']     = $no;
			$row['id']     = $field->id;
			$row['nama']   = $field->nama;
			$row['active'] = $field->active;
			$row['parent'] = $field->parent;

			$data[]          = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->mless->count_all(),
			"recordsFiltered" => $this->mless->count_filtered(),
			"data"            => $data,
		);

		echo json_encode($output);
	}
}
        
    /* End of file  KategoriController.php */
