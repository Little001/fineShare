<!-- HEADER -->
<?php include 'header.php'; ?>
<!-- CONTENT -->		
<div class="content-middle">
	<form id="upload" method="post" action="uploader.php" enctype="multipart/form-data">
		<div id="drop">
			<a>Procházet</a>
			<span>Zde můžete přesunout soubory</span>
			<input type="file" name="upl" multiple />
		</div>
		<ul>
		</ul>
	</form>
	<!-- JavaScript Includes -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="uploader/js/jquery.knob.js"></script>
	<!-- jQuery File Upload Dependencies -->
	<script src="uploader/js/jquery.ui.widget.js"></script>
	<script src="uploader/js/jquery.iframe-transport.js"></script>
	<script src="uploader/js/jquery.fileupload.js"></script>
	<!-- Our main JS file -->
	<script src="uploader/js/script.js"></script>
</div>
<!-- FOOTER -->
<?php include 'footer.php'; ?>
