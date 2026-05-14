<?php
include 'db.php';

$razorpay_payment_id = $_POST['razorpay_payment_id'];
$order_id = $_POST['order_id'];

// Update order as paid directly
$sql = "UPDATE orders SET payment_status='paid', payment_id='$razorpay_payment_id' WHERE id=$order_id";

if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "error";
}
?>

