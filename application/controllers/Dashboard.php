<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        check_admin();
    }
    public function index()
    {
        
        $data = [
            'title' => 'Dashboard',
            'user' => get_user(),
            'view' => 'admin/index',
            'total_mahasiswa' =>  $this->db->get_where('user', ['id_role' => 3])->num_rows(),
            'total_dosen' =>  $this->db->get_where('user', ['id_role' => 2])->num_rows(),
            'total_pemlap' =>  $this->db->get_where('user', ['id_role' => 9])->num_rows(),
        ];
        $this->load->view('index', $data);
    }
    public function pemlap()
    {
        
        $data = [
            'title' => 'List Pembimbing Lapangan',
            'user' => get_user(),
            'view' => 'admin/pemlap',
            'data' => $this->db->where('id_role', 9)->order_by('id', 'DESC')->get('user')->result(),
            'js' => ['master_pemlap']
        ];
        $this->load->view('index', $data);
    }

    public function group()
    {
      
        $data = [
            'title' => 'List Group',
            'user' => get_user(),
            'view' => 'admin/group',
            'js' => ['master_group'],
            'dosen' => $this->db->order_by('id', 'DESC')->get_where('user', ['id_role' => 2])->result(),
            'periode' => $this->db->order_by('id', 'DESC')->get('periode')->result()
        ];
        $this->load->view('index', $data);
    }

    public function logbook_mhs()
    {
        
        $data = [
            'title' => 'Logbook Saya',
            'user' => get_user(),
            'view' => 'mhs/my_logbook',
            'js' => ['logbook_mhs'],
            'access' => check_access_group()
        ];
        $this->load->view('index', $data);
    }

    public function add_mhs_logbook()
    {
        $access = check_access_group();
        if($access < 1){
            redirect('auth/blocked');
        }
       
        $data = [
            'title' => 'Logbook Baru',
            'user' => get_user(),
            'view' => 'mhs/new_logbook',
            'js' => ['new_mhs_logbook'],
            'js_module' => 'ckeditor.js'
        ];
        $this->load->view('index', $data);
    }

    public function detail_mhs_logbook($id = null)
    {

        $access = check_access_group();
        if($access < 1){
            redirect('auth/blocked');
        }
       
        if ($id) {
            $user = get_user();
            $get_data = $this->db->get_where('log_mahasiswa', ['sha1(id)' => $id, 'id_user' => $user->id_user])->row();
            if ($get_data) {
                $data = [
                    'title' => 'Detail Logbook',
                    'user' => $user,
                    'data' => $get_data,
                    'view' => 'mhs/detail_logbook',
                ];
                $this->load->view('index', $data);
            } else {
                redirect(base_url('mhs/my-logbook/'));
            }
        } else {
            redirect(base_url('mhs/my-logbook/'));
        }
    }

    public function mhs_edit_logbook($id = null)
    {

        $access = check_access_group();
        if($access < 1){
            redirect('auth/blocked');
        }
     
        if ($id) {
            $user = get_user();
            $get_data = $this->db->get_where('log_mahasiswa', ['sha1(id)' => $id, 'id_user' => $user->id_user])->row();
            if ($get_data) {
                $data = [
                    'title' => 'Edit Logbook',
                    'user' => $user,
                    'data' => $get_data,
                    'view' => 'mhs/edit_logbook',
                    'js' => ['new_mhs_logbook'],
                    'js_module' => 'ckeditor.js'
                ];
                $this->load->view('index', $data);
            } else {
                redirect(base_url('mhs/my-logbook/'));
            }
        } else {
            redirect(base_url('mhs/my-logbook/'));
        }
    }


    //list logbook mahasigma di bagian pemlap,dosen,& superadmin
    public function logbook_mahasiswa_list()
    {
      
        $user = get_user();
        if ($user->id_role == 1) {
            $data_filter = [
                'dosen' => $this->db->select('user.id, user.nama_lengkap AS nama')->from('user')->where(['id_role' => 2, 'is_active' => 1])->get()->result(),
                'periode' => $this->db->get('periode')->result()
            ];
        } else if ($user->id_role == 2 || $user->id_role == 9) {
            $query_data = $this->db->select('periode.id AS id_periode, periode.periode, tbl_group.id AS id_group,  tbl_group.nama_group')->from('periode')->join('tbl_group', 'periode.id = tbl_group.id_periode')->get()->result();
            $data_filter = [
                'group' => $query_data,
                'periode' => $this->db->get('periode')->result()
            ];
        } else {
            $data_filter = [];
        }

        $data = [
            'title' => 'Logbook Mahasiswa',
            'user' => $user,
            'view' => 'admin/logbook_mhs',
            'js' => ['list_mhs_logbook'],
            'filter' => $data_filter
        ];
        $this->load->view('index', $data);
    }

    public function list_logbook_mhs($id = null)
    {
        
        if ($id) {
            $data = [
                'title' => 'List Logbook Mahasiswa',
                'user' => get_user(),
                'view' => 'admin/list_logbook_mhs',
                'js' => ['mhs_logbook']
            ];
            $this->load->view('index', $data);
        } else {
            redirect(base_url('logbook-mahasiswa'));
        }
    }

    public function detail_logbook_mhs($id = null)
    {
        
        if ($id) {
            $get_data = $this->db->get_where('log_mahasiswa', ['sha1(id)' => $id])->row();
            if ($get_data) {
                $data = [
                    'title' => 'Detail Logbook Mahasiswa',
                    'user' => get_user(),
                    'view' => 'admin/detail_logbook_mhs',
                    'data' => $get_data,
                    'js' => ['master_detail_logbook']
                ];
                $this->load->view('index', $data);
            } else {
                redirect(base_url('logbook-mahasiswa'));
            }
        } else {
            redirect(base_url('logbook-mahasiswa'));
        }
    }




    //bagian logbook milik pemlap
    public function lap_pemlap()
    {
        
        $user = get_user();
        $access = check_access_group();
        
        if ($user->id_role == 2 || $user->id_role == 1) {
            $data = [
                'title' => 'Laporan Pembimbing',
                'user' => $user,
                'view' => 'admin/index_laporan',
                'js' => ['pemlap_report']
            ];
        } else if ($user->id_role == 9) {
            $data = [
                'title' => 'Laporan Pembimbing',
                'user' => $user,
                'view' => 'dpl/index_laporan',
                'js' => ['lap_pemlap'],
                'access' => $access
            ];
        }

        $this->load->view('index', $data);
    }

    public function add_report()
    {

        $access = check_access_group();
        if($access < 1){
            redirect('auth/blocked');
        }
        
        $data = [
            'title' => 'Tambah Laporan',
            'user' => get_user(),
            'view' => 'dpl/add_laporan',
            'js' => ['add_report'],
            'js_module' => 'ckeditor.js'
        ];
        $this->load->view('index', $data);
    }

    public function detail_report($id = null)
    {

        $access = check_access_group();
        if($access < 1){
            redirect('auth/blocked');
        }
       
        if ($id) {
            $user = get_user();
            $get_data = $this->db->where('sha1(id)', $id)->where('id_dosen', $user->id_user)->get('log_pemlap')->row();
            if ($get_data) {
                $data = [
                    'title' => 'Detail Laporan',
                    'user' => $user,
                    'view' => 'dpl/detail_laporan',
                    'data' => $get_data
                ];
                $this->load->view('index', $data);
            } else {
                redirect(base_url('report-pemlap'));
            }
        } else {
            redirect(base_url('report-pemlap'));
        }
    }

    public function edit_report($id = null)
    {

        $access = check_access_group();
        if($access < 1){
            redirect('auth/blocked');
        }
     
        if ($id) {
            $user = get_user();
            $get_data = $this->db->where('sha1(id)', $id)->where('id_dosen', $user->id_user)->get('log_pemlap')->row();
            if ($get_data) {
                $data = [
                    'title' => 'Edit Laporan',
                    'user' => $user,
                    'view' => 'dpl/edit_laporan',
                    'data' => $get_data,
                    'js' => ['edit_report'],
                    'js_module' => 'ckeditor.js'
                ];
                $this->load->view('index', $data);
            } else {
                redirect(base_url('report-pemlap'));
            }
        } else {
            redirect(base_url('report-pemlap'));
        }
    }



    //menu laporan pemlap di bagian super admin & dosen
    public function list_laporan_pemlap($id = null)
    {
        
        $data = [
            'title' => 'List Laporan',
            'user' => get_user(),
            'view' => 'admin/list_laporan_pemlap',
            'js' => ['list_laporan_pemlap']
        ];
        $this->load->view('index', $data);
    }

    public function detail_laporan_pemlap($id = null)
    {
     
        if ($id) {
            $user = get_user();
            $get_data = $this->db->get_where('log_pemlap', ['sha1(id)' => $id])->row();
            if ($get_data) {
                $data = [
                    'title' => 'Detail Laporan',
                    'user' => $user,
                    'view' => 'admin/detail_laporan_pemlap',
                    'data' => $get_data,
                    'id' => $id,
                    'js' => ['detail_report_pemlap']
                ];
                $this->load->view('index', $data);
            } else {
                redirect(base_url('report-pemlap'));
            }
        } else {
            redirect(base_url('report-pemlap'));
        }
    }
}