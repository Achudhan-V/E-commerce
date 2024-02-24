<?php
session_start();

include("db_connection.php");

$uid=$_GET['u_id'];

$sql = "select o.p_id , p.p_img , p.p_name , o.order_date , o.quantity , o.amount
        from orders o inner join products p 
        on p.p_id = o.p_id
        where o.u_id = $uid";

$res = mysqli_query($conn,$sql);
$orderitems = array();
if(mysqli_num_rows($res) > 0){
    while($row = mysqli_fetch_assoc($res)){
        $orderitems[] = $row;
    }
}

echo json_encode($orderitems);
exit();

?>