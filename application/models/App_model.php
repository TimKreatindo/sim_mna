<?php
defined('BASEPATH') or exit('No direct script access allowed');
class App_model extends CI_Model
{
    public function get_data_user()
    {
        $this->db->select('
            user.*,
            user.nama_lengkap AS nama_user,
            user_role.nama,
            user_role.nama AS nama_role,
        ')
            ->from('user')
            ->join('user_role', 'user.id_role = user_role.id');
        $data = $this->db->get();
        return $data;
    }

    public function get_data_menu($parent = null, $role = null)
    {
        $user = get_user();
        $type = [1, 2];
        $this->db->select('
            menu.*,
            menu_access.id_role
        ')
            ->from('menu')
            ->join('menu_access', 'menu.id = menu_access.id_menu');
        if ($role) {
            $this->db->where('menu_access.id_role', $role);
        } else {
            $this->db->where('menu_access.id_role', $user->id_role);
        }
        if ($parent) {
            $this->db->where('menu.parent', $parent)
                ->where('menu.type', 3);
        } else {
            $this->db->where_in('menu.type', $type);
        }
        $data = $this->db->get();
        return $data;
    }


    //omke gas omke gas dirikulah tabung gas
    //bagiane menu group 
    private function mhs_registered()
    {
        $this->db->select('id_user')->from('group_mahasiswa')->group_by('id_user');
        $data = $this->db->get()->result();

        $output = [];
        foreach ($data as $d) {
            $output[] = $d->id_user;
        }
        return $output;
    }

    private function pemlap_registered()
    {
        $this->db->select('id_user')->from('group_pemlap')->group_by('id_user');
        $data = $this->db->get()->result();

        $output = [];
        foreach ($data as $d) {
            $output[] = $d->id_user;
        }
        return $output;
    }

    private function query_get_user_table($role = null, $selected = null)
    {
        if ($role == 9) {
            $not = $this->pemlap_registered();
        } else if ($role == 3) {
            $not = $this->mhs_registered();
        }

        $this->db->select('
            user.id,
            user.nama_lengkap,
            user.nim,
            user.email,
            user.instansi_magang,
            user.alamat_magang
        ')->from('user')
            ->order_by('user.id', 'DESC')
            ->where('is_active', 1);
        if ($role) {
            $this->db->where('user.id_role', $role);
        }
        if ($role == 9 || $role == 3) {
            $this->db->where_not_in('user.id', $not);
        }

        if ($selected) {
            $this->db->where_not_in('user.id', $selected);
        }
    }

    private function filter_user_table($role = null, $selected = null)
    {
        $this->query_get_user_table($role, $selected);
        $search = ['nim', 'email', 'nama_lengkap', 'instansi_magang'];
        $i = 0;
        foreach ($search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
    }

    public function get_mhs_table($role = null, $selected = null)
    {
        $this->filter_user_table($role, $selected);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function filtered_mhs_table($role = null, $selected = null)
    {
        $this->filter_user_table($role, $selected);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_mhs_table($role = null, $selected = null)
    {
        $this->query_get_user_table($role, $selected);
        return $this->db->count_all_results();
    }



    private function query_group($periode = null)
    {
        $this->db->select('
            tbl_group.*,
            periode.periode,
            user.nama_lengkap
        ')
            ->from('tbl_group')
            ->join('periode', 'periode.id = tbl_group.id_periode')
            ->join('user', 'user.id = tbl_group.id_dosen');

        if ($periode) {
            $this->db->where('tbl_group.id_periode', $periode);
        }
    }

    private function filter_group($periode = null)
    {
        $this->query_group($periode);
        $search = ['nama_lengkap', 'periode', 'nama_group'];
        $i = 0;
        foreach ($search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
    }

    public function get_group($periode = null)
    {
        $this->filter_group($periode);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_filter_group($periode = null)
    {
        $this->filter_group($periode);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_group($periode = null)
    {
        $this->query_group($periode);
        return $this->db->count_all_results();
    }

    public function get_group_row($id = null)
    {
        $this->db->select('
            tbl_group.*,
            periode.periode,
            user.*
        ')->from('tbl_group')
            ->join('periode', 'periode.id = tbl_group.id_periode')
            ->join('user', 'user.id = tbl_group.id_dosen')
            ->join('group_mahasiswa', 'group_mahasiswa.id_group = tbl_group.id')
            ->join('group_pemlap', 'group_pemlap.id_group = tbl_group.id');
        if ($id) {
            $this->db->where('tbl_group.id', $id);
        }
        $this->db->group_by('tbl_group.id')->order_by('tbl_group.create_at', 'DESC');
        $data = $this->db->get();
        return $data;
    }

    public function detail_people_group($id = null, $type){
        $this->db->select('
            user.*
        ')
        ->from('user');

        if($type === 3){
            //mahasigma
            $this->db
            ->join('group_mahasiswa', 'user.id = group_mahasiswa.id_user')
            ->where('group_mahasiswa.id_group', $id);
        } else if($type === 9){
            //pemlap
            $this->db
            ->join('group_pemlap', 'user.id = group_pemlap.id_user')
            ->where('group_pemlap.id_group', $id);
        }
        $this->db->group_by('user.id');

        $data = $this->db->get();
        return $data;
    }
}