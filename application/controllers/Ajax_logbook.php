<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Ajax_logbook extends CI_Controller
{
    public function validation_mhs()
    {
        cek_ajax();
        $file = $_FILES['file'];
        $follow_kegiatan = htmlspecialchars($this->input->post('mengikuti_kegiatan'));
        $kegiatan = htmlspecialchars($this->input->post('kegiatan'));
        $aktivitas = htmlspecialchars($this->input->post('aktivitas'));
        $solusi = htmlspecialchars($this->input->post('solusi'));
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        if ($file && $follow_kegiatan && $kegiatan && $aktivitas && $solusi) {


            $new_filename = 'mhs-' . date('d-m-Y') . '-' . date('s') . '-' . time();
            $config['upload_path']          = './assets/logbook/mhs/';
            $config['allowed_types']        = 'pdf|doc|docx|png|jpg|jpeg|png';
            $config['max_size']             = 2000;
            $config['file_name']            = $new_filename;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $uploaded_file = [
                    'file_path' => $this->upload->data('full_path'),
                    'file_name' => $this->upload->data('file_name'),
                    'file_ext' => $this->upload->data('file_ext'),
                    'file_size' => $this->upload->data('file_size')
                ];
                return $this->mhs_add_logbook($uploaded_file);
            } else {
                $params = [
                    'status' => false,
                    'msg' => $this->upload->display_errors()
                ];
            }
        } else {
            $params = [
                'status' => false,
                'msg' => 'Harap semua inputan'
            ];
        }
        json_output(200, $params);
    }

    private function mhs_add_logbook($file)
    {
        $input_post = $this->input->post(null, true);
        $user = get_user();
        $jadwal = [
            'start' => htmlspecialchars($input_post['start_date']),
            'end' => htmlspecialchars($input_post['end_date'])
        ];
        $log = [
            [
                'date' => date('Y-m-d H:i:s'),
                'desc' => 'Berhasil menambahkan log baru'
            ]
        ];

        $data = [
            'id_user' => $user->id_user,
            'jadwal' => json_encode($jadwal),
            'mengikuti' => htmlspecialchars($input_post['mengikuti_kegiatan']),
            'jenis_kegiatan' => htmlspecialchars($input_post['kegiatan']),
            'uraian_kegiatan' => $input_post['aktivitas'],
            'hasil' => $input_post['solusi'],
            'file_tugas' => json_encode($file),
            'status' => 2,
            'ctt' => '[]',
            'create_at' => date('Y-m-d H:i:s'),
            'last_update' => date('Y-m-d H:i:s'),
            'log_activity' => json_encode($log)
        ];

        $this->db->insert('log_mahasiswa', $data);
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Log baru berhasil di tambahkan',
                'redirect' => base_url('mhs/my-logbook')
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Log baru gagal di tambahkan'
            ];
        }

        json_output(200, $params);
    }

    public function mhs_load_logbook()
    {
        cek_ajax();
        $get_data = $this->logbook->get_mhs_logbook();

        $data = [];
        $i = 1;
        foreach ($get_data as $gd) {
            $decode_jadwal = json_decode($gd->jadwal);
            $create_start = date_create($decode_jadwal->start);
            $create_end = date_create($decode_jadwal->end);

            if ($gd->status == 1) {
                $status = '<span class="badge text-bg-success">Tervalidasi</span>';
            } else if ($gd->status == 11) {
                $status = '<span class="badge text-bg-warning">Menunggu Konfirmasi Dosen</span>';
            } else if ($gd->status == 9) {
                $status = '<span class="badge text-bg-danger">Ditolak Dosen</span>';
            } else if ($gd->status == 99) {
                $status = '<span class="badge text-bg-danger">Ditolak Pemlap</span>';
            } else if ($gd->status == 2) {
                $status = '<span class="badge text-bg-warning">Menunggu Konfirmasi Pemlap</span>';
            } else {
                $status = '<span class="badge text-bg-secondary">Unknow</span>';
            }


            if ($gd->mengikuti == 'Iya') {
                $kegiatan = '<span class="badge text-bg-success">Mengikuti</span>';
            } else {
                $kegiatan = '<span class="badge text-bg-danger">Tidak Mengikuti</span>';
            }


            if ($gd->status == 9 || $gd->status == 99) {
                $update_link = '<li><a class="dropdown-item" href="' . base_url('mhs/update-mylogbook/') . sha1($gd->id) . '">Edit</a></li>';
            } else {
                $update_link = '';
            }

            $row = [];

            $row[] = $i++;
            $row[] = date_format($create_start, 'd F Y') . ' - ' . date_format($create_end, 'd F Y');
            $row[] = $kegiatan;
            $row[] = $gd->jenis_kegiatan;
            $row[] = $status;
            $row[] = '
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="' . base_url('mhs/my-logbook/') . sha1($gd->id) . '">Detail</a></li>
                        <li><a class="dropdown-item" href="#" onclick="detail_log(\'' . sha1($gd->id) . '\')">Log</a></li>
                        ' . $update_link . '    
                    </ul>
                </div>
            ';


            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->logbook->count_mhs_logbook(),
            "recordsFiltered" => $this->logbook->getfilter_mhs_logbook(),
            "data" => $data,
        ];
        json_output(200, $output);
    }

    public function mhs_edit_logbook()
    {
        cek_ajax();
        $file = $_FILES['file'];
        $id = htmlspecialchars($this->input->post('id'));
        $follow_kegiatan = htmlspecialchars($this->input->post('mengikuti_kegiatan'));
        $kegiatan = htmlspecialchars($this->input->post('kegiatan'));
        $aktivitas = htmlspecialchars($this->input->post('aktivitas'));
        $solusi = htmlspecialchars($this->input->post('solusi'));
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');

        if ($id && $follow_kegiatan && $kegiatan && $aktivitas && $solusi) {
            $old_data = $this->db->where('sha1(id)', $id)->get('log_mahasiswa')->row();
            $decode_file = json_decode($old_data->file_tugas);
            $old_file = $decode_file->file_name;

            if ($file) {
                $new_filename = 'mhs-' . date('d-m-Y') . '-' . date('s') . '-' . time();
                $config['upload_path']          = './assets/logbook/mhs/';
                $config['allowed_types']        = 'pdf|doc|docx|png|jpg|jpeg|png';
                $config['max_size']             = 2000;
                $config['file_name']            = $new_filename;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $uploaded_file = [
                        'file_path' => $this->upload->data('full_path'),
                        'file_name' => $this->upload->data('file_name'),
                        'file_ext' => $this->upload->data('file_ext'),
                        'file_size' => $this->upload->data('file_size')
                    ];
                } else {
                    $params = [
                        'status' => false,
                        'msg' => $this->upload->display_errors()
                    ];
                    echo json_encode($params);
                    die;
                }
            } else {
                $uploaded_file = $decode_file;
            }
        } else {
            $params = [
                'status' => false,
                'msg' => 'Harap semua inputan'
            ];
            echo json_encode($params);
            die;
        }

        $this->pv_mhs_edit_logbook($old_data, $uploaded_file);
    }

    private function pv_mhs_edit_logbook($old_data, $file)
    {
        $input_post = $this->input->post(null, true);



        $jadwal = [
            'start' => htmlspecialchars($input_post['start_date']),
            'end' => htmlspecialchars($input_post['end_date'])
        ];
        $log = [
            'date' => date('Y-m-d H:i:s'),
            'desc' => 'Logbook sudah di update'
        ];

        $new_log = $this->logbook->update_changelog($old_data->log_activity, $log);

        $data = [
            'jadwal' => json_encode($jadwal),
            'mengikuti' => htmlspecialchars($input_post['mengikuti_kegiatan']),
            'jenis_kegiatan' => htmlspecialchars($input_post['kegiatan']),
            'uraian_kegiatan' => $input_post['aktivitas'],
            'hasil' => $input_post['solusi'],
            'file_tugas' => json_encode($file),
            'status' => 2,
            'last_update' => date('Y-m-d H:i:s'),
            'log_activity' => json_encode($new_log)
        ];

        $this->db->where('sha1(id)', $input_post['id'])->update('log_mahasiswa', $data);
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Logbook berhasil di update',
                'redirect' => base_url('mhs/my-logbook')
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Logbook gagal di update'
            ];
        }

        json_output(200, $params);
    }

    public function mhs_show_log()
    {
        cek_ajax();
        $id = $this->input->post('id');
        $data_log = $this->db->get_where('log_mahasiswa', ['sha1(id)' => $id])->row();
        if ($data_log) {
            $decode_log = json_decode($data_log->log_activity);

            $params = [
                'status' => true,
                'data' => $decode_log
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Data not found'
            ];
        }
        json_output(200, $params);
    }


    //list logbook mahasiswa untuk pemlap,dosen,&super admin
    public function get_list_mahasiswa()
    {
        cek_ajax();
        $user = get_user();

        if ($user->id_role == 1) {
            $dosen = $this->input->post('dosen');
            $periode = $this->input->post('periode');
            $group = null;
            $pemlap = null;
        } else if ($user->id_role == 2) {
            $dosen = $user->id_user;
            $periode = $this->input->post('periode');
            $group = $this->input->post('group');
            $pemlap = null;
        } else if ($user->id_role == 9) {
            $dosen = null;
            $periode = $this->input->post('periode');
            $group = $this->input->post('group');
            $pemlap = $user->id_user;
        }

        $get_data = $this->logbook->get_list_mahasiswa($group, $periode, $dosen, $pemlap);
        $data = [];
        $i = 1;
        foreach ($get_data as $gd) {
            $row = [];
            $row[] = $i++;
            $row[] = $gd->nim;
            $row[] = $gd->nama_lengkap;
            $row[] = '<a href="' . base_url('logbook-mahasiswa/list/') . sha1($gd->id) . '" class="btn btn-sm btn-secondary">List Logbook</a>';
            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->logbook->count_list_mahasiswa($group, $periode, $dosen, $pemlap),
            "recordsFiltered" => $this->logbook->getlist_filtered_mahasiswa($group, $periode, $dosen, $pemlap),
            "data" => $data,
        ];
        json_output(200, $output);
    }

    public function load_tbl_list_logbook()
    {
        cek_ajax();
        $id = htmlspecialchars($this->input->post('id'));

        $get_data = $this->logbook->get_mhs_logbook($id);

        $data = [];
        $i = 1;
        foreach ($get_data as $gd) {
            $decode_jadwal = json_decode($gd->jadwal);
            $create_start = date_create($decode_jadwal->start);
            $create_end = date_create($decode_jadwal->end);

            if ($gd->status == 1) {
                $status = '<span class="badge text-bg-success">Tervalidasi</span>';
            } else if ($gd->status == 11) {
                $status = '<span class="badge text-bg-warning">Menunggu Konfirmasi Dosen</span>';
            } else if ($gd->status == 9) {
                $status = '<span class="badge text-bg-danger">Ditolak Dosen</span>';
            } else if ($gd->status == 99) {
                $status = '<span class="badge text-bg-danger">Ditolak Pemlap</span>';
            } else if ($gd->status == 2) {
                $status = '<span class="badge text-bg-warning">Menunggu Konfirmasi Pemlap</span>';
            } else {
                $status = '<span class="badge text-bg-secondary">Unknow</span>';
            }


            if ($gd->mengikuti == 'Iya') {
                $kegiatan = '<span class="badge text-bg-success">Mengikuti</span>';
            } else {
                $kegiatan = '<span class="badge text-bg-danger">Tidak Mengikuti</span>';
            }

            $row = [];

            $row[] = $i++;
            $row[] = date_format($create_start, 'd F Y') . ' - ' . date_format($create_end, 'd F Y');
            $row[] = $kegiatan;
            $row[] = $gd->jenis_kegiatan;
            $row[] = $status;
            $row[] = '
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a target="_blank" class="dropdown-item" href="' . base_url('logbook-mahasiswa/detail/') . sha1($gd->id) . '">Detail</a></li>
                        <li><a class="dropdown-item" href="#" onclick="detail_log(\'' . sha1($gd->id) . '\')">Log</a></li>
                    </ul>
                </div>
            ';


            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->logbook->count_mhs_logbook($id),
            "recordsFiltered" => $this->logbook->getfilter_mhs_logbook($id),
            "data" => $data,
        ];
        json_output(200, $output);
    }

    public function act_logbook()
    {
        cek_ajax();
        $id = htmlspecialchars($this->input->post('id'));
        $act = htmlspecialchars($this->input->post('act'));
        $notes = htmlspecialchars($this->input->post('notes'));
        $user = get_user();

        if ($user->id_role == 2) {
            if ($act == 1) {
                $new_status = 1;
            } else {
                $new_status = 9;
            }

            $data_log_activity = [
                'date' => date('Y-m-d H:i:s'),
                'desc' => 'Di setujui oleh Dosen',
            ];
            $role = 'Dosen';
        } else if ($user->id_role == 9) {
            if ($act == 1) {
                $new_status = 11;
            } else {
                $new_status = 99;
            }

            $data_log_activity = [
                'date' => date('Y-m-d H:i:s'),
                'desc' => 'Di setujui oleh Pemlap',
            ];
            $role = 'Pemlap';
        } else {
            $params = [
                'status' => false,
                'msg' => 'User denied'
            ];
            echo json_encode($params);
            die;
        }

        $data_ctt = [
            'date' => date('Y-m-d H:i:s'),
            'from' => $user->nama_lengkap . ' (' . $role . ')',
            'ctt' => $notes
        ];


        $get_data = $this->db->where('sha1(id)', $id)->get('log_mahasiswa')->row();

        if ($get_data) {
            $new_log = $this->logbook->update_changelog($get_data->log_activity, $data_log_activity);

            if ($notes != '' || $notes != null) {
                $new_ctt = $this->logbook->update_changelog($get_data->ctt, $data_ctt);

                $data_update = [
                    'status' => $new_status,
                    'log_activity' => json_encode($new_log),
                    'ctt' => json_encode($new_ctt)
                ];
            } else {
                $data_update = [
                    'status' => $new_status,
                    'log_activity' => json_encode($new_log),
                ];
            }

            $this->db->where('id', $get_data->id)->update('log_mahasiswa', $data_update);
            if ($this->db->affected_rows() > 0) {
                $params = [
                    'status' => true,
                    'msg' => 'Logbook berhasil di update'
                ];
            } else {
                $params = [
                    'status' => false,
                    'msg' => 'Logbook gagal di update'
                ];
            }
        } else {
            $params = [
                'status' => false,
                'msg' => 'Data not found'
            ];
        }

        json_output(200, $params);
    }

    //laporan milik pemlap
    public function load_report()
    {
        cek_ajax();
        $get_data = $this->logbook->get_report();
        $data = [];
        $i = 1;
        foreach ($get_data as $gd) {
            $decode_date = json_decode($gd->tanggal);
            $start_date = date_create($decode_date->start);
            $end_date = date_create($decode_date->end);

            if ($gd->status == 'submited') {
                $status = 'Terkirim';
                $color = 'warning';
            } else if ($gd->status == 'accepted') {
                $status = 'Tervalidasi';
                $color = 'success';
            } else if ($gd->status == 'rejected') {
                $status = 'Di Tolak';
                $color = 'danger';
            } else {
                $status = 'Unknow';
                $color = 'secondary';
            }

            if ($gd->status == 'rejected') {
                $other_option = '
                        <li><a class="dropdown-item" href="#" onclick="delete_report(\'' . sha1($gd->id) . '\')">Hapus</a></li>
                        <li><a class="dropdown-item" href="' . base_url('edit-report/') . sha1($gd->id) . '">Edit</a></li>
                ';
            } else {
                $other_option = '';
            }


            $row = [];

            $row[] = $i++;
            $row[] = date_format($start_date, 'd F Y') . ' - ' . date_format($end_date, 'd F Y');
            $row[] = '<span class="badge text-bg-' . $color . '">' . $status . '</span>';
            $row[] = '
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="fas fa-cogs"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="detail_log(\'' . sha1($gd->id) . '\')">Log</a></li>
                        <li><a class="dropdown-item" href="' . base_url('detail-report/') . sha1($gd->id) . '">Detail</a></li>
                        ' . $other_option . '
                    </ul>
                </div>';

            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->logbook->count_all_report(),
            "recordsFiltered" => $this->logbook->count_filter_report(),
            "data" => $data,
        ];
        json_output(200, $output);
    }

    public function add_report()
    {
        cek_ajax();
        $file = $_FILES['file'];
        $input_post = $this->input->post(null, true);

        $start_date = $input_post['start_date'];
        $end_date = $input_post['end_date'];
        $activity = $input_post['activity'];
        $result = $input_post['result'];

        if ($file && $start_date && $end_date && $activity && $result) {
            $new_filename = 'dpl-' . date('d-m-Y') . '-' . date('s') . '-' . time();
            $config['upload_path']          = './assets/logbook/pemlap/';
            $config['allowed_types']        = 'pdf|doc|docx|png|jpg|jpeg|png';
            $config['max_size']             = 2000;
            $config['file_name']            = $new_filename;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                $uploaded_file = [
                    'file_path' => $this->upload->data('full_path'),
                    'file_name' => $this->upload->data('file_name'),
                    'file_ext' => $this->upload->data('file_ext'),
                    'file_size' => $this->upload->data('file_size')
                ];
                return $this->_add_report($input_post, $uploaded_file);
            } else {
                $params = [
                    'status' => false,
                    'msg' => $this->upload->display_errors()
                ];
                echo json_encode($params);
                die;
            }
        } else {
            $params = [
                'status' => false,
                'msg' => 'Harap isi semua isian'
            ];
            echo json_encode($params);
            die;
        }
    }

    private function _add_report($input_post, $uploaded_file)
    {
        $user = get_user();
        $data_tgl = [
            'start' => $input_post['start_date'],
            'end' => $input_post['end_date']
        ];
        $data_log = [
            [
                'date' => date('Y-m-d H:i:s'),
                'desc' => 'Berhasil menambahkan laporan baru'
            ]
        ];


        $data = [
            'id_dosen' => $user->id_user,
            'tanggal' => json_encode($data_tgl),
            'uraian' => $input_post['activity'],
            'hasil' => $input_post['result'],
            'dokumentasi' => json_encode($uploaded_file),
            'ctt' => '[]',
            'create_at' => date('Y-m-d H:i:s'),
            'last_update' => date('Y-m-d H:i:s'),
            'status' => 'submited',
            'log_activity' => json_encode($data_log)
        ];

        $this->db->insert('log_pemlap', $data);
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Laporan berhasil di kirim',
                'redirect' => base_url('report-pemlap')
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Laporan gagal di kirim',

            ];
        }
        json_output(200, $params);
    }

    public function act_laporan()
    {
        cek_ajax();
        $act = $this->input->post('act');
        $id = htmlspecialchars($this->input->post('id'));


        switch ($act) {
            case 'log':
                $get_data = $this->db->get_where('log_pemlap', ['sha1(id)' => $id])->row();
                if ($get_data) {
                    $log = json_decode($get_data->log_activity);

                    $data = [
                        'status' => true,
                        'data' => $log
                    ];
                } else {
                    $data = [
                        'status' => false,
                        'msg' => 'No data result'
                    ];
                }

                json_output(200, $data);
                break;
            case 'delete':
                $this->db->where('sha1(id)', $id)->delete('log_pemlap');
                if ($this->db->affected_rows() > 0) {
                    $data = [
                        'status' => true,
                        'data' => 'Laporan berhasil di hapus'
                    ];
                } else {
                    $data = [
                        'status' => false,
                        'data' => 'Laporan gagal di hapus'
                    ];
                }
                json_output(200, $data);
                break;
            default:
                $data = [
                    'status' => false,
                    'msg' => 'Unknow action'
                ];
                json_output(200, $data);
                break;
        }
    }

    public function edit_laporan()
    {
        cek_ajax();

        $file = $_FILES['file'];
        $input_post = $this->input->post(null, true);

        $start_date = $input_post['start_date'];
        $end_date   = $input_post['end_date'];
        $activity   = $input_post['activity'];
        $result     = $input_post['result'];
        $id         = $input_post['id'];

        if ($id && $start_date && $end_date && $activity && $result) {
            $get_data = $this->db->where('sha1(id)', $id)->get('log_pemlap')->row();

            if ($get_data) {
                $decode_file = json_decode($get_data->dokumentasi);

                if ($file) {
                    $new_filename = 'dpl-' . date('d-m-Y') . '-' . date('s') . '-' . time();
                    $config['upload_path']          = './assets/logbook/pemlap/';
                    $config['allowed_types']        = 'pdf|doc|docx|png|jpg|jpeg|png';
                    $config['max_size']             = 2000;
                    $config['file_name']            = $new_filename;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file')) {
                        $uploaded_file = [
                            'file_path' => $this->upload->data('full_path'),
                            'file_name' => $this->upload->data('file_name'),
                            'file_ext' => $this->upload->data('file_ext'),
                            'file_size' => $this->upload->data('file_size')
                        ];
                    } else {
                        $params = [
                            'status' => false,
                            'msg' => $this->upload->display_errors()
                        ];
                        echo json_encode($params);
                        die;
                    }
                } else {
                    $uploaded_file = $decode_file;
                }
            } else {
                $params = [
                    'status' => false,
                    'msg' => 'Data tidak di temukan'
                ];
                echo json_encode($params);
                die;
            }
        } else {
            $params = [
                'status' => false,
                'msg' => 'Inputan harap di isi'
            ];
            echo json_encode($params);
            die;
        }
        $this->_edit_data($input_post, $uploaded_file, $get_data);
    }

    private function _edit_data($input_post, $uploaded_file, $old_data)
    {
        $id = $input_post['id'];
        $add_log = ['date' => date('Y-m-d H:i:s'), 'desc' => 'Laporan berhasil di update'];
        $new_log = $this->logbook->update_changelog($old_data->log_activity, $add_log);
        $tanggal = ['start' => $input_post['start_date'], 'end' => $input_post['end_date']];


        $data = [
            'tanggal' => json_encode($tanggal),
            'uraian' => $input_post['activity'],
            'hasil' => $input_post['result'],
            'dokumentasi' => json_encode($uploaded_file),
            'last_update' => date('Y-m-d H:i:s'),
            'log_activity' => json_encode($new_log),
            'status' => 'submited',
        ];

        $this->db->where('id', $old_data->id)->update('log_pemlap', $data);
        if ($this->db->affected_rows() > 0) {
            $params = [
                'status' => true,
                'msg' => 'Laporan berhasil di kirim',
                'redirect' => base_url('report-pemlap')
            ];
        } else {
            $params = [
                'status' => false,
                'msg' => 'Laporan gagal di kirim',

            ];
        }
        json_output(200, $params);
    }




    //laporan pemlap di bagian super admin & dosen
    public function load_data_report()
    {
        cek_ajax();
        $user = get_user();
        if($user->id_role == 1){
            $role = null;
        } else {
            $role = $user->id_user;
        }
        $get_data = $this->logbook->get_list_pemlap($role);
        $data = [];
        $i = 1;
        foreach ($get_data as $gd) {
            $row = [];

            $row[] = $i++;
            $row[] = $gd->nama_lengkap;
            $row[] = $gd->instansi_magang;
            $row[] = $gd->alamat_magang;
            $row[] = '<a href="' . base_url('report-pemlap/user/') . sha1($gd->id) . '" class="btn btn-sm btn-secondary">Detail</a>';

            $data[] = $row;
        }


        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->logbook->c_all_report($role),
            "recordsFiltered" => $this->logbook->c_filter_pemlap($role),
            "data" => $data,
        ];
        json_output(200, $output);
    }

    public function list_laporan_pemlap()
    {
        cek_ajax();
        $id = htmlspecialchars($this->input->post('id'));
        $get_data = $this->logbook->get_report($id);
        $data = [];
        $i = 1;
        foreach ($get_data as $gd) {
            $decode_date = json_decode($gd->tanggal);
            $start_date = date_create($decode_date->start);
            $end_date = date_create($decode_date->end);


            if ($gd->status == 'submited') {
                $status = 'Terkirim';
                $color = 'warning';
            } else if ($gd->status == 'accepted') {
                $status = 'Tervalidasi';
                $color = 'success';
            } else if ($gd->status == 'rejected') {
                $status = 'Di Tolak';
                $color = 'danger';
            } else {
                $status = 'Unknow';
                $color = 'secondary';
            }

            $row = [];

            $row[] = $i++;
            $row[] = date_format($start_date, 'd F Y') . ' - ' . date_format($end_date, 'd F Y');
            $row[] = '<span class="badge text-bg-' . $color . '">' . $status . '</span>';
            $row[] = '
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                       <i class="fas fa-cogs"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="detail_log(\'' . sha1($gd->id) . '\')">Log</a></li>
                        <li><a class="dropdown-item" target="_blank" href="' . base_url('report-pemlap/detail/') . sha1($gd->id) . '">Detail</a></li>
                    </ul>
                </div>
            ';

            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->logbook->count_all_report($id),
            "recordsFiltered" => $this->logbook->count_filter_report($id),
            "data" => $data,
        ];
        json_output(200, $output);
    }

    public function act_report_admin()
    {
        cek_ajax();
        $id = $this->input->post('id', true);
        $note = $this->input->post('notes');
        $status = $this->input->post('status');
        $user = get_user();

        $get_data = $this->db->where('sha1(id)', $id)->get('log_pemlap')->row();

        if ($get_data) {
            if ($status === 1) {
                $update_status = 'accepted';
                $message = 'setujui';
            } else {
                $update_status = 'rejected';
                $message = 'tolak';
            }
            $add_log = [
                'date' => date('Y-m-d H:i:s'),
                'desc' => 'Laporan di ' . $message . ' dosen'
            ];
            $new_log = $this->logbook->update_changelog($get_data->log_activity, $add_log);



            if ($note != '' || $note != null) {
                $add_note = [
                    'date' => date('Y-m-d H:i:s'),
                    'from' => $user->nama_lengkap . ' (Dosen)',
                    'ctt' => $note
                ];
                $new_note = $this->logbook->update_changelog($get_data->ctt, $add_note);

                $data_update = [
                    'status' => $update_status,
                    'ctt' => json_encode($new_note),
                    'log_activity' => json_encode($new_log)
                ];
            } else {
                $data_update = [
                    'status' => $update_status,
                    'log_activity' => json_encode($new_log)
                ];
            }

            $this->db->where('id', $get_data->id)->update('log_pemlap', $data_update);
            if ($this->db->affected_rows() > 0) {
                $params = [
                    'status' => true,
                    'msg' => 'Laporan berhasil di update'
                ];
            } else {
                $params = [
                    'status' => false,
                    'msg' => 'Laporan gagal di update'
                ];
            }
        } else {
            $params = [
                'status' => false,
                'msg' => 'Data not found'
            ];
        }

        json_output(200, $params);
    }
}