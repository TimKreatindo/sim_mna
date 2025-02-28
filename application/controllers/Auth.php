<?php
defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set('Asia/Jakarta');
class Auth extends CI_Controller
{

    public function index()
    {
        $this->load->view('auth/login');
    }

    public function validation_login()
    {
        cek_ajax();
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_email' => form_error('email'),
                'err_password' => form_error('password')
            ];
            echo json_encode($params);
            die;
        } else {
            $captcha = $this->captcha->validation_captcha($this->input->post('g-recaptcha-response'));
            if ($captcha['status'] === false) {
                $params = [
                    'status' => false,
                    'type' => 'result',
                    'msg' => $captcha['msg']
                ];
                echo json_encode($params);
                die;
            } else {
                $this->to_login();
            }
        }
    }

    private function to_login()
    {
        $email = $this->input->post('email');
        $password = md5(sha1($this->input->post('password')));
        $user = $this->db->get_where('user', ['email' => $email])->row();

        if ($user) {
            if ($user->password == $password) {
                if ($user->is_active == 1) {
                    $data = [
                        'email' => $user->email,
                        'status' => $user->is_active,
                        'id_role' => $user->id_role
                    ];
                    $this->session->set_userdata($data);
                    $params = [
                        'type' => 'result',
                        'status' => true,
                        'msg' => 'Login Success',
                        'redirect' => base_url('user/profile')
                    ];
                } else {
                    $params = [
                        'type' => 'result',
                        'status' => false,
                        'msg' => 'Account is not active'
                    ];
                }
            } else {
                $params = [
                    'type' => 'result',
                    'status' => false,
                    'msg' => 'Invalid Password'
                ];
            }
        } else {
            $params = [
                'type' => 'result',
                'status' => false,
                'msg' => 'Invalid Email'
            ];
        }

        echo json_encode($params);
    }


    public function register()
    {
        $this->load->view('auth/register');
    }

    public function validation_mahasiswa()
    {
        cek_ajax();
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('nim', 'NIM', 'required|trim|is_unique[user.nim]');
        $this->form_validation->set_rules('alamat', 'Alamat Mahasiswa', 'required');
        $this->form_validation->set_rules('instansi_magang', 'Instansi Magang', 'required');
        $this->form_validation->set_rules('alamat_magang', 'Alamat Magang', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[user.email]');
        $this->form_validation->set_rules('new_pass', 'Password Baru', 'required|trim|min_length[5]|matches[repeat_pass]');
        $this->form_validation->set_rules('repeat_pass', 'Ulangi Password Baru', 'required|trim|matches[new_pass]');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_nama_lengkap' => form_error('nama_lengkap'),
                'err_nim' => form_error('nim'),
                'err_alamat' => form_error('alamat'),
                'err_instansi_magang' => form_error('instansi_magang'),
                'err_alamat_magang' => form_error('alamat_magang'),
                'err_email' => form_error('email'),
                'err_new_pass' => form_error('new_pass'),
                'err_repeat_pass' => form_error('repeat_pass')
            ];
            echo json_encode($params);
        } else {
            $captcha = $this->captcha->validation_captcha($this->input->post('g-recaptcha-response'));
            if ($captcha['status'] === false) {
                $params = [
                    'status' => false,
                    'type' => 'result',
                    'msg' => $captcha['msg']
                ];
                echo json_encode($params);
                die;
            } else {
                $this->action_register_mahasiswa();
            }
        }
    }

    private function action_register_mahasiswa()
    {
        $token = md5(sha1(random_bytes(32)));
        $limit_token = substr($token, 0, 20);
        $data = [
            'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap')),
            'nim' => htmlspecialchars($this->input->post('nim')),
            'alamat' => $this->input->post('alamat'),
            'instansi_magang' => $this->input->post('instansi_magang'),
            'alamat_magang' => $this->input->post('alamat_magang'),
            'email' => htmlspecialchars($this->input->post('email')),
            'password' => md5(sha1($this->input->post('new_pass'))),
            'is_active' => 0,
            'id_role' => 3
        ];
        $data_mail = [
            'email' => htmlspecialchars($this->input->post('email')),
            'type' => 'verification',
            'token' => $limit_token,
            'create_at' => date('Y-m-d H:i:s')
        ];
        $to_send_email = [
            'name' => htmlspecialchars($this->input->post('nama_lengkap')),
            'email' => htmlspecialchars($this->input->post('email')),
            'link' => base_url('verify/') . urldecode($limit_token),
            'type' => 'verify'
        ];

        $this->db->trans_begin();
        $this->db->insert('user', $data);
        $this->db->insert('mail_send', $data_mail);
        $send_mail = $this->mail->send_mail($to_send_email);
        if ($this->db->trans_status() && $send_mail) {
            $this->db->trans_commit();
            $params = [
                'status' => true,
                'type' => 'result',
                'msg' => 'User baru berhasil di tambahkan',
                'redirect' => base_url('auth')
            ];
        } else {
            $this->db->trans_rollback();
            $params = [
                'status' => false,
                'type' => 'result',
                'msg' => 'User baru gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function validation_pembimbing()
    {

        cek_ajax();
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[user.email]');
        $this->form_validation->set_rules('alamat', 'Alamat Mahasiswa', 'required');
        $this->form_validation->set_rules('nama_bank', 'Nama Bank', 'required');
        $this->form_validation->set_rules('no_rekening', 'Nomor Rekening', 'required|trim|numeric');
        $this->form_validation->set_rules('instansi_magang', 'Instansi Magang', 'required');
        $this->form_validation->set_rules('alamat_magang', 'Alamat Magang', 'required');
        $this->form_validation->set_rules('new_pass', 'Password Baru', 'required|trim|min_length[5]|matches[repeat_pass]');
        $this->form_validation->set_rules('repeat_pass', 'Ulangi Password Baru', 'required|trim|matches[new_pass]');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_nama_lengkap' => form_error('nama_lengkap'),
                'err_email' => form_error('email'),
                'err_alamat' => form_error('alamat'),
                'err_nama_bank' => form_error('nama_bank'),
                'err_no_rekening' => form_error('no_rekening'),
                'err_instansi_magang' => form_error('instansi_magang'),
                'err_alamat_magang' => form_error('alamat_magang'),
                'err_new_pass' => form_error('new_pass'),
                'err_repeat_pass' => form_error('repeat_pass')
            ];
            echo json_encode($params);
        } else {
            $captcha = $this->captcha->validation_captcha($this->input->post('g-recaptcha-response'));
            if ($captcha['status'] === false) {
                $params = [
                    'status' => false,
                    'type' => 'result',
                    'msg' => $captcha['msg']
                ];
                echo json_encode($params);
                die;
            } else {
                $this->action_register_pembimbing();
            }
        }
    }

    private function action_register_pembimbing()
    {
        $token = md5(sha1(random_bytes(32)));
        $limit_token = substr($token, 0, 20);
        $data = [
            'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap')),
            'email' => htmlspecialchars($this->input->post('email')),
            'alamat' => $this->input->post('alamat'),
            'nama_bank' => $this->input->post('nama_bank'),
            'no_rekening' => $this->input->post('no_rekening'),
            'instansi_magang' => $this->input->post('instansi_magang'),
            'alamat_magang' => $this->input->post('alamat_magang'),
            'password' => md5(sha1($this->input->post('new_pass'))),
            'is_active' => 0,
            'id_role' => 9
        ];
        $data_mail = [
            'email' => htmlspecialchars($this->input->post('email')),
            'type' => 'verification',
            'token' => $limit_token,
            'create_at' => date('Y-m-d H:i:s')
        ];
        $to_send_email = [
            'name' => htmlspecialchars($this->input->post('nama_lengkap')),
            'email' => htmlspecialchars($this->input->post('email')),
            'link' => base_url('verify/') . urldecode($limit_token),
            'type' => 'verify'
        ];
        $this->db->trans_begin();
        $this->db->insert('user', $data);
        $this->db->insert('mail_send', $data_mail);
        $send_mail = $this->mail->send_mail($to_send_email);
        if ($this->db->trans_status() && $send_mail) {
            $this->db->trans_commit();
            $params = [
                'status' => true,
                'type' => 'result',
                'msg' => 'User baru berhasil di tambahkan',
                'redirect' => base_url('auth')
            ];
        } else {
            $this->db->trans_rollback();
            $params = [
                'status' => false,
                'type' => 'result',
                'msg' => 'User baru gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }

    public function verify($token = null)
    {
        if ($token) {
            $data = $this->db->get_where('mail_send', ['token' => $token, 'type' => 'verification'])->row();
            if ($data) {
                $this->db->trans_begin();
                $this->db->set('is_active', 1);
                $this->db->where('email', $data->email);
                $this->db->update('user');
                $this->db->delete('mail_send', ['email' => $data->email]);
                if ($this->db->trans_status()) {
                    $this->db->trans_commit();
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Akun berhasil di aktivasi, silahkan login
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');
                } else {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Akun gagal di aktivasi
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Data tidak ditemukan
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Token tidak valid
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>');
        }
        redirect(base_url('auth'));
    }

    public function forgot_password()
    {
        $this->load->view('auth/forgot_password');
    }

    public function verify_email()
    {
        cek_ajax();
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_email' => form_error('email')
            ];
            echo json_encode($params);
            die;
        } else {
            $email = $this->input->post('email');
            $captcha = $this->captcha->validation_captcha($this->input->post('g-recaptcha-response'));
            $get_user = $this->db->where('email', $email)->get('user')->num_rows();
            if ($captcha['status'] === false) {
                $params = [
                    'status' => false,
                    'type' => 'result',
                    'msg' => $captcha['msg']
                ];
                echo json_encode($params);
                die;
            } else {
                if ($get_user <= 0) {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Email tidak terdaftar'
                    ];
                    echo json_encode($params);
                    die;
                } else {
                    $this->to_verify_email();
                }
            }
        }
    }

    private function to_verify_email()
    {
        $email = $this->input->post('email');
        $data_user = $this->db->where('email', $email)->get('user')->row();

        $list_number = mt_rand(1, 999999);
        $random_number = sprintf("%06d", $list_number);
        $new_pass = md5(sha1($random_number));

        $data_mail = [
            'name' => $data_user->nama_lengkap,
            'email' => $email,
            'new_pass' => $random_number,
            'type' => 'forgot_password'
        ];


        $this->db->trans_start();
        $this->db->set('password', $new_pass)
            ->where('email', $email)
            ->update('user');
        $send_mail = $this->mail->send_mail($data_mail);


        if ($this->db->trans_status() == true && $send_mail == true) {
            $params = [
                'status' => true,
                'type' => 'result',
                'msg' => 'Email verifikasi berhasil di kirim',
                'redirect' => base_url('auth')
            ];
            $this->db->trans_commit();
        } else {
            $params = [
                'status' => false,
                'type' => 'result',
                'msg' => 'Email verifikasi gagal di kirim'
            ];
            $this->db->trans_rollback();
        }

        json_output(200, $params);
    }
}
