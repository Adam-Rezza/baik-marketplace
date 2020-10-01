<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TransaksiController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('TemplateAdmin', NULL, 'template');
        $this->load->model('M_transaksi_less', 'mless');
    }

    public function index()
    {
        $data['title']    = 'List Transaksi';
        $data['content']  = 'transaksi/index';
        $data['vitamin']  = 'transaksi/index_vitamin';

        $this->template->template($data);
    }

    public function show()
    {
        $id   = $this->input->get('id');
        $exec = $this->mcore->get('keranjang', '*', ['transaksi_id' => $id], 'id', 'ASC');

        if ($exec->num_rows() == 0) {
            echo json_encode([
                'code' => '404',
                'msg'  => 'Data tidak ditemukan',
                'lq'   => $this->db->last_query()
            ]);
            exit;
        }

        $data = [];
        foreach ($exec->result() as $key) {
            $nama_produk = '';
            if ($key->produk_id != NULL) {
                $arr_produk = $this->mcore->get('produk', 'nama', ['id' => $key->produk_id]);

                if ($arr_produk->num_rows() > 0) {
                    $nama_produk = $arr_produk->row()->nama;
                }
            }
            $nested['nama_produk'] = $nama_produk;
            $nested['harga']       = number_format($key->harga, '0');
            $nested['qty']         = $key->qty;
            array_push($data, $nested);
        }


        echo json_encode([
            'code' => 200,
            'id'   => $id,
            'data' => $data,
        ]);
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

            $nama_kelurahan = '';
            if ($field->kelurahan != NULL && $field->kelurahan != '0') {
                $arr_kelurahan = $this->mcore->get('kelurahan', 'nama', ['id_kel' => $field->kelurahan]);

                if ($arr_kelurahan->num_rows() > 0) {
                    $nama_kelurahan = $arr_kelurahan->row()->nama;
                }
            }

            $nama_kecamatan = '';
            if ($field->kecamatan != NULL && $field->kecamatan != '0') {
                $arr_kecamatan = $this->mcore->get('kecamatan', 'nama', ['id_kec' => $field->kecamatan]);

                if ($arr_kecamatan->num_rows() > 0) {
                    $nama_kecamatan = $arr_kecamatan->row()->nama;
                }
            }

            $nama_kota = '';
            if ($field->kota != NULL && $field->kota != '0') {
                $arr_kota = $this->mcore->get('kabupaten', 'nama', ['id_kab' => $field->kota]);

                if ($arr_kota->num_rows() > 0) {
                    $nama_kota = $arr_kota->row()->nama;
                }
            }

            $nama_provinsi = '';
            if ($field->provinsi != NULL && $field->provinsi != '0') {
                $arr_provinsi = $this->mcore->get('provinsi', 'nama', ['id_prov' => $field->provinsi]);

                if ($arr_provinsi->num_rows() > 0) {
                    $nama_provinsi = $arr_provinsi->row()->nama;
                }
            }

            $row['no']            = $no;
            $row['id']            = $field->id;
            $row['toko_id']       = $field->toko_id;
            $row['pengirim']      = $field->pengirim;
            $row['telp_pengirim'] = $field->telp_pengirim;
            $row['user_id']       = $field->user_id;
            $row['penerima']      = $field->penerima;
            $row['telp_penerima'] = $field->telp_penerima;
            $row['alamat']        = $field->alamat;
            $row['kelurahan']     = $nama_kelurahan;
            $row['kecamatan']     = $nama_kecamatan;
            $row['kota']          = $nama_kota;
            $row['provinsi']      = $nama_provinsi;
            $row['created_date']  = $field->created_date;
            $row['process_date']  = $field->proccess_date;
            $row['shipment_date'] = $field->shipment_date;
            $row['delivery_date'] = $field->delivery_date;
            $row['failed_date']   = $field->failed_date;
            $row['failed_reason'] = $field->failed_reason;

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
}
        
/* End of file  TransaksiController.php */
