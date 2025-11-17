<?php

include '../connection.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT ID, CustomerName, CustomerPhone FROM customers";
$result = $conn->query($query);

$customers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
}

echo json_encode($customers);
$conn->close();
?>
