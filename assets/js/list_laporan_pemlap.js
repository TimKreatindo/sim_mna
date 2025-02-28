$(document).ready(function () {
	load_main_table();
});

function load_main_table() {
	const id = $("#id_users").data("value");
	$("#main_table").DataTable().destroy();
	$("#main_table").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "table-list-report",
			type: "POST",
			data: {
				id: id,
			},
		},
		columnDefs: [{}],
		ordering: false,
		iDisplayLength: 10,
		autoWidth: false,
	});
}

function detail_log(id) {
	loading_animation();
	$.ajax({
		url: base_url + "act_laporan",
		data: { id: id, act: "log" },
		type: "POST",
		dataType: "JSON",
		error: function (xhr, status, error) {
			setTimeout(() => {
				Swal.close();
				error_alert(error);
			}, 200);
		},
		success: function (d) {
			setTimeout(() => {
				Swal.close();
				if (d.status == false) {
					error_alert(d.msg);
				} else {
					let data = d.data;
					let html = "";
					for (let i = 0; i < data.length; i++) {
						html +=
							"<tr> <td>" +
							data[i].date +
							"</td> <td>" +
							data[i].desc +
							"</td> </tr>";
					}
					$("#modalLog .modal-body table tbody").html(html);
					$("#modalLog").modal("show");
				}
			}, 200);
		},
	});
}
