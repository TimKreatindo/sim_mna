<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Logbook MNA | Register</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE 4 | Register Page v2" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS." />
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard" />
    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/fontawesome-free/css/all.min.css">
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="<?= base_url('assets/') ?>/dist/css/adminlte.css" />
    <!--end::Required Plugin(AdminLTE)-->

    <!--plugins-->
    <script src="<?= base_url('assets') ?>/plugins/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://www.google.com/recaptcha/api.js?hl=id" async defer></script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="register-page bg-body-secondary">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-3">
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modalMahasiswa">
                    <div class=" card mb-3">
                        <div class="text-center mt-3">
                            <i class="fas fa-10x fa-users"></i>
                        </div>
                        <div class="card-body">
                            <h3 class="text-center">Mahasiswa Magang</h3>
                        </div>
                    </div>
                </button>
            </div>

            <div class="col-3">
                <a type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modalPembimbing">
                    <div class="card mb-3">
                        <div class="text-center mt-3">
                            <i class="fas fa-10x fa-warehouse"></i>
                        </div>
                        <div class="card-body">
                            <h3 class="text-center">Pembimbing Instansi</h3>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col-3">
                <div class="text-center">
                    <a href="<?= base_url('auth') ?>" class=" btn btn-primary">Sudah Ada Akun</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Mahasiswa Daftar Start -->
    <div class="modal fade" id="modalMahasiswa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title text-light" id="staticBackdropLabel">Daftar Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <form action="<?= base_url('auth/validation_mahasiswa') ?>" id="form_register_mahasiswa" method="post">
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Jhon">
                                <label>Nama Lengkap</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-person"></span></div>
                        </div>
                        <small class="text-danger" id="err_nama_lengkap"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input type="email" class="form-control" name="email" id="email" placeholder="example@user.com">
                                <label>Email</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                        </div>
                        <small class="text-danger" id="err_email"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="nim" id="nim" placeholder="E3xxxxx">
                                <label>NIM</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-person-square"></span></div>
                        </div>
                        <small class="text-danger" id="err_nim"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <textarea class="form-control" name="alamat" id="alamat"></textarea>
                                <label>Alamat Mahasiswa</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-geo-alt-fill"></span></div>
                        </div>
                        <small class="text-danger" id="err_alamat"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="instansi_magang" id="instansi_magang" placeholder="Diskominfo">
                                <label>Nama Instansi Magang</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-buildings-fill"></span></div>
                        </div>
                        <small class="text-danger" id="err_instansi_magang"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <textarea type="text" class="form-control" name="alamat_magang" id="alamat_magang"></textarea>
                                <label>Alamat Magang</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-geo"></span></div>
                        </div>
                        <small class="text-danger" id="err_alamat_magang"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input type="password" id="new_pass" name="new_pass" class="form-control" placeholder="Password" />
                                <label>Password</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-person-lock"></span></div>
                        </div>
                        <small class="text-danger" id="err_new_pass"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input type="password" id="repeat_pass" name="repeat_pass" class="form-control" placeholder="Password" />
                                <label>Repeat Password</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-person-fill-lock"></span></div>
                        </div>
                        <small class="text-danger" id="err_repeat_pass"></small>
                        <div class="input-group mb-2">
                            <div class="form-floating">
                                <div class="g-recaptcha" data-sitekey="<?= $this->config->item('sitekey') ?>"></div>
                            </div>
                        </div>
                        <!--begin::Row-->
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-4 mt-2">
                                <div class="d-grid gap-2">
                                    <button type="submit" id="regis_mhs" class="btn btn-primary">Daftar</button>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!--end::Row-->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Mahasiswa Daftar End -->

    <!-- Modal Pembimbing Instansi Daftar Start -->
    <div class="modal fade" id="modalPembimbing" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-light">
                    <h5 class="modal-title text-light" id="staticBackdropLabel">Detail Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <form action="<?= base_url('auth/validation_pembimbing') ?>" id="form_register_pembimbing" method="post">
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" placeholder="Jhon">
                                <label>Nama Lengkap</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-person"></span></div>
                        </div>
                        <small class="text-danger" id="err_nama_lengkap"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input type="email" class="form-control" name="email" id="email" placeholder="example@user.com">
                                <label>Email</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
                        </div>
                        <small class="text-danger" id="err_email"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="nama_bank" id="nama_bank" placeholder="E3xxxxx">
                                <label>Nama Bank</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-person-square"></span></div>
                        </div>
                        <small class="text-danger" id="err_bank"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="no_rekening" id="no_rekening" placeholder="E3xxxxx">
                                <label>Nomor Rekening</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-person-square"></span></div>
                        </div>
                        <small class="text-danger" id="err_no_rekening"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <textarea class="form-control" name="alamat" id="alamat"></textarea>
                                <label>Alamat</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-geo-alt-fill"></span></div>
                        </div>
                        <small class="text-danger" id="err_alamat"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="instansi_magang" id="instansi_magang" placeholder="Diskominfo">
                                <label>Nama Instansi</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-buildings-fill"></span></div>
                        </div>
                        <small class="text-danger" id="err_instansi_magang"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <textarea type="text" class="form-control" name="alamat_magang" id="alamat_magang"></textarea>
                                <label>Alamat Instansi</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-geo"></span></div>
                        </div>
                        <small class="text-danger" id="err_alamat_magang"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input type="password" id="new_pass" name="new_pass" class="form-control" placeholder="Password" />
                                <label>Password</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-person-lock"></span></div>
                        </div>
                        <small class="text-danger" id="err_new_pass"></small>
                        <div class="input-group mb-1">
                            <div class="form-floating">
                                <input type="password" id="repeat_pass" name="repeat_pass" class="form-control" placeholder="Password" />
                                <label>Repeat Password</label>
                            </div>
                            <div class="input-group-text"><span class="bi bi-person-fill-lock"></span></div>
                        </div>
                        <small class="text-danger" id="err_repeat_pass"></small>
                        <div class="input-group mb-2">
                            <div class="form-floating">
                                <div class="g-recaptcha" data-sitekey="<?= $this->config->item('sitekey') ?>"></div>
                            </div>
                        </div>
                        <!--begin::Row-->
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-4 mt-2">
                                <div class="d-grid gap-2">
                                    <button type="submit" id="regis_pemlab" class="btn btn-primary">Daftar</button>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!--end::Row-->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Pembimbing Instansi Daftar End -->

    <!-- /.register-box -->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)-->
    <!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <!--end::Required Plugin(Bootstrap 5)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <script src="<?= base_url('assets/') ?>/dist/js/adminlte.js"></script>
    <!--end::Required Plugin(AdminLTE)-->
    <!--begin::OverlayScrollbars Configure-->

</body>

<script>
    const spinner_btn = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
    const spinner = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';
    $('#form_register_mahasiswa').submit(function(e) {
        e.preventDefault()
        let spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

        $('#regis_mhs').attr('disabled', true)
        $('#regis_mhs').html(spinner)
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                $('#regis_mhs').removeAttr('disabled')
                $('#regis_mhs').html('Daftar')

                if (d.type == 'validation') {
                    if (d.err_nama_lengkap == '') {
                        $('#err_nama_lengkap').html('')
                    } else {
                        $('#err_nama_lengkap').html(d.err_nama_lengkap)
                    }
                    if (d.err_nim == '') {
                        $('#err_nim').html('')
                    } else {
                        $('#err_nim').html(d.err_nim)
                    }
                    if (d.err_alamat == '') {
                        $('#err_alamat').html('')
                    } else {
                        $('#err_alamat').html(d.err_alamat)
                    }
                    if (d.err_instansi_magang == '') {
                        $('#err_instansi_magang').html('')
                    } else {
                        $('#err_instansi_magang').html(d.err_instansi_magang)
                    }
                    if (d.err_alamat_magang == '') {
                        $('#err_alamat_magang').html('')
                    } else {
                        $('#err_alamat_magang').html(d.err_alamat_magang)
                    }
                    if (d.err_email == '') {
                        $('#err_email').html('')
                    } else {
                        $('#err_email').html(d.err_email)
                    }

                    if (d.err_new_pass == '') {
                        $('#err_new_pass').html('')
                    } else {
                        $('#err_new_pass').html(d.err_new_pass)
                    }

                    if (d.err_repeat_pass == '') {
                        $('#err_repeat_pass').html('')
                    } else {
                        $('#err_repeat_pass').html(d.err_repeat_pass)
                    }

                } else if (d.type == 'result') {
                    $('#err_nama_lengkap').html('')
                    $('#err_nim').html('')
                    $('#err_alamat').html('')
                    $('#err_instansi_magang').html('')
                    $('#err_alamat_magang').html('')
                    $('#err_new_pass').html('')
                    $('#err_repeat_pass').html('')

                    if (d.status == false) {
                        error_alert(d.msg)
                    } else {
                        Swal.fire({
                            title: "Success",
                            text: d.msg,
                            icon: "success"
                        }).then((res) => {
                            window.location.href = d.redirect
                        });
                    }

                }
            },
            error: function(xhr, status, error) {
                $('#regis_mhs').removeAttr('disabled')
                $('#regis_mhs').html('Daftar')
                error_alert(error)
            }

        })
    })

    $('#form_register_pembimbing').submit(function(e) {
        e.preventDefault()
        let spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

        $('#regis_pemlab').attr('disabled', true)
        $('#regis_pemlab').html(spinner)
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                $('#regis_pemlab').removeAttr('disabled')
                $('#regis_pemlab').html('Daftar')

                if (d.type == 'validation') {
                    if (d.err_nama_lengkap == '') {
                        $('#err_nama_lengkap').html('')
                    } else {
                        $('#err_nama_lengkap').html(d.err_nama_lengkap)
                    }
                    if (d.err_alamat == '') {
                        $('#err_alamat').html('')
                    } else {
                        $('#err_alamat').html(d.err_alamat)
                    }
                    if (d.err_nama_bank == '') {
                        $('#err_nama_bank').html('')
                    } else {
                        $('#err_nama_bank').html(d.err_nama_bank)
                    }
                    if (d.err_no_rekening == '') {
                        $('#err_no_rekening').html('')
                    } else {
                        $('#err_no_rekening').html(d.err_no_rekening)
                    }
                    if (d.err_instansi_magang == '') {
                        $('#err_instansi_magang').html('')
                    } else {
                        $('#err_instansi_magang').html(d.err_instansi_magang)
                    }
                    if (d.err_alamat_magang == '') {
                        $('#err_alamat_magang').html('')
                    } else {
                        $('#err_alamat_magang').html(d.err_alamat_magang)
                    }
                    if (d.err_email == '') {
                        $('#err_email').html('')
                    } else {
                        $('#err_email').html(d.err_email)
                    }

                    if (d.err_new_pass == '') {
                        $('#err_new_pass').html('')
                    } else {
                        $('#err_new_pass').html(d.err_new_pass)
                    }

                    if (d.err_repeat_pass == '') {
                        $('#err_repeat_pass').html('')
                    } else {
                        $('#err_repeat_pass').html(d.err_repeat_pass)
                    }

                } else if (d.type == 'result') {
                    $('#err_nama_lengkap').html('')
                    $('#err_email').html('')
                    $('#err_alamat').html('')
                    $('#err_nama_bank').html('')
                    $('#err_no_rekening').html('')
                    $('#err_instansi_magang').html('')
                    $('#err_alamat_magang').html('')
                    $('#err_new_pass').html('')
                    $('#err_repeat_pass').html('')

                    if (d.status == false) {
                        error_alert(d.msg)
                    } else {
                        Swal.fire({
                            title: "Success",
                            text: d.msg,
                            icon: "success"
                        }).then((res) => {
                            window.location.href = d.redirect
                        });
                    }

                }
            },
            error: function(xhr, status, error) {
                $('#regis_pemlab').removeAttr('disabled')
                $('#regis_pemlab').html('Daftar')
                error_alert(error)
            }

        })
    })

    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }
</script>

</html>