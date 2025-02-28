<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'user' => get_user(),
            'view' => 'user/index'
        ];
        $this->load->view('index', $data);
    }

    public function profile()
    {
        $data = [
            'title' => 'Profile',
            'user' => get_user(),
            'view' => 'user/profile'
        ];
        $this->load->view('index', $data);
    }

    public function change_profile()
    {
        $validation_nim = $this->input->post('role_user');
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        if ($validation_nim == 3) {
            $this->form_validation->set_rules('nim', 'NIM', 'required|trim');
        }
        if ($validation_nim == 3 || $validation_nim == 9) {
            $this->form_validation->set_rules('instansi_magang', 'Instansi Magang', 'required');
            $this->form_validation->set_rules('alamat_magang', 'Alamat Magang', 'required');
        }

        $this->form_validation->set_rules('alamat', 'Alamat Mahasiswa', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');

        if ($this->form_validation->run() == false) {

            if ($validation_nim == 3) {
                $err_nim = form_error('nim');
            } else {
                $err_nim = "";
            }
            if ($validation_nim == 3 || $validation_nim == 9) {
                $err_instansi_magang = form_error('instansi_magang');
                $err_alamat_magang = form_error('alamat_magang');
            } else {
                $err_instansi_magang = "";
                $err_alamat_magang = "";
            }

            $params = [
                'type' => 'validation',
                'err_nama_lengkap' => form_error('nama_lengkap'),
                'err_nim' => $err_nim,
                'err_alamat' => form_error('alamat'),
                'err_instansi_magang' => $err_instansi_magang,
                'err_alamat_magang' => $err_alamat_magang,
                'err_email' => form_error('email')
            ];
            echo json_encode($params);
        } else {
            $email = $this->input->post('email');
            $user = get_user();
            $email_already = $this->db->get_where('user', ['email' => $email, 'id !=' => $user->id_user])->num_rows();

            if ($email_already > 0) {
                $params = [
                    'type' => 'validation',
                    'err_email' => 'Email is already'
                ];
                echo json_encode($params);
                die;
            } else {
                $this->action_change_profile();
            }
        }
    }
    private function action_change_profile()
    {
        $id = $this->input->post('id');
        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap'),
            'nim' => htmlspecialchars($this->input->post('nim')),
            'alamat' => $this->input->post('alamat'),
            'instansi_magang' => $this->input->post('instansi_magang'),
            'alamat_magang' => $this->input->post('alamat_magang'),
            'email' => htmlspecialchars($this->input->post('email')),
        ];
        $this->db->where('id', $id)->update('user', $data);
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'type' => 'result',
                'msg' => 'Berhasil Mengganti Profile',
                'redirect' => base_url('user/profile')
            ];
        } else {
            $params = [
                'status' => false,
                'type' => 'result',
                'msg' => 'Gagal Mengganti Profile'
            ];
        }
        echo json_encode($params);
    }

    public function validation_pass()
    {
        $this->form_validation->set_rules('old_pass', 'Old Password', 'required|trim');
        $this->form_validation->set_rules('new_pass', 'New Password', 'required|trim|min_length[5]|matches[repeat_new_pass]');
        $this->form_validation->set_rules('repeat_new_pass', 'Repeat New Password', 'required|trim|matches[new_pass]');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_old_pass' => form_error('old_pass'),
                'err_new_pass' => form_error('new_pass'),
                'err_repeat_new_pass' => form_error('repeat_new_pass')
            ];
            echo json_encode($params);
            die;
        } else {
            $user = get_user();
            $old_pass = md5(sha1($this->input->post('old_pass')));
            $new_pass = md5(sha1($this->input->post('new_pass')));


            if ($user->password == $old_pass) {
                if ($user->password != $new_pass) {
                    $this->to_change_password();
                } else {
                    $params = [
                        'type' => 'validation',
                        'err_new_pass' => 'The new password cannot be the same as the old password'
                    ];
                    echo json_encode($params);
                    die;
                }
            } else {
                $params = [
                    'type' => 'validation',
                    'err_old_pass' => 'Wrong Old Password'
                ];
                echo json_encode($params);
                die;
            }
        }
    }

    private function to_change_password()
    {
        $new_pass  = md5(sha1($this->input->post('new_pass')));
        $user = get_user();
        $this->db->set('password', $new_pass)->where('id', $user->id)->update('user');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'type' => 'result',
                'status' => true,
                'msg' => 'Password berhasil di perbarui',
                'redirect' => base_url('user/profile')
            ];
        } else {
            $params = [
                'type' => 'result',
                'status' => false,
                'msg' => 'Password gagal di perbarui'
            ];
        }
        echo json_encode($params);
    }
}
