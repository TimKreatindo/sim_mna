import {
	ClassicEditor,
	Essentials,
	Heading,
	Paragraph,
	Bold,
	Italic,
	Underline,
	Font,
	Link,
	BlockQuote,
	List,
	Indent,
	IndentBlock,
	Table,
	TableColumnResize,
	TableToolbar,
} from "ckeditor5";

let val_editor_1 = $("#val_activity").data("value");
let val_editor_2 = $("#val_solve").data("value");

let val_report_1 = $("#hidden_kegiatan").data("value");
let val_report_2 = $("#hidden_temuan").data("value");

let value_editor_1;
let value_editor_2;

if (val_editor_1 == "" || val_editor_1 == null) {
	value_editor_1 = val_report_1;
} else {
	value_editor_1 = val_editor_1;
}

if (val_editor_2 == "" || val_editor_2 == null) {
	value_editor_2 = val_report_2;
} else {
	value_editor_2 = val_editor_2;
}

ClassicEditor.create(document.querySelector(".editor"), {
	licenseKey: "GPL", // Or 'GPL'.
	plugins: [
		Essentials,
		Heading,
		Paragraph,
		Bold,
		Italic,
		Font,
		Underline,
		Link,
		BlockQuote,
		List,
		Indent,
		IndentBlock,
		Table,
		TableColumnResize,
		TableToolbar,
	],
	toolbar: [
		"undo",
		"redo",
		"|",
		"heading",
		"bold",
		"italic",
		"underline",
		"link",
		"BlockQuote",
		"insertTable",
		"|",
		"fontSize",
		"fontFamily",
		"fontColor",
		"fontBackgroundColor",
		"|",
		"bulletedList",
		"numberedList",
		"|",
		"outdent",
		"indent",
	],
	initialData: value_editor_1,
})
	.then((editor) => {
		window.editor = editor;
		editor1 = editor;
	})
	.catch((error) => {
		console.error(error);
	});

ClassicEditor.create(document.querySelector(".editor2"), {
	licenseKey: "GPL", // Or 'GPL'.
	plugins: [
		Essentials,
		Heading,
		Paragraph,
		Bold,
		Italic,
		Font,
		Underline,
		Link,
		BlockQuote,
		List,
		Indent,
		IndentBlock,
		Table,
		TableColumnResize,
		TableToolbar,
	],
	toolbar: [
		"undo",
		"redo",
		"|",
		"heading",
		"bold",
		"italic",
		"underline",
		"link",
		"BlockQuote",
		"insertTable",
		"|",
		"fontSize",
		"fontFamily",
		"fontColor",
		"fontBackgroundColor",
		"|",
		"bulletedList",
		"numberedList",
		"|",
		"outdent",
		"indent",
	],
	initialData: value_editor_2,
})
	.then((editor) => {
		window.editor = editor;
		editor2 = editor;
	})
	.catch((error) => {
		console.error(error);
	});
