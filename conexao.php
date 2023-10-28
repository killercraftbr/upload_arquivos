<?php
$host ="localhost";
$db = "upload";
$user= "root";
$pass ="";
$mysqli = new mysqli($host,$user,$pass,$db);
if($mysqli->connect_errno){
    die("vish maiquinho, o banco deu erro");}
    
?>