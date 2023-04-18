<!DOCTYPE html>
<html lang="en">
<head>
  <meta
      charset="UTF-8"
      name="viewport"
      content="width=device-width, initial-scale=1"
    >
  <title>Order Submitted</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="icon" href="images/cubeIcon.png">
</head>
<body>
<div>

<?php

error_reporting(E_ALL ^ E_NOTICE);

function secure($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
};

$first_name = secure($_POST['first_name']);
$last_name = secure($_POST['last_name']);
$order_color = secure($_POST['selected_color']);
$quality = secure($_POST['quality']);
$order_notes = secure($_POST['order_notes']);
$order_address = secure($_POST['order_address']);
$delivery_notes = secure($_POST['delivery_notes']);
$order_date = date("Y/m/d");

if (empty($first_name) or empty($last_name) or empty($order_color) or empty($quality) or empty($order_address)){
  echo "Something went wrong, one or more required values are empty or invalid";
}else{
  $conn = new mysqli(username and password withheld); #withheld for security
  if($conn->connect_error){
    die("Connection Failed : ".$conn->connect_error);
  }else{
#--------------------------------------------------------------------------------------
    $sql = "INSERT INTO orderTicket (firstName, lastName)
            VALUES (?, ?)";

    $stmt = mysqli_stmt_init($conn);
    if ( ! mysqli_stmt_prepare($stmt, $sql)){
      die(mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "ss", $first_name, $last_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_query($conn, "SELECT MAX(ticketID) FROM orderTicket");
    $row = mysqli_fetch_array($result);
    $currentTicketID = $row[0];   
#---------------------------------------------------------------------------------------
    $sql = "INSERT INTO orderAddress (itemAddress, ticketID)
            VALUES (?, ?)";

    $stmt = mysqli_stmt_init($conn);
    if ( ! mysqli_stmt_prepare($stmt, $sql)){
      die(mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "ss", $order_address, $currentTicketID);
    mysqli_stmt_execute($stmt);
#-----------------------------------------------------------------------------------------
    if( ! empty($delivery_notes)){
    $sql = "INSERT INTO deliveryNotes (notes, ticketID)
            VALUES (?, ?)";

    $stmt = mysqli_stmt_init($conn);
    if ( ! mysqli_stmt_prepare($stmt, $sql)){
      die(mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "ss", $delivery_notes, $currentTicketID);
    mysqli_stmt_execute($stmt);
    };
#-------------------------------------------------------------------------------------------
    $sql = "INSERT INTO customOrder (color, dateOrdered, quality, ticketID)
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_stmt_init($conn);
    if ( ! mysqli_stmt_prepare($stmt, $sql)){
      die(mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "ssss", $order_color, $order_date, $quality, $currentTicketID);
    mysqli_stmt_execute($stmt);

    $result2 = mysqli_query($conn, "SELECT MAX(orderID) FROM customOrder");
    $row2 = mysqli_fetch_array($result2);
    $currentOrderID = $row2[0];
#--------------------------------------------------------------------------------------------
    $sql = "INSERT INTO orderDescription (itemDescript, orderID)
            VALUES (?, ?)";

    $stmt = mysqli_stmt_init($conn);
    if ( ! mysqli_stmt_prepare($stmt, $sql)){
      die(mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "ss", $order_notes, $currentOrderID);
    mysqli_stmt_execute($stmt);
#--------------------------------------------------------------------------------------------
    echo "<h4>Thank you, {$first_name}</h4><br>";
    echo "<h4>You ordered: {$order_notes}</h4><br>";
    echo "<h4>Your color of choice was: {$order_color}</h4><br>";
    echo "<h4>You selected the quality: {$quality}</h4><br>";
    echo "<h4>It will be delivered to: {$order_address}</h4><br>";
    if( ! empty($delivery_notes)){
      echo "<h4>Here are the delivery notes you specified: {$delivery_notes}</h4><br>";
    };
    echo "<h4>You submitted this order on: {$order_date}</h4><br><br>";
    echo "<h4>You may close this page</h4><br><br>";
    echo "<h4>Changed your mind? Something went Wrong?</h4><br>";
    echo "<h4>Contact us at D3Printing@gmail.com</h4>";
  }
}
?>
</div>
</body>
</html>
