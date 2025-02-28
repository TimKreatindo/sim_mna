<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Master extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // check_admin();
    }
    public function role()
    {
        $data = [
            'title' => 'Master Role User',
            'user' => get_user(),
            'view' => 'master/role',
            'data' => $this->db->get('user_role')->result()
        ];
        $this->load->view('index', $data);
    }

    public function user()
    {
        check_admin();
        $data = [
            'title' => 'Master User',
            'user' => get_user(),
            'view' => 'master/user',
            'role_user' => $this->db->select('*')
                ->from('user_role')
                ->where('user_role.id !=', 1)
                ->where('user_role.id !=', 9)
                ->get()->result(),
            'data' => $this->model->get_data_user()->result()
        ];
        $this->load->view('index', $data);
    }

    public function menu()
    {
        $data = [
            'title' => 'Master Menu',
            'user' => get_user(),
            'view' => 'master/menu',
            'menu_dropdown' => $this->db->get_where('menu', ['type' => 2, 'status' => 1])->result(),
            'data' => $this->db->where(['type !=' => 3, 'status' => 1])->get('menu')->result()
        ];
        $this->load->view('index', $data);
    }

    public function access_menu()
    {
        $data = [
            'title' => 'Master Access Menu',
            'user' => get_user(),
            'view' => 'master/access_menu',
            'role' => $this->db->get('user_role')->result(),
            'menu' => $this->db->where(['type !=' => 3, 'status' => 1])->get('menu')->result()
        ];
        $this->load->view('index', $data);
    }
    public function periode(){
        $data = [
            'title' => 'Master Periode',
            'user' => get_user(),
            'view' => 'master/periode',
            'js' => ['master_periode'],
            'data' => $this->db->order_by('id', 'DESC')->get('periode')->result()
        ];
        $this->load->view('index', $data);
    }
}