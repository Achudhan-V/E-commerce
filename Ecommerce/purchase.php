<?php
session_start();
include("db_connection.php");
if (isset($_GET['redirect_status']) && $_GET['redirect_status'] === 'succeeded' &&
    isset($_GET['payment_intent_client_secret'])) {

    $clientSecret = $_GET['payment_intent_client_secret'];
    $uid = $_SESSION['uid'];

    $cartQuery = "SELECT p_id, quantity, total FROM cart WHERE u_id = $uid";
    $cartResult = mysqli_query($conn,$cartQuery);

    // Insert each item from the cart into the 'orders' table
    while ($row = $cartResult->fetch_assoc()) {
        $pid = $row['p_id'];
        $quantity = $row['quantity'];
        $total = $row['total'];

        // Insert into 'orders' table
        $insertQuery = "INSERT INTO orders (u_id, p_id, quantity, amount) VALUES ($uid, $pid, $quantity, $total)";
        mysqli_query($conn,$insertQuery);
    }

    // Clear the cart for the user
    $clearCartQuery = "DELETE FROM cart WHERE u_id = $uid";
    mysqli_query($conn,$clearCartQuery);


    echo '<script>alert("Payment succeeded!");</script>';
    
} 
?>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>E-Commerce website</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet"  type="text/css" href="style.css"/>
 
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 </head>
<body>
    
<div class="header">
    <a onclick="window.location.href='page2.php'">Home</a>
    <div class="header-right">
      <button onclick="document.getElementById('pastOrders').style.display='block'">Past Orders</button>
      <button  onclick="document.getElementById('id02').style.display='block'" >Account</button>
    </div>
</div>

<!-- cart -->
<div style="background-color:orange;">
<h1 style='display:inline; color:black ; margin-left:40vw;'>My Cart</h1>
 <table class='cart-table' id='cart-table'>
           <tr>
            <th>Product id</th>
            <th>Product image</th>
            <th>Product name</th>
            <th>Product price </th>
            <th>Quantity <button onclick="toggleEditable()">edit</button></th>
            <th>Amount</th>
            <th>Remove</th>
        </tr>
   </table>
   <!-- payment  -->
   <div style="margin-left:30vw;display:none" id="payArea">
   <?php
    $uid = $_SESSION['uid'];
    $totalAmountQuery = "SELECT SUM(total) AS totalAmount FROM cart where u_id = $uid";
    $totalAmountResult = mysqli_query($conn, $totalAmountQuery);
    $totalAmountData = mysqli_fetch_assoc($totalAmountResult);
    $totalAmount = $totalAmountData['totalAmount'];
    
    echo "<h1 id='tot'>Total amount : Rs " .  $totalAmount . "</h1>"; 
    ?> 
    <button onclick="document.getElementById('bill').style.display='block';" style="margin-left:13vw;">Proceed payment</button>   
  </div>
</div>

<img src='imgs/emptycart.png' id='emptycart' style='width:100vw;height:60vh; display:none ;'>

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

<!--snack -->
<div id="removesnack">Item removed successfully !</div>

<!-- Display past orders details here -->
<div id="pastOrders" class="modal" style="background-color:orange;overflow:scroll;">
<h1 style='display:inline; color:white ; margin-left:40vw;'>My Orders</h1>
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
<div class="modal" style="margin-top:5vh;" id='bill'>
    <div class="row">
        <div class="col-75">
            <div class="containerBill">
                <button onclick="document.getElementById('bill').style.display='none';" style="background-color:red;float:right;">X</button>
                <form>
                    <div class="row">
                        <div class="col-50">
                            <h3>Billing Address</h3>
                            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                            <input class="billinp" type="text" id="fname" name="firstname" placeholder="Your name" required>
                            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                            <input class="billinp" type="text" id="adr" name="address" placeholder="Your address" required>
                            <label for="city"><i class="fa fa-institution"></i> City</label>
                            <input class="billinp" type="text" id="city" name="city" placeholder="NYour city name" required>
                            <div class="row">
                                <div class="col-50">
                                    <label for="state">State</label>
                                    <input class="billinp" type="text" id="state" name="state" placeholder="Tamilnadu" required>
                                </div>
                                <div class="col-50">
                                    <label for="zip">Zip</label>
                                    <input class="billinp" type="text" id="zip" name="zip" placeholder="10001" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Continue to checkout" class="btn" onclick="pay()">
                </form>
            </div>
        </div>
    </div>
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

<script>
document.addEventListener("DOMContentLoaded", function() {
  const paymentStatus = sessionStorage.getItem("paymentStatus");

  if (paymentStatus === "success") {
    alert("Payment succeeded!");
  } else if (paymentStatus === "failure") {
    alert("Payment failed. Please try again.");
  }

  // Remove the item from sessionStorage
  sessionStorage.removeItem("paymentStatus");
});

function pay(){
    var fname = document.getElementById('fname').value;
    var adr = document.getElementById('adr').value;
    var city = document.getElementById('city').value;
    var state = document.getElementById('state').value;
    var zip = document.getElementById('zip').value;
 if (fname === '' || adr === '' || city === '' || state === '' || zip === '') {
        return false; // Prevent form submission
    }
    fetch('public/create.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
        })
            .then(response => response.json())
            .then(data => {
                // Redirect the user to the payment page with the client secret
                console.log(data.clientSecret);
                window.location.href = 'public/checkout.html?client_secret=' + data.clientSecret;
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle error as needed
            });
  
}
   
//cart
fetch(`buy.php`)
.then(response => response.json())
    .then(data => {
        const cartTable = document.getElementById('cart-table');
        const nocart = document.getElementById('emptycart');
        
        if (data.length > 0) {
            nocart.style.display = 'none';
           // cartTable.style.display = 'block';
            document.getElementById('payArea').style.display='block';
            data.forEach(item => {
                const row = document.createElement('tr');
                row.id=`row_${item.p_id}`;
                row.innerHTML = `
                    <td>${item.p_id}</td>
                    <td><img src='${item.p_img}'></td>
                    <td>${item.p_name}</td>
                    <td>Rs ${item.p_price}</td>
                    <td><input type="number" id="quantity_${item.p_id}" name="quantity" min="1" max="${item.available}" value="${item.quantity}" readonly>
                    <button onclick="updateQuantity(${item.p_id} , ${item.available})">Update</button></td>
                    <td id="total_${item.p_id}">${item.total}</td>
                    <td><button onclick="removeItem(${item.p_id})" style="background-color:red">Remove</button></td>
                `;
                cartTable.appendChild(row);
            });
        } else {
            alert("Add items to cart");
            nocart.style.display = 'block';
            cartTable.style.display = 'none';
          //  document.getElementById('payArea').style.display='none';
        }
    })
    .catch(error => console.error(error));


    function updateQuantity(productId,maxAvail) {
    let newQuantity = document.getElementById(`quantity_${productId}`).value;
    if(newQuantity > maxAvail){
        newQuantity = maxAvail;
    }
    if(newQuantity < 1){
        newQuantity = 1;
    }
    const qId = "quantity_"+productId;
    document.getElementById(qId).value = "" + newQuantity;
    
    fetch('buy.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `updateQuantity=true&productId=${productId}&newQuantity=${newQuantity}`,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const totalElement = document.getElementById(`total_${productId}`);
                totalElement.innerText = data.newTotal;
                document.getElementById('tot').innerText = `Total amount : Rs` + data.totalAmount;
                toggleEditable();
            } else {
                console.error(data.message);
            }
        })
        .catch(error => console.error(error));
}

function toggleEditable() {
        var inputs = document.getElementsByTagName('input');
        

        for (var i = 0; i < inputs.length; i++) {
            inputs[i].readOnly = !inputs[i].readOnly;

            if (inputs[i].style.border === "" || inputs[i].style.border === "none") {
            inputs[i].style.border = "solid 2px red";
            inputs[i].style.padding = "10px";
        } else {    
            inputs[i].removeAttribute("style");
        }

        }
    }

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
        if(!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if(data.success){
        var tableRow = document.getElementById("row_" + p_id);
        if (tableRow) {
            tableRow.remove();
        }
        document.getElementById('tot').innerText = `Total amount: Rs `+ data.tot;
        removesnack();
     }
     else{
        window.alert("cannot remove");
     }
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


//cancel:
var modal = document.querySelector('#id02'); // When the user clicks anywhere outside of modals, close them
window.onclick = function(event) {
if (event.target == modal) {
modal.style.display = "none";
}
}

</script>
</html>
