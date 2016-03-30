<?php include 'header.php'; ?>
<!-- CONTENT -->
<script>
	$(document).on("click", "a.fileDownloadPromise", function () {
    $.fileDownload($(this).prop('href'))
        .done(function () { alert('File download a success!'); })
        .fail(function () { alert('File download failed!'); });
 
    return false; //this is critical to stop the click event which will trigger a normal file download
});
	
</script>

<a class="fileDownloadPromise" href="uploader/files/Images/Arco.pdf">reportA</a>

<!-- FOOTER -->
<?php include 'footer.php'; ?>
