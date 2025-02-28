<?php
$option_kegiatan = [9, 3];
?>
<!--begin::Container-->
<div class="container-fluid">
    <!--begin::Row-->
    <div class="row">

        <?= form_open_multipart('pengumuman/validation_edit_pengumuman', 'id="form_edit_pengumuman"') ?>
        <input type="hidden" name="maker" id="maker" class="form-control" value="<?= $user->id ?>">
        <input type="hidden" name="id" id="id" class="form-control" value="<?= $data->id ?>">
        <div class="form-group mb-2">
            <div class="form-floating">
                <input type="text" name="judul" id="judul" class="form-control" placeholder="Jhon" value="<?= $data->judul ?>">
                <label>Judul</label>
            </div>
        </div>
        <small class="text-danger" id="err_judul"></small>
        <div class="form-group mb-2">
            <div class="input-group mb-1">
                <div class="form-floating">
                    <textarea name="isi" id="isi" class="form-control"><?= $data->isi ?></textarea>
                </div>
            </div>
        </div>
        <small class="text-danger" id="err_isi"></small>
        <div class="form-group mb-2">
            <div class="col-md-6">
                <select class="form-select" name="to_role" id="to_role" required>
                    <option selected disabled value="">Ditujukan Ke...</option>
                    <?php
                    foreach ($role_user as $ru) {
                        if ($ru->id == $data->to_role) {
                            echo '<option selected value="' . $ru->id . '">' . $ru->nama . '</option>';
                        } else {
                            echo '<option value="' . $ru->id . '">' . $ru->nama . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <small class="text-danger" id="err_to_role"></small>

        <!--begin::Row-->
        <div class="row">
            <!-- /.col -->
            <div class="col-3 mt-2">
                <div class="d-grid gap-2">
                    <button type="submit" id="to_submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->
        <?= form_close() ?>

    </div>
    <!--end::Row-->
</div>
<!--end::Container-->

<script>
    $(document).ready(function() {
        tinymce.init({
            selector: '#isi',
            setup: function(editor) {
                editor.on('change', function(e) {
                    editor.save();
                });
            },
            height: 300,
            placeholder: 'Tulis Isi dari Pengumuman...',
            menubar: false,
            statusbar: false,

        });

    })

    $('#form_edit_pengumuman').submit(function(e) {
        e.preventDefault()
        let spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

        $('#to_submit').attr('disabled', true)
        $('#to_submit').html(spinner)
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                $('#to_submit').removeAttr('disabled')
                $('#to_submit').html('Save')

                if (d.type == 'validation') {
                    if (d.err_judul == '') {
                        $('#err_judul').html('')
                    } else {
                        $('#err_judul').html(d.err_judul)
                    }
                    if (d.err_isi == '') {
                        $('#err_isi').html('')
                    } else {
                        $('#err_isi').html(d.err_isi)
                    }
                    if (d.err_to_role == '') {
                        $('#err_to_role').html('')
                    } else {
                        $('#err_to_role').html(d.err_to_role)
                    }

                } else if (d.type == 'result') {
                    $('#err_judul').html('')
                    $('#err_isi').html('')
                    $('#err_to_role').html('')


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
                $('#to_submit').removeAttr('disabled')
                $('#to_submit').html('Save')
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