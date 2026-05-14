<!DOCTYPE html>
<html>
<head>
  <title>Order History - Hotel Priyanka</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #111; color: #fff; font-family: 'Poppins', sans-serif; padding: 20px; }
    h1 { font-family: 'Playfair Display', serif; color: #c9a84c; margin-bottom: 4px; }
    .subtitle { color: #777; font-size: 0.85rem; margin-bottom: 24px; }
    .nav { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
    .nav a { padding: 8px 16px; background: #1a1a1a; border: 1px solid #444; border-radius: 8px; color: #ccc; text-decoration: none; font-size: 0.82rem; }
    .nav a.active { background: #c9a84c; color: #111; font-weight: 600; border-color: #c9a84c; }
    .day-card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 12px; padding: 16px; margin-bottom: 14px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
    .day-date { font-family: 'Playfair Display', serif; color: #c9a84c; font-size: 1rem; }
    .day-stats { display: flex; gap: 20px; flex-wrap: wrap; }
    .day-stat { text-align: center; }
    .day-stat .num { font-size: 1.2rem; font-weight: 700; color: #c9a84c; }
    .day-stat .lbl { font-size: 0.7rem; color: #777; }
    .view-btn { padding: 6px 16px; background: transparent; border: 1px solid #c9a84c; color: #c9a84c; border-radius: 8px; text-decoration: none; font-size: 0.82rem; }
    .no-orders { text-align: center; padding: 40px; color: #555; }
    .total-bar { background: #1a1a1a; border: 1px solid #c9a84c; border-radius: 12px; padding: 16px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
    .total-bar .lbl { color: #aaa; font-size: 0.85rem; }
    .total-bar .num { font-size: 1.5rem; font-weight: 700; color: #c9a84c; }
  </style>
</head>
<body>

<h1>📅 Order History</h1>
<div class="subtitle">Hotel Priyanka — All Time Revenue</div>

<div class="nav">
  <a href="owner.php">📊 Today</a>
  <a href="history.php" class="active">📅 History</a>
  <a href="kitchen.php">👨‍🍳 Kitchen</a>
  <a href="index.html">🍽️ Menu</a>
</div>

<?php
include 'db.php';

// Overall total
$overallRevenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as sum FROM orders WHERE payment_status='paid'"))['sum'] ?? 0;
$overallOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'];
?>

<div class="total-bar">
  <div>
    <div class="lbl">All Time Revenue</div>
    <div class="num">₹<?php echo number_format($overallRevenue); ?></div>
  </div>
  <div>
    <div class="lbl">Total Orders</div>
    <div class="num"><?php echo $overallOrders; ?></div>
  </div>
</div>

<?php
// Get daily summary
$days = mysqli_query($conn, "
  SELECT 
    DATE(created_at) as date,
    COUNT(*) as total_orders,
    SUM(CASE WHEN payment_status='paid' THEN total ELSE 0 END) as revenue,
    SUM(CASE WHEN payment_status='paid' THEN 1 ELSE 0 END) as paid_count,
    SUM(CASE WHEN status='done' THEN 1 ELSE 0 END) as done_count
  FROM orders 
  GROUP BY DATE(created_at) 
  ORDER BY date DESC
");

if (mysqli_num_rows($days) > 0) {
  while($day = mysqli_fetch_assoc($days)) {
    echo "
    <div class='day-card'>
      <div class='day-date'>📅 " . date('d M Y', strtotime($day['date'])) . "</div>
      <div class='day-stats'>
        <div class='day-stat'>
          <div class='num'>₹" . number_format($day['revenue']) . "</div>
          <div class='lbl'>Revenue</div>
        </div>
        <div class='day-stat'>
          <div class='num'>" . $day['total_orders'] . "</div>
          <div class='lbl'>Orders</div>
        </div>
        <div class='day-stat'>
          <div class='num'>" . $day['paid_count'] . "</div>
          <div class='lbl'>Paid</div>
        </div>
        <div class='day-stat'>
          <div class='num'>" . $day['done_count'] . "</div>
          <div class='lbl'>Done</div>
        </div>
      </div>
      <a href='owner.php?date=" . $day['date'] . "' class='view-btn'>View Details →</a>
    </div>";
  }
} else {
  echo "<div class='no-orders'>No order history yet 📋</div>";
}
?>

</body>
</html>