<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ProdukController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('TemplateAdmin', NULL, 'template');
		$this->load->model('M_produk_less', 'mless');
	}

	public function index()
	{
		$data['title']    = 'Produk Management';
		$data['content']  = 'produk/index';
		$data['vitamin']  = 'produk/index_vitamin';

		$this->template->template($data);
	}

	public function show()
	{
		$id = $this->input->get('id');
		$exec = $this->mcore->get('banner', '*', ['id' => $id, 'del' => NULL]);

		if ($exec->num_rows() == 0) {
			echo json_encode([
				'code' => '404',
				'msg' => 'Data tidak ditemukan'
			]);
			exit;
		}

		echo json_encode([
			'code'   => 200,
			'id'     => $id,
			'gambar' => base_url() . 'public/img/banner/' . $exec->row()->gambar,
			'url'    => $exec->row()->url,
			'active' => $exec->row()->active,
		]);
	}

	public function store()
	{
		$cur_date = new DateTime('now');
		$url      = $this->input->post('url');
		$active   = $this->input->post('active');

		if (in_array($url, ['', NULL])) {
			$url = "#";
		}

		$config['upload_path']      = './public/img/banner/';
		$config['allowed_types']    = 'gif|jpg|png';
		$config['overwrite']        = TRUE;
		$config['file_ext_tolower'] = TRUE;
		$config['encrypt_name']     = TRUE;


		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('gambar')) {
			$ret = ['code' => 500, 'msg' => $this->upload->display_errors()];
		} else {
			$gambar_name = $this->upload->data('file_name');
			$last_urutan = $this->mcore->get('banner', 'urutan', ['del' => NULL, 'active' => '1'], 'urutan', 'DESC');

			if ($last_urutan->num_rows() == 0) {
				$last_urutan = 1;
			} else {
				$last_urutan = $last_urutan->row()->urutan + 1;
			}
			$data = [
				'gambar' => $gambar_name,
				'url'    => $url,
				'urutan' => $last_urutan,
				'active' => $active,
				'del'    => NULL,
			];

			$exec = $this->mcore->store('banner', $data);

			if (!$exec) {
				$ret = ['code' => 500, 'msg' => 'Proses tambah banner gagal, silahkan coba kembali'];
			} else {
				$ret = ['code' => 200, 'msg' => 'Proses tambah banner berhasil'];
			}
		}

		echo json_encode($ret);
	}

	public function update()
	{
		$id     = $this->input->post('id_edit');
		$url    = $this->input->post('url_edit');
		$active = $this->input->post('active_edit');

		$check = $this->mcore->count('banner', ['id' => $id]);

		if ($check == 0) {
			echo json_encode([
				'code' => 404,
				'msg' => 'Data Banner Tidak ditemukan, proses update dibatalkan',
			]);
			exit;
		}

		if (in_array($url, ['', NULL])) {
			$url = "#";
		}

		$config['upload_path']      = './public/img/banner/';
		$config['allowed_types']    = 'gif|jpg|png';
		$config['overwrite']        = TRUE;
		$config['file_ext_tolower'] = TRUE;
		$config['encrypt_name']     = TRUE;


		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('gambar_edit')) {
			$ret = ['code' => 500, 'msg' => $this->upload->display_errors()];
		} else {
			$gambar_name = $this->upload->data('file_name');
			$data = [
				'gambar' => $gambar_name,
				'url'    => $url,
				'active' => $active,
			];

			$exec = $this->mcore->update('banner', $data, ['id' => $id]);

			if (!$exec) {
				$ret = ['code' => 500, 'msg' => 'Proses update banner gagal, silahkan coba kembali'];
			} else {
				$ret = ['code' => 200, 'msg' => 'Proses update banner berhasil'];
			}
		}

		echo json_encode($ret);
	}

	public function destroy()
	{
		$id = $this->input->post('id');

		$object = ['del' => '1'];
		$where  = ['id' => $id];
		$exec   = $this->mcore->update('banner', $object, $where);

		if ($exec) {
			$ret = ['code' => 200, 'msg' => 'Hapus Banner Berhasil'];
		} else {
			$ret = ['code' => 500, 'msg' => 'Hapus Banner Gagal'];
		}

		echo json_encode($ret);
	}

	public function datatables()
	{
		$list = $this->mless->get_datatables();
		$data = array();
		$no   = $_POST['start'];
		$total_data = $this->mless->count_filtered();
		foreach ($list as $field) {
			$no++;
			$row             = array();

			$row['no']            = $no;
			$row['id']            = $field->id;
			$row['toko_id']       = $field->toko_id;
			$row['nama_toko']     = $field->nama_toko;
			$row['kategori_id']   = $field->kategori_id;
			$row['nama_kategori'] = $field->nama_kategori;
			$row['nama']          = $field->nama;
			$row['desc']          = $field->desc;
			$row['harga_asli']    = $field->harga_asli;
			$row['harga_disc']    = $field->harga_disc;
			$row['terjual']       = $field->terjual;
			$row['rating']        = $field->rating;
			$row['ban']           = $field->ban;

			$delete = '<button class="btn btn-danger btn-xs" onclick="deleteData(\'' . $field->id . '\');"><i class="fa fa-trash fa-fw"></i> Delete</button>';
			$edit = '<button class="btn btn-info btn-xs" onclick="editData(\'' . $field->id . '\');"><i class="fa fa-pencil fa-fw"></i> Edit</button>';

			$row['actions'] = '
			<div class="text-center">
				<div class="btn-group">
				' . $delete . '
				</div>
			</div>
			';

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
        
    /* End of file  BannerController.php */
