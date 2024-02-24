<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>E-Commerce website</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet"  type="text/css" href="style.css" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 </head>
<body>
  
  
  <div class="header">
    <a href="">Home</a>
   <span class="arrow">➔</span>
    <div class="header-right">
      <button  onclick="document.getElementById('id01').style.display='block'" style="width:auto;" >Sign Up</button>
      <button  onclick="document.getElementById('id02').style.display='block'" style="width:auto;" >Log in</button>
      <button  onclick="document.getElementById('id03').style.display='block'" style="width:auto;" >Admin</button>
    </div>
</div>
           <?php
       if(isset($_SESSION['uid'])){
           echo "<div style='padding:20px; width:40vw; border:solid 2px red;background-color:orange;z-index:1000;position:fixed;margin-left:30vw;'>";
           echo "<a href='page2.php' style='text-decoration:none; background-color:orange; margin-left:9vw; font-size:35px;'>Continue shopping</a>";
           echo "</div>";
       }
      ?>
<div id="id01" class="modal">
  <form method="post" class="modal-content"  onsubmit="registerUser(event)">
    <div class="container">
      <h1>Sign Up</h1>
      <p>Please fill in this form to create an account.</p>
      <hr>
      <label><b>Name</b></label>
      <input type="text" placeholder="Your name" name="username" required>

      <label><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="mailid" required>

      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>

      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" class="signupbtn">Sign Up</button>
      </div>
    </div>
  </form>
</div>

<div id="id02" class="modal">
  <form method="post" class="modal-content"  onsubmit="loginUser(event)">
    <div class="container">
      <h1>Login</h1>
      <p>Please fill in this form to login</p>
      <hr>
      <label><b>Name</b></label>
      <input type="text" placeholder="Your name" name="lusername" required>


      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="lpassword" required>

      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" class="signupbtn">Log in</button>
      </div>
    </div>
  </form>
</div>

<!--admin-->
<div id="id03" class="modal">
  <form method="post" class="modal-content"  onsubmit="registerAdmin(event)">
    <div class="container">
      <h1>Login in as Admin</h1>
      <hr>
      <label><b>Name</b></label>
      <input type="text" placeholder="Your name" name="adminname" required>
      <label><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="adminpassword" required>

      <div class="clearfix">
        <button type="button" onclick="document.getElementById('id03').style.display='none'" class="cancelbtn">Cancel</button>
        <button type="submit" class="signupbtn">Login</button>
      </div>
    </div>
  </form>
</div>


  <div class="slideshow-container">

    <div class="mySlides fade">
      <img src="imgs/phone.jpg">
      <div class="text">Mobiles</div>
    </div>
    
   
    <div class="mySlides fade">
      <img src="imgs/book.png">
      <div class="text">Books</div>
    </div>

    <div class="mySlides fade">
      <img src="imgs/watch.jpg">
      <div class="text">Watch</div>
    </div>

    <div class="mySlides fade">
      <img src="imgs/shoe.png">
      <div class="text">Shoes</div>
    </div>
    <div class="mySlides fade">
      <img src="imgs/coat.jpg">
      <div class="text">Coat Suits</div>
    </div>
    </div>

   <!-- about-->
   <div class="feature-container">
    <div class="feature">
      <div class="feature-icon">&#128101;</div>
      <div class="feature-title">1 Million+ Users</div>
      <div class="feature-description">Join our growing community</div>
    </div>
  
    <div class="feature">
      <div class="feature-icon">&#127873;</div>
      <div class="feature-title">1000+ Brands</div>
      <div class="feature-description">Explore a diverse range of brands</div>
    </div>
  
    <div class="feature">
      <div class="feature-icon">&#128230;</div>
      <div class="feature-title">Free Delivery</div>
      <div class="feature-description">Enjoy free and fast shipping</div>
    </div>
  
    <div class="feature">
      <div class="feature-icon">&#10003;</div>
      <div class="feature-title">Quality Guarantee</div>
      <div class="feature-description">Assured quality on all products</div>
    </div>
  </div>
<!-- sample products-->

  <div class ="flex">
    <div class="card">
      <img src="imgs/watch.jpg"><br>
      <h1>Watch</h1>
      <p>Sign in to continue !</p>
    </div>
    <div class="card">
      <img src="imgs/book.png"><br>
      <h1>Books</h1>
      <p>Sign in to continue !</p>
    </div>
    <div class="card">
      <img src="imgs/coat.jpg "><br>
      <h1>Clothings</h1>
      <p>Sign in to continue !</p>
    </div>       
    <div class="card">
      <img src="imgs/phone.jpg"><br>
      <h1>Mobiles</h1>
      <p>Sign in to continue !</p>
    </div>
    <div class="card">
      <img src="imgs/shoe.png"><br>
      <h1>Shoes</h1>
      <p>Sign in to continue !</p>
    </div>
    <div class="card">
      <img src="imgs/grocery.jpg"><br>
  <h1>Grocery</h1>
  <p>Sign in to continue !</p>
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
 function registerUser(event) {
  event.preventDefault(); // Prevent form submission
  var username = document.querySelector("input[name='username']").value;
  var email = document.querySelector("input[name='mailid']").value;
  var password = document.querySelector("input[name='password']").value;

    fetch('signin.php', {
    method: 'POST',
    body: new URLSearchParams({
      username: username,
      mailid: email,
      password: password
    })
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(data.message);
      } else {
        alert(data.message);
      }

      // Clear  inputs
      document.querySelector("input[name='username']").value = "";
      document.querySelector("input[name='mailid']").value = "";
      document.querySelector("input[name='password']").value = "";

      document.getElementById('id01').style.display = 'none';
    })
    .catch(error => {
      console.error('Error:', error);
    });
}  

function loginUser(event) {
  event.preventDefault(); 
  console.log("Logging in user...");
  var username = document.querySelector("input[name='lusername']").value;
  var password = document.querySelector("input[name='lpassword']").value;
    fetch('login.php', {
    method: 'POST',
    body: new URLSearchParams({
      username: username,
      password: password
    })
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(data.message);
        window.location.href = "page2.php";
      } else {
        alert(data.message);
      }

      // Clear inputs
      document.querySelector("input[name='lusername']").value = "";
      document.querySelector("input[name='lpassword']").value = "";
      document.getElementById('id02').style.display = 'none';
    })
    .catch(error => {
      console.error('Error:', error);
    });
}  
//admin
function registerAdmin(event) {
  event.preventDefault();
  var adminname = document.querySelector("input[name='adminname']").value;
  var adminpassword = document.querySelector("input[name='adminpassword']").value;

  fetch('adminDashboard.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body:JSON.stringify({
      adminname: adminname,
      password: adminpassword
    }) 
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(data.message);
        window.location.href ="adminPage.php";
      } else {
        alert(data.message);
      }
      // Clear inputs
      document.querySelector("input[name='adminname']").value = "";
      document.querySelector("input[name='adminpassword']").value = "";

      document.getElementById('id03').style.display = 'none';
    })
    .catch(error => {
      console.error('Error:', error);
    });
}  

let slideIndex = 0;
    showSlides();
    
    function showSlides() {
      let i;
      let slides = document.getElementsByClassName("mySlides");
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
      }
      slideIndex++;
      if (slideIndex > slides.length) {slideIndex = 1}    
      slides[slideIndex-1].style.display = "block";  
      setTimeout(showSlides, 1500); 
    }

    var modals = document.querySelector('#id01, #id02, #id03');

// When  user clicks  outside of modals close it
window.onclick = function(event) {
  if (event.target == modals) {
    modals.style.display = "none";
  }
}
</script>
</body>
</html>
