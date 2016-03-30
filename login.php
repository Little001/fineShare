<!-- After POST -->
<?php 
	if(isset($_POST["logout_user"])){
		unset($_SESSION['login_user']);
		header('Location: index.php');
	}
	if(isset($_POST["login_user"])){
		if($_POST['login_name'] !== '' || $_POST['pass'] !== ''){	
			$sql = "SELECT * FROM users WHERE login ='". $_POST['login_name'] ."'";
			$result = $conn->query($sql);
			if ($result->num_rows > 0){
				if (password_verify($_POST['pass'], $result->fetch_object()->password)){
					$_SESSION['login_user']= $_POST['login_name'];
					$typeMsg = 1;
					$message = 'Přihlášení proběhlo v pořádku';
				}
				else{
					$message = 'Zadali jste špatné heslo';
				}	
			} 
			else{
			    $message = 'Tento uživatel neexistuje';
			}
		}
		else{
			$message = 'Musíte vyplnit všechna pole';
		}
	}
?>		

<?php 
	if(!isset($_SESSION['login_user'])){
?>
<div class="arrow-div">
	<form id="login_user" method="POST" action="" enctype="multipart/form-data">
		<div class="login_line">
			<div class="login_main">Přihlašte se k vašemu účtu</div>
			<div class="login_close"><span class="fa fa-times-circle"></span></div>
		</div>
		<div class="dialog-item">
			<div class="icon-login"><span class="fa fa-user"></span></div>
			<input type="text" name="login_name" id="login_name" placeholder="Uživatelské jméno"/>
		</div>
		<div class="dialog-item">
			<div class="icon-login"><span class="fa fa-lock"></span></div>	
			<input type="password" name="pass" id="login_pass" placeholder="Vaše heslo"/>
		</div>
		<input type="submit" name="login_user" id="login_button" value="Přihlásit" />
		<a href="forgetpass.php">Zapomenuté heslo <span class="fa fa-long-arrow-right"></span></a>
	</form>	
	
	<div class="reg">Nemám účet, chci se registrovat <span class="fa fa-plus"></span></div>
</div>
<?php 
	}
?>
