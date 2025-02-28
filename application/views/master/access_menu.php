<!--begin::Container-->
<div class="container-fluid">
	<!--begin::Row-->
	<div class="row">
		<div class="card">
			<div class="card-body">

				<table class="table table-bordered">
					<tr class="bg-dark text-light">
						<th>Role</th>
						<th width="5%" class="text-center"><i class="fa fa-cogs"></i></th>
					</tr>
					<?php foreach ($role as $r) { ?>
						<tr>
							<td><?= $r->nama ?></td>
							<td width="5%" class="text-center">
								<button class="btn btn-sm btn-primary" onclick="add_access('<?= $r->id ?>')"><i class="fa fa-cogs"></i></button>
							</td>
						</tr>
					<?php } ?>
				</table>
			</div>

		</div>
	</div>
	<!--end::Row-->
</div>
<!--end::Container-->


<div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="<?= base_url('ajax/update_access_menu') ?>" method="post" id="form_access">
				<input type="hidden" name="role" id="idrole">
				<div class="modal-body" id="show_form">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="to_submit">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	const spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

	function add_access(id) {
		$('#staticBackdrop').modal('show')
		$('#staticBackdropLabel').html('Akses Menu')
		$('#show_form').html('')
		$('#idrole').val(id)
		show_access_form(id)
	}

	function show_access_form(id) {
		$.ajax({
			url: '<?= base_url('ajax/get_form_menu') ?>',
			data: {
				role: id
			},
			type: 'POST',
			success: function(d) {
				$('#show_form').html(d)
			},
			error: function(xhr, status, error) {
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

	$('#form_access').submit(function(e) {
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
				if (d.status == false) {
					Swal.fire({
						title: "Error",
						text: d.msg,
						icon: "error"
					}).then((res) => {
						window.location.reload();
					});
				} else {
					Swal.fire({
						title: "Success",
						text: d.msg,
						icon: "success"
					}).then((res) => {
						window.location.reload();
					});
				}
			},
			error: function(xhr, status, error) {
				$('#to_submit').removeAttr('disabled')
				$('#to_submit').html('Save')
				error_alert(error)
			}
		})
	})
</script>