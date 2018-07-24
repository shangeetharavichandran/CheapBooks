<html>
<head> page 3 </head>
<body>
<button type ="button" name="Buy"> Buy</button>
<?php
session_start();
// when customer clicks on buy ,save the current basket to the database
if(isset($_POST['buy']=='Buy')
{
try{
$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::
ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$basket_id = $_SESSION['basket'];
foreach($_SESSION['no_items_in_basket'] as $ISBN=>$value){
$quantity= $_SESSION[no_items_in_basket][$ISBN];
$statement= $dbh->prepare("insert into contains(ISBN,basketId,number) values( )");
$statement->execute();
}
$_SESSION['no_items_in_basket']=array();
}
}
?>
</body>
</html>
