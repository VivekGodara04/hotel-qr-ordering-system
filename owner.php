<!DOCTYPE html>
<html>
<head>
  <title>Owner Dashboard - Hotel Priyanka</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;600&display=swap" rel="stylesheet"/>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #111; color: #fff; font-family: 'Poppins', sans-serif; padding: 20px; }
    h1 { font-family: 'Playfair Display', serif; color: #c9a84c; margin-bottom: 4px; }
    .subtitle { color: #777; font-size: 0.85rem; margin-bottom: 24px; }

    /* STATS */
    .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 14px; margin-bottom: 24px; }
    .stat-card { background: #1a1a1a; border: 1px solid #2a2a2a; border-radius: 12px; padding: 16px; text-align: center; }
    .stat-card.gold { border-color: #c9a84c; }
    .stat-num { font-size: 1.8rem; font-weight: 700; color: #c9a84c; }
    .stat-label { font-size: 0.75rem; color: #777; margin-top: 4px; }

    /* DATE FILTER */
    .date-bar { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
    .date-bar label { font-size: 0.85rem; color: #aaa; }
    .date-bar input { padding: 8px 12px; background: #1a1a1a; border: 1px solid #444; border-radius: 8px; color: #eee; font-family: 'Poppins', sans-serif; font-size: 0.85rem; }
    .date-btn { padding: 8px 16px; background: #c9a84c; color: #111; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 0.85rem; }

    /* ORDERS TABLE */
    .orders-wrap { background: #1a1a1a; border-radius: 12px; overflow: hidden; border: 1px solid #2a2a2a; }
    .orders-wrap h2 { font-family: 'Playfair Display', serif; color: #c9a84c; padding: 16px; border-bottom: 1px solid #2a2a2a; font-size: 1rem; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #222; color: #c9a84c; font-size: 0.75rem; padding: 10px 14px; text-align: left; letter-spacing: 1px; }
    td { padding: 10px 14px; font-size: 0.82rem; border-bottom: 1px solid #222; color: #ddd; }
    tr:last-child td { border-bottom: none; }
    .badge { font-size: 0.65rem; font-weight: 700; padding: 2px 8px; border-radius: 10px; }
    .badge.paid { background: #2d6a4f; color: #fff; }
    .badge.unpaid { background: #c0392b; color: #fff; }
    .badge.done { background: #2d6a4f; color: #fff; }
    .badge.pending { background: #e67e22; color: #fff; }

    /* NAV */
    .nav { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; }
    .nav a { padding: 8px 16px; background: #1a1a1a; border: 1px solid #444; border-radius: 8px; color: #ccc; text-decoration: none; font-size: 0.82rem; }
    .nav a.active { background: #c9a84c; color: #111; font-weight: 600; border-color: #c9a84c; }

    .no-orders { text-align: center; padding: 40px; color: #555; }
  </style>
</head>
<body>

<h1>📊 Owner Dashboard</h1>
<div class="subtitle">Hotel Priyanka — Daily Revenue & Orders</div>

<div class="nav">
  <a href="owner.php" class="active">📊 Today</a>
  <a href="history.php">📅 History</a>
  <a href="kitchen.php">👨‍🍳 Kitchen</a>
  <a href="index.html">🍽️ Menu</a>
</div>

<?php
include 'db.php';

// Get selected date
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Stats for selected date
$totalOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = '$date'"))['count'];
$totalRevenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as sum FROM orders WHERE DATE(created_at) = '$date' AND payment_status='paid'"))['sum'] ?? 0;
$paidOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = '$date' AND payment_status='paid'"))['count'];
$unpaidOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = '$date' AND payment_status='unpaid'"))['count'];
$doneOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = '$date' AND status='done'"))['count'];
$pendingOrders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = '$date' AND status='pending'"))['count'];
?>

<!-- DATE FILTER -->
<div class="date-bar">
  <label>Select Date:</label>
  <form method="GET" style="display:flex;gap:10px;">
    <input type="date" name="date" value="<?php echo $date; ?>">
    <button type="submit" class="date-btn">View</button>
  </form>
</div>

<!-- STATS -->
<div class="stats-grid">
  <div class="stat-card gold">
    <div class="stat-num">₹<?php echo number_format($totalRevenue); ?></div>
    <div class="stat-label">💰 Today's Revenue</div>
  </div>
  <div class="stat-card">
    <div class="stat-num"><?php echo $totalOrders; ?></div>
    <div class="stat-label">📋 Total Orders</div>
  </div>
  <div class="stat-card">
    <div class="stat-num"><?php echo $paidOrders; ?></div>
    <div class="stat-label">💳 Paid Orders</div>
  </div>
  <div class="stat-card">
    <div class="stat-num"><?php echo $unpaidOrders; ?></div>
    <div class="stat-label">⚠️ Unpaid Orders</div>
  </div>
  <div class="stat-card">
    <div class="stat-num"><?php echo $doneOrders; ?></div>
    <div class="stat-label">✅ Completed</div>
  </div>
  <div class="stat-card">
    <div class="stat-num"><?php echo $pendingOrders; ?></div>
    <div class="stat-label">⏳ Pending</div>
  </div>
</div>

<!-- ORDERS TABLE -->
<div class="orders-wrap">
  <h2>Orders for <?php echo date('d M Y', strtotime($date)); ?></h2>
  <?php
  $orders = mysqli_query($conn, "SELECT * FROM orders WHERE DATE(created_at) = '$date' ORDER BY created_at DESC");
  if (mysqli_num_rows($orders) > 0) {
  ?>
  <table>
    <tr>
      <th>#</th>
      <th>TABLE</th>
      <th>ITEMS</th>
      <th>TOTAL</th>
      <th>PAYMENT</th>
      <th>STATUS</th>
      <th>TIME</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($orders)) { ?>
    <tr>
      <td><?php echo $row['id']; ?></td>
      <td><?php echo $row['table_number']; ?></td>
      <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo $row['items']; ?></td>
      <td>₹<?php echo $row['total']; ?></td>
      <td><span class="badge <?php echo $row['payment_status']; ?>"><?php echo strtoupper($row['payment_status']); ?></span></td>
      <td><span class="badge <?php echo $row['status']; ?>"><?php echo strtoupper($row['status']); ?></span></td>
      <td><?php echo date('h:i A', strtotime($row['created_at'])); ?></td>
    </tr>
    <?php } ?>
  </table>
  <?php } else { ?>
  <div class="no-orders">No orders for this date 📋</div>
  <?php } ?>
</div>

</body>
</html>