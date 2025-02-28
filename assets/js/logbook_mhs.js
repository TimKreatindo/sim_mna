$(document).ready(function () {
	load_table();
});

function load_table() {
	$("#my-table").DataTable().destroy();
	$("#my-table").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "mhs/load_my_logbook",
			type: "POST",
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
		url: base_url + "mhs/show_log_activity",
		data: { id: id },
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
