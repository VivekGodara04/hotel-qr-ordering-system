<?php
include 'db.php';

$id = $_POST['id'];
$status = isset($_POST['status']) ? $_POST['status'] : 'done';

$sql = "UPDATE orders SET status='$status' WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "error";
}
?>

