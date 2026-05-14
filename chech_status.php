<?php
include 'db.php';
header('Content-Type: application/json');

$id = $_GET['id'];

$sql = "SELECT status, course FROM orders WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $course = json_decode($row['course'], true);
    $courseStatus = '';

    if ($row['status'] === 'done') {
        $courseStatus = '🎉 All your orders are ready! Enjoy your meal!';
    } elseif ($row['status'] === 'starter_done') {
        $courseStatus = '🥗 Your Starters are Ready! Main Course coming soon!';
    }

    echo json_encode([
        'status' => $row['status'],
        'course_status' => $courseStatus
    ]);
} else {
    echo json_encode(['status' => 'not_found', 'course_status' => '']);
}
?>