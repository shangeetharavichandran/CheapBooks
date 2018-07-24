<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors','On');
if(isset($_POST['login']))
{
try {
$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::
ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$hash= md5($password);
$stmt = $dbh->prepare("SELECT * FROM customers WHERE username=:username and
password=:password");
$stmt -> execute(array(':username'=>$username, ':password'=>$hash));
if($stmt->rowCount() > 0)
{//set this variable only on successful login
$_SESSION['user_session'] = $username;
//echo $_SESSION['user_session'];
header('HTTP/1.1 200 OK');
header("Location: home.php");
exit();
}
else
{
$error = "not valid user";
echo $error;
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
<title>Login Form</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Login Form</h2>
<form action="customer.php" method="post">
<label>UserName :</label>
<input id="name" name="username" type="text">
<label>Password :</label>
<input id="password" name="password" type="password">
<button type="submit" name="login"> Login</button>
<label> New users must register here </label>
<button type="button" name="register" onclick ="location.href='register.php';" /> Register
</button>
</form>
</body>
</html>
