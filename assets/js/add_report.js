$("#form_main").submit(function (e) {
	e.preventDefault();
	loading_animation();

	let activity = editor1.getData();
	let solve = editor2.getData();

	$.ajax({
		url: $(this).attr("action"),
		data: (function (formData) {
			let dataTambahan = {
				activity: activity,
				result: solve,
			};

			$.each(dataTambahan, function (key, value) {
				formData.append(key, value);
			});

			return formData;
		})(new FormData(this)),
		type: "POST",
		dataType: "JSON",
		contentType: false,
		processData: false,

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
						window.location.href = d.redirect;
					});
				}
			}, 200);
		},
	});
});
