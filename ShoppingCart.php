<?php
session_start();
if(!isset($_SESSION['basket'])){
$_SESSION['basket'] = array();
}
if($_GET['ISBN']!=null && $_GET['title'] != null){
$isbn = $_GET['ISBN'];
$title = $_GET['title'];
$_SESSION['basket'][$isbn] = $title;
print_r($_SESSION['basket']);
$size = count($_SESSION['basket']);
echo $size;
}
?>
