<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <h5 class="card-title">Profile <?= $user->nama_lengkap ?></h5>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!--begin::Row-->
                    <form action="<?= base_url('user/change_profile') ?>" id="form_change_profile" method="post">
                        <input type="hidden" class="form-control" id="id" name="id" value="<?= $user->id_user ?>" />
                        <input type="hidden" class="form-control" id="role_user" name="role_user" value="<?= $user->id_role ?>" />
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?= $user->nama_lengkap ?>" />
                                <div class="input-group-text"><i class="fas fa-user"></i></div>
                            </div>
                            <small class="text-danger" id="err_nama_lengkap"></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Akun Email</label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="email" name="email" value="<?= $user->email ?>" />
                                <div class="input-group-text"><i class="fas fa-at"></i></div>
                            </div>
                            <small class="text-danger" id="err_email"></small>
                        </div>
                        <?php if ($user->id_role == 3) { ?>
                            <div class="mb-3">
                                <label class="form-label">NIM</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nim" name="nim" value="<?= $user->nim ?>" />
                                    <div class="input-group-text">
                                        <i class="fas fa-id-badge"></i>
                                    </div>
                                </div>
                                <small class="text-danger" id="err_nim"></small>
                            </div>
                        <?php } ?>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $user->alamat ?>" />
                                <div class="input-group-text"><i class="fas fa-map-marked-alt"></i></div>
                            </div>
                            <small class="text-danger" id="err_alamat"></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Instansi</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="instansi_magang" name="instansi_magang" value="<?= $user->instansi_magang ?>" />
                                <div class="input-group-text"><i class="fas fa-warehouse"></i></div>
                            </div>
                            <small class="text-danger" id="err_instansi_magang"></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Instansi</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="alamat_magang" name="alamat_magang" value="<?= $user->alamat_magang ?>" />
                                <div class="input-group-text"><i class="fas fa-map-pin"></i></div>
                            </div>
                            <small class="text-danger" id="err_alamat_magang"></small>
                        </div>
                        <?php if ($user->id_role == 9) { ?>
                            <div class="mb-3">
                                <label class="form-label">Nama Bank</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="nama_bank" name="nama_bank" value="<?= $user->nama_bank ?>" />
                                    <div class="input-group-text"><i class="fas fa-money-bill"></i></div>
                                </div>
                                <small class="text-danger" id="err_nama_bank"></small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor Rekening</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="<?= $user->no_rekening ?>" />
                                    <div class="input-group-text"><i class="fas fa-money-check"></i></div>
                                </div>
                                <small class="text-danger" id="err_no_rekening"></small>
                            </div>
                        <?php } ?>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit" id="to_profile">Submit form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-info card-outline mb-4">
                <div class="card-header">
                    <h5 class="card-title">Change Password</h5>

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="<?= base_url('user/validation_pass') ?>" id="form_change_pass" method="post">
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="old_pass" name="old_pass" />
                                <div class="input-group-text"><i class="fas fa-user-lock"></i></div>
                            </div>
                            <small class="text-danger" id="err_old_pass"></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="new_pass" name="new_pass" />
                                <div class="input-group-text"><i class="fas fa-key"></i></div>
                            </div>
                            <small class="text-danger" id="err_new_pass"></small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Repeat Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="repeat_new_pass" name="repeat_new_pass" />
                                <div class="input-group-text"><i class="fas fa-lock"></i></div>
                            </div>
                            <small class="text-danger" id="err_repeat_new_pass"></small>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-info" type="submit" id="to_password">Submit form</button>
                        </div>
                    </form>
                    <!--begin::Row-->
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Row-->

<script>
    const spinner_btn = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
    const spinner = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';

    $('#form_change_profile').submit(function(e) {
        e.preventDefault()
        let spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

        $('#to_profile').attr('disabled', true)
        $('#to_profile').html(spinner)
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                $('#to_profile').removeAttr('disabled')
                $('#to_profile').html('Submit')

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

                } else if (d.type == 'result') {
                    $('#err_nama_lengkap').html('')
                    $('#err_nim').html('')
                    $('#err_alamat').html('')
                    $('#err_instansi_magang').html('')
                    $('#err_alamat_magang').html('')

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
                $('#to_profile').removeAttr('disabled')
                $('#to_profile').html('Submit')
                error_alert(error)
            }

        })
    })

    $('#form_change_pass').submit(function(e) {
        e.preventDefault()
        let spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

        $('#to_password').attr('disabled', true)
        $('#to_password').html(spinner)
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                $('#to_password').removeAttr('disabled')
                $('#to_password').html('Submit')

                if (d.type == 'validation') {
                    if (d.err_old_pass == '') {
                        $('#err_old_pass').html('')
                    } else {
                        $('#err_old_pass').html(d.err_old_pass)
                    }
                    if (d.err_new_pass == '') {
                        $('#err_new_pass').html('')
                    } else {
                        $('#err_new_pass').html(d.err_new_pass)
                    }
                    if (d.err_repeat_new_pass == '') {
                        $('#err_repeat_new_pass').html('')
                    } else {
                        $('#err_repeat_new_pass').html(d.err_repeat_new_pass)
                    }


                } else if (d.type == 'result') {
                    $('#err_old_pass').html('')
                    $('#err_new_pass').html('')
                    $('#err_repeat_new_pass').html('')

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
                $('#to_password').removeAttr('disabled')
                $('#to_password').html('Submit')
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