<?php
session_start();
if(!isset($_SESSION['user_session'])){
header("Location: customer.php");
exit();
}
//echo $_SESSION['basket'];
if(!isset($_SESSION['basket'])){
$_SESSION['basket'] = array();
}
?>
<html>
<head>
<script type="text/javascript">
var request = new XMLHttpRequest();
function displayResult () {
if (request.readyState == 4) {
console.log('sdadsds');
var result = request.responseText;
document.getElementById('count').innerHTML = result;
//alert(result);
}
};
function addToCart(isbn,bookname){
console.log('24356');
request.onreadystatechange = displayResult;
request.open("GET","add_to_cart.php?ISBN="+isbn+"&title="+bookname);
request.send();
}
</script>
welcome </head>
<body>
<form action ="home.php" method_exists ="GET">
<table>
<tr>
<td> Search by Author: </td><td colspan="2"><input type="text" name="searchauthor"></td>
</tr>
<tr>
<td> Search by Title: </td><td colspan="2"><input type="text" name ="searchbytitle"></td>
</tr>
<td></td><td><input type="submit" value="Search" name="Search"></td>
</table>
</form>
<?php
try{
if(isset($_GET['Search'])){
$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=cheapbooks","root","",array(PDO::
ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
$sql="";
if(isset($_GET['searchauthor']) && $_GET['searchauthor'] != null && isset($_GET['Search'])){
$searchauthor = $_GET['searchauthor'];
$sql = "SELECT book.title as book_name, writtenby.ISBN , stocks.number, book.price from
writtenby INNER JOIN author on author.ssn = writtenby.ssn INNER JOIN book on book.ISBN =
writtenby.ISBN INNER join stocks on stocks.ISBN = book.ISBN WHERE author.name = '
{$searchauthor}'";
}
else if(isset($_GET['searchbytitle']) && $_GET['searchbytitle']!=null && isset($_GET[
'Search'])){
$searchbytitle = $_GET['searchbytitle'];
$sql = "SELECT book.title as book_name, writtenby.ISBN , stocks.number, book.price from
writtenby INNER JOIN author on author.ssn = writtenby.ssn INNER JOIN book on book.ISBN =
writtenby.ISBN INNER join stocks on stocks.ISBN = book.ISBN WHERE book.title = '
{$searchbytitle}'";
}
echo "<table width=\"900\">";
echo "<tr><th >ISBN</th><th>Book Title</th><th>Price</th><th>No. of Available Books
</th></tr>";
$dbh->beginTransaction();
$statement = $dbh->prepare($sql);
$statement->execute();
$dbh->commit();
if($statement->rowcount()){
while($row=$statement ->fetch()){
echo "<tr><td>";
echo $row['ISBN'];
echo "</td><td>";
echo $row['book_name'];
echo "</td><td>";
echo $row['price'];
echo "</td><td>";
echo $row['number'];
echo "</td><td>";
//echo "<a href='add_to_cart.php?ISBN={$row['ISBN']}&title={$row['book_name']}'>Add
to cart";
//echo "<a href='#'
onclick='addToCart('"+$row['ISBN']+"','"+$row['book_name']+"');'>Add to cart</a>";
echo "<button type='button' onClick='addToCart(&quot;{$row['ISBN']}&quot;,&quot;
{$row['book_name']}&quot;)'>Add to cart</button>";
echo "</td><tr>";
}
echo "</table>";
}
}
}
catch(PDOException $e){
echo $e->getMessage();
}
?>
<form action ="checkout.php" method ="GET">
<button type="button" name="shoppingbasket" >Shopping Basket </button>
<div id="count"></div>
<button type="button" name="logout" > Log Out </button>
</form>
</body>
</html>
