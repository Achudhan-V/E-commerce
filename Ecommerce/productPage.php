<?php
session_start();
include("db_connection.php");

$x=$_GET['x'];

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
      <button onclick="fetchWishlist()">wishlist</button>
      <button onclick="viewcart()">View Cart</button>
      <button onclick="window.location.href='purchase.php'">Purchase</button>
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
<div id="cart" class="modal" style="background-color:orange; overflow:scroll;">
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
        echo "<tr id='row_" . $cartItem['p_id'] . "'>";
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

<!--snack -->  <!-- added/ already added-->
<div id="removesnack">Item removed successfully !</div>
<div id="addsnack"></div> 




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


<!--wishlist -->
<div id="wishlist" class="modal" style="background-color:orange;overflow:scroll;">
<h1 style='display:inline; color:white ; margin-left:40vw;'>My WishList</h1>
<button onclick="location.reload()" style="background-color:red ;float:right;">X</button>
<table class='cart-table' id="wishTable">
    <tr>
      <th>Product id</th>
      <th>Product image</th>
      <th>Product name</th>
      <th>Price</th>
      <th>Add to cart</th>
      <th>Remove</th>
    </tr>
  </table>
<img src='imgs/emptywish.png' id="noWish" style='width:30vw;height:60vh; margin-left:380px; margin-top:50px;'>    
</div>

<!--product type name and image-->
<div class="flex-container">
    <div id="productType" style="font-size:30px; padding:20px 10px;"></div>
    <div><img src="" id="productImg" style="width:95vw; height:75vh;"></div>
</div> <br><br>
<div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
    <h1 style="padding: 10px 15px; height:8vh;">Search :</h1> 
    <input type="text" name="p_name" id="p_name"  style="font-size:25px; border: solid 2px skyblue; height: 10vh; width: 50vw;">
</div>

<!--description -->
<div id='desc' style="display:none;">
<!-- js code -->
</div>


<!-- products based on search -->
  <div class ="flex" id="productsContainer">
    
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
        document.getElementById('p_name').addEventListener('input', searchProducts);
        window.addEventListener('load', searchProducts);
 let x = <?php echo $x; ?>;
 let pT= document.getElementById("productType");
 let pI = document.getElementById("productImg");
 switch(x){
    case 100: pT.innerHTML = "Purchase Clothes ! Style is a way to say who you are without having to speak.";
              pI.src = "imgs/coat.jpg";  break;
    case 200:pT.innerHTML = "Purchase Mobiles ! Unlock innovation with our latest mobile collection – where technology meets elegance";
              pI.src = "imgs/phone.jpg";
             break;
    case 300:pT.innerHTML = "Purchase Shoes ! Step into style and comfort with our trendy shoe collection – every step is a statement";
              pI.src = "imgs/shoe.png";
             break;
    case 400:pT.innerHTML = "Purchase Watch ! Timeless elegance on your wrist – discover our exquisite watch collection.";
              pI.src = "imgs/watch.jpg";
             break;    
    case 500:pT.innerHTML = "Purchase Grocery items ! From farm to table, savor the freshness – explore our premium grocery selection";
              pI.src = "imgs/grocery.jpg";
             break;    
    case 600:pT.innerHTML = "Purchase Books ! Immerse yourself in the world of words – dive into our captivating book collection";
              pI.src = "imgs/book.png";
             break;
 }


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

//search:
function searchProducts() {
    let search = document.getElementById('p_name').value;

    fetch(`products.php?search=${search}&x=${x}`)
      .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            //console.log(response.json());
            return response.json();
        })
        .then(products => {
            console.log(products);
            displayProducts(products);
            updateWishlistIcons();
        })
        .catch(error => console.error("Error here1:",error));
}



function displayProducts(products){
    const productsContainer = document.getElementById("productsContainer");
            productsContainer.innerHTML = ""; 
            if(products.length > 0){
            products.forEach(product => {
                // product card 
                var y = Number(product.p_price)+Number(458);
                const productCard = `
                    <div class="card" style="height:fit-content">
                        <img src="${product.p_img}">
                        <i id="wish_${product.p_id}" class="fa fa-heart heart-icon" style="font-size:30px;" onclick="wishlist(${product.p_id})"></i>
                        <h4 class="product-name">
                        ${product.p_name}</h4>
                        <p style="display:inline"><b>Rs: ${product.p_price}</b>&nbsp;&nbsp; <s>Rs: ${y}</s></p>
                        <button onclick="displayDescription(\`${product.p_description}\` , ${product.p_id} ,\`${product.p_img}\` ,\`${product.p_name}\`,${product.p_price})" style="background-color:orange;">About</button>
                        <button onclick="addToCart(${product.p_id} ,  ${product.p_price})">Add to Cart</button>
                    </div>
                `;
                console.log(productCard);
                productsContainer.innerHTML += productCard;
            });
        }
        else{
            productsContainer.innerHTML = '<p>No results found</p>';
        }
}
// display description
function displayDescription(desc, pid, img, name, price) {
    let elt = `<img src="${img}" style="width:275px;height:290px;margin-left:15vw;">
               <button onclick="document.getElementById('desc').style.display='none'" style="background-color:red;position:fixed;margin-left:18vw;">X</button>
                <div style="width:50vw;word-wrap: break-word;">
                <h4>Name: ${name}</h4>
                <h4>Price: Rs ${price}</h4>
                <h4>Description:</h4>`;
    elt += `<pre style="word-wrap: break-word;width:50vw;">${desc}</pre></div>`;
    elt += `
<div style="height:fit-content;border:solid 2px red">
<h3>Reviews:</h3>
<h5>Leave your review here:</h5>
<div class="flex">
    <textarea id="userReview" placeholder="Type your review" rows="4" cols="50"></textarea>
    <button onclick="addReview(${pid})">Submit</button>
</div>
<div id="allReviews">
    <!-- All reviews-->
</div></div>`;

    document.getElementById("desc").innerHTML = "";
    document.getElementById("desc").innerHTML = elt;
    document.getElementById("desc").style.display = 'block';
    // load all reviews
    displayAllReviews(pid);
}
// add to cart
function addToCart(productId , productPrice) {
            fetch(`addToCart.php?p_id=${productId}&p_price=${productPrice}`)
                .then(response => response.json())
                .then(data => {
                    addsnack(data.message);
                })
                .catch(error => console.error(error));
        }
function addsnack(msg){
    var x = document.getElementById("addsnack");
    x.innerHTML = msg;
    x.classList.add("show");

    setTimeout(function() {
        x.classList.remove("show");
    }, 3000);
}

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


function wishlist(pid) {
    const icon = document.getElementById(`wish_${pid}`);

    if (icon) {
        const currentColor = icon.style.color;
        const newColor = currentColor === 'red' ? 'lightgrey' : 'red';
        icon.style.color = newColor;

        // Send the request to the server without handling the response
        fetch(`updateWishlist.php?pid=${pid}`)
            .catch(error => {
                console.error('Error:', error);
                // Revert the change on error if needed
                 icon.style.color = currentColor;
            });
    } else {
        console.error(`Element with ID ${pid} not found.`);
    }
}

function updateWishlistIcons() {
    // Fetch initial wishlist details when the page loads
    fetch('updateWishlist.php')
        .then(response => response.json())
        .then(data => handleInitialWishlist(data))
        .catch(error => {
            console.error('Error fetching initial wishlist:', error);
            console.log('Response:', error.response); 
        });

    function handleInitialWishlist(wishlistItems) {
        console.table(wishlistItems);
        wishlistItems.forEach(item => {
            const iconId = `wish_${item.p_id}`;
            const icon = document.getElementById(iconId);
            if (icon) {
                const color = item.wish === '1' ? 'red' : 'lightgrey';
                icon.style.color = color;
            } else {
                console.log('Icon not found');
            }
        });
    }
};

//wishlist table
function fetchWishlist(){
    document.getElementById('wishlist').style.display = "block";
    fetch(`updateWishlist.php?wish=1`)
        .then(response => response.json())
        .then(data => {
            displayWishlist(data);
        })
        .catch(error => console.error('Error fetching wishlist:', error));
}
function displayWishlist(wishlistItems) {
    const wishlistTable = document.getElementById('wishTable');
    const noWish = document.getElementById("noWish");

    wishlistTable.innerHTML = ""; // Clear existing content

    if (wishlistItems.length > 0) {
        noWish.style.display = 'none';
        wishlistItems.forEach(item => {
            const row = document.createElement('tr');
            row.id = `wishlistRow_${item.p_id}`;
            row.innerHTML = `
                <td>${item.p_id}</td>
                <td><img src='${item.p_img}'></td>
                <td>${item.p_name}</td>
                <td>${item.p_price}</td>
                <td><button onclick="addToCart(${item.p_id}, ${item.p_price})">Add to Cart</button></td>
                <td><button onclick="removeWish(${item.p_id})">Remove</button></td>
            `;
            wishlistTable.appendChild(row);
        });
    } else {
        wishlistTable.style.display='none';
        noWish.style.display = 'block';
    }
}

function removeWish(pid){
    document.getElementById(`wishlistRow_${pid}`).remove();
    fetch(`updateWishlist.php?removeWish=${pid}`)
        .catch(error => console.error('Error:', error));  
}

function addReview(pid){
    let review = document.getElementById("userReview").value;
    if(review === ""){
        return;
    }
    fetch("review.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            review: review,
            pid: pid,
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("addReview:"+data);
        if (data.success) {
            document.getElementById("userReview").value = ""; 
            displayAllReviews(pid);
        } else {
            alert("Unable to process");
        }
    })
    .catch(error => console.error(error));
}
function displayAllReviews(pid) {
    fetch("review.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            allReview: true,
            pid: pid,
        }),
    })
    .then(response => {
        console.log(response);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(reviews => {
        console.log("allReviews"+reviews);
        let reviewsContainer = document.getElementById('allReviews');
        reviewsContainer.innerHTML = "";

        if (reviews && reviews.length > 0) {
            reviews.forEach(review => {
                let reviewElement = document.createElement('div');
                reviewElement.style.backgroundColor = "lightgrey";
                reviewElement.style.border = "solid 1px black";
                reviewElement.style.width = "100%";
                reviewElement.style.height = "auto";

                reviewElement.innerHTML = `
                    <span><b>Username:</b> ${review.u_name}</span> &nbsp;&nbsp;&nbsp; 
                    <span><b>Date:</b> ${review.date}</span><br>
                    <p><b>Review:</b> ${review.review}</p>
                `;

                reviewsContainer.appendChild(reviewElement);
            });
        } else {
            console.log('No reviews available'); // Add a log statement or handle accordingly
        }
    })
    .catch(error => alert(error));
}


//cancel:
var modal = document.querySelector('#id02'); // When the user clicks anywhere outside of modals, close them
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


</script>
</body>
</html>
