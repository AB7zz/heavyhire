<?php 

$connect = mysqli_connect("localhost", "root", "", "heavyhire");

if($connect === true){ 
    echo "not connected"; 
}
?>