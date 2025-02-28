$(document).ready(function () {
	load_main_table();
});

function load_main_table() {
	$("#main_table").DataTable().destroy();
	$("#main_table").dataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "table-list-pemlap",
			type: "POST",
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
