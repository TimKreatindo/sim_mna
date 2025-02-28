<!--begin::Container-->
<div class="container-fluid">
    <!--begin::Row-->
    <div class="row">

        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-3">
                        <select class="form-control" onchange="refresh()" id="role_user" name="role_user">
                            <option value="">--Pilih Role--</option>
                            <?php foreach ($role_user as $ru) : ?>
                                <option value="<?= $ru->id; ?>"><?= $ru->nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-3"></div>
                    <div class="col-3"></div>
                    <div class="col-3">
                        <div class="text-end">
                            <a class="btn btn-success mb-3" href="<?= base_url('pengumuman/tambah') ?>"><i class="fa fa-plus"></i> Tambah Pengumuman</a>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered w-100 mt-2" id="table_pengumuman" style="width:100%">
                    <thead>
                        <tr class="bg-secondary">
                            <th>#</th>
                            <th>Judul</th>
                            <th>Pembuat</th>
                            <th>Untuk</th>
                            <th>Tanggal Pengumuman</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <!--end::Row-->
</div>
<!--end::Container-->

<!-- Start Detail Pengumuman -->
<div class="modal" id="modalDetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title text-light" id="staticBackdropLabel">Detail Pengumuman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <input type="hidden" name="id" id="id">
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<!-- End Detail Pengumuman -->

<script>
    const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

    $(document).ready(function() {
        $('#table_pengumuman').DataTable({
            "serverSide": true,
            "ordering": false,
            "order": [],
            "ajax": {
                "url": "<?php echo base_url() ?>ajax/datatable_pengumuman",
                "type": "GET",
                "data": {
                    role_user: function() {
                        return $('#role_user').val()
                    }
                }
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],
        });
    })

    function refresh() {
        table = $('#table_pengumuman').DataTable();
        table.destroy();

        $table = $('#table_pengumuman').DataTable({
            "serverSide": true,
            "ordering": false,
            "order": [],
            "ajax": {
                "url": "<?php echo base_url() ?>ajax/datatable_pengumuman",
                "type": "GET",
                "data": {
                    role_user: function() {
                        return $('#role_user').val()
                    }
                }
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],
        });
    }

    function detail_data(id) {
        $('#modalDetail').modal('show')
        $('#modalDetail').find('.modal-body').html('')

        $.ajax({
            url: '<?= base_url('ajax/detail_pengumuman') ?>',
            data: {
                id: id
            },
            type: 'POST',
            success: function(d) {
                $('#modalDetail').find('.modal-body').html(d)
            },
            error: function(xhr, status, error) {
                error_alert(error)
            }
        })
    }

    function delete_user(id, username, nama, role) {
        $('#exampleModal').modal('show')
        $('#exampleModal').find('.modal-title').html('Edit User');

        $('#err_nama').html('')
        $('#err_username').html('')
        $('#err_new_pass').html('')
        $('#err_repeat_pass').html('')

        $('#act').val('edit');
        $('#id').val(id);
        $('#role').val(role);
        $('#nama').val(nama);
        $('#username').val(username);
        $('#new_pass').val('');
        $('#repeat_pass').val('');
    }

    function action_status(status, id, act) {
        $.ajax({
            url: '<?= base_url('ajax/action_pengumuman') ?>',
            data: {
                id: id,
                status: status,
                act: act
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                if (d.status == false) {
                    Swal.fire({
                        title: "Error",
                        text: d.msg,
                        icon: "error"
                    }).then((res) => {
                        window.location.reload()
                    });
                } else {
                    Swal.fire({
                        title: "Success",
                        text: d.msg,
                        icon: "success"
                    }).then((res) => {
                        window.location.reload()
                    });
                }
            },
            error: function(xhr, status, error) {
                error_alert(error)
            }
        })
    }

    function delete_pengumuman(id) {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Untuk menghapus Pengumuman ini?",
            showCancelButton: true,
            confirmButtonText: "Yes",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                to_delete_pengumuman(id)
            }
        });
    }

    function to_delete_pengumuman(id) {
        $.ajax({
            url: '<?= base_url('pengumuman/delete_pengumuman') ?>',
            data: {
                id: id
            },
            type: 'POST',
            dataType: 'JSON',
            success: function(d) {
                if (d.status == false) {
                    Swal.fire({
                        title: "Error",
                        text: d.msg,
                        icon: "error"
                    }).then((res) => {
                        window.location.reload()
                    });
                } else {
                    Swal.fire({
                        title: "Success",
                        text: d.msg,
                        icon: "success"
                    }).then((res) => {
                        window.location.reload()
                    });
                }
            },
            error: function(xrh, status, error) {
                error_alert(error)
            }
        })
    }

    function error_alert(msg) {
        Swal.fire({
            title: "Error",
            text: msg,
            icon: "error"
        });
    }
</script>