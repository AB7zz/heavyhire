<?php 

$url = 'http://localhost:8080/api';

$con = mysqli_connect("localhost", "root", "", "heavyhire");

if($con === true){ 
    echo "not connected"; 
}

?>