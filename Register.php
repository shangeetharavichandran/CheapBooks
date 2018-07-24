<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors','On');
if(isset($_POST['register']))
{
try {
$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::
ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$uname = trim($_POST['uname']);
$pswrd = trim($_POST['pswrd']);
$address = trim($_POST['address']);
$email = trim($_POST['email']);
$phnumber = trim($_POST['phnumber']);
if($uname==""){
$error[] = " provide the username";
}
else if($pswrd==""){
$error[] = "provide password";
}
else if($email==""){
$error[]= "provide email id";
}
else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
$error[]= "please enter a valid email address";
}
else
{
$stmt = $dbh->prepare("insert into customers (username,password,address,phone,email)
values(:uname,:pswrd,:address,:phnumber,:email)");
$hashpassword= md5($pswrd);
$stmt->bindparam(":uname", $uname);
$stmt->bindparam(":pswrd", $hashpassword);
$stmt->bindparam(":address", $address);
$stmt->bindparam(":phnumber", $phnumber);
$stmt->bindparam(":email", $email);
$stmt->execute();
header("Location: customer.php");
echo "registered successfully";
exit();
}
}
catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title> Registration Page </title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Registration Form</h2>
<form action="register.php" method="post">
<label> Enter your username: </label>
<input type="text" name="uname" id="uname">
<label> Enter your password: </label>
<input type="password" name="pswrd" id="pswrd">
<label> Enter your address: </label>
<input type="text" name="address" id="address">
<label> Enter your email: </label>
<input type="text" name="email" id="email">
<label> Enter your phone number: </label>
<input type="text" name="phnumber" id="phnumber">
<input type='submit' name='register' value='register' />
</body>
</html>
