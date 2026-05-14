<?php
include 'db.php';
header('Content-Type: application/json');

// Only fetch today's orders for kitchen
$sql = "SELECT * FROM orders WHERE DATE(created_at) = CURDATE() ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

$orders = [];
while($row = mysqli_fetch_assoc($result)) {
    $row['course'] = json_decode($row['course'], true) ?? [];
    $orders[] = $row;
}

echo json_encode($orders);
?>