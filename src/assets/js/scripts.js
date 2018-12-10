/* Set the width of the side navigation to 250px and the left margin of the page content to 250px and add a black background color to body */
function openNav() {
	document.getElementById("mySidenav").style.width = "500px";
	document.getElementById("main").style.marginLeft = "500px";

	setTimeout(function() {
		document.getElementById("content-sidenav").style.opacity = "1";
	}, 500)
}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
function closeNav() {
	document.getElementById("content-sidenav").style.opacity = "0";

	setTimeout(function() {
		document.getElementById("mySidenav").style.width = "0";
		document.getElementById("main").style.marginLeft = "0";
	}, 400)
}

$(function() {
	$('#file-finder-form').on('submit', onSearchFiles);

	function onSearchFiles(event) {
		event.preventDefault();

		var searchKey = $(this).find('input').val();
		var sensitive = $('.sensitive select').find('option:selected').attr('value');
		var directory = $('.directories select').find('option:selected').attr('value');

		$.ajax({
			url: 'file-finder/api/searchByContent',
			type: 'GET',
			data: {
				searchKey: searchKey,
				directory: directory,
				sensitive: sensitive
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			error: onError,
			success: successFiles
		});
	}

	function onError(data) {
		alert(data);
	}

	function getFileTemplate(file) {
		return '<div class="panel panel-default">\n' +
			'<div class="panel-body">\n' +
			'<p>Directory - ' + file.directory +
			'<p>File name - ' + file.name  +
			'</div>\n' +
			'</div>';
	}

	function successFiles(data) {
		var files = data.files;
		var foundFiles = data.foundFiles;
		var element = $('.files');


		$('.found').text(foundFiles);
		$('.from').text(data.searchedFiles);

		if(foundFiles === 0) {
			element.html('<h3>No files content matched your search criteria !</h3>');

			return;
		}

		element.html('');

		for(var i = 0; i < data.foundFiles; i++) {
			element.append(getFileTemplate(files[i]))
		}
	}
});