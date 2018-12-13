<!doctype html>
<html lang="en">
<head>
	<title>File Finder Demo</title>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="{{asset('file_finder/css/style.css')}}">
	<script
		src="https://code.jquery.com/jquery-3.3.1.min.js"
		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="{{asset('file_finder/js/filefinder_templates.js')}}"></script>
	<script src="{{asset('file_finder/js/scripts.js')}}"></script>
</head>
<body>
	<div id="demo-finder">
		<div id="documentation-panel" class="sidenav">
			<a href="javascript:void(0)" class="closebtn" id="hide-documentation">&times;</a>
			<div id="content-sidenav">
				<h2 class="padding-border">Available Features</h2>
				<ul class="content-bg">
					<li>- Search files by Content</li>
				</ul>
				
				<h3 class="padding-border">API SETTINGS</h3>
				<ul class="content-bg">
					<li>- Set case sensitive for string search</li>
					<li>- Choose directory searching</li>
				</ul>
				
				<h3 class="padding-border">REST API</h3>
				<div class="content-bg">
					<span>Route:  file-finder/api/searchByContent</span>
					<p class="q-params">Query params</p>
					<ul>
						<li>- searchString -> searched string in content file</li>
						<li>- directory -> traversed directory</li>
						<li>- sensitive -> search by case sensitive</li>
					</ul>
				</div>
				<h3 class="padding-border top-padding">Errors</h3>
				<div class="content-bg">
					<div class="code-style">
						<div>
							{
							<div>
								<span>"error"</span>: "ERROR MESSAGE"
							</div>
							}
						</div>
					</div>
				</div>
				<h3 class="padding-border top-padding">JSON Results</h3>
				<div class="content-bg">
					<div class="code-style">
						<div class="l1">
							{
							<div class="l2">
								<span>"searchedString"</span>: "test",<br>
								<span>"searchedFilesCount"</span>: 19,<br>
								<span>"foundFilesCount"</span>: 2,<br>
								<span>"files"</span>: [
								<div class="l3">
									{
									<div class="l2">
										<span>"name"</span>: "test1.txt",<br>
										<span>"directory"</span>: "TextFiles",<br>
										<span>"pathName"</span>: "Directory name",<br>
										<span>"extension"</span>: "txt",<br>
										<span>"size"</span>: 27,<br>
										<span>"positionString"</span>: 0
									</div>
									},
								</div>
								]
							</div>
							}
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Use any element to open the sidenav -->
		<button class="btn btn-info btn-lg" id="show-documentation">Documentation</button>
		
		<!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
		<div id="main">
			<div class="container">
				<div class="row holder-settings">
					<div class="sensitive">
						<span>Select case sensitive</span>
						<select>
							<option value="off">off</option>
							<option value="on">on</option>
						</select>
					</div>
					<div class="directories">
						<span>Select directory</span>
						<select>
							@foreach($directories as $path => $directory)
								<option value="{{$path}}">{{$directory}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="row">
					<div class="flex-container">
						<div id="custom-search-input">
							<h2>Test File Finder API</h2>
							<form action="#" method="GET" id="file-finder-form">
								<div class="input-group col-md-12">
									<input required type="text" class="form-control input-lg" placeholder="search file..." />
									<span class="input-group-btn">
									<button class="btn btn-info btn-lg" type="submit">
										<i class="glyphicon glyphicon-search"></i>
									</button>
								</span>
								</div>
							</form>
						</div>
						<button class="btn btn-info btn-lg reset-files-search" type="button">
							Reset
						</button>
						<div class="search-data">
							<span>Found <b class="found">{{$data['foundFilesCount']}}</b> from <b class="from">{{$data['searchedFilesCount']}}</b></span>
						</div>
					</div>
				</div>
				
				<div class="row files">
					@foreach($data['files'] as $file)
						<div class="panel panel-default">
							<div class="panel-body">
								<p>Directory - {{$file['directory']}}</p>
								<p>File name - {{$file['name']}}</p>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</body>
</html>