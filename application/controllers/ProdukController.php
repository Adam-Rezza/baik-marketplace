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

    public function up()
    {
        $id = $this->input->get('id');
        $count = $this->mcore->count('banner', ['id' => $id]);

        if ($count == 0) {
            $ret = ['code' => 404, 'msg' => 'Data tidak ditemukan'];
        } else {
            $cur = $this->mcore->get('banner', 'id, urutan', ['id' => $id]);
            $cur_urutan = $cur->row()->urutan;
            $prev_urutan = $cur_urutan - 1;
            if ($prev_urutan <= 0) {
                $prev_urutan = 1;
            }
            $where_prev = [
                'urutan' => $prev_urutan,
                'del'    => NULL
            ];
            $prev = $this->mcore->get('banner', 'id, urutan', $where_prev);
            $id_prev = $prev->row()->id;

            $update_prev = $this->mcore->update('banner', ['urutan' => $cur_urutan], ['id' => $id_prev]);

            $update_cur = $this->mcore->update('banner', ['urutan' => $prev_urutan], ['id' => $id]);

            if ($update_prev && $update_cur) {
                $ret = ['code' => 200, 'msg' => ""];
            } else {
                $ret = ['code' => 500, 'msg' => "Update urutan gagal, silahkan coba kembali"];
            }
        }

        echo json_encode($ret);
    }

    public function down()
    {
        $id = $this->input->get('id');
        $count = $this->mcore->count('banner', ['id' => $id]);

        if ($count == 0) {
            $ret = ['code' => 404, 'msg' => 'Data tidak ditemukan'];
        } else {
            $cur = $this->mcore->get('banner', 'id, urutan', ['id' => $id]);
            $cur_urutan = $cur->row()->urutan;
            $next_urutan = $cur_urutan + 1;
            $where_next = [
                'urutan' => $next_urutan,
                'del'    => NULL
            ];
            $next = $this->mcore->get('banner', 'id, urutan', $where_next);

            $update_next = TRUE;
            if ($next->num_rows() != 0) {
                $id_next = $next->row()->id;
                $update_next = $this->mcore->update('banner', ['urutan' => $cur_urutan], ['id' => $id_next]);
            }


            $update_cur = $this->mcore->update('banner', ['urutan' => $next_urutan], ['id' => $id]);

            if ($update_next && $update_cur) {
                $ret = ['code' => 200, 'msg' => ""];
            } else {
                $ret = ['code' => 500, 'msg' => "Update urutan gagal, silahkan coba kembali"];
            }
        }

        echo json_encode($ret);
    }
}
        
    /* End of file  BannerController.php */
