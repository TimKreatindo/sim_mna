function accept_report(id) {
	const stat = 1;
	ajax_act_report(id, stat);
}
function reject_report(id) {
	const stat = 0;
	ajax_act_report(id, stat);
}

function ajax_act_report(id, stat) {
	loading_animation();
	let notes = $("#notes").val();
	$.ajax({
		url: base_url + "act-report",
		data: { id: id, status: stat, notes: notes },
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
					Swal.fire({
						icon: "success",
						title: "Success",
						text: d.msg,
					}).then((res) => {
						window.location.reload();
					});
				}
			}, 200);
		},
	});
}
