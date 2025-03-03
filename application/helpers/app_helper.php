<?php

function cek_ajax()
{
    $t = get_instance();
    if (!$t->input->is_ajax_request()) {
        exit('No direct script access allowed');
    }
}

function get_user()
{
    $t = get_instance();
    $email = $t->session->userdata('email');
    // $user = $t->db->get_where('user', ['email' => $email])->row();
    $user = $t->db->select('*,user.id AS id_user,user_role.nama as nama_role')->from('user')
        ->join('user_role', 'user_role.id = user.id_role', 'left')
        ->where('user.email', $email)
        ->get()->row();
    if ($user) {
        return $user;
    } else {
        redirect('auth');
    }
}

function check_admin()
{
    $t = get_instance();
    $role = $t->session->userdata('id_role');
    $url = $t->uri->uri_string();
    $url1 = $t->uri->segment(1);
    $url2 = $t->uri->segment(2);

    if($url2 == '' || $url2 == null){
        $merge_url = $url1;
    } else {
        $length_url_2 = strlen($url2);
        if($length_url_2 >= 40){
            $merge_url = $url1;
        } else {
            $merge_url = $url1 .'/'. $url2; 
        }
    }


    $access_menu = $t->db
                    ->select('menu_access.id AS id_access')
                    ->from('menu_access')
                    ->join('menu', 'menu_access.id_menu = menu.id')
                    ->where('menu_access.id_role', $role)
                    ->where('menu.url', $url)
                    ->where('menu.status', 1)
                    ->get()->num_rows();

    $access_url = $t->db->get_where('menu_feature', ['id_role' => $role, 'url' => $merge_url])->num_rows();
    

    // var_dump($merge_url, $access_url, $access_menu, $role);
    // die;
    if($access_menu < 1){
        if($access_url < 1){
            redirect('auth/blocked');
        }
    }
}

function json_output($statusHeader, $response)
{
    $t = get_instance();
    $t->output->set_content_type('application/json');
    $t->output->set_status_header($statusHeader);
    $t->output->set_output(json_encode($response));
}

function tgl_indo($date)
{
    if ($date == '0000-00-00' || $date == null) {
        return '-';
    } else {
        $BulanIndo = array(
            "Januari", "Februari", "Maret",

            "April", "Mei", "Juni",

            "Juli", "Agustus", "September",

            "Oktober", "November", "Desember"
        );

        $tahun = substr($date, 0, 4);

        $bulan = substr($date, 5, 2);

        $tgl   = substr($date, 8, 2);

        $jam   = substr($date, 10);

        $result = $tgl . " " . $BulanIndo[(int)$bulan - 1] . " " . $tahun . " " . $jam;

        return ($result);
    }
}

function rupiah($angka)
{

    if ($angka == '' || $angka == null) {

        $rupiah = 0;
    } else {

        $rupiah = number_format($angka, 0, ',', '.');
    }

    return "Rp " . $rupiah;
}

function bilanganbulat($teks)
{
    $teks = preg_replace("/[^0-9]/", "", $teks);
    return $teks;
}
function cek_tgl($elem)
{
    if ($elem == '0000-00-00' || $elem == '' || $elem == null) {
        echo '-';
    } else {
        $d = date_create($elem);
        echo date_format($d, 'd F Y');
    }
}

function check_access_group(){
    $t = get_instance();
    $role = $t->session->userdata('id_role');
    $email = $t->session->userdata('email');

    if($role == 3){
        //mahasiswa
        $q_data =   $t->db->select('group_mahasiswa.*')
                ->from('group_mahasiswa')
                ->join('tbl_group', 'group_mahasiswa.id_group = tbl_group.id')
                ->join('user', 'group_mahasiswa.id_user = user.id')
                ->where('user.email', $email)
                ->where('user.is_active', 1)
                ->get()
                ->num_rows();
      
    } else if($role == 9) {
        //pemlap
        $q_data =   $t->db->select('group_pemlap.*')
                ->from('group_pemlap')
                ->join('tbl_group', 'group_pemlap.id_group = tbl_group.id')
                ->join('user', 'group_pemlap.id_user = user.id')
                ->where('user.email', $email)
                ->where('user.is_active', 1)
                ->get()
                ->num_rows();
       
    } else {
        $q_data = 0;
    }

    return $q_data;
}