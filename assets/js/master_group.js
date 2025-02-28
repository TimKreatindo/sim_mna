// const base_url = $("#base_url").data("val");

$(document).ready(function () {
	load_main_data();
	$("#modalMHS, #modalPemlap").on("show.bs.modal", function () {
		$("#modalAdd").modal("hide");
	});

	$("#modalMHS, #modalPemlap").on("hide.bs.modal", function () {
		$("#modalAdd").modal("show");
	});
});

function add_data() {
	$("#modalAdd").modal("show");
	$("#modalAdd .modal-title").html("Tambah Data");

	$("#action").val("add");
	$("#id_group").val("");
	$("#name").val("");
	$("#periode").val("");
	$("#dospem").val("");

	$("#table_mhs tbody").html("");
	$("#table_pemlap tbody").html("");
}

function add_list_mhs() {
	$("#modalMHS").modal("show");

	let all_form = $("#form_group").serializeArray();
	let has_selected = [];
	for (let i = 0; i < all_form.length; i++) {
		if (all_form[i].name == "mahasiswa[]") {
			has_selected.push(all_form[i].value);
		}
	}

	load_list_mhs(has_selected);
}

function add_list_pemlap() {
	$("#modalPemlap").modal("show");
	let all_form = $("#form_group").serializeArray();
	let has_selected = [];
	for (let i = 0; i < all_form.length; i++) {
		if (all_form[i].name == "pemlap[]") {
			has_selected.push(all_form[i].value);
		}
	}
	load_list_pemlap(has_selected);
}

function load_list_mhs(has_selected = null) {
	$("#table_list_mahasiswa").DataTable().destroy();
	$("#table_list_mahasiswa").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "load_list_mahasiswa_table",
			type: "POST",
			data: {
				selected: has_selected,
			},
		},
		columnDefs: [
			{
				targets: [0, 1, 2, 3, 4], //first column / numbering column
				className: "text-nowrap",
			},
		],
		ordering: false,
		iDisplayLength: 10,
		autoWidth: false,
	});
}

function select_mhs(id = null, nim = null, nama = null, email = null) {
	$("#modalMHS").modal("hide");
	const html =
		"<tr><td>" +
		nim +
		"<input type='hidden' name='mahasiswa[]' value='" +
		id +
		"'>" +
		"</td> <td>" +
		nama +
		"</td> <td>" +
		email +
		"</td> <td><button class='btn btn-sm btn-danger remove_list' type='button'><i class='far fa-times-circle'></i></button></td></tr>";

	$("#table_mhs tbody").append(html);
}

function load_list_pemlap(has_selected = null) {
	$("#table_list_pemlap").DataTable().destroy();
	$("#table_list_pemlap").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "load_list_pemlap_table",
			type: "POST",
			data: {
				selected: has_selected,
			},
		},
		columnDefs: [
			{
				targets: [0, 1, 2, 3, 4], //first column / numbering column
				className: "text-nowrap",
			},
		],
		ordering: false,
		iDisplayLength: 10,
		autoWidth: false,
	});
}

function select_pemlap(
	id = null,
	nama = null,
	email = null,
	instansi = null,
	alamat = null
) {
	$("#modalPemlap").modal("hide");

	const html =
		"<tr><td>" +
		nama +
		"<input type='hidden' name='pemlap[]' value='" +
		id +
		"'>" +
		"<td>" +
		email +
		"</td> <td>" +
		instansi +
		"</td> <td>" +
		alamat +
		"</td>" +
		"<td><button class='btn btn-sm btn-danger remove_list' type='button'><i class='far fa-times-circle'></i></button></td></tr>";

	$("#table_pemlap tbody").append(html);
}

$(document).on("click", ".remove_list", function () {
	$(this).parent("td").parent("tr").remove();
});

$("#form_group").submit(function (e) {
	e.preventDefault();
	loading_animation();

	$.ajax({
		url: $(this).attr("action"),
		data: $(this).serialize(),
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
					$("#modalAdd").modal("hide");
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
});

function load_main_data() {
	let periode = $("#select_periode").val();
	$("#table_periode").DataTable().destroy();
	$("#table_periode").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "table_group",
			type: "POST",
			data: {
				periode: periode,
			},
		},
		columnDefs: [
			{
				targets: [0, 1, 2, 3, 4], //first column / numbering column
				className: "text-nowrap",
			},
		],
		ordering: false,
		iDisplayLength: 10,
		autoWidth: false,
	});
}

$("#select_periode").change(function () {
	load_main_data();
});

function detail_data(id = null) {
	if (id) {
		loading_animation();

		$.ajax({
			url: base_url + "act_group",
			data: {
				id: id,
				act: "detail",
			},
			type: "POST",
			error: function (xhr, status, error) {
				setTimeout(() => {
					Swal.close();
					error_alert(error);
				}, 200);
			},
			success: function (d) {
				const main = d.main_data[0];
				const mhs = d.mahasiswa;
				const pemlap = d.pemlap;

				$("#group_name").html(main.nama_group);
				$("#dospem_name").html(main.nama_lengkap);
				$("#periode_name").html(main.periode);

				let html_mhs = "";
				let html_pemlap = "";
				for (let i = 0; i < mhs.length; i++) {
					html_mhs +=
						"<tr> <td>" +
						mhs[i].nim +
						"</td> <td>" +
						mhs[i].nama_lengkap +
						"</td> <td>" +
						mhs[i].email +
						"</td> </tr>";
				}

				for (let a = 0; a < pemlap.length; a++) {
					html_pemlap +=
						"<tr> <td>" +
						pemlap[a].nama_lengkap +
						"</td> <td>" +
						pemlap[a].email +
						"</td> <td>" +
						pemlap[a].instansi_magang +
						"</td> <td>" +
						pemlap[a].alamat_magang +
						"</td> </tr>";
				}

				$("#table_mahasiswa tbody").html(html_mhs);
				$("#table_detail_pemlap tbody").html(html_pemlap);

				setTimeout(() => {
					$("#modalDetail").modal("show");
					Swal.close();
				}, 200);
			},
		});
	} else {
		error_alert("invalid parameters");
	}
}

function edit_data(id) {
	if (id) {
		loading_animation();

		$.ajax({
			url: base_url + "act_group",
			data: {
				id: id,
				act: "detail",
			},
			type: "POST",
			error: function (xhr, status, error) {
				setTimeout(() => {
					Swal.close();
					error_alert(error);
				}, 200);
			},
			success: function (d) {
				const main = d.main_data[0];
				const mhs = d.mahasiswa;
				const pemlap = d.pemlap;

				let html_mhs = "";
				let html_pemlap = "";

				for (let a = 0; a < mhs.length; a++) {
					html_mhs +=
						"<tr><td>" +
						mhs[a].nim +
						"<input type='hidden' name='mahasiswa[]' value='" +
						mhs[a].id +
						"'>" +
						"</td> <td>" +
						mhs[a].nama_lengkap +
						"</td> <td>" +
						mhs[a].email +
						"</td> <td><button class='btn btn-sm btn-danger remove_list' type='button'><i class='far fa-times-circle'></i></button></td></tr>";
				}
				for (let b = 0; b < pemlap.length; b++) {
					html_pemlap +=
						"<tr><td>" +
						pemlap[b].nama_lengkap +
						"<input type='hidden' name='pemlap[]' value='" +
						pemlap[b].id +
						"'>" +
						"<td>" +
						pemlap[b].email +
						"</td> <td>" +
						pemlap[b].instansi_magang +
						"</td> <td>" +
						pemlap[b].alamat_magang +
						"</td>" +
						"<td><button class='btn btn-sm btn-danger remove_list' type='button'><i class='far fa-times-circle'></i></button></td></tr>";
				}
				$("#table_mhs tbody").html(html_mhs);
				$("#table_pemlap tbody").html(html_pemlap);
				$("#modalAdd .modal-title").html("Edit Data");

				$("#action").val("edit");
				$("#id_group").val(id);
				$("#name").val(main.nama_group);
				$("#periode").val(main.id_periode);
				$("#dospem").val(main.id_dosen);

				setTimeout(() => {
					$("#modalAdd").modal("show");
					Swal.close();
				}, 200);
			},
		});
	} else {
		error_alert("invalid parameters");
	}
}

function delete_data(id) {
	if (id) {
		Swal.fire({
			title: "Apakah anda yakin?",
			text: "Untuk menghapus group ini?",
			showCancelButton: true,
			confirmButtonText: "Yes",
		}).then((result) => {
			/* Read more about isConfirmed, isDenied below */
			if (result.isConfirmed) {
				loading_animation();
				$.ajax({
					url: base_url + "act_group",
					data: {
						id: id,
						act: "delete",
					},
					type: "POST",
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
		});
	} else {
		error_alert("invalid parameters");
	}
}
