<?php
include '../connection.php';

$adminId = $_POST['adminId'];
$field = $_POST['field'];
$value = $_POST['value'];

$sql = "UPDATE users SET $field = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $value, $adminId);
$stmt->execute();
$stmt->close();
$conn->close();
?>
