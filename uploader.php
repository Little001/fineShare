<?php
// A list of permitted file extensions for Images
$images = array('jpeg', 'jfif', 'jif', 'jp2', 'jpx', 'j2k', 'j2c', 'fpx', 'pcd', 'jpg', 'exif', 'tiff', 'tif', 
				'gif', 'bmp', 'png', 'ppm', 'pgm', 'pbm', 'pnm', 'webp', 'hdr', 'heif', 'bpg', 'cgm', 'svg');
// A list of permitted file extensions for audio
$audio = array('aa', 'aac', 'aax', 'act', 'aiff', 'amr', 'ape', 'au', 'awb', 'dct', 'dss', 'dvf', 'flac', 
			   'gsm', 'iklax', 'ivs', 'm4a', 'm4b', 'm4p', 'mmf', 'mp3', 'mpc', 'msv', 'ogg', 'oga', 'opus', 
			   'ra', 'rm', 'raw', 'sln', 'tta', 'vox', 'wav', 'wma', 'wv', 'webm');
// A list of permitted file extensions for video
$video = array('webm', 'mkv', 'flv', 'vob', 'ogv', 'drc', 'gifv', 'mng', 'avi', 'mov', 'qt', 'wmv', 'yuv', 
			   'rmvb', 'asf', 'mp4', 'm4p', 'm4v', 'mpg', 'mp2', 'mpeg', 'mpe', 'mpv', 'm2v', 'svi', '3gp', 
			   '3g2', 'mxf', 'roq', 'nsv', 'flv', 'f4v', 'f4p', 'f4a', 'f4b');
// A list of permitted file extensions for documents
$documents = array('doc', 'docx', 'log', 'msg', 'odt', 'pages', 'rtf', 'tex', 'txt', 'wpd', 'wps', 'csv', 
				   'dat', 'ged', 'key', 'keychain', 'pps', 'ppt', 'pptx', 'sdf', 'tax2014', 'tax2015', 
				   'vcf', 'xml', 'pdf', 'indd', 'accdb', 'db', 'dbf', 'mdb', 'pdb', 'sql', 'dwg', 'dxf', 
				   '.asp', 'aspx', 'cer', 'cfm', 'csr', 'css', 'htm', 'html', 'js', 'jsp', 'php', 'rss', 
				   'xhtml', 'fnt', 'fon', 'otf', 'ttf', 'cfg', 'ini');
// A list of permitted file extensions for $archive
$archive = array('7z', 'cbr', 'deb', 'gz', 'pkg', 'rar', 'rpm', 'sitx', 'tar.gz', 'tar', 'zip', 'zipx');

// not supported files!
$notSupport = array('apk', 'app', 'bat', 'cgi', 'com', 'exe', 'gadget', 'jar', 'pif', 'wsf');

$direction = 'uploader/files/';
$table = '';
$currentDirect = '';

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
	
	//when upload file is not supported
	if(in_array(strtolower($extension), $notSupport)){
		echo '{"status":"error"}';
		exit;
	}
	if(in_array(strtolower($extension), $video)){
		$direction = 'uploader/files/Video/';
		$table = 'video';
		$currentDirect = 'Video';
	}
	if(in_array(strtolower($extension), $audio)){
		$direction = 'uploader/files/Audio/';
		$table = 'audio';
		$currentDirect = 'Audio';
	}
	if(in_array(strtolower($extension), $images)){
		$direction = 'uploader/files/Images/';
		$table = 'images';
		$currentDirect = 'Images';
	}
	if(in_array(strtolower($extension), $documents)){
		$direction = 'uploader/files/Documents/';
		$table = 'documents';
		$currentDirect = 'Documents';
	}
	if(in_array(strtolower($extension), $archive)){
		$direction = 'uploader/files/Archives/';
		$table = 'archives';
		$currentDirect = 'Archives';
	}
	if(move_uploaded_file($_FILES['upl']['tmp_name'], $direction.$_FILES['upl']['name'])){	
		//add file info to DB   
		include 'dbConnection.php';		
		$url = $direction .$_FILES['upl']['name'];
		$sql = "INSERT INTO ".$table." (name, url, likes, size, date, category) VALUES ('".$_FILES['upl']['name']."', '".$url."', '0',".$_FILES['upl']['size'].", now(),'". $currentDirect ."')";
		if ($conn->query($sql) === TRUE) {
			$conn->close();
		    echo '{"status":"success"}';
			exit;
		} 
		else {
			$conn->close();
		    echo '{"status":"error"}';
			exit;
		}
	}
}
echo '{"status":"error"}';
exit;

	
	

