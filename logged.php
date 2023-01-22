<?php

	session_start();

	if ((!isset($_POST['email'])) || (!isset($_POST['password'])))
	{
		header('Location: login.php');
		exit();
	}
	

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
						header('Location: forumUser.php');
					}else {
					
						$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy email 2 stopien lub hasło!</span>';
						header('Location: login.php');
						
					}
					
				} else {
					
					$_SESSION['blad'] = '<span style="color:red">Nieprawidłowy 1 stopien email lub hasło!</span>';
					echo $email;
					header('Location: login.php');
					
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
	
?>