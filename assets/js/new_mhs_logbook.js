$(document).ready(function () {
	let select_kegiatan = $("#mengikuti_kegiatan").val();
	let kegiatan = $("#show_opt_kegiatan").data("kegiatan");

	if (select_kegiatan == "Iya" && kegiatan != "") {
		let html =
			'<label><b>Jenis Kegiatan</b></label>  <input type="text" name="kegiatan" class="form-control" value="' +
			kegiatan +
			'" required>';
		$("#show_opt_kegiatan").html(html);
	} else if (select_kegiatan == "Tidak" && kegiatan != "") {
		let html =
			'<label><b>Alasan Tidak Mengikuti Kegiatan</b></label>  <input value="' +
			kegiatan +
			'" type="text" name="kegiatan" class="form-control" required>';
		$("#show_opt_kegiatan").html(html);
	} else {
		$("#show_opt_kegiatan").html("");
	}
});

$("#mengikuti_kegiatan").on("change", function () {
	let thisval = $(this).val();
	if (thisval && thisval === "Iya") {
		let html =
			'<label><b>Jenis Kegiatan</b></label>  <input type="text" name="kegiatan" class="form-control" required>';
		$("#show_opt_kegiatan").html(html);
	} else if (thisval && thisval == "Tidak") {
		let html =
			'<label><b>Alasan Tidak Mengikuti Kegiatan</b></label>  <input type="text" name="kegiatan" class="form-control" required>';
		$("#show_opt_kegiatan").html(html);
	} else {
		$("#show_opt_kegiatan").html("");
	}
});

$("#form_my_logbook").submit(function (e) {
	e.preventDefault();
	loading_animation();

	let activity = editor1.getData();
	let solve = editor2.getData();

	$.ajax({
		url: $(this).attr("action"),
		data: (function (formData) {
			let dataTambahan = {
				aktivitas: activity,
				solusi: solve,
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
