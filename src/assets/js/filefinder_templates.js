function getFileTemplate(file) {
	return '<div class="panel panel-default">\n' +
		'<div class="panel-body">\n' +
		'<p>Directory - ' + file.directory +
		'<p>File name - ' + file.name  +
		'</div>\n' +
		'</div>';
}

function getNoResultTemplate() {
	return '<h3>No files content matched your search criteria !</h3>';
}

function getLoadingTemplate() {
	return '<div class="holder-loading">' +
	'<div class="loading"></div>' +
	'</div>';
}
