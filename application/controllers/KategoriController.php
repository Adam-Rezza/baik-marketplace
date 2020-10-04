<?php

defined('BASEPATH') or exit('No direct script access allowed');

class KategoriController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('TemplateAdmin', NULL, 'template');
		$this->load->model('M_kategori_less', 'mless');
	}

	public function index()
	{
		$data['title']    = 'Kategori Management';
		$data['content']  = 'kategori/index';
		$data['vitamin']  = 'kategori/index_vitamin';

		$this->template->template($data);
	}

	public function show()
	{
		$id   = $this->input->get('id');
		$exec = $this->mcore->get('kategori', '*', ['id' => $id, 'del' => FALSE]);

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
			'nama'   => $exec->row()->nama,
			'active' => $exec->row()->active,
			'gambar' => $exec->row()->gambar,
		]);
	}

	public function show_sub()
	{
		$id   = $this->input->get('id');
		$exec = $this->mcore->get('sub_kategori', '*', ['id' => $id, 'del' => FALSE]);

		if ($exec->num_rows() == 0) {
			echo json_encode([
				'code' => '404',
				'msg'  => 'Data tidak ditemukan'
			]);
			exit;
		}

		echo json_encode([
			'code'   => 200,
			'id'     => $id,
			'nama'   => $exec->row()->nama,
			'parent' => $exec->row()->parent,
			'active' => $exec->row()->active,
		]);
	}

	public function store()
	{
		$cur_date = new DateTime('now');
		$nama     = $this->input->post('nama');
		$parent   = $this->input->post('parent');
		$active   = $this->input->post('active');

		if ($parent == 'no') {
			$check = $this->mcore->count('kategori', ['nama' => $nama, 'del' => FALSE]);

			if ($check > 0) {
				echo json_encode([
					'code' => 500,
					'msg' => 'Kategori telah terdaftar, silahkan gunakan nama kategori lain'
				]);
				exit;
			}

			$last_no_urut = $this->mcore->get('kategori', 'urutan', ['del' => FALSE], 'urutan', 'DESC', 1);

			if ($last_no_urut->num_rows() == 0) {
				$last_no_urut = 1;
			} else {
				$last_no_urut = $last_no_urut->row()->urutan + 1;
			}

			$nama_gambar = NULL;
			if (!empty($_FILES['gambar']['name'])) {
				$config['upload_path']      = './public/img/kategori/';
				$config['allowed_types']    = 'gif|jpg|png';
				$config['overwrite']        = TRUE;
				$config['file_ext_tolower'] = TRUE;
				$config['encrypt_name']     = TRUE;


				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('gambar')) {
					$ret = ['code' => 500, 'msg' => $this->upload->display_errors()];
					echo json_encode($ret);
					exit;
				} else {
					$nama_gambar = $this->upload->data('file_name');
				}
			}

			$data = [
				'nama'         => $nama,
				'urutan'       => $last_no_urut,
				'created_date' => $cur_date->format('Y-m-d H:i:s'),
				'active'       => ($active == '1') ? TRUE : FALSE,
				'del'          => FALSE,
				'gambar'       => $nama_gambar,
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
		} else {
			$check = $this->mcore->count('sub_kategori', ['parent' => $parent, 'nama' => $nama, 'del' => FALSE]);

			if ($check > 0) {
				echo json_encode([
					'code' => 500,
					'msg' => 'Sub Kategori telah terdaftar, silahkan gunakan nama Sub kategori lain'
				]);
				exit;
			}

			$last_no_urut = $this->mcore->get('sub_kategori', 'urutan', ['parent' => $parent, 'del' => FALSE], 'urutan', 'DESC', 1);

			if ($last_no_urut->num_rows() == 0) {
				$last_no_urut = 1;
			} else {
				$last_no_urut = $last_no_urut->row()->urutan + 1;
			}

			$data = [
				'parent'       => $parent,
				'nama'         => $nama,
				'urutan'       => $last_no_urut,
				'created_date' => $cur_date->format('Y-m-d H:i:s'),
				'active'       => ($active == '1') ? TRUE : FALSE,
				'del'          => FALSE,
			];
			$exec = $this->mcore->store('sub_kategori', $data);

			if ($exec) {
				echo json_encode([
					'code' => 200,
					'msg' => 'Proses Tambah Sub Kategori Berhasil'
				]);
				exit;
			} else {
				echo json_encode([
					'code' => 500,
					'msg' => 'Proses Tambah Sub Kategori Gagal, Gagal terhubung dengan Database'
				]);
				exit;
			}
		}
	}

	public function update()
	{
		$id          = $this->input->post('id_edit');
		$nama        = $this->input->post('nama_edit');
		$active      = $this->input->post('active_edit');
		$prev_gambar = $this->input->post('nama_gambar_edit');

		$check = $this->mcore->count('kategori', ['id' => $id]);

		if ($check == 0) {
			echo json_encode([
				'code' => 404,
				'msg' => 'Data Kategori Tidak ditemukan, proses update dibatalkan',
			]);
			exit;
		}

		$nama_gambar = $prev_gambar;
		if (!empty($_FILES['gambar_edit']['name'])) {
			$config['upload_path']      = './public/img/kategori/';
			$config['allowed_types']    = 'gif|jpg|png';
			$config['overwrite']        = TRUE;
			$config['file_ext_tolower'] = TRUE;
			$config['encrypt_name']     = TRUE;


			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('gambar_edit')) {
				$ret = ['code' => 500, 'msg' => $this->upload->display_errors()];
				echo json_encode($ret);
				exit;
			} else {
				$nama_gambar = $this->upload->data('file_name');
			}
		}

		$data = [
			'nama'   => $nama,
			'active' => ($active == '1') ? TRUE : FALSE,
			'gambar' => $nama_gambar,
		];

		$exec = $this->mcore->update('kategori', $data, ['id' => $id]);

		if ($exec) {
			$ret = [
				'code' => 200,
				'msg'  => 'Update Kategori Berhasil',
				'data' => $data
			];
		} else {
			$ret = [
				'code' => 500,
				'msg' => 'Update Kategori Gagal',
			];
		}

		echo json_encode($ret);
	}

	public function update_sub()
	{
		$id          = $this->input->post('id_edit_sub');
		$nama        = $this->input->post('nama_edit_sub');
		$parent      = $this->input->post('parent_edit_sub');
		$active      = $this->input->post('active_edit_sub');
		$prev_parent = $this->input->post('prev_parent_edit');

		$check = $this->mcore->count('sub_kategori', ['id' => $id]);

		if ($check == 0) {
			echo json_encode([
				'code' => 404,
				'msg' => 'Data Kategori Tidak ditemukan, proses update dibatalkan',
			]);
			exit;
		}

		$data = [
			'nama'   => $nama,
			'parent' => $parent,
			'active' => ($active == '1') ? TRUE : FALSE,
		];

		if ($prev_parent != $parent) {
			$arr_last_urutan = $this->mcore->get('sub_kategori', 'urutan', ['parent' => $parent, 'del' => FALSE], 'urutan', 'DESC', '1');

			$last_urutan = 1;
			if ($arr_last_urutan->num_rows() > 0) {
				$last_urutan = $arr_last_urutan->row()->urutan + 1;
			}

			$data = [
				'nama'   => $nama,
				'parent' => $parent,
				'active' => ($active == '1') ? TRUE : FALSE,
				'urutan' => $last_urutan,
			];
		}

		$exec = $this->mcore->update('sub_kategori', $data, ['id' => $id]);

		if ($exec) {
			$ret = [
				'code'   => 200,
				'msg'    => 'Update Sub Kategori Berhasil',
				'parent' => $parent,
			];
		} else {
			$ret = [
				'code' => 500,
				'msg'  => 'Update Sub Kategori Gagal',
			];
		}

		echo json_encode($ret);
	}

	public function destroy()
	{
		$id = $this->input->post('id');

		$object = ['del' => TRUE];
		$where  = ['id' => $id];
		$exec   = $this->mcore->update('kategori', $object, $where);

		if ($exec) {
			$ret = ['code' => 200, 'msg' => 'Hapus Kategori Berhasil'];
			$exec2   = $this->mcore->update('sub_kategori', $object, ['parent' => $id]);

			if (!$exec2) {
				$ret = ['code' => 500, 'msg' => 'Hapus Sub Kategori Gagal'];
			}
		} else {
			$ret = ['code' => 500, 'msg' => 'Hapus Kategori Gagal'];
		}

		$reindent = $this->_reindent('kategori');

		if ($reindent === FALSE) {
			$ret = ['code' => 500, 'msg' => 'proses reindent gagal, silahkan hubungi team IT'];
		}

		echo json_encode($ret);
	}

	public function destroy_sub()
	{
		$id = $this->input->post('id');

		$object = ['del' => TRUE];
		$where  = ['id' => $id];
		$exec   = $this->mcore->update('sub_kategori', $object, $where);

		$parent = $this->mcore->get('sub_kategori', 'parent', $where);

		if ($parent->num_rows() > 0) {
			if ($exec) {
				$ret = ['code' => 200, 'msg' => 'Hapus Sub Kategori Berhasil', 'parent' => $parent->row()->parent];
			} else {
				$ret = ['code' => 500, 'msg' => 'Hapus Sub Kategori Gagal'];
			}

			$reindent = $this->_reindent('sub_kategori', $parent->row()->parent);

			if ($reindent === FALSE) {
				$ret = ['code' => 200, 'msg' => 'proses reindent gagal, Karna Kategori sudah tidak memiliki Sub Kategori'];
			}
		}

		echo json_encode($ret);
	}

	public function sub()
	{
		$id = $this->input->get('id');

		$items = $this->mcore->get('sub_kategori', '*', ['parent' => $id, 'del' => FALSE], 'urutan', 'ASC');

		if ($items->num_rows() == 0) {
			$ret = ['code' => 404, 'msg' => 'Tidak memiliki Sub Kategori'];
		} else {
			$data = [];
			foreach ($items->result() as $key) {
				if ($key->active == TRUE) {
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
		$data = $this->mcore->get('kategori', '*', ['active' => TRUE, 'del' => FALSE]);

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
		$total_data = $this->mless->count_filtered();
		foreach ($list as $field) {
			$no++;
			$row             = array();

			$row['no']     = $no;
			$row['id']     = $field->id;

			$gambar = '';
			if ($field->gambar) {
				$gambar = base_url() . 'public/img/kategori/' . $field->gambar;
			}
			$row['gambar'] = '<img src="' . $gambar . '" class="img-thumbnail" style="width: 100px !important;" />';
			$row['nama']   = $field->nama;
			$row['active'] = $field->active;

			if ($field->urutan == 1) {
				$updown = '<button class="btn btn-warning btn-xs" onclick="downData(\'' . $field->id . '\', \'parent\');"><i class="fa fa-arrow-down fa-fw"></i></button>';
			} elseif ($field->urutan == $total_data) {
				$updown = '
				<button class="btn btn-success btn-xs" onclick="upData(\'' . $field->id . '\', \'parent\');"><i class="fa fa-arrow-up fa-fw"></i></button>
				';
			} else {
				$updown = '
				<button class="btn btn-success btn-xs" onclick="upData(\'' . $field->id . '\', \'parent\');"><i class="fa fa-arrow-up fa-fw"></i></button>
				<button class="btn btn-warning btn-xs" onclick="downData(\'' . $field->id . '\', \'parent\');"><i class="fa fa-arrow-down fa-fw"></i></button>
				';
			}
			$row['urutan'] = $field->urutan . " " . $updown;

			$delete = '<button class="btn btn-danger btn-xs" onclick="deleteData(\'' . $field->id . '\');"><i class="fa fa-trash fa-fw"></i> Delete</button>';
			$edit = '<button class="btn btn-info btn-xs" onclick="editData(\'' . $field->id . '\');"><i class="fa fa-pencil fa-fw"></i> Edit</button>';
			$detail = '<button class="btn btn-primary btn-xs" onclick="detailData(\'' . $field->id . '\');"><i class="fa fa-list fa-fw"></i> Sub Kategori</button>';

			$row['actions'] = '
			<div class="text-center">
				<div class="btn-group">
				' . $delete . '
				' . $edit . '
				' . $detail . '
				</div>
			</div>
			';

			$data[] = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->mless->count_all(),
			"recordsFiltered" => $this->mless->count_filtered(),
			"data"            => $data,
		);

		echo json_encode($output);
	}

	public function up_parent()
	{
		$id    = $this->input->get('id');
		$count = $this->mcore->count('kategori', ['id' => $id]);

		if ($count == 0) {
			$ret = ['code' => 404, 'msg' => 'Data tidak ditemukan'];
		} else {
			$cur        = $this->mcore->get('kategori', 'id, urutan', ['id' => $id]);
			$cur_urutan = $cur->row()->urutan;

			$where_prev  = "urutan = (select max(urutan) from kategori where urutan < '" . $cur_urutan . "' AND del = false) ";
			$prev        = $this->mcore->get('kategori', 'id, urutan', $where_prev);
			$prev_id     = $prev->row()->id;
			$prev_urutan = $prev->row()->urutan;

			if ($prev_urutan <= 0) {
				$prev_urutan = 1;
			}

			$update_prev = $this->mcore->update('kategori', ['urutan' => $cur_urutan], ['id' => $prev_id]);
			$update_cur = $this->mcore->update('kategori', ['urutan' => $prev_urutan], ['id' => $id]);

			if ($update_prev && $update_cur) {
				$ret = ['code' => 200, 'msg' => "", 'prev_id' => $prev_id, 'id' => $id];
			} else {
				$ret = ['code' => 500, 'msg' => "Update urutan gagal, silahkan coba kembali"];
			}
		}

		$reindent = $this->_reindent('kategori');

		if ($reindent === FALSE) {
			$ret = ['code' => 500, 'msg' => 'proses reindent gagal, silahkan hubungi team IT'];
		}

		echo json_encode($ret);
	}

	public function down_parent()
	{
		$id    = $this->input->get('id');
		$count = $this->mcore->count('kategori', ['id' => $id]);

		if ($count == 0) {
			$ret = ['code' => 404, 'msg' => 'Data tidak ditemukan'];
		} else {
			$cur        = $this->mcore->get('kategori', 'id, urutan', ['id' => $id]);
			$cur_urutan = $cur->row()->urutan;

			$where_next  = "urutan = (select min(urutan) from kategori where urutan > '" . $cur_urutan . "' AND del = false) ";
			$next        = $this->mcore->get('kategori', 'id, urutan', $where_next);
			$next_id     = $next->row()->id;
			$next_urutan = $next->row()->urutan;

			$update_next = $this->mcore->update('kategori', ['urutan' => $cur_urutan], ['id' => $next_id]);
			$update_cur  = $this->mcore->update('kategori', ['urutan' => $next_urutan], ['id' => $id]);

			if ($update_next && $update_cur) {
				$ret = ['code' => 200, 'msg' => ""];
			} else {
				$ret = ['code' => 500, 'msg' => "Update urutan gagal, silahkan coba kembali"];
			}
		}

		echo json_encode($ret);
	}

	public function up_child()
	{
		$id    = $this->input->get('id');
		$count = $this->mcore->count('sub_kategori', ['id' => $id]);

		if ($count == 0) {
			$ret = ['code' => 404, 'msg' => 'Data tidak ditemukan'];
		} else {
			$cur        = $this->mcore->get('sub_kategori', 'id, urutan, parent', ['id' => $id]);
			$cur_urutan = $cur->row()->urutan;
			$parent     = $cur->row()->parent;

			$where_prev  = "urutan = (select max(urutan) from sub_kategori where urutan < '" . $cur_urutan . "' AND del = false AND parent = '" . $parent . "') AND del = false AND parent = '" . $parent . "'";
			$prev        = $this->mcore->get('sub_kategori', 'id, urutan', $where_prev);
			$prev_id     = $prev->row()->id;
			$prev_urutan = $prev->row()->urutan;

			$update_prev = $this->mcore->update('sub_kategori', ['urutan' => $cur_urutan], ['id' => $prev_id]);
			$update_cur  = $this->mcore->update('sub_kategori', ['urutan' => $prev_urutan], ['id' => $id]);

			if ($update_prev && $update_cur) {
				$ret = ['code' => 200, 'msg' => "", 'id_parent' => $parent];
			} else {
				$ret = ['code' => 500, 'msg' => "Update urutan gagal, silahkan coba kembali", 'id_parent' => $parent];
			}
		}

		echo json_encode($ret);
	}

	public function down_child()
	{
		$id    = $this->input->get('id');
		$count = $this->mcore->count('sub_kategori', ['id' => $id]);

		if ($count == 0) {
			$ret = ['code' => 404, 'msg' => 'Data tidak ditemukan'];
		} else {
			$cur        = $this->mcore->get('sub_kategori', 'id, urutan, parent', ['id' => $id]);
			$cur_urutan = $cur->row()->urutan;
			$parent     = $cur->row()->parent;

			$where_next  = "urutan = (select min(urutan) from sub_kategori where urutan > '" . $cur_urutan . "' AND del = false AND parent = '" . $parent . "') AND del = false AND parent = '" . $parent . "'";
			$next        = $this->mcore->get('sub_kategori', 'id, urutan', $where_next);
			$next_id     = $next->row()->id;
			$next_urutan = $next->row()->urutan;

			$update_next = $this->mcore->update('sub_kategori', ['urutan' => $cur_urutan], ['id' => $next_id]);
			$update_cur  = $this->mcore->update('sub_kategori', ['urutan' => $next_urutan], ['id' => $id]);

			if ($update_next && $update_cur) {
				$ret = ['code' => 200, 'msg' => "", 'id_parent' => $parent];
			} else {
				$ret = ['code' => 500, 'msg' => "Update urutan gagal, silahkan coba kembali"];
			}
		}

		echo json_encode($ret);
	}

	public function _reindent($jenis, $parent = NULL)
	{
		if ($jenis == 'kategori') {
			$arr = $this->mcore->get('kategori', 'id', ['del' => FALSE], 'urutan', 'ASC');
		} else {
			$arr = $this->mcore->get('sub_kategori', 'id', ['del' => FALSE, 'parent' => $parent], 'urutan', 'ASC');
		}

		if ($arr->num_rows() == 0) {
			return FALSE;
		}

		$data = [];

		$no_urut = 1;
		foreach ($arr->result() as $key) {
			$id     = $key->id;

			$data  = ['urutan' => $no_urut];
			$where = ['id' => $id];
			$exec  = $this->mcore->update($jenis, $data, $where);

			$no_urut++;
		}

		if ($exec) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
        
    /* End of file  KategoriController.php */
