<?php

defined('BASEPATH') or exit('No direct script access allowed');

class BannerController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('TemplateAdmin', NULL, 'template');
		$this->load->model('M_banner_less', 'mless');
	}

	public function index()
	{
		$data['title']    = 'Banner Management';
		$data['content']  = 'banner/index';
		$data['vitamin']  = 'banner/index_vitamin';

		$this->template->template($data);
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

			$row['no']     = $no;
			$row['id']     = $field->id;
			$row['gambar'] = '<img src="' . base_url('public/img/banner/' . $field->gambar) . '" class="img-thumbnail" />';
			$row['url']    = $field->url;
			$row['active'] = $field->active;

			if ($field->urutan == 1) {
				$updown = '<button class="btn btn-warning btn-xs" onclick="downData(\'' . $field->id . '\');"><i class="fa fa-arrow-down fa-fw"></i></button>';
			} elseif ($field->urutan == $total_data) {
				$updown = '
				<button class="btn btn-success btn-xs" onclick="upData(\'' . $field->id . '\');"><i class="fa fa-arrow-up fa-fw"></i></button>
				';
			} else {
				$updown = '
				<button class="btn btn-success btn-xs" onclick="upData(\'' . $field->id . '\');"><i class="fa fa-arrow-up fa-fw"></i></button>
				<button class="btn btn-warning btn-xs" onclick="downData(\'' . $field->id . '\');"><i class="fa fa-arrow-down fa-fw"></i></button>
				';
			}
			$row['urutan'] = $field->urutan . " " . $updown;

			$delete = '<button class="btn btn-danger btn-xs" onclick="deleteData(\'' . $field->id . '\');"><i class="fa fa-trash fa-fw"></i> Delete</button>';
			$edit = '<button class="btn btn-info btn-xs" onclick="editData(\'' . $field->id . '\');"><i class="fa fa-pencil fa-fw"></i> Edit</button>';

			$row['actions'] = '
			<div class="text-center">
				<div class="btn-group">
				' . $delete . '
				' . $edit . '
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
