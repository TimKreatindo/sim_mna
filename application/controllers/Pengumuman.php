<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pengumuman extends CI_Controller
{
    public function index()
    {

        $role = $this->session->userdata('id_role');
        $data = [
            'title' => 'Pengumuman',
            'user' => get_user(),
            'pengumuman' => $this->db->select('*')
                ->from('pengumuman')
                ->where('pengumuman.to_role', $role)
                ->get()->result(),
            'view' => 'pengumuman/index'
        ];
        $this->load->view('index', $data);
    }
    public function list_pengumuman()
    {
        check_admin();
        $data = [
            'title' => 'Pengumuman',
            'user' => get_user(),
            'role_user' => $this->db->select('*')
                ->from('user_role')
                ->where('user_role.id !=', 1)
                ->get()->result(),
            'view' => 'pengumuman/list_pengumuman'
        ];
        $this->load->view('index', $data);
    }
    public function tambah()
    {
        $data = [
            'title' => 'Tambah Pengumuman',
            'user' => get_user(),
            'role_user' => $this->db->select('*')
                ->from('user_role')
                ->where('user_role.id !=', 1)
                ->get()->result(),
            'js_module' => 'ckeditor.js',
            'view' => 'pengumuman/tambah'
        ];
        $this->load->view('index', $data);
    }
    public function validation_tambah()
    {
        cek_ajax();
        $this->form_validation->set_rules('judul', 'Judul Pengumuman', 'required');
        $this->form_validation->set_rules('isi', 'Isi Pengumuman', 'required');
        $this->form_validation->set_rules('to_role', 'Role Pengumuman', 'required');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_judul' => form_error('judul'),
                'err_isi' => form_error('isi'),
                'err_to_role' => form_error('to_role'),
            ];
            echo json_encode($params);
        } else {
            $this->action_tambah();
        }
    }
    public function action_tambah()
    {
        $post = $this->input->post();
        $maker = $this->input->post('maker');
        $data = [
            'judul' => $this->input->post('judul'),
            'isi' => $post['isi'],
            'to_role' => $this->input->post('to_role'),
            'maker' => $maker,
            'created_at' => date('Y-m-d')
        ];
        $this->db->insert('pengumuman', $data);
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'type' => 'result',
                'msg' => 'Pengumuman baru berhasil di tambahkan',
                'redirect' => base_url('pengumuman/list_pengumuman')
            ];
        } else {
            $params = [
                'status' => false,
                'type' => 'result',
                'msg' => 'Pengumuman baru gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }
    public function edit($id)
    {
        $data = [
            'title' => 'Pengumuman',
            'user' => get_user(),
            'data' => $this->db->select('*')
                ->from('pengumuman')
                ->where('pengumuman.id', $id)
                ->get()->row(),
            'role_user' => $this->db->select('*')
                ->from('user_role')
                ->where('user_role.id !=', 1)
                ->where('user_role.id !=', 2)
                ->get()->result(),
            'view' => 'pengumuman/edit',
            'js_module' => 'ckeditor.js'
        ];
        $this->load->view('index', $data);
    }
    public function validation_edit_pengumuman()
    {
        cek_ajax();
        get_user();
        $this->form_validation->set_rules('judul', 'Judul Pengumuman', 'required');
        $this->form_validation->set_rules('isi', 'Isi Pengumuman', 'required');
        $this->form_validation->set_rules('to_role', 'Role Pengumuman', 'required');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_judul' => form_error('judul'),
                'err_isi' => form_error('isi'),
                'err_to_role' => form_error('to_role'),
            ];
            echo json_encode($params);
        } else {
            $this->to_edit_pengumuman();
        }
    }

    public function to_edit_pengumuman()
    {
        cek_ajax();
        $id = $this->input->post('id');
        $data = [
            'judul' => $this->input->post('judul'),
            'isi' => $this->input->post('isi'),
            'maker' => $this->input->post('maker'),
            'to_role' => $this->input->post('to_role'),
        ];
        $this->db->where('id', $id)->update('pengumuman', $data);
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'type' => 'result',
                'msg' => 'Pengumuman berhasil di edit',
                'redirect' => base_url('pengumuman/list_pengumuman')
            ];
        } else {
            $params = [
                'status' => false,
                'type' => 'result',
                'msg' => 'Pengumuman gagal di edit'
            ];
        }
        echo json_encode($params);
    }
    public function delete_pengumuman()
    {
        cek_ajax();
        get_user();

        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('pengumuman');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Pengumuman berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Pengumuman gagal di hapus'
            ];
        }
        echo json_encode($params);
    }
}
