$(function() {
	$('#file-finder-form').submit(onSearchFiles);
	$('.reset-files-search').click(onResetSearchFiles);
	$('#show-documentation').click(onToggleClassDocumentation.bind(this, 'addClass'));
	$('#hide-documentation').click(onToggleClassDocumentation.bind(this, 'removeClass'));

	function onToggleClassDocumentation(method) {
		$('#documentation-panel')[method]('show-documentation');
	}

	function onResetSearchFiles() {
		showLoading();
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
			beforeSend: showLoading,
			error: onError,
			success: successFiles,
			complete: removeLoading
		});
	}

	function onError(data) {
		alert(data.responseJSON.error);
	}

	function successFiles(data) {
		var files = data.files;
		var foundFilesCount = data.foundFilesCount;
		var element = $('.files');


		$('.found').text(foundFilesCount);
		$('.from').text(data.searchedFilesCount);

		if(foundFilesCount === 0) {
			element.html(getNoResultTemplate());

			return;
		}

		element.html('');

		for(var i = 0; i < foundFilesCount; i++) {
			element.append(getFileTemplate(files[i]))
		}
	}

	function showLoading() {
		if($('.holder-loading').length > 0) {
			return;
		}

		$('body').prepend(getLoadingTemplate);
	}

	function removeLoading() {
		$('.holder-loading').fadeOut(400, function() {
			$(this).remove();
		});
	}
});