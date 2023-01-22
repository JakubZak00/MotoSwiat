<?php 
include "db_conn.php";
$id = $_GET['id'];
$sql = "DELETE FROM `item` WHERE id=$id";
$result = mysqli_query($conn, $sql);
if($result){
    header("Location: forum.php?msg=Post usunięty");
}
else{
    echo "Błąd: " . mysqli_error($conn);
}
?>