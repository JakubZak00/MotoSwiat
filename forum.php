<?php
session_start();

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
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="index.html"><i class="fa-solid fa-car"></i> moto<span class="text-light">świat</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.html#Article">Artykuły</a></li>
                    <li class="nav-item"><a class="nav-link" href="forum.php">Forum</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.html#team">Eksperci</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.html#contact">Kontakt</a></li>
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
    <header class="masthead">
        <div class="container">
            <div class="row">
                <div class="col-7">
                    <input class="form-control search" type="search" placeholder="wyszukaj" aria-label="wyszukaj">
                </div>
              <?php if(isset($_SESSION['name'])) {?>
                <div class="col-4">
                    <a href="add_new.php" class="btn btn-primary mb-2">Dodaj Zapytanie</a>
                </div>
              <?php } ?>
            </div>
        </div>
        </div>
    </header>
    <article>
        <div class="container bg-light">
         <?php
         include "db_conn.php";
        if(isset($_GET['msg'])) {
        $msg = $_GET['msg'];
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        '.$msg.'
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
      </div>';
     } 
        ?> 
            </br>
            <h1 class="h2 text-dark text-uppercase text-center font-weight-bold m-4 border-bottom border-danger pb-2">
                Forum</h1>
            <?php if(isset($_SESSION['name'])) {?>
            <h2>Witam <?php echo $_SESSION['name'];?> </h2>
            </br>
            <?php } ?>
            <div class="row">
                <div class="col-lg-8 bg-light">
                    <ol class="list-group list-group-numbered text-dark my-3 ml-3">
                        <div >
                    <?php 
                     
                        $sql="SELECT * FROM `item`";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        if($row['title']!= ""){
                        ?>
                        
                        <div class="list-group-item list-group-item-action p-4 order">
                        <a class="aNew" href="order.php?id=<?php echo $row['id']?>">
                        <div class="col-11">
                            <div class="text-end"><?php echo $row ['time']?></div>
                            <p class="d-flex"><img class="img-fluid img-brand d-block " src="assets/img/avatar.jpg" alt="avatar" />
                            <span class="mx-2 mt-2"><?php echo $row ['name']?></span>
                            </p>
                            <p class="h4 d-block"><?php echo $row ['id']?>. &nbsp<?php echo $row ['title']?></p>
                            <p><?php echo $row ['content']?></p>
                        </a>
                        </div>
                        <?php if($_SESSION['name']==$row['name'])
                        {?>
                            <div class="col-2 m-auto">
                                <a class="me-2"href="edit.php?id=<?php echo $row['id']?>"><i class="fa-solid fa-pen-to-square"></i></a> 
                                <a href="delete.php?id=<?php echo $row['id']?>"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        <?php }?> 
                           
                        </div>

                        <?php
                            }
                        }
                    ?>
                        </div>
                    </ol>
                </div>

                <aside class="col-lg-4">
                    <h3 class="h4 my-3 text-dark">Fora tematyczne</h3>
                    <ul class="list-group">
                        <a href="#" class="list-group-item list-group-item-light list-group-item-action">Peugeot</a>
                        <a href="#" class="list-group-item list-group-item-light list-group-item-action">BMW</a>
                        <a href="#" class="list-group-item list-group-item-light list-group-item-action">Audi</a>
                        <a href="#" class="list-group-item list-group-item-light list-group-item-action">Volksvagen</a>
                        <a href="#" class="list-group-item list-group-item-light list-group-item-action">Mazda</a>
                        <a href="#" class="list-group-item list-group-item-light list-group-item-action">Skoda</a>
                        <a href="#" class="list-group-item list-group-item-light list-group-item-action">Jaguar</a>
                        <a href="#" class="list-group-item list-group-item-light list-group-item-action">Mercedes</a>
                        <a href="#" class="list-group-item list-group-item-light list-group-item-action">Land Rover</a>
                        <a href="#" class="list-group-item list-group-item-light list-group-item-action mb-4">Jeep</a>

                    </ul>
            </div>

    </article>

    <!-- Footer-->
    <footer class="footer py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 text-lg-start">Copyright &copy; MotoŚwiat 2022</div>
                <div class="col-lg-4 my-3 my-lg-0">
                    <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Twitter"><i
                            class="fab fa-twitter"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Facebook"><i
                            class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="LinkedIn"><i
                            class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                    <a class="link-dark text-decoration-none" href="#!">Terms of Use</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <script src="js/search.js"></script>
   


</body>

</html>