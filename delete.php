<?php
include('db.php');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "UPDATE Products SET IsDeleted = 1 WHERE ProductId = $id";
    if($conn->query($sql) === TRUE){
        echo "<br>Product deleted successfully";
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>