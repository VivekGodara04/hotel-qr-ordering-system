<?php
include 'db.php';

$table = $_POST['table'];
$items = $_POST['items'];
$total = $_POST['total'];
$course = isset($_POST['course']) ? $_POST['course'] : '{}';

$sql = "INSERT INTO orders (table_number, items, total, course) VALUES ('$table', '$items', '$total', '$course')";

if (mysqli_query($conn, $sql)) {
    $id = mysqli_insert_id($conn);
    echo "success:id:" . $id;
} else {
    echo "error: " . mysqli_error($conn);
}
?>