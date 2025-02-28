// const base_url = $("#base_url").data("val");

$(document).ready(function () {
	$("#main_table").dataTable();
});

function delete_data(id) {
	if (id) {
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Data akan di hapus permanen",
			showDenyButton: false,
			showCancelButton: true,
			confirmButtonText: "Yes",
		}).then((result) => {
			if (result.isConfirmed) {
				main_action(id, "delete");
			}
		});
	} else {
		error_alert("Data invalid");
	}
}

function status_account(id, status) {
	if (id && status) {
		main_action(id, "status", status);
	} else {
		error_alert("Data invalid");
	}
}

function main_action(id, action, status = null) {
	loading_animation();
	$.ajax({
		url: base_url + "act_master_pemlap",
		data: {
			id: id,
			act: action,
			status: status,
		},
		type: "Post",
		dataType: "JSON",
		error: function (xhr, status, error) {
			setTimeout(() => {
				Swal.close();
				error_alert(error);
			}, 200);
		},
		success: function (data) {
			setTimeout(() => {
				Swal.close();
				if (data.status == false) {
					Swal.fire({
						icon: "error",
						title: "Error",
						text: data.msg,
					});
				} else {
					Swal.fire({
						icon: "success",
						title: "Success",
						text: data.msg,
					}).then((res) => {
						window.location.reload();
					});
				}
			}, 200);
		},
	});
}
