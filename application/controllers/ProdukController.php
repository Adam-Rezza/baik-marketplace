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
		$id   = $this->input->get('id');
		$exec = $this->mcore->get('gambar_produk', '*', ['produk_id' => $id, 'del' => FALSE], 'urutan', 'ASC');

		if ($exec->num_rows() == 0) {
			echo json_encode([
				'code' => '404',
				'msg' => 'Data tidak ditemukan',
				'lq' => $this->db->last_query()
			]);
			exit;
		}

		$data = [];
		foreach ($exec->result() as $key) {
			$nested['gambar'] = base_url() . 'public/img/produk/' . $key->gambar;
			$nested['actions'] = '<button class="btn btn-danger" onclick="deleteDataGambar(\'' . $key->id . '\', \'' . $id . '\');"><i class="fa fa-trash fa-fw"></i> Delete</button>';
			array_push($data, $nested);
		}


		echo json_encode([
			'code' => 200,
			'id'   => $id,
			'data' => $data,
		]);
	}

	public function destroy()
	{
		$id = $this->input->post('id');

		$object = ['del' => TRUE];
		$where  = ['id' => $id];
		$exec   = $this->mcore->update('produk', $object, $where);

		if ($exec) {
			$ret = ['code' => 200, 'msg' => 'Hapus Produk Berhasil'];
		} else {
			$ret = ['code' => 500, 'msg' => 'Hapus Produk Gagal'];
		}

		echo json_encode($ret);
	}

	public function destroy_gambar()
	{
		$id = $this->input->post('id');

		$object = ['del' => TRUE];
		$where  = ['id' => $id];
		$exec   = $this->mcore->update('gambar_produk', $object, $where);

		if ($exec) {
			$ret = ['code' => 200, 'msg' => 'Hapus Gambar Produk Berhasil'];
		} else {
			$ret = ['code' => 500, 'msg' => 'Hapus Gambar Produk Gagal'];
		}

		echo json_encode($ret);
	}

	public function ban()
	{
		$id = $this->input->post('id');
		$old_ban = $this->input->post('ban');

		$ban = 0;
		$msg = 'Aktifkan produk berhasil';
		if ($old_ban == 0) {
			$ban = 1;
			$msg = 'Non Aktifkan produk berhasil';
		}

		$object = ['ban' => $ban];
		$where  = ['id' => $id];
		$exec   = $this->mcore->update('produk', $object, $where);

		if ($exec) {
			$ret = ['code' => 200, 'msg' => $msg];
		} else {
			$ret = ['code' => 500, 'msg' => 'Update Status Produk Gagal'];
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
			$row['harga_asli_rp'] = 'Rp.' . number_format($field->harga_asli, 0, ',', '.');
			$row['harga_disc']    = $field->harga_disc;
			$row['harga_disc_rp'] = 'Rp.' . number_format($field->harga_disc, 0, ',', '.');
			$row['terjual']       = $field->terjual;
			$row['rating']        = $field->rating;
			$row['ban']           = $field->ban;

			$delete = '<button class="btn btn-danger btn-xs" onclick="deleteData(\'' . $field->id . '\');"><i class="fa fa-trash fa-fw"></i> Delete</button>';

			$icon = 'fa fa-times';
			$text = 'Non Aktifkan';
			$color = 'warning';
			if ($field->ban == '1') {
				$icon = 'fa fa-check';
				$text = 'Aktifkan';
				$color = 'success';
			}
			$ban = '<button class="btn btn-' . $color . ' btn-xs" onclick="banData(\'' . $field->id . '\', ' . $field->ban . ');"><i class="fa ' . $icon . ' fa-fw"></i> ' . $text . '</button>';

			$detail = '<button class="btn btn-info btn-xs" onclick="showDetail(\'' . $field->id . '\');"><i class="fa fa-search fa-fw"></i> Detail</button>';

			$row['actions'] = '
			<div class="text-center">
				<div class="btn-group">
				' . $delete . '
				' . $ban . '
				' . $detail . '
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
