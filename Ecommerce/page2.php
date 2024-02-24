<?php
session_start();
include("db_connection.php");
?>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>E-Commerce website</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet"  type="text/css" href="style.css" />
 
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

 </head>
<body>
  
  
  <div class="header">
    <a onclick="window.location.href='index.php'">Home</a>
    <div class="header-right">
       <button onclick="window.location.href='purchase.php'">Purchase</button>
      <button onclick="viewcart()">View Cart</button>
      <button onclick="document.getElementById('pastOrders').style.display='block'">Past Orders</button>
      <button  onclick="document.getElementById('id02').style.display='block'" >Account</button>
    </div>
</div>


<div id="id02" class="modal">
<form class="modal-content" action="logout.php" method="post">
    <div class="container">
        <h1>User Details</h1>
        <p>User Id: <?php echo $_SESSION['uid']; ?></p>
        <p>Username: <?php echo $_SESSION['uname']; ?></p>
        <p>Email: <?php echo $_SESSION['umailid']; ?></p>
        
        <br><br>
        <div class="clearfix">
            <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
            <button type="submit" class="signupbtn">Log out</button>
        </div>
    </div>
</form>
</div>
<!-- cart details here -->
<div id="cart" class="modal" style="background-color:orange;overflow:scroll;">
<h1 style='display:inline; color:white ; margin-left:40vw;'>My Cart</h1>
<button onclick="document.getElementById('cart').style.display='none'" style="background-color:red ;float:right;">X</button>

<?php
// Assuming $uid contains the user's ID from the session
$uid = $_SESSION['uid'];

// Fetch cart items from the database
$cartQuery = "SELECT c.p_id, c.quantity, c.total, p.p_name, p.p_img FROM cart c INNER JOIN products p ON c.p_id = p.p_id WHERE c.u_id = $uid";
$cartResult = mysqli_query($conn, $cartQuery);

if (mysqli_num_rows($cartResult) > 0) {
    echo "<table class='cart-table'>";
    echo "<tr>
            <th>Product id</th>
            <th>Product image</th>
            <th>Product name</th>
            <th>Quantity</th>
            <th>Amount</th>
            <th>Remove</th>
        </tr>";
    while ($cartItem = mysqli_fetch_assoc($cartResult)) {
        echo "<tr>";
        echo "<td>" . $cartItem['p_id'] . "</td>";
        echo "<td>" . "<img src='" . $cartItem['p_img'] . "'>" . "</td>";
        echo "<td>" . $cartItem['p_name'] . "</td>";
        echo "<td>" . $cartItem['quantity'] . "</td>";
        echo "<td>" . $cartItem['total'] . "</td>";
        echo "<td><button onclick=\"removeItem(" . $cartItem['p_id'] . ")\">Remove</button></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<img src='imgs/emptycart.png' style='width:50vw;height:60vh; margin-left:290px; margin-top:50px;'>";
}
?>
</div>

<!-- Display past orders details here -->
<div id="pastOrders" class="modal" style="background-color:orange; overflow:scroll;">
<h1 style='display:inline; color:white ;margin-left:40vw;'>My Orders</h1>
<button onclick="document.getElementById('pastOrders').style.display='none'" style="background-color:red ;float:right;">X</button>
<table class='cart-table' id="orderTable">
    <tr>
      <th>Product id</th>
      <th>Product image</th>
      <th>Product name</th>
      <th>Order Date</th>
      <th>Quantity</th>
      <th>Amount</th>
    </tr>
  </table>
<img src='imgs/noorders.jpg' id="noOrders" style='width:30vw;height:60vh; margin-left:380px; margin-top:50px;'>    
</div>
<!-- products-->
 
  <div class ="flex">
    <a href="productPage.php?x=100" ><div class="card">
      <img src="imgs/coat.jpg"  style="height:270px;">
      <h1>Clothings</h1>
    </div> </a>
    <a href="productPage.php?x=200" ><div class="card">
      <img src="imgs/phone.jpg" style="height:270px;">
      <h1>Mobiles</h1>
    </div> </a>
    <a href="productPage.php?x=300" ><div class="card">
      <img src="imgs/shoe.png" style="height:270px;">
      <h1>Shoes</h1>
    </div> </a>
 
  <a href="productPage.php?x=400" ><div class="card">
      <img src="imgs/watch.jpg" style="height:270px;">
      <h1>Watch</h1>
    </div> </a>
    <a href="productPage.php?x=500" > <div class="card">
      <img src="imgs/grocery.jpg" style="height:270px;">
      <h1>Grocery</h1>
    </div> </a>
    <a href="productPage.php?x=600" > <div class="card">
      <img src="imgs/book.png" style="height:270px;">
  <h1>Books</h1>
    </div> </a>
  </div>
 

 <footer>
  <p>Contact us: wondercart@email.com</p>
    <div>
    <a href="#" class="fa fa-facebook"></a>
      <a href="#" class="fa fa-twitter"></a>
      <a href="#" class="fa fa-linkedin"></a>
      <a href="#" class="fa fa-youtube"></a>
      <a href="#" class="fa fa-instagram"></a>
      <a href="#" id="goToTop">&#x25B2;</a>
    </div>
    </footer>
    
    <div id="removesnack">Item removed successfully !</div>

<script>

//view  cart
function viewcart() {
    sessionStorage.setItem('displayCart', 'true');
    location.reload();
}
document.addEventListener('DOMContentLoaded', function() {
    var displayCart = sessionStorage.getItem('displayCart');
    if (displayCart === 'true') {
        document.getElementById('cart').style.display = 'block';
        sessionStorage.removeItem('displayCart');
    }
});


 //orders
 const uid = <?php echo $_SESSION['uid']; ?>;
 fetch(`orders.php?u_id=${uid}`) //use backtick here.
.then(response => response.json())
.then(x => {
   const orderTable = document.getElementById('orderTable');
   const noOrders = document.getElementById('noOrders');
   
   if(x.length > 0){
    noOrders.style.display = 'none';
    x.forEach(y => {
      const row = document.createElement('tr'); //use backtick here
      row.innerHTML = `  
      <td> ${y.p_id} </td>
      <td><img src='${y.p_img}'></td>
      <td> ${y.p_name}</td>
      <td> ${y.order_date}</td>
      <td> ${y.quantity}</td>
      <td> ${y.amount}</td>`; 

      orderTable.appendChild(row);
    });
   }
   else{
    noOrders.style.display = 'block';
    orderTable.style.display= 'none';
   }
})
.catch(error => console.error(error));

//remove_item
function removeItem(p_id) {

fetch("remove_item.php?p_id=" + p_id)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        var tableRow = document.getElementById("row_" + p_id);
        if (tableRow) {
            tableRow.remove();
        }
        removesnack();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function removesnack(){
var x = document.getElementById("removesnack");
x.classList.add("show");

setTimeout(function() {
x.classList.remove("show");
}, 3000);
}

var modal = document.querySelector('#id02');
// When the user clicks anywhere outside of modals, close them
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</body>
</html>
