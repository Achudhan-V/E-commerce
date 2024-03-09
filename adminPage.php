<?php
  session_start();
  if (!isset($_SESSION['admin'])) {
      echo "<script>alert('Get out');</script>";
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>E-Commerce website</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet"  type="text/css" href="style.css" />
 </head>
<body style="background-color: lightblue;">
  
  
  <div class="header ">
    <h1 style="text-align: center;">Admin Dashboard</h1>
    <div>
        <button onclick="window.history.back()" >Home</button>
        <a href="index.php" style="float: right;">Logout</a>

    </div>

</div>

<div class="flex">
    <button onclick="add()">Add an item</button>
    <button onclick="remove()">Remove an item</button>
    <button onclick="update()">Update an item</button>
</div>

<!--add-->
<div id="add" style="display:none">
 <div class="flex" style="border:solid 2px blue;">
    <h2>Insert an item</h2>
    <button onclick="document.getElementById('add').style.display='none'" style="background-color:red ;float:right;">X</button>   
 </div>
 <div class="flex">
    <button onclick="adddetails('add1' , 100)">Clothings</button>
    <button onclick="adddetails('add2' , 200)">Mobiles</button>
    <button onclick="adddetails('add3' , 300)">Shoes</button>
    <button onclick="adddetails('add4' , 400)">Watches</button>
    <button onclick="adddetails('add5' , 500)">Grocery</button>
    <button onclick="adddetails('add6' , 600)">Books</button>
</div>
<div id="addTable" style="display:none;">
    <h1 id="addHeading"></h1>
    <div>
        <label for="pid">Product Id:</label>
        <h3 id="pid"></h3>
    </div>
    <div>
        <label for="pname">Product Name:</label>
        <input type="text" name="pname" id="pname" required>
    </div>
    <div>
        <label for="psrc">Image src:</label>
        <input type="text" name="psrc" id="psrc" required>
    </div>
    <div>
        <label for="pprice">Price:</label>
        <input type="number" name="pprice" id="pprice" required>
    </div>
    <div>
        <label for="pdesc">Description:</label><br>
        <textarea name="pdesc" id="pdesc" rows="22" cols="50" required></textarea>
    </div>
    <div>
        <label for="pavail">Available Quantity:</label>
        <input type="number" name="pavail" id="pavail" required>
    </div>
    <div>
        <button onclick="insertItem()" style="margin-left: 25vw;">Insert</button>
    </div>
</div>

 </div>
<!--remove-->
<div id="delete" style="display:none">
    <div class="flex" style="border:solid 2px blue;">
        <h2>Delete an item</h2>
        <button onclick="document.getElementById('delete').style.display='none'" style="background-color:red ;float:right;">X</button>    
    </div>
   <div class="flex">
    <button onclick="removedetails('remove1' , 100)">Clothings</button>
    <button onclick="removedetails('remove2' , 200)">Mobiles</button>
    <button onclick="removedetails('remove3' , 300)">Shoes</button>
    <button onclick="removedetails('remove4' , 400)">Watches</button>
    <button onclick="removedetails('remove5' , 500)">Grocery</button>
    <button onclick="removedetails('remove6' , 600)">Books</button>
    </div>

    
    <div id="removeTable" style="display:none">
        <h1 id="removeHeading"></h1>
    <table id="removeTableData" class='cart-table'>
           <!--items from script-->
    </table>
    </div>
</div>

<!--update-->
<div id="update" style="display:none">
    <div class="flex" style="border:solid 2px blue;">
        <h2>Update an item</h2>
        <button onclick="document.getElementById('update').style.display='none'" style="background-color:red ;float:right;">X</button>    
    </div>
   <div class="flex">
    <button onclick="updatedetails('update1' , 100)">Clothings</button>
    <button onclick="updatedetails('update2' , 200)">Mobiles</button>
    <button onclick="updatedetails('update3' , 300)">Shoes</button>
    <button onclick="updatedetails('update4' , 400)">Watches</button>
    <button onclick="updatedetails('update5' , 500)">Grocery</button>
    <button onclick="updatedetails('update6' , 600)">Books</button>
    </div>

    
    <div id="updateTable" style="display:none">
        <h1 id="updateHeading"></h1>
    <table id="updateTableData" class='cart-table'>
           <!--items from script-->
    </table>
    </div>
</div>

<!--hidden details to refresh p_id after inserting-->
<input type="hidden" name="category" id="category">
<input type="hidden" name="range" id="range">
</body>

<script>
function add(){
 document.getElementById('add').style.display='block';
 document.getElementById('delete').style.display='none';
 document.getElementById('update').style.display='none';
}
function remove(){
    document.getElementById('delete').style.display='block';
 document.getElementById('add').style.display='none';
 document.getElementById('update').style.display='none';
 
}
function update(){
        document.getElementById('delete').style.display='none';
        document.getElementById('add').style.display='none';
        document.getElementById('update').style.display='block';
}

function adddetails(category , range){
    
    document.getElementById('category').value = category;
    document.getElementById('range').value = range;
    
        switch(category){
        case "add1": 
            document.getElementById('addHeading').innerHTML = "Insert only clothing items";
            document.getElementById('addTable').style.display = 'block';
            break;
        case "add2": 
            document.getElementById('addHeading').innerHTML = "Insert only Mobile items";
            document.getElementById('addTable').style.display = 'block';
            break;
        case "add3": 
            document.getElementById('addHeading').innerHTML = "Insert only Shoe items";
            document.getElementById('addTable').style.display = 'block';
            break;
        case "add4": 
            document.getElementById('addHeading').innerHTML = "Insert only Watch items";
            document.getElementById('addTable').style.display = 'block';
            break;
        case "add5": 
            document.getElementById('addHeading').innerHTML = "Insert only Grocery items";
            document.getElementById('addTable').style.display = 'block';
            break;
        case "add6": 
            document.getElementById('addHeading').innerHTML = "Insert only Books";
            document.getElementById('addTable').style.display = 'block';
            break;
    }
    fetch('adminDashboard.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        getMaxId: true,
        range: range,
    }),
})
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('pid').innerText = data.maxId;
        } else {
            console.error('Failed to fetch max p_id:', data.message);
        }
    })
    .catch(error => console.error('Error fetching max p_id:', error));
}
function insertItem() {
    let pid = document.getElementById("pid").innerText;
    let pname = document.getElementById("pname").value;
    let psrc = document.getElementById("psrc").value;
    let pprice = document.getElementById("pprice").value;
    let pdesc = document.getElementById("pdesc").value;
    let pavail = document.getElementById("pavail").value;
    
    if (!pid || !pname || !psrc || !pprice || !pdesc || !pavail) {
        alert("Please fill in all fields");
        return;
    }
    // use adminDashboard.php to insert items to products table with cols(p_id, p_name, p_price, p_description, p_img, available)
    fetch('adminDashboard.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            insertItem: true,
            pid: pid,
            pname: pname,
            psrc: psrc,
            pprice: pprice,
            pdesc: pdesc,
            pavail: pavail
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            document.getElementById("pname").value = "";
            document.getElementById("psrc").value = "";
            document.getElementById("pprice").value = "";
            document.getElementById("pdesc").value = "";
            document.getElementById("pavail").value = "";
            
            //updating p_id
            let c=document.getElementById('category').value;
            let r=document.getElementById('range').value;
            adddetails(c,r); // for updating p_id everytime.
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}
//Removing
function removedetails(category , range){
    switch(category){
        case "remove1": 
            document.getElementById('removeHeading').innerHTML = "Remove clothing items";
            document.getElementById('removeTable').style.display = 'block';
            break;
        case "remove2": 
            document.getElementById('removeHeading').innerHTML = "Remove Mobile items";
            document.getElementById('removeTable').style.display = 'block';
            break;
        case "remove3": 
            document.getElementById('removeHeading').innerHTML = "Remove Shoe items";
            document.getElementById('removeTable').style.display = 'block';
            break;
        case "remove4": 
            document.getElementById('removeHeading').innerHTML = "Remove Watch items";
            document.getElementById('removeTable').style.display = 'block';
            break;
        case "remove5": 
            document.getElementById('removeHeading').innerHTML = "Remove Grocery items";
            document.getElementById('removeTable').style.display = 'block';
            break;
        case "remove6": 
            document.getElementById('removeHeading').innerHTML = "Remove Books";
            document.getElementById('removeTable').style.display = 'block';
            break;
    }
    fetch('adminDashboard.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        getRows: true,
        range: range,
    }),
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        document.getElementById('removeTableData').innerHTML ="";
        document.getElementById('removeTableData').innerHTML+=`<tr>
        <th>Product Id</th>
        <th>Product name</th>
        <th>Image</th>
        <th>Price</th>
        <th>Available quantity</th>
        <th>Remove</th>
        </tr>`;
        const rows = data.rows;
        rows.forEach(row => {
            const single = `
                <tr id='row_${row.p_id}'>
                   <td>${row.p_id}</td>
                   <td>${row.p_name}</td>
                   <td><img src='${row.p_img}' style="width:100% ;height:auto;"></td>
                   <td>${row.p_price}</td>
                   <td>${row.available}</td>
                   <td><button onclick="removeItem(${row.p_id})">Remove</button></td>
                </tr>
            `;

            document.getElementById('removeTableData').innerHTML += single;
        });
    } else {
        console.error('Failed to fetch rows:', data.message);
    }
}).catch(error => console.error('Error fetching rows:', error.message));


}

function removeItem(pid){

    fetch('adminDashboard.php',{
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        },
        body: JSON.stringify({
        removeRow: true,
        pid: pid,
    }),  
    })
    .then(x => x.json())
    .then(data =>{
        if(data.success){
            console.log(data.msg);
            document.getElementById(`row_${pid}`).remove();
        }
        else{
            alert(data.msg);
        }
    })
    .catch(error => console.error(error));
}

//update
function updatedetails(category, range) {
    const categoryMap = {
        'update1': 'clothing items',
        'update2': 'Mobile items',
        'update3': 'Shoe items',
        'update4': 'Watch items',
        'update5': 'Grocery items',
        'update6': 'Books',
    };
    document.getElementById('updateHeading').innerHTML = `Update ${categoryMap[category]}`;
    document.getElementById('updateTable').style.display = 'block';

    fetch('adminDashboard.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            getRows: true,
            range: range,
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const tableData = document.getElementById('updateTableData');
            tableData.innerHTML = `
                <tr>
                    <th>Product Id</th>
                    <th>Product name</th>
                    <th>Image</th>
                    <th>Update Image Src</th>
                    <th>Price</th>
                    <th>Available quantity</th>
                    <th>Description</th>
                    <th>Update</th>
                </tr>
            `;

            const rows = data.rows;
            rows.forEach(row => {
                const rowElement = document.createElement('tr');
                rowElement.innerHTML = `
                <td>${row.p_id}</td>
                <td contenteditable='true' id='productName_${row.p_id}'>${row.p_name}</td>
                <td><img src='${row.p_img}' style="width:100%; height:auto;">
                <td contenteditable='true'><input type='text' value='${row.p_img}' id='imageSrc_${row.p_id}'></td>
                </td>
                <td contenteditable='true' id='price_${row.p_id}'>${row.p_price}</td>
                <td contenteditable='true' id='availableQty_${row.p_id}'>${row.available}</td>
                <td contenteditable='true' id='description_${row.p_id}'>${row.p_description}</td>
                <td><button onclick="updateItem(${row.p_id})">Update</button></td>
                `;
                tableData.appendChild(rowElement);
            });
        } else {
            console.error('Failed to fetch rows:', data.message);
        }
    })
    .catch(error => console.error('Error fetching rows:', error.message));
}
function updateItem(pid) {
    //console.log("here");
    const productName = document.getElementById(`productName_${pid}`).innerText;
    const imageSrc = document.getElementById(`imageSrc_${pid}`).value; //innerText; //querySelector('input').value;
    const price = document.getElementById(`price_${pid}`).innerText;
    const availableQty = document.getElementById(`availableQty_${pid}`).innerText;
    const description = document.getElementById(`description_${pid}`).innerText;

    fetch('adminDashboard.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            updateRow: true,
            pid: pid,
            productName: productName,
            imageSrc: imageSrc,
            price: price,
            availableQty: availableQty,
            description: description
        }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error(error));

    //over
}
</script>
</html>
