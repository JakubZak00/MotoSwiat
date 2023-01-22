<?php 
session_start();
include "db_conn.php";

$id = $_GET['id'];

if(isset($_POST['submit'])) {
    $name = $_POST['first_name'];
    $content = $_POST['content'];
    
   
    $sql = "INSERT INTO `item`(`id`, `name`, `content`, `parent_comment`) VALUES (NULL,'$name','$content', '$id')";

    $result = mysqli_query($conn,$sql);

    if($result){
        header("Location: order.php?id=$id");
    }else{
        echo "Błąd: " . mysqli_error($conn);
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
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <div class="text-center mt-5">
            <h3>Odpowidz na post</h3>
        </div>
        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width:50vh; min-width:300px;">
                <div class="row">
                    <div class="col">
                        <label class="form-label">Imię</label>
                        <input type="text" class="form-control" name="first_name" placeholder="imię" readonly="readonly" value="<?php 
                                if(isset($_SESSION['name'])) echo $_SESSION['name']; ?>">
                    </div>

                </div>
                <div class="mb-3">
                        <label class="form-label">Treść:</label>
                        <textarea type="text" class="form-control" name="content" placeholder="Odpowiedź"></textarea>
                </div>
                <div>
                    <button type= "submit" class="btn btn-success" name="submit">Zapisz</button>
                    <a href="forum.php" class="btn btn-danger">Anuluj</a>
                </div>
            </form>
        </div>

    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>