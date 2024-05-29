<?php 
include_once "connect.php";
$id=$_GET['id'];
$query="delete from tk where id=$id";
$done=mysqli_query($conn,$query);

header("location:index.php");
?>