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
	$('.reset-files-search').on('click', onResetSearchFiles);

	function onResetSearchFiles() {
		location.reload();
	}

	function onSearchFiles(event) {
		event.preventDefault();

		var searchString = $(this).find('input').val();
		var sensitive = $('.sensitive select').find('option:selected').attr('value');
		var directory = $('.directories select').find('option:selected').attr('value');

		doSearchFiles(searchString, sensitive, directory);
	}

	function doSearchFiles(searchString, sensitive, directory) {
		$.ajax({
			url: 'file-finder/api/searchByContent',
			type: 'GET',
			data: {
				searchString: searchString,
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
		alert(data.responseJSON.error);
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
		var foundFilesCount = data.foundFilesCount;
		var element = $('.files');


		$('.found').text(foundFilesCount);
		$('.from').text(data.searchedFilesCount);

		if(foundFilesCount === 0) {
			element.html('<h3>No files content matched your search criteria !</h3>');

			return;
		}

		element.html('');

		for(var i = 0; i < foundFilesCount; i++) {
			element.append(getFileTemplate(files[i]))
		}
	}
});