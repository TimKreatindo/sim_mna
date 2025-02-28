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
							<button class="btn btn-success mb-3" onclick="add_user()"><i class="fa fa-plus"></i> Tambah User</button>
						</div>
					</div>
				</div>
				<table class="table table-bordered w-100 mt-2" id="table_user" style="width:100%">
					<thead>
						<tr class="bg-secondary">
							<th>#</th>
							<th>Nama</th>
							<th>Email</th>
							<th>Instansi Magang</th>
							<th>Role</th>
							<th>Status</th>
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

<!-- Start Add Modal -->
<div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= base_url('ajax/validation_user') ?>" id="form_user" method="post">
				<input type="hidden" name="act" id="act">
				<input type="hidden" name="id" id="id">
				<div class="modal-body">
					<div class="form-group mb-3">
						<label>Role User</label>
						<select name="id_role" id="id_role" required class="form-control">
							<option value="">--pilih--</option>
							<?php foreach ($role_user as $ru) : ?>
								<option value="<?= $ru->id ?>"><?= $ru->nama ?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="form-group mb-3">
						<label>Nama Lengkap</label>
						<input type="text" name="nama_lengkap" id="nama_lengkap" required class="form-control">
						<small class="text-danger" id="err_nama_lengkap"></small>
					</div>

					<div class="form-group mb-3">
						<label>Email</label>
						<input type="text" name="email" id="email" required class="form-control" placeholder="Memakai Email Aktif">
						<small class="text-danger" id="err_email"></small>
					</div>

					<div class="form-group mb-3">
						<label>Nomor Induk</label>
						<input type="text" name="nim" id="nim" class="form-control">
						<small class="text-danger" id="err_nim"></small>
					</div>

					<div class="form-group mb-3">
						<label>Alamat</label>
						<textarea type="text" class="form-control" name="alamat" id="alamat"></textarea>
						<small class="text-danger" id="err_alamat"></small>
					</div>

					<div class="form-group mb-3">
						<label>Instansi Magang</label>
						<input type="text" name="instansi_magang" id="instansi_magang" class="form-control">
						<small class="text-danger" id="err_instansi_magang"></small>
					</div>

					<div class="form-group mb-3">
						<label>Alamat Instansi</label>
						<textarea type="text" class="form-control" name="alamat_magang" id="alamat_magang"></textarea>
						<small class="text-danger" id="err_alamat_magang"></small>
					</div>

					<div class="form-group mb-3">
						<label>Password Baru</label>
						<input type="password" name="new_pass" id="new_pass" required class="form-control">
						<small class="text-danger" id="err_new_pass"></small>
					</div>

					<div class="form-group mb-3">
						<label>Ulangi Password Baru</label>
						<input type="password" name="repeat_pass" id="repeat_pass" required class="form-control">
						<small class="text-danger" id="err_repeat_pass"></small>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="to_submit">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Add Modal -->

<!-- Start Detail Modal -->
<div class="modal" id="modalDetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-header bg-primary text-light">
				<h5 class="modal-title text-light" id="staticBackdropLabel">Detail User</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="mb-3 row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Nama Lengkap</label>
					<div class="col-sm-10">
						<input type="text" class="form-control-plaintext" id="dt_nama" readonly>
					</div>
				</div>
				<div class="mb-3 row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Nama Lengkap</label>
					<div class="col-sm-10">
						<input type="text" class="form-control-plaintext" id="dt_role" readonly>
					</div>
				</div>

				<div class="mb-3 row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Nomor Induk</label>
					<div class="col-sm-10">
						<input type="text" class="form-control-plaintext" id="dt_nim" readonly>
					</div>
				</div>
				<div class="mb-3 row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
					<div class="col-sm-10">
						<input type="text" class="form-control-plaintext" id="dt_email" readonly>
					</div>
				</div>

				<div class="mb-3 row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Alamat</label>
					<div class="col-sm-10">
						<textarea class="form-control" id="dt_alamat" disabled></textarea>
					</div>
				</div>

				<div class="mb-3 row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Instansi Magang</label>
					<div class="col-sm-10">
						<input type="text" class="form-control-plaintext" id="dt_instansi" readonly>
					</div>
				</div>

				<div class="mb-3 row">
					<label for="staticEmail" class="col-sm-2 col-form-label">Alamat Magang</label>
					<div class="col-sm-10">
						<textarea class="form-control" id="dt_alamat_instansi" disabled></textarea>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
<!-- End Detail Modal -->

<!-- Start Ganti Password Modal -->
<div class="modal" id="modalChangePass" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header bg-primary text-light">
				<h5 class="modal-title text-light" id="staticBackdropLabel">Ganti Password User</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= base_url('ajax/validation_user') ?>" id="form_change_pass" method="post">
				<div class="modal-body">
					<input type="hidden" name="act" id="act_change">
					<input type="hidden" name="id_change" id="id_change">
					<div class="form-group mb-3">
						<label>Password Lama</label>
						<input type="password" name="pass_old" id="pass_old" required class="form-control">
						<small class="text-danger" id="err_pass_old"></small>
					</div>

					<div class="form-group mb-3">
						<label>Password Baru</label>
						<input type="password" name="pass_new" id="pass_new" required class="form-control">
						<small class="text-danger" id="err_pass_new"></small>
					</div>

					<div class="form-group mb-3">
						<label>Ulangi Password Baru</label>
						<input type="password" name="pass_repeat" id="pass_repeat" required class="form-control">
						<small class="text-danger" id="err_pass_repeat"></small>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary" id="change_pass">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Ganti Password Modal -->

<script>
	const spinner_btn = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
	const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

	$(document).ready(function() {
		$('#table_user').DataTable({
			"serverSide": true,
			"ordering": false,
			"order": [],
			"ajax": {
				"url": "<?php echo base_url() ?>ajax/datatable_user",
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
		table = $('#table_user').DataTable();
		table.destroy();

		$table = $('#table_user').DataTable({
			"serverSide": true,
			"ordering": false,
			"order": [],
			"ajax": {
				"url": "<?php echo base_url() ?>ajax/datatable_user",
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

	function add_user() {
		$('#exampleModal').modal('show')
		$('#exampleModal').find('.modal-title').html('Tambah User Baru');

		$('#err_id_role').html('')
		$('#err_nama_lengkap').html('')
		$('#err_email').html('')
		$('#err_nim').html('')
		$('#err_alamat').html('')
		$('#err_instansi_magang').html('')
		$('#err_alamat_magang').html('')
		$('#err_new_pass').html('')
		$('#err_repeat_pass').html('')

		$('#act').val('add');
		$('#id').val('');
		$('#id_role').val('')
		$('#nama_lengkap').val('')
		$('#email').val('')
		$('#nim').val('')
		$('#alamat').val('')
		$('#instansi_magang').val('')
		$('#alamat_magang').val('')
		$('#new_pass').val('')
		$('#repeat_pass').val('')
	}

	function action_status(status, id, act) {
		$.ajax({
			url: '<?= base_url('ajax/action_user') ?>',
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

	function detail_user(id) {
		$('#modalDetail').modal('show')
		$('.modal-title').html('Detail User')

		$.ajax({
			url: '<?= base_url('ajax/detail_user') ?>',
			data: {
				id: id
			},
			type: 'POST',
			dataType: 'JSON',
			success: function(d) {
				$('#dt_role').val(d.nama_role)
				$('#dt_nama').val(d.nama_lengkap)
				$('#dt_email').val(d.email)
				$('#dt_nim').val(d.nim)
				$('#dt_alamat').val(d.alamat)
				$('#dt_instansi').val(d.instansi_magang)
				$('#dt_alamat_instansi').val(d.alamat_magang)
				$('#dt_alamat_instansi').val(d.alamat_magang)
				$('#dt_alamat_instansi').val(d.alamat_magang)
			},
			error: function(xhr, status, error) {
				error_alert(error)
			}
		})
	}

	function get_detail_user(id) {
		$.ajax({
			url: '<?= base_url('ajax/detail_user') ?>',
			data: {
				id: id
			},
			type: 'POST',
			dataType: 'JSON',
			success: function(d) {

				$('#id_role').val(d.id_role)
				$('#nama_lengkap').val(d.nama_lengkap)
				$('#email').val(d.email)
				$('#nim').val(d.nim)
				$('#alamat').val(d.alamat)
				$('#instansi_magang').val(d.instansi_magang)
				$('#alamat_magang').val(d.alamat_magang)

			},
			error: function(xhr, status, error) {
				error_alert(error)
			}
		})
	}

	function delete_user(id) {
		Swal.fire({
			title: "Apakah anda yakin?",
			text: 'untuk menghapus data ini?',
			showCancelButton: true,
			confirmButtonText: "Yes",
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				$.ajax({
					url: '<?= base_url('ajax/delete_user') ?>',
					data: {
						id: id
					},
					type: 'POST',
					dataType: 'JSON',
					success: function(d) {
						if (d.status == false) {
							error_alert(d.msg);
							setTimeout(() => {
								load_data();
							}, 1500);
						} else {
							Swal.fire({
								title: "Success",
								text: d.msg,
								icon: "success"
							}).then((res) => {
								load_data()
							});
						}
					},
					error: function(xhr, status, error) {
						error_alert(error)
					}
				})
			}
		});
	}

	function error_alert(msg) {
		Swal.fire({
			title: "Error",
			text: msg,
			icon: "error"
		});
	}

	$('#form_user').submit(function(e) {
		e.preventDefault();
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
					if (d.err_id_role == '') {
						$('#err_id_role').html('')
					} else {
						$('#err_id_role').html(d.err_id_role)
					}

					if (d.err_nama_lengkap == '') {
						$('#err_nama_lengkap').html('')
					} else {
						$('#err_nama_lengkap').html(d.err_nama_lengkap)
					}

					if (d.err_email == '') {
						$('#err_email').html('')
					} else {
						$('#err_email').html(d.err_email)
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
					$('#err_id_role').html('')
					$('#err_nama_lengkap').html('')
					$('#err_email').html('')
					$('#err_nim').html('')
					$('#err_alamat').html('')
					$('#err_instansi_magang').html('')
					$('#err_alamat_magang').html('')
					$('#err_new_pass').html('')
					$('#err_repeat_pass').html('')

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
				}

			},
			error: function(xhr, status, error) {
				$('#to_submit').removeAttr('disabled')
				$('#to_submit').html('Save')
				error_alert(error)
			}
		})
	})

	function change_pass(id) {
		$('#modalChangePass').modal('show')
		$('#modalChangePass').find('.modal-title').html('Ganti Password User');

		$('#err_pass_old').html('')
		$('#err_pass_new').html('')
		$('#err_pass_repeat').html('')

		$('#act_change').val('change_pass');
		$('#id_change').val(id);
		$('#pass_old').val('')
		$('#pass_new').val('')
		$('#pass_repeat').val('')
	}

	$('#form_change_pass').submit(function(e) {
		e.preventDefault();
		$('#change_pass').attr('disabled', true)
		$('#change_pass').html(spinner)

		$.ajax({
			url: $(this).attr('action'),
			data: $(this).serialize(),
			type: 'POST',
			dataType: 'JSON',
			success: function(d) {
				$('#change_pass').removeAttr('disabled')
				$('#change_pass').html('Save')

				if (d.type == 'validation') {
					if (d.err_pass_old == '') {
						$('#err_pass_old').html('')
					} else {
						$('#err_pass_old').html(d.err_pass_old)
					}
					if (d.err_pass_new == '') {
						$('#err_pass_new').html('')
					} else {
						$('#err_pass_new').html(d.err_pass_new)
					}

					if (d.err_pass_repeat == '') {
						$('#err_pass_repeat').html('')
					} else {
						$('#err_pass_repeat').html(d.err_pass_repeat)
					}

				} else if (d.type == 'result') {
					$('#err_pass_new').html('')
					$('#err_pass_repeat').html('')

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
				}

			},
			error: function(xhr, status, error) {
				$('#change_pass').removeAttr('disabled')
				$('#change_pass').html('Save')
				error_alert(error)
			}
		})
	})
</script>