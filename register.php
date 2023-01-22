<?php 
session_start();
if(isset($_POST['email']))
{
	 $good = true;
	 $name = $_POST['name'];
	 
	 if((strlen($name)<3)||(strlen($name)>20))
	 {
		$good=false;
		$_SESSION['e_name']="Nick musi posiadać od 3 do 20 znaków!";
	 }
	 if(ctype_alnum($name)==false)
	 {
		$good=false;
		$_SESSION['e_name']="Nick może składać się tylko z liter i cyfr(bez polskich znaków)"; 
	 }

	 $email = $_POST['email'];
     $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
         
     if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
    	{
            $good=false;
            $_SESSION['e_email']="Podaj poprawny adres e-mail!";
        }

	 $password1 =$_POST['password1'];
	 $password2 =$_POST['password2'];

	 if((strlen($password1)<8)||(strlen($password1)>20))
	 {
		$good=false;
		$_SESSION['e_haslo']="Haslo musi posiadać od 8 do 20 znaków!";
	 }
	 if($password2!=$password1)
	 {
		$good=false;
		$_SESSION['e_haslo']="Hasla różnią się od siebie";
	 }

	 $haslo_hash = password_hash($password1, PASSWORD_DEFAULT);

	 if(!isset($_POST['regulamin']))
	 {
		$good=false;
		$_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
	 }
	 
	if(isset($_POST['submit']))
	{
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	$response = $_POST['token_generate'];
	$remoteip = $_SERVER['REMOTE_ADDR'];
	$secret = '6LdNVW8jAAAAAEjjoF2TWiJ3uyPBWtzAwxWxuhB7';
	$request = file_get_contents($url.'?secret='.$secret.'&response='.$response);

	$result = json_decode($request);
	// print_r($result);

		if($result->success == false)
		{ 
		// $good=false;
		$_SESSION['e_recapth']="Jesteś botem!";
		}
	}
	
	$_SESSION['fr_name'] = $name;
	$_SESSION['fr_email'] = $email;
	$_SESSION['fr_password1'] = $password1;
	$_SESSION['fr_password2'] = $password2;
	if(isset($_POST['regulamin']))$_SESSION['fr_regulamin'] = true;

	require_once "db_conn.php";
	mysqli_report(MYSQLI_REPORT_STRICT);

	try
	{
		
		if($conn->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}else{
			$rezultat = $conn->query("SELECT id FROM user WHERE email='$email'");
			if(!$rezultat)throw new Exception($conn->error);

			$ile_takich_maili = $rezultat->num_rows;
			if($ile_takich_maili>0)
			{
				$good=false;
				$_SESSION['e_email']="Instnieje już konto przypisane do tego adresu email!";
			}
			$rezultat = $conn->query("SELECT id FROM user WHERE name='$name'");
			if(!$rezultat)throw new Exception($conn->error);

			$ile_takich_name = $rezultat->num_rows;
			if($ile_takich_name>0)
			{
				$good=false;
				$_SESSION['e_name']="Istnieje już konto przypisane do tej nazwy!";
			}

			if($good==true)
	 		{
				if ($conn->query("INSERT INTO user VALUES (NULL, '$name', '$haslo_hash', '$email')")){
					$_SESSION['udanarejstracja']=true;
					header('Location: forum.php');
				}else{
					throw new Exception($conn->error);
				}
			
	 		}
			$conn->close();

		}

	}
	catch(Exception $e)
	{
		echo 'Błąd serwera! Przepraszamy za niedogodności';
		echo '<br />Informacja developerska'.$e;
	}
	

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="MotoŚwiat - Największe forum pasjonatów motoryzacji" />
    <meta name="author" content="Jakub Zakrzewski" />
    <title>MotoŚwiat</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon"
        href="/assets/img/sport-car.png" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bar" id="mainNav" style="background-color: #212529;">
        <div class="container">
            <a class="navbar-brand" href="index.html"><i class="fa-solid fa-car"></i> moto<span class="text-light">świat</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#Article">Artykuły</a></li>
                    <li class="nav-item"><a class="nav-link" href="forum.php">Forum</a></li>
                    <li class="nav-item"><a class="nav-link" href="#team">Eksperci</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Kontakt</a></li>
                    <div class="btn-group">
                        <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" ar
                        ia-expanded="false"><i class="fa-lg fa-solid fa-circle-user"></i> Konto
                            
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="login.php">Zaloguj</a></li>
                            <li><a class="dropdown-item" href="register.php">Zarejstruj</a></li>
                            <?php if(isset($_SESSION['name'])) {?>
                            <li><a class="dropdown-item" href="logout.php">Wyloguj</a></li> <?php } ?>
                        </ul>
                    
                    </div>
                </ul>
            </div>
        </div>
</nav>
<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="text-center my-5">
						<img src="https://cdn3.iconfinder.com/data/icons/essential-rounded/64/Rounded-31-512.png" alt="logo" width="100">
					</div>
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mt-4">Rejstracja</h1>

							<form method="post">


								<div class="mt-2">
									<label class="mt-2 text-muted" for="name">Nazwa</label>
									<input id="name" type="text" class="form-control"   required autofocus value= "<?php 
									if(isset($_SESSION['fr_name']))
										{
											echo $_SESSION['fr_name'];
											unset($_SESSION['fr_name']);
										}
									?>" name="name"/>
									<?php if(isset($_SESSION['e_name'])){
									echo'<div class="text-danger">'.$_SESSION['e_name'].'</div>';
									unset($_SESSION['e_name']);
									}?>
								</div>

								<div class="mt-2">
									<label class="mt-2 text-muted" for="email">E-Mail</label>
									<input id="email" type="email" class="form-control"value= "<?php 
									if(isset($_SESSION['fr_email']))
										{
											echo $_SESSION['fr_email'];
											unset($_SESSION['fr_email']);
										}
									?>" name="email"/>
									<?php if(isset($_SESSION['e_email'])){
									echo'<div class="text-danger">'.$_SESSION['e_email'].'</div>';
									unset($_SESSION['e_email']);
									}?>
								</div>
								
								<div>
									<label class="mt-2 text-muted" for="password">Hasło</label>
									<input id="password" type="password" class="form-control"value= "<?php 
									if(isset($_SESSION['fr_password1']))
										{
											echo $_SESSION['fr_password1'];
											unset($_SESSION['fr_password1']);
										}
									?>" name="password1"/>
								</div>
								<div>
									<label class="mt-2 text-muted" for="password">Powtórz Hasło</label>
									<input id="password" type="password" class="form-control" value= "<?php 
									if(isset($_SESSION['fr_password2']))
										{
											echo $_SESSION['fr_password2'];
											unset($_SESSION['fr_password2']);
										}
									?>" name="password2"/>
									<?php if(isset($_SESSION['e_haslo'])){
									echo'<div class="text-danger">'.$_SESSION['e_haslo'].'</div>';
									unset($_SESSION['e_haslo']);
									}?>
								</div>

								<label> <input type="checkbox" class="text-muted mt-4" value= "<?php 
								if(isset($_SESSION['fr_regulamin']))
									{
										echo $_SESSION['fr_regulamin'];
										unset($_SESSION['fr_regulamin']);
									}
								?>" name="regulamin"/>  Akceptuje Regulamin</label>
								<?php if(isset($_SESSION['e_regulamin'])){
									echo'<div class="text-danger">'.$_SESSION['e_regulamin'].'</div>';
									unset($_SESSION['e_regulamin']);
									}?>


								<input type="hidden" name="token_generate" id="token_generate"/>
								<?php if(isset($_SESSION['e_recapth'])){
									echo'<div class="text-danger">'.$_SESSION['e_recapth'].'</div>';
									unset($_SESSION['e_recapth']);
									}?>
								<Div>
								<input type="submit" class="btn btn-primary ms-auto mt-3" name="submit" value="Zarejstruj się" />
								</Div>
								

							</form>
						</div>
					
				</div>
				<div class="text-center mt-5 text-muted">
					Copyright &copy; 2022 &mdash; MotoŚwiat
				</div>
			</div>
		</div>
	</div>
</section>

<script>

	grecaptcha.ready(function() {
	  grecaptcha.execute('6LeHFvgiAAAAAEMWsTmwAo4m9aSwlKIj_U2G1DOg', {action: 'submit'}).then(function(token) {
		  var response = document.getElementById('token_generate');
		  response.value = token;
	  });
	});
  
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>