<?php

function secure($data){
    $data = trim($data)
    $data = stripslashes($data)
    $data = htmlspecialchars($data)
    return $data;
}


$first_name = secure($_POST['first_name'])
$last_name = secure($_POST['last_name'])
$order_color = secure($_POST['selected_color'])
$file = secure($_POST['object_file'])
$quality = secure($_POST['quality'])
$order_notes = secure($_POST['order_notes'])
$order_address = secure($_POST['order_address'])
$delivery_notes = secure($_POST['delivery_notes'])



/*
$conn = new mysqli(stuff goes here);

if ($conn->connect_error){
    die('Failed to Connect : '.$conn->connect_error);
}else{
    $stmt = $conn->prepare("insert into table name(first_name, last_name, selected_color, object_file)
        values(?, ?, ?, ?)")
    $stmt->bind_param("ssss", $first_name, $last_name, $order_color, $file);
    $stmt->execute();
    echo "Order Sent"
    $stmt->close();
    $conn->close();
}
*/
?>