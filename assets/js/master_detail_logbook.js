function reject_logbook() {
	const act = 0;
	to_action(act);
}

function approve_logbook() {
	const act = 1;
	to_action(act);
}

function to_action(act) {
	const id = $("#uri").data("value");
	let notes = $("#notes").val();

	loading_animation();
	$.ajax({
		url: base_url + "action-logbook",
		data: {
			act: act,
			id: id,
			notes: notes,
		},
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
