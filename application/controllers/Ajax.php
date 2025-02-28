<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Ajax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function validation_role()
    {
        cek_ajax();
        $act = $this->input->post('act');
        if ($act == 'add') {
            $this->form_validation->set_rules('role', 'Nama Role', 'required|trim|is_unique[user_role.nama]');
            if ($this->form_validation->run() == false) {
                $params = [
                    'type' => 'validation',
                    'err_role' => form_error('role')
                ];
                echo json_encode($params);
                die;
            } else {
                $this->to_action_role();
            }
        } else if ($act == 'edit') {
            $role = htmlspecialchars($this->input->post('role'));
            $id = $this->input->post('id');
            $get_role = $this->db->get_where('user_role', ['nama' => $role, 'id !=' => $id])->num_rows();
            if ($get_role > 0) {
                $params = [
                    'type' => 'validation',
                    'err_role' => 'Nama Role is already available'
                ];
                echo json_encode($params);
                die;
            } else {
                $this->to_action_role();
            }
        } else {
            $params = [
                'type' => 'result',
                'status' => false,
                'msg' => 'Error to action data'
            ];
            echo json_encode($params);
        }
    }

    private function to_action_role()
    {
        $act = htmlspecialchars($this->input->post('act'));
        $role = htmlspecialchars($this->input->post('role'));
        switch ($act) {
            case 'add':
                $data = ['nama' => $role];
                $this->db->insert('user_role', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'type' => 'result',
                        'status' => true,
                        'msg' => 'Role baru berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'type' => 'result',
                        'status' => false,
                        'msg' => 'Role baru gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
                break;
            case 'edit':
                $id = htmlspecialchars($this->input->post('id'));
                $this->db->set('nama', $role)->where('id', $id)->update('user_role');
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'type' => 'result',
                        'status' => true,
                        'msg' => 'Role berhasil di edit'
                    ];
                } else {
                    $params = [
                        'type' => 'result',
                        'status' => false,
                        'msg' => 'Role gagal di edit'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }

    public function delete_role()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('user_role');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Role berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Role gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function validation_user()
    {
        cek_ajax();
        $user = get_user();
        $act = $this->input->post('act');
        if ($act == 'add') {
            $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[user.email]');
            $this->form_validation->set_rules('new_pass', 'Password Baru', 'required|trim|min_length[5]|matches[repeat_pass]');
            $this->form_validation->set_rules('repeat_pass', 'Ulangi Password Baru', 'required|trim|matches[new_pass]');

            if ($this->form_validation->run() == false) {
                $params = [
                    'type' => 'validation',
                    'err_nama_lengkap' => form_error('nama_lengkap'),
                    'err_email' => form_error('email'),
                    'err_new_pass' => form_error('new_pass'),
                    'err_repeat_pass' => form_error('repeat_pass')
                ];
                echo json_encode($params);
            } else {
                $this->to_action_user($user, $act);
            }
        } else if ($act == 'edit') {
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
                $email = htmlspecialchars($this->input->post('email'));
                $id = $this->input->post('id');
                $get_user = $this->db->get_where('user', ['email' => $email, 'id !=' => $id])->num_rows();
                if ($get_user > 0) {
                    $params = [
                        'type' => 'validation',
                        'err_email' => 'email is already available'
                    ];
                } else {
                    $this->to_action_user($user, $act);
                }
            }
        } else if ($act == 'change_pass') {
            $this->form_validation->set_rules('pass_old', 'Old Password', 'required|trim');
            $this->form_validation->set_rules('pass_new', 'New Password', 'required|trim|min_length[5]|matches[pass_repeat]');
            $this->form_validation->set_rules('pass_repeat', 'Repeat New Password', 'required|trim|matches[pass_new]');

            if ($this->form_validation->run() == false) {
                $params = [
                    'type' => 'validation',
                    'err_pass_old' => form_error('pass_old'),
                    'err_pass_new' => form_error('pass_new'),
                    'err_pass_repeat' => form_error('pass_repeat')
                ];
                echo json_encode($params);
                die;
            } else {
                $id = $this->input->post('id_change');
                $get_user = $this->db->get_where('user', ['id' => $id])->row();
                $get_pass_old = $get_user->password;
                $old_pass = md5(sha1($this->input->post('pass_old')));
                $new_pass = md5(sha1($this->input->post('pass_new')));

                if ($get_pass_old == $old_pass) {
                    if ($get_pass_old != $new_pass) {
                        $this->to_change_password();
                    } else {
                        $params = [
                            'type' => 'validation',
                            'err_pass_new' => 'The new password cannot be the same as the old password'
                        ];
                        echo json_encode($params);
                        die;
                    }
                } else {
                    $params = [
                        'type' => 'validation',
                        'err_pass_old' => 'Wrong Old Password'
                    ];
                    echo json_encode($params);
                    die;
                }
            }
        } else {
            $params = [
                'status' => false,
                'type' => 'result',
                'msg' => 'Invalid action'
            ];
            echo json_encode($params);
            die;
        }
    }

    private function to_action_user($user, $act)
    {
        switch ($act) {
            case 'add':
                $data = [
                    'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap')),
                    'nim' => htmlspecialchars($this->input->post('nim')),
                    'alamat' => $this->input->post('alamat'),
                    'instansi_magang' => $this->input->post('instansi_magang'),
                    'alamat_magang' => $this->input->post('alamat_magang'),
                    'email' => htmlspecialchars($this->input->post('email')),
                    'password' => md5(sha1($this->input->post('new_pass'))),
                    'is_active' => 1,
                    'id_role' => $this->input->post('id_role')
                ];
                $this->db->insert('user', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'User baru berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'User baru gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
                break;
            case 'edit':
                $id = $this->input->post('id');
                $data = [
                    'nama_lengkap' => htmlspecialchars($this->input->post('nama_lengkap')),
                    'nim' => htmlspecialchars($this->input->post('nim')),
                    'alamat' => $this->input->post('alamat'),
                    'instansi_magang' => $this->input->post('instansi_magang'),
                    'alamat_magang' => $this->input->post('alamat_magang'),
                    'email' => htmlspecialchars($this->input->post('email')),
                    'password' => md5(sha1($this->input->post('new_pass'))),
                    'is_active' => 1,
                    'id_role' => $this->input->post('id_role')
                ];
                $this->db->where('id', $id)->update('user', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'User berhasil di edit'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'User gagal di edit'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }

    public function action_user()
    {
        cek_ajax();
        $act = $this->input->post('act');
        switch ($act) {
            case 'status':
                $id = $this->input->post('id');
                $data = [
                    'is_active' => htmlspecialchars($this->input->post('status'))
                ];
                $this->db->where('id', $id)->update('user', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Status user berhasil di ubah'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Status user gagal di ubah'
                    ];
                }
                echo json_encode($params);
                break;
            case 'delete':
                $id = $this->input->post('id');
                $this->db->where('id', $id)->delete('user');
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Data user berhasil di hapus'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Data user gagal di hapus'
                    ];
                }
                echo json_encode($params);
                break;
        }
    }

    public function datatable_user()
    {
        cek_ajax();
        $get = $this->input->get();

        $data_user = $this->master->get_user_datatable();
        $data = array();
        $i = 1;
        foreach ($data_user as $du) {
            $delete = 'delete';
            $status = 'status';
            $row = array();
            if ($du->is_active == 1) {
                $status_user = '<span class="badge bg-success">Aktif</span>';
            } else {
                $status_user = '<span class="badge bg-danger">Nonaktif</span>';
            }
            if ($du->instansi_magang) {
                $tempat_magang = $du->instansi_magang;
            } else {
                $tempat_magang = '';
            }
            if ($du->is_active == 1) {
                $status = '<a class="dropdown-item" href="#" onclick="action_status(0, \'' . $du->id . '\', \'' . $status . '\')">Nonaktifkan</a>';
            } else {
                $status = '<a class="dropdown-item" href="#" onclick="action_status(1, \'' . $du->id . '\', \'' . $status . '\')">Aktifkan</a>';
            }
            $row[] = $this->security->xss_clean($i);
            $row[] = $this->security->xss_clean($du->nama_lengkap);
            $row[] = $this->security->xss_clean($du->email);
            $row[] = $this->security->xss_clean($tempat_magang);
            $row[] = $this->security->xss_clean($du->nama_role);
            $row[] = $status_user;
            $row[] = '
            <div class="dropdown dropleft">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
				<div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="detail_user(\'' . $du->id . '\')">Detail</a>
                <a class="dropdown-item" href="#" onclick="change_pass(\'' . $du->id . '\')">Ganti Password</a>
                ' . $status . '
                <a class="dropdown-item" href="#" onclick="action_status(0, \'' . $du->id . '\', \'' . $delete . '\')">Hapus</a>
										
                </div>
			</div>';
            $data[] = $row;

            $i++;
        }
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->master->count_all_datatable_user(),
            "recordsFiltered" => $this->master->count_filtered_datatable_user(),
            "data" => $data,
        );
        echo json_encode($result);
    }

    public function detail_user()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $get_user = $this->master->get_detail_user($id)->row();
        echo json_encode($get_user);
        die;
    }

    public function validation_pass_user()
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
        $new_pass  = md5(sha1($this->input->post('pass_new')));
        $id = $this->input->post('id_change');
        $this->db->set('password', $new_pass)->where('id', $id)->update('user');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'type' => 'result',
                'status' => true,
                'msg' => 'Password berhasil di perbarui'
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

    public function validation_menu()
    {
        cek_ajax();
        get_user();
        $this->form_validation->set_rules('label', 'Label', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('url', 'URL', 'required|trim');
        $this->form_validation->set_rules('icon', 'Icon', 'required|trim');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_label' => form_error('label'),
                'err_url' => form_error('url'),
                'err_icon' => form_error('icon')
            ];
            echo json_encode($params);
            die;
        } else {
            $this->to_action_menu();
        }
    }

    private function to_action_menu()
    {
        $act = $this->input->post('act');
        switch ($act) {
            case 'add':
                $data = [
                    'label' => htmlspecialchars($this->input->post('label')),
                    'url' => htmlspecialchars($this->input->post('url')),
                    'icon' => $this->input->post('icon'),
                    'type' => $this->input->post('type'),
                    'parent' => $this->input->post('parent'),
                    'status' => 1
                ];
                $this->db->insert('menu', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Menu baru berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Menu baru gagal di tambahkan'
                    ];
                }
                echo json_encode($params);
                break;
            case 'edit':
                $id = $this->input->post('id');

                $data = [
                    'label' => htmlspecialchars($this->input->post('label')),
                    'url' => htmlspecialchars($this->input->post('url')),
                    'icon' => $this->input->post('icon'),
                    'type' => $this->input->post('type'),
                    'parent' => $this->input->post('parent'),
                ];
                $this->db->where('id', $id)->update('menu', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'type' => 'result',
                        'msg' => 'Menu berhasil di edit'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'type' => 'result',
                        'msg' => 'Menu gagal di edit'
                    ];
                }


                echo json_encode($params);
                break;
        }
    }

    public function detail_menu()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $get_user = $this->db->get_where('menu', ['id' => $id])->row();
        echo json_encode($get_user);
        die;
    }

    public function delete_menu()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('menu');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Menu berhasil di hapus'
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Menu gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function get_form_menu()
    {
        cek_ajax();
        get_user();
        $data['role'] = $this->input->post('role');
        $data['menu'] = $this->db->where(['type !=' => 3, 'status' => 1])->get('menu')->result();
        $this->load->view('ajax/show_form_access_menu', $data);
    }

    public function update_access_menu()
    {
        cek_ajax();
        get_user();
        $id_role = $this->input->post('role');
        $menu = $this->input->post('check');
        if (!$menu) {
            $params = [
                'status' => false,
                'msg' => 'Harap pilih menu'
            ];
        } else {
            $jml_menu = count($menu);
            $insert_data = [];
            for ($i = 0; $i < $jml_menu; $i++) {
                array_push($insert_data, array(
                    'id_role' => $id_role,
                    'id_menu' => $menu[$i]
                ));
            }


            $this->db->trans_begin();
            $this->db->where('id_role', $id_role)->delete('menu_access');
            $this->db->insert_batch('menu_access', $insert_data);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $params = [
                    'status' => false,
                    'msg' => 'Akses menu gagal di perbarui'
                ];
            } else {
                $this->db->trans_commit();
                $params = [
                    'status' => true,
                    'msg' => 'Akses menu berhasil di perbarui'
                ];
            }
        }
        echo json_encode($params);
    }
    public function act_periode()
    {
        cek_ajax();
        $id = htmlspecialchars($this->input->post('id'));
        $act = htmlspecialchars($this->input->post('act'));
        $periode = htmlspecialchars($this->input->post('periode'));

        switch ($act) {
            case 'add':
                $data = [
                    'periode' => $periode,
                    'create_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('periode', $data);
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Periode baru berhasil di tambahkan'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Periode baru gagal di tambahkan'
                    ];
                }
                json_output(200, $params);
                break;
            case 'edit':
                $this->db->set('periode', $periode)->where('md5(id)', $id)->update('periode');
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Periode berhasil di edit'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Periode gagal di edit'
                    ];
                }
                json_output(200, $params);
                break;
            case 'delete':
                $this->db->where('md5(id)', $id)->delete('periode');
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Periode berhasil di hapus'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Periode gagal di hapus'
                    ];
                }
                json_output(200, $params);
                break;
            default:
                $params = [
                    'status' => false,
                    'msg' => 'Invalid parameters'
                ];
                json_output(200, $params);
                break;
        }
    }

    //group
    public function master_pemlap()
    {
        cek_ajax();
        $id = $this->input->post('id');
        $act = htmlspecialchars($this->input->post('act'));
        $status = htmlspecialchars($this->input->post('status'));

        switch ($act) {
            case 'delete':
                $this->db->where('md5(id)', $id)->delete('user');
                if ($this->db->affected_rows() > 0) {
                    $params = [
                        'status' => true,
                        'msg' => 'Data berhasil di hapus'
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Data gagal di hapus'
                    ];
                }
                json_output(200, $params);
                break;
            case 'status':
                if ($status == 0 || $status == 1) {
                    $this->db->set('is_active', $status)->where('md5(id)', $id)->update('user');
                    if ($this->db->affected_rows() > 0) {
                        $params = [
                            'status' => true,
                            'msg' => 'Status berhasil di ubah'
                        ];
                    } else {
                        $params = [
                            'status' => false,
                            'msg' => 'Status gagal di ubah'
                        ];
                    }
                } else {
                    $params = [
                        'status' => false,
                        'msg' => 'Status is invalid'
                    ];
                }
                json_output(200, $params);
                break;
            default:
                $params = [
                    'status' => false,
                    'msg' => 'Action is invalid'
                ];
                json_output(200, $params);

                break;
        }
    }

    public function list_mahasiswa_group()
    {
        cek_ajax();
        $selected = $this->input->post('selected');
        $get_data = $this->model->get_mhs_table(3, $selected);
        $i = 1;
        $data = [];
        foreach ($get_data as $gd) {
            $row = [];

            $row[] = $i++;
            $row[] = $gd->nim;
            $row[] = $gd->nama_lengkap;
            $row[] = $gd->email;
            $row[] = '<button class="btn btn-sm btn-success" onclick="select_mhs(\'' . $gd->id . '\', \'' . $gd->nim . '\', \'' . $gd->nama_lengkap . '\',  \'' . $gd->email . '\')" type="button" ><i class="far fa-check-circle"></i></button>';

            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->filtered_mhs_table(3, $selected),
            "recordsFiltered" => $this->model->count_mhs_table(3, $selected),
            "data" => $data,
        ];
        json_output(200, $output);
    }

    public function list_pemlap_group()
    {
        cek_ajax();
        $selected = $this->input->post('selected');
        $get_data = $this->model->get_mhs_table(9, $selected);
        $data = [];
        foreach ($get_data as $gd) {
            $row = [];

            $row[] = $gd->nama_lengkap;
            $row[] = $gd->email;
            $row[] = $gd->instansi_magang;
            $row[] = $gd->alamat_magang;
            $row[] = '<button class="btn btn-sm btn-success" onclick="select_pemlap(\'' . $gd->id . '\',  \'' . $gd->nama_lengkap . '\',  \'' . $gd->email . '\',  \'' . $gd->instansi_magang . '\', \'' . $gd->alamat_magang . '\')" type="button" ><i class="far fa-check-circle"></i></button>';

            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->filtered_mhs_table(3, $selected),
            "recordsFiltered" => $this->model->count_mhs_table(3, $selected),
            "data" => $data,
        ];
        json_output(200, $output);
    }

    public function validation_group()
    {
        cek_ajax();
        $id = $this->input->post('id');
        $act = $this->input->post('act');

        $group_name = htmlspecialchars($this->input->post('name'));
        $periode = htmlspecialchars($this->input->post('periode'));
        $dospem = htmlspecialchars($this->input->post('dospem'));

        $mahasiswa = $this->input->post('mahasiswa');
        $pemlap = $this->input->post('pemlap');




        if (isset($mahasiswa) && isset($pemlap) && $group_name && $periode && $dospem) {
            $c_mhs = count($mahasiswa);
            $c_pemlap = count($pemlap);

            switch ($act) {
                case 'add':
                    $new_id = time();
                    $data_pemlap = [];
                    $data_mahasiswa = [];

                    for ($a = 0; $a < $c_mhs; $a++) {
                        $row = [
                            'id_group' => $new_id,
                            'id_user' => $mahasiswa[$a]
                        ];
                        $data_mahasiswa[] = $row;
                    }
                    for ($b = 0; $b < $c_pemlap; $b++) {
                        $row = [
                            'id_group' => $new_id,
                            'id_user' => $pemlap[$b]
                        ];
                        $data_pemlap[] = $row;
                    }

                    $insert_data = [
                        'id' => $new_id,
                        'nama_group' => $group_name,
                        'id_dosen' => $dospem,
                        'id_periode' => $periode,
                        'create_at' => date('Y-m-d H:i:s'),
                        'last_update' => date('Y-m-d H:i:s'),
                    ];

                    $this->db->trans_begin();
                    $this->db->insert('tbl_group', $insert_data);
                    $this->db->insert_batch('group_mahasiswa', $data_mahasiswa);
                    $this->db->insert_batch('group_pemlap', $data_pemlap);

                    if ($this->db->trans_status() === FALSE) {
                        $this->db->trans_rollback();
                        $params = [
                            'status' => false,
                            'msg' => 'Data group gagal di tambahkan'
                        ];
                    } else {
                        $this->db->trans_commit();
                        $params = [
                            'status' => true,
                            'msg' => 'Data group berhasil di tambahkan'
                        ];
                    }
                    json_output(200, $params);
                    break;
                default:
                    $params = [
                        'status' => false,
                        'msg' => 'Invalid action'
                    ];
                    json_output(200, $params);
                    break;
            }
        } else {
            $params = [
                'status' => false,
                'msg' => 'Harap isi semua inputan'
            ];
            json_output(200, $params);
        }
    }

    public function table_group()
    {
        cek_ajax();
        $periode = $this->input->post('periode');
        $get_data = $this->model->get_group($periode);
        $data = [];
        $i = 1;
        foreach ($get_data as $gd) {
            $row = [];

            $row[] = $i++;
            $row[] = $gd->nama_group;
            $row[] = $gd->periode;
            $row[] = $gd->nama_lengkap;
            $row[] = '
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="detail_data(\'' . $gd->id . '\')">Detail</a></li>
                        <li><a class="dropdown-item" href="#" onclick="edit_data(\'' . $gd->id . '\')">Edit</a></li>
                        <li><a class="dropdown-item" href="#" onclick="delete_data(\'' . $gd->id . '\')">Hapus</a></li>
                    </ul>
                </div>
            ';

            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model->filtered_mhs_table($periode),
            "recordsFiltered" => $this->model->count_mhs_table($periode),
            "data" => $data,
        ];
        json_output(200, $output);
    }

    public function act_group()
    {
        cek_ajax();
        $id = htmlspecialchars($this->input->post('id'));
        $act = $this->input->post('act');
        switch($act){
            case 'detail':
                $get_data = $this->model->get_group_row($id)->result();
                $mahasiswa = $this->model->detail_people_group($id, 3)->result();
                $pemlap = $this->model->detail_people_group($id, 9)->result();

                $data_output = [
                    'main_data'     => $get_data,
                    'mahasiswa'     => $mahasiswa,
                    'pemlap'        => $pemlap
                ];

                json_output(200, $data_output);
                break;
            case 'delete':
                $this->db->trans_begin();
                $this->db->delete('group_mahasiswa', ['id_group' => $id]);
                $this->db->delete('group_pemlap', ['id_group' => $id]);
                $this->db->delete('tbl_group', ['id' => $id]);

                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $params = [
                        'status' => false,
                        'msg' => 'Group gagal di hapus'
                    ];
                } else {
                    $this->db->trans_commit();
                    $params = [
                        'status' => true,
                        'msg' => 'Group berhasil di hapus'
                    ];
                }
                json_output(200, $params);
                break;
        }
    }
    public function daftar_mahasiswa()
    {
        cek_ajax();
        $this->load->view('auth/form_mahasiswa');
    }
    public function daftar_pembimbing()
    {
        cek_ajax();
        $this->load->view('auth/form_pemlap');
    }
    public function datatable_pengumuman()
    {
        cek_ajax();
        $get = $this->input->get();

        $data_pengumuman = $this->pengumuman->get_pengumuman_datatable();
        $data = array();
        $i = 1;
        foreach ($data_pengumuman as $dp) {
            $delete = 'delete';
            $row = array();

            $row[] = $this->security->xss_clean($i);
            $row[] = $this->security->xss_clean($dp->judul);
            $row[] = $this->security->xss_clean($dp->nama_lengkap);
            $row[] = $this->security->xss_clean($dp->nama_role);
            $row[] = $this->security->xss_clean(tgl_indo($dp->created_at));
            $row[] = '
            <div class="dropdown dropleft">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
				<div class="dropdown-menu">
                <a class="dropdown-item" href="#" onclick="detail_data( \'' . $dp->id_pengumuman . '\')">Detail</a>
                <a class="dropdown-item" href="' . site_url('pengumuman/edit/' . $dp->id_pengumuman) . '">Edit</a>
                <a class="dropdown-item" href="#" onclick="delete_pengumuman(' . $dp->id_pengumuman . ')">Hapus</a>			
                </div>
			</div>';
            $data[] = $row;

            $i++;
        }
        $result = array(
            "draw" => $get['draw'],
            "recordsTotal" => $this->pengumuman->count_all_datatable_pengumuman(),
            "recordsFiltered" => $this->pengumuman->count_filtered_datatable_pengumuman(),
            "data" => $data,
        );
        echo json_encode($result);
    }
    public function detail_pengumuman()
    {
        cek_ajax();
        get_user();
        $id = $this->input->post('id');
        $data = $this->pengumuman->get_detail_pengumuman($id)->row();

        $get_pengumuman = ' 
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Judul</label>
                <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="' . $data->judul . '">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Isi Pengumuman</label>
                <div class="col-sm-10">
                 <textarea class="form-control" disabled>' . $data->isi . '</textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Pembuat</label>
                <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="' . $data->nama_lengkap . '">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Untuk</label>
                <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="' . $data->nama_role . '">
                </div>
            </div>';

        echo $get_pengumuman;
    }
}