<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pengumuman_model extends CI_Model
{
    // DATATABLE MASTER TANAH START //
    public $column_search_pengumuman = array('pengumuman.id', 'pengumuman.judul', 'pengumuman.isi', 'user_role.nama');
    public $column_order_pengumuman = array(null, 'pengumuman.id', 'pengumuman.judul', 'pengumuman.isi', 'user_role.nama');
    public $order_pengumuman = array('pengumuman.id' => 'DESC');
    private function _get_query_pengumuman()
    {
        $get = $this->input->get();
        $this->db->select(' pengumuman.*, pengumuman.id as id_pengumuman,
            user.*,
            user_role.nama,
            user_role.nama AS nama_role,')
            ->from('pengumuman')
            ->join('user_role', 'pengumuman.to_role = user_role.id', 'left')
            ->join('user', 'pengumuman.maker = user.id', 'left');
        if (!empty($get['role_user'])) {
            $this->db->where('pengumuman.to_role', $get['role_user']);
        }
        $i = 0;
        foreach ($this->column_search_pengumuman as $item) {
            if ($get['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $get['search']['value']);
                } else {
                    $this->db->or_like($item, $get['search']['value']);
                }

                if (count($this->column_search_pengumuman) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }
        if (isset($get['order'])) {
            $this->db->order_by($this->column_order_pengumuman[$get['order']['0']['column']], $get['order']['0']['dir']);
        } else if (isset($this->order_pengumuman)) {
            $order = $this->order_pengumuman;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    public function count_all_datatable_pengumuman()
    {
        $this->db->from('pengumuman');
        return $this->db->count_all_results();
    }
    public function count_filtered_datatable_pengumuman()
    {
        $this->_get_query_pengumuman();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function get_pengumuman_datatable()
    {
        $get = $this->input->get();
        $this->_get_query_pengumuman();
        if ($get['length'] != -1) {
            $this->db->limit($get['length'], $get['start']);
        }

        $query = $this->db->get();
        return $query->result();
    }
    // DATATABLE MASTER TANAH END //

    public function get_detail_pengumuman($id = null)
    {
        $this->db->select('
        pengumuman.*,
        user.*,
        user_role.nama as nama_role,
        ')
            ->from('pengumuman')
            ->join('user', 'pengumuman.maker = user.id')
            ->join('user_role', 'pengumuman.to_role = user_role.id');
        if ($id) {
            $this->db->where('pengumuman.id', $id);
        }

        return $this->db->get();
    }
}
