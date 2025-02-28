// const base_url = $("#base_url").data("val");

$(document).ready(function () {
	$("#main_table").dataTable();
});

$("#form_periode").submit(function (e) {
	e.preventDefault();
	loading_animation();

	$.ajax({
		url: $(this).attr("action"),
		data: $(this).serialize(),
		type: "post",
		dataType: "json",
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
						$("#staticBackdrop").modal("hide");
						window.location.reload();
					});
				}
			}, 200);
		},
		error: function (xhr, status, error) {
			setTimeout(() => {
				Swal.close();
				alert(error);
			}, 200);
		},
	});
});

function add_data() {
	$("#staticBackdrop").modal("show");
	$("#staticBackdrop").find(".modal-title").text("Tambah Data");
	$("#act_periode").val("add");
	$("#id_periode").val("");
	$("#periode").val("");
}

function edit_data(id, periode) {
	if (id && periode) {
		$("#staticBackdrop").modal("show");
		$("#staticBackdrop").find(".modal-title").text("Edit Data");
		$("#act_periode").val("edit");
		$("#id_periode").val(id);
		$("#periode").val(periode);
	} else {
		error_alert("Data invalid");
	}
}

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
				loading_animation();
				$.ajax({
					url: base_url + "act_master_periode",
					data: {
						id: id,
						act: "delete",
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
		});
	} else {
		error_alert("Data invalid");
	}
}
