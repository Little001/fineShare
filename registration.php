<?php include 'header.php'; ?>
<!-- CONTENT -->
<?php 
	$_SESSION['count'] = time();
	
	$image;	
	$user_reg = '';
	$email_reg = '';
	$captcha_str = '';
	
	if(isset($_POST['registration'])){
		if(isset($_SESSION['captcha_string'])){
			$captcha_str = $_SESSION['captcha_string'];
		}
		echo $captcha_str . 'tady';
			$user_reg = $_POST['username'];
			$email_reg = $_POST['email'];
			if($_POST['username'] !== '' || $_POST['email'] !== '' || $_POST['password'] !== '' || $_POST['repass'] !== '' || $_POST['code'] !== ''){
				if($_POST['password'] == $_POST['repass']){
					if($_POST['code'] == $captcha_str){
						if(valid_email($_POST['email'])){	
							if(valid_password($_POST['password'])){	
									/*Hash Password*/
									$options = [
									    'cost' => 11,
									];
									// Get the password from post
									$passwordFromPost = $_POST['password'];
									$hash = password_hash($passwordFromPost, PASSWORD_BCRYPT, $options);					
								$sql = "INSERT INTO users (name, surname, email, login, password) VALUES ('', '', '". $_POST['email'] ."', '" . $_POST['username'] ."', '". $hash ."')";
								if ($conn->query($sql) === TRUE) {
									$typeMsg = 1;
									$message = 'Registrace proběhla v pořádku';
								} 
								else{
									/*echo "Error: " . $sql . "<br>" . $conn->error;*/
									$message = 'Interní chyba, zkuste to později';
								}
							}
							else{
								$message = 'Heslo musí mít minimálně 8 znaků';
							}
						}
						else{
							$message = 'Email není ve správném tvaru';
						}
					}
					else{
						$message = 'Špatně jste opsali kód';
					}
				}
				else{
					$message = 'Hesla se neshodují';
				}
			}
			else{
				$message = 'Musíte vyplnit všechna pole';
			}
		}
		
	
	function valid_email($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
	
	function valid_password($pass){
		return strlen($pass) >= 8; 
	}

	create_image();
	function  create_image()
	{
	    global $image;
	    $image = imagecreatetruecolor(200, 50) or die("Cannot Initialize new GD image stream");
	    $background_color = imagecolorallocate($image, 255, 255, 255);
	    $text_color = imagecolorallocate($image, 0, 255, 255);
	    $line_color = imagecolorallocate($image, 64, 64, 64);
	    $pixel_color = imagecolorallocate($image, 0, 0, 255);
	    imagefilledrectangle($image, 0, 0, 200, 50, $background_color);
	    for ($i = 0; $i < 3; $i++) {
	        imageline($image, 0, rand() % 50, 200, rand() % 50, $line_color);
	    }
	    for ($i = 0; $i < 1000; $i++) {
	        imagesetpixel($image, rand() % 200, rand() % 50, $pixel_color);
	    }
	    $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	    $len = strlen($letters);
	    $letter = $letters[rand(0, $len - 1)];
	    $text_color = imagecolorallocate($image, 0, 0, 0);
	    $word = "";
	    for ($i = 0; $i < 6; $i++) {
	        $letter = $letters[rand(0, $len - 1)];
	        imagestring($image, 7, 5 + ($i * 30), 20, $letter, $text_color);
	        $word .= $letter;
	    }
	    $_SESSION['captcha_string'] = $word;
		$_SESSION['kokot'] = "kokt";
	    $images = glob("*.png");
	    foreach ($images as $image_to_delete) {
	        @unlink($image_to_delete);
	    }
	    imagepng($image, "image" . $_SESSION['count'] . ".png");
	}
?>
		
<div class="content-middle">
	<div class="registration">
		<?php echo $_SESSION['captcha_string'] ?>
		<div class="registration-user">
			<h3>Registrace nového uživatele</h3>
			<span>Registrace Vám bude trvat chvilku. Vyplňte prosím povinna pole označené*.</span>
			<form id="registration" method="post" action="registration.php" enctype="multipart/form-data">
					<div class="row">
						<label for="username" class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>Uživatelské jméno: </label>
						<input type="text" name="username" placeholder="Zadejte Vaše uživatelské jméno" value="<?=$user_reg?>" class='col-xs-12 col-sm-6 col-md-6 col-lg-6'/>
					</div>
					<div class="row">
						<label for="email" class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>Vás email: </label>
						<input type="email" name="email" placeholder="Zadejte Vás email" value="<?=$email_reg?>" class='col-xs-12 col-sm-6 col-md-6 col-lg-6'/>
					</div>
					<div class="row">
						<label for="password" class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>Heslo: </label>
						<input type="password" name="password" placeholder="Zadejte Vaše heslo" class='col-xs-12 col-sm-6 col-md-6 col-lg-6'/>
					</div>
					<div class="row">
						<label for="repass" class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>Znova heslo: </label>
						<input type="password" name="repass" placeholder="Zadejte Vaše heslo znovu" class='col-xs-12 col-sm-6 col-md-6 col-lg-6'/>
					</div>
					<div class="row">
						<img src="image<?php echo $_SESSION['count'] ?>.png" class='col-xs-12 col-xs-offset-0 col-sm-6 col-sm-offset-6 col-md-6 col-md-offset-6 col-lg-6 col-lg-offset-6'>
					</div>
					<div class="row">
						<label for="code" class='col-xs-12 col-sm-6 col-md-6 col-lg-6'>Ověřovací kód</label>
						<input type="text" name="code" placeholder="Zde opište ověřovací kód" class='col-xs-12 col-sm-6 col-md-6 col-lg-6'/>
					</div>
					<div class="row">
						<input type="submit" name="registration" value="REGISTRACE" id="regSubmit"/>
					</div>
			</form>
		</div>
		<div class="login-social">
			<ul>
				<li><h3>Registrace přeš sociální sítě</h3></li>
				<li><span>Můžete se jednoduše zaregistrovat přes sociální sítě.</span></li>
				<li><button class="btn btn-facebook"><i class="fa fa-facebook"></i> | Connect with Facebook</button></li>
				<li><button class="btn btn-google"><i class="fa fa-google-plus"></i> | Connect with Google+</button></li>
				<li><button class="btn btn-twitter"><i class="fa fa-twitter"></i> | Connect with Twitter</button></li>
				<li><button class="btn btn-linkedin"><i class="fa fa-linkedin"></i> | Connect with LinkedIn</button></li>
				<li><span>Máte V.I.P. pozvánku? Zde zadejte kód</span></li>
				<li><input type="text" placeholder="Pokud máte kód, můžete jej uplatnit zde"/></li>
			</ul>
		</div>
	</div>
</div>
<!-- FOOTER -->
<?php include 'footer.php'; ?>