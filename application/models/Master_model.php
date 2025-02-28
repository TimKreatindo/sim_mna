<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Master_model extends CI_Model
{
    public function get_data_user()
    {
        $this->db->select('a.*,b.*')
            ->from('user a')
            ->join('user_role b', 'a.id_role = b.id', 'left');
        return $this->db->get()->result();
    }

    // DATATABLE MASTER TANAH START //
    public $column_search_user = array('user.id', 'user.nama_lengkap', 'user.instansi_magang', 'user.email');
    public $column_order_user = array(null, 'user.id', 'user.nama_lengkap', 'user.instansi_magang', 'user.email');
    public $order_user = array('user.id' => 'DESC');
    private function _get_query_user()
    {
        $get = $this->input->get();
        $this->db->select(' user.*,
            user_role.nama,
            user_role.nama AS nama_role,')
            ->from('user')
            ->join('user_role', 'user.id_role = user_role.id', 'left')
            ->where('id_role !=', 9)
            ->where('id_role !=', 1);
        if (!empty($get['role_user'])) {
            $this->db->where('user.id_role', $get['role_user']);
        }
        $i = 0;
        foreach ($this->column_search_user as $item) {
            if ($get['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $get['search']['value']);
                } else {
                    $this->db->or_like($item, $get['search']['value']);
                }

                if (count($this->column_search_user) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if (isset($get['order'])) {
            $this->db->order_by($this->column_order_user[$get['order']['0']['column']], $get['order']['0']['dir']);
        } else if (isset($this->order_user)) {
            $order = $this->order_user;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function count_all_datatable_user()
    {
        $this->db->from('user');
        return $this->db->count_all_results();
    }
    public function count_filtered_datatable_user()
    {
        $this->_get_query_user();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_user_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_user();
        if ($get['length'] != -1) {
            $this->db->limit($get['length'], $get['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }
    // DATATABLE MASTER TANAH END //

    public function get_detail_user($id = null)
    {
        $this->db->select('
        user.*,
        user_role.nama as nama_role,
        ')
            ->from('user')
            ->join('user_role', 'user.id_role = user_role.id');
        if ($id) {
            $this->db->where('user.id', $id);
        }

        return $this->db->get();
    }

    public function detail_tanah($id)
    {
        $this->db->select('a.*,b.nama_proyek,c.kode as kode_sertifikat1,d.kode as kode_sertifikat2,e.*');
        $this->db->from('master_tanah a');
        $this->db->join('master_proyek b', 'a.proyek_id = b.id', 'left');
        $this->db->join('master_sertifikat_tanah c', 'c.id = a.status_surat_tanah1', 'left');
        $this->db->join('master_sertifikat_tanah d', 'd.id = a.status_surat_tanah2', 'left');
        $this->db->join('master_status_proyek e', 'e.id = a.status_proyek', 'left');
        $this->db->where('a.id', $id);
        $query = $this->db->get();
        return $query;
    }
}
