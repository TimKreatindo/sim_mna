$(document).ready(function () {
	load_main_data();
});

function load_main_data() {
	let periode = $("#periode").val();
	let group = $("#group").val();
	let dosen = $("#dosen").val();

	$("#list_mahasiswa").DataTable().destroy();
	$("#list_mahasiswa").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "load-list-mahasiswa",
			type: "POST",
			data: {
				periode: periode,
				group: group,
				dosen: dosen,
			},
		},
		columnDefs: [
			{
				targets: [0, 1, 2, 3], //first column / numbering column
				className: "text-nowrap",
			},
		],
		ordering: false,
		iDisplayLength: 10,
		autoWidth: false,
	});
}

function filter_data() {
	load_main_data();
}
