<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Logbook_model extends CI_Model
{
    // ini punya mahassigma
    public function update_changelog($data, $add_data)
    {
        $decode = json_decode($data);
        $decode[] = $add_data;
        return $decode;
    }

    private function query_mhs_logbook($hash_id = null)
    {
        $user = get_user();
        $this->db->select('*')->from('log_mahasiswa')->order_by('id', 'DESC');
        if ($hash_id) {
            $this->db->where('sha1(id_user)', $hash_id);
        } else {
            $this->db->where('id_user', $user->id_user);
        }
    }

    private function filter_mhs_logbook($hash_id = null)
    {
        $this->query_mhs_logbook($hash_id);
        $search = ['jadwal', 'jenis_kegiatan', 'uraian_kegiatan', 'hasil'];
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

    public function get_mhs_logbook($hash_id = null)
    {
        $this->filter_mhs_logbook($hash_id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getfilter_mhs_logbook($hash_id = null)
    {
        $this->filter_mhs_logbook($hash_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_mhs_logbook($hash_id = null)
    {
        $this->query_mhs_logbook($hash_id);
        return $this->db->count_all_results();
    }


    //ini di bagian menu logbook-mahasiswa
    private function query_list_mahasiswa($group = null, $periode = null, $dosen = null, $pemlap = null)
    {
        $this->db->select('
            user.nama_lengkap,
            user.nim,
            user.id
        ')
            ->from('user')
            ->join('group_mahasiswa', 'user.id = group_mahasiswa.id_user')
            ->join('tbl_group', 'group_mahasiswa.id_group = tbl_group.id')
            ->join('group_pemlap', 'tbl_group.id = group_pemlap.id_group')
            ->where('user.id_role', 3)
            ->group_by('user.id');

        if ($group) {
            $this->db->where('tbl_group.id', $group);
        }

        if ($periode) {
            $this->db->where('tbl_group.id_periode', $periode);
        }

        if ($dosen) {
            $this->db->where('tbl_group.id_dosen', $dosen);
        }

        if ($pemlap) {
            $this->db->where('group_pemlap.id_user', $pemlap);
        }
    }

    private function filter_list_mahasiswa($group = null, $periode = null, $dosen = null, $pemlap = null)
    {
        $this->query_list_mahasiswa($group, $periode, $dosen, $pemlap);
        $search = ['nim', 'nama', 'email'];
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

    public function get_list_mahasiswa($group = null, $periode = null, $dosen = null, $pemlap = null)
    {
        $this->filter_list_mahasiswa($group, $periode, $dosen, $pemlap);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function getlist_filtered_mahasiswa($group = null, $periode = null, $dosen = null, $pemlap = null)
    {
        $this->filter_list_mahasiswa($group, $periode, $dosen, $pemlap);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_list_mahasiswa($group = null, $periode = null, $dosen = null, $pemlap = null)
    {
        $this->query_list_mahasiswa($group, $periode, $dosen, $pemlap);
        return $this->db->count_all_results();
    }


    //ini bagian menu laporan milik pemlap
    private function q_report_pemlap($hash_id = null)
    {
        $user = get_user();
        $this->db->select('*')->from('log_pemlap')->order_by('id', 'DESC');
        if ($hash_id) {
            $this->db->where('sha1(id_dosen)', $hash_id);
        } else {
            $this->db->where('id_dosen', $user->id_user);
        }
    }

    private function filter_report($hash_id = null)
    {
        $this->q_report_pemlap($hash_id);
        $search = ['jadwal', 'jenis_kegiatan', 'uraian_kegiatan', 'hasil'];
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

    public function get_report($hash_id = null)
    {
        $this->filter_report($hash_id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filter_report($hash_id = null)
    {
        $this->filter_report($hash_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_report($hash_id = null)
    {
        $this->q_report_pemlap($hash_id);
        return $this->db->count_all_results();
    }



    //load data pemlap di menu laporan pembimbing
    private function q_list_pemlap($role = null)
    {
        $this->db->select('
            user.id,
            user.nama_lengkap,
            user.instansi_magang,
            user.alamat_magang
        ')
            ->from('user')
            ->join('group_pemlap', 'user.id = group_pemlap.id_user')
            ->join('tbl_group', 'tbl_group.id = group_pemlap.id_group')
            ->where('user.id_role', 9);

            if($role){
                $this->db->where('tbl_group.id_dosen', $role);
            }
    }

    private function filter_list_pemlap($role = null)
    {
        $this->q_list_pemlap($role);
        $search = ['nama_lengkap', 'email', 'instansi_magang', 'alamat_magang'];
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

    public function get_list_pemlap($role = null)
    {
        $this->filter_list_pemlap($role);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function c_filter_pemlap($role = null)
    {
        $this->filter_list_pemlap($role);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function c_all_report($role = null)
    {
        $this->q_list_pemlap($role);
        return $this->db->count_all_results();
    }
}