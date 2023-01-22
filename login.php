<?php
session_start();
if(isset($_POST['submit'])){

	require_once "db_conn.php";
	mysqli_report(MYSQLI_REPORT_STRICT);
	try
	{

		
		
		if ($conn->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}
		else
		{
		

			$email = $_POST['email'];
			$password = $_POST['password'];
			
			$email = htmlentities($email, ENT_QUOTES, "UTF-8");
		
			if ($result = @$conn->query(
			sprintf("SELECT * FROM user WHERE email='%s'",
			mysqli_real_escape_string($conn,$email),
			mysqli_real_escape_string($conn,$password))))
			{
				
				$users = $result->num_rows;
				if($users>0)
				{
					$row = $result->fetch_assoc();
					

					if(password_verify($password, $row['pass']))
					{
						
						$_SESSION['logged'] = true;
						
						$_SESSION['id'] = $row['id'];
						$_SESSION['email'] = $row['email'];
						$_SESSION['name'] = $row['name'];
						
						unset($_SESSION['blad']);
						$result->free_result();
						session_write_close();
						header('Location: forum.php');
						exit();
					}else {
						
						$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy email lub hasło!</span>';
						header('Location: login.php');
						
					}
					
				} else {
					
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy email lub hasło!</span>';
					session_write_close();
					header('Location: login.php');
					exit();
					
				}
				
			}
			
			$conn->close();
		}
	}
	catch(Exception $e)
	{
		echo 'Bład serwera!';
		echo '<br/>'.e;
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
							<h1 class="fs-4 card-title fw-bold mb-4">Login</h1>
							<form method="post">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">E-Mail</label>
									<input id="email" type="email" class="form-control" name="email"  required autofocus>
									<div class="invalid-feedback">
										Email jest niepoprawny
									</div>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Hasło</label>
										<a href="forgot.html" class="float-end">
											Zapomniałeś hasła?
										</a>
									</div>
									<input id="password" type="password" class="form-control" name="password" required>
								    <div class="invalid-feedback">
								    	Hasło jest wymagane
							    	</div>
								</div>

                                <?php 
                                if(isset($_SESSION['blad']))	echo $_SESSION['blad']; ?>


								<div class="d-flex align-items-center">
									<div class="form-check">
										<input type="checkbox" name="remember" id="remember" class="form-check-input" checked>
										<label for="remember" class="form-check-label" >Zapamietaj mnie</label>
									</div>
									<button type="submit" class="btn btn-primary ms-auto" name="submit">
										Zaloguj
									</button>
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								Nie posiadasz konta? <a href="register.php" class="text-dark">Zarejstruj się</a>
							</div>
						</div>
					</div>
					<div class="text-center mt-5 text-muted">
						Copyright &copy; 2022 &mdash; MotoŚwiat 
					</div
				</div>
			</div>
		</div>
	</section>


    </form>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>