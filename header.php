<?php 
	session_start();
	$message = 0;
	$typeMsg = 0;
?>
<!DOCTYPE html>
<html>
    <head>
	   <?php include 'dbConnection.php'; 
		   header('Set-Cookie: fileDownload=true; path=/');?> 
       <?php include 'imports.php'; ?> 
	   
    </head>
    <body>
		<div class="loader">
			<!--<div class="cssload-preloader cssload-loading centered">
				<span class="cssload-slice"></span>
				<span class="cssload-slice"></span>
				<span class="cssload-slice"></span>
				<span class="cssload-slice"></span>
				<span class="cssload-slice"></span>
				<span class="cssload-slice"></span>
			</div>-->
		</div>
        <header>
			<div class="clientMessage"><span></span></div>
            <div class="upHeaderBackground">
				<div class="login">
					<?php include 'login.php'; ?>
				</div>
				
                <div class="upHeader">
                    <nav class="navbar navbar-inverse mainMenu">
						<div class="container-fluid">
							<div class="navbar-header">
								<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>                        
								</button>
								<span class="navbar-brand">
									<div class="logo"><a href="index.php"><img src="Images/logo.png"></a></div>
								</span>
							</div>
							<div class="collapse navbar-collapse menu" id="myNavbar">
								<ul class="nav navbar-nav navbar-right">
									<li>
										<a href="#">Úvod</a>
									</li>
									<li>
										<a href="#">Podmínky užívání</a>
									</li>
									<li>
										<a href="#">FAQ</a>
									</li>
									<li>
										<a href="#">Kontakty</a>
									</li>
									<?php 
										if(isset($_SESSION['login_user'])){
									?>
									<li>
										<a class="login_name"><span class="fa fa-user"> </span><?php echo $_SESSION['login_user']; ?></a>
									</li>
									<li>
										<form id="login_user" method="POST" action="" enctype="multipart/form-data">
											<input type="submit" name="logout_user" value="Odhlásit" />
										</form>
									</li>
									<?php
										}
										else{
									 ?>
									<li>
										<a class="login_button"><span class="fa fa-user"></span> Přihlásit</a>
									</li>
									<li>
										<a href="registration.php">Registrovat</a>
									</li>
									<?php 
										}
									?>
								</ul>
							</div>
						</div>
					</nav>
                </div>
            </div>
            <div class="headerBackground"></div>
       	</header>