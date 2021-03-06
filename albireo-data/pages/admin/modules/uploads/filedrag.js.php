<script>
	/*
filedrag.js - HTML5 File Drag & Drop demonstration
Featured on SitePoint.com
Developed by Craig Buckler (@craigbuckler) of OptimalWorks.net
*/
	(function() {

		// getElementById
		function $id(id) {
			return document.getElementById(id);
		}

		// output information
		function Output(msg) {
			var m = $id("upload_messages");
			m.innerHTML = msg + m.innerHTML;
		}

		// file drag hover
		function FileDragHover(e) {
			e.stopPropagation();
			e.preventDefault();
			e.target.className = (e.type == "dragover" ? "hover" : "");
		}

		// file selection
		function FileSelectHandler(e) {

			// cancel event and hover styling
			FileDragHover(e);

			// fetch FileList object
			var files = e.target.files || e.dataTransfer.files;

			// process all File objects
			for (var i = 0, f; f = files[i]; i++) {

				// console.log(f);

				if (f.size > $id("upload_max_file_size").value) {
					Output("<p class='t-red'>Large file - " + f.name + " (" + f.size + " byte)</p>");
					continue;
				}

				var ext = '|' + f.name.substr(f.name.lastIndexOf(".") + 1) + '|';
				var upload_ext = '|' + $id("upload_ext").value + '|';

				// console.log(upload_ext);
				// console.log(ext);

				if (upload_ext.indexOf(ext) == -1) {
					Output("<p class='t-red t-white'>Forbidden type file - " + f.name + " (" + f.type + ")</p>");
					continue;
				}

				ParseFile(f);
				UploadFile(f);
			}
		}

		// output file information
		function ParseFile(file) {
			// ничего не выводим
			return;

			Output(
				'<div class="t90 mar5-b"><b>' + file.name + '</b> | Type: ' + file.type + ' | Size: ' + file.size + 'bytes</div>'
			);
		}

		// upload files
		function UploadFile(file) {
			var xhr = new XMLHttpRequest();

			if (xhr.upload && (file.size > $id("upload_max_file_size").value)) {
				return;
			}

			var ext = '|' + file.name.substr(file.name.lastIndexOf(".") + 1) + '|';
			var upload_ext = '|' + $id("upload_ext").value + '|';

			if (xhr.upload && (upload_ext.indexOf(ext) > -1)) {

				// create progress bar
				var o = $id("upload_progress");
				var progress = o.appendChild(document.createElement("p"));
				progress.appendChild(document.createTextNode("Preparing... " + file.name));

				// progress bar
				xhr.upload.addEventListener("progress", function(e) {
					// var pc = parseInt(100 - (e.loaded / e.total * 100));
					// progress.style.backgroundPosition = pc + "% 0";

					progress.innerHTML = "Uploading " + parseInt(e.loaded / e.total * 100) + "% ... please wait...";

				}, false);

				// file received/failed
				xhr.onreadystatechange = function(e) {
					if (xhr.readyState == 4) {
						progress.className = (xhr.status == 200 ? "success" : "failure");
						Output('<p class="t90">' + xhr.responseText + '</p>');
						progress.innerHTML = file.name + ' ... (' + file.size + ' byte)';
					}
				};

				// start upload
				xhr.open("POST", $id("upload_action").value, true);

				xhr.setRequestHeader("X-REQUESTED-FILENAME", unescape(encodeURIComponent(file.name)));
				xhr.setRequestHeader("X-REQUESTED-FILEUPDIR", unescape(encodeURIComponent($id("upload_dir").value)));
				xhr.setRequestHeader("X-REQUESTED-REPLACEFILE", unescape(encodeURIComponent($id("upload_replace_file").checked )));

				xhr.send(file);
			}
		}

		// initialize
		function Init() {

			var fileselect = $id("upload_fileselect"),
				filedrag = $id("upload_filedrag"),
				submitbutton = $id("upload_submitbutton");

			// console.log($id("upload_action").value);

			// file select
			fileselect.addEventListener("change", FileSelectHandler, false);

			// is XHR2 available?
			var xhr = new XMLHttpRequest();
			if (xhr.upload) {
				// file drop
				filedrag.addEventListener("dragover", FileDragHover, false);
				filedrag.addEventListener("dragleave", FileDragHover, false);
				filedrag.addEventListener("drop", FileSelectHandler, false);
				filedrag.style.display = "block";

				// remove submit button
				submitbutton.style.display = "none";
			}
		}

		// call initialization file
		if (window.File && window.FileList && window.FileReader) {
			Init();
		}

	})();
</script>