<!DOCTYPE html>
<html>
<head>
  <title>QR Code Generator - Priyanka Hotel</title>
  <style>
    body { background: #111; color: #fff; font-family: Arial; padding: 20px; text-align: center; }
    h1 { color: #c9a84c; margin-bottom: 10px; }
    p { color: #777; margin-bottom: 30px; }
    .qr-grid { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
    .qr-card {
      background: #1a1a1a;
      border: 1px solid #333;
      border-radius: 12px;
      padding: 20px;
      width: 200px;
    }
    .qr-card h3 { color: #c9a84c; margin-bottom: 12px; }
    .qr-card img { width: 160px; height: 160px; }
    .print-btn {
      margin-top: 30px;
      background: #c9a84c;
      color: #111;
      border: none;
      padding: 12px 30px;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <h1>🍽️ QR Code Generator</h1>
  <p>One QR code per table — customers scan and order directly!</p>

  <div class="qr-grid">
    <?php
    $baseUrl = "http://priyankahotel.wuaze.com/?table=";
    $totalTables = 10;

    for ($i = 1; $i <= $totalTables; $i++) {
      $tableUrl = urlencode($baseUrl . $i);
      $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=" . $tableUrl;

      echo "<div class='qr-card'>";
      echo "<h3>Table $i</h3>";
      echo "<img src='$qrUrl' alt='QR Table $i'>";
      echo "</div>";
    }
    ?>
  </div>

  <br>
  <button class="print-btn" onclick="window.print()">🖨️ Print All QR Codes</button>

</body>
</html>