<!DOCTYPE html>
<html>
<head>
  <title>Kitchen Display - Priyanka Hotel</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { background: #111; color: #fff; font-family: Arial; padding: 20px; }
    
    h1 { color: #c9a84c; margin-bottom: 5px; font-size: 1.5rem; }
    .subtitle { color: #777; font-size: 0.85rem; margin-bottom: 16px; }

    /* NEW ORDER BANNER */
    .new-order-banner {
      display: none;
      background: #c0392b;
      color: #fff;
      text-align: center;
      padding: 14px;
      font-size: 1.2rem;
      font-weight: bold;
      border-radius: 10px;
      margin-bottom: 16px;
      animation: pulse 0.5s infinite alternate;
    }
    @keyframes pulse {
      from { opacity: 1; }
      to { opacity: 0.5; }
    }

    /* FILTER BARS */
    .filter-bar {
      display: flex; gap: 8px; flex-wrap: wrap;
      margin-bottom: 10px; align-items: center;
    }
    .filter-btn {
      padding: 6px 14px; border-radius: 20px;
      border: 1px solid #444; background: transparent;
      color: #ccc; cursor: pointer; font-size: 0.8rem;
    }
    .filter-btn.active {
      background: #c9a84c; color: #111;
      font-weight: bold; border-color: #c9a84c;
    }

    /* ORDER CARDS */
    .orders-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 16px;
      margin-top: 16px;
    }
    .order-card {
      background: #1a1a1a;
      border: 2px solid #c9a84c;
      border-radius: 12px;
      padding: 16px;
      position: relative;
      transition: all 0.3s;
    }
    .order-card.done {
      border-color: #2d6a4f;
      opacity: 0.5;
    }
    .order-card.new-card {
      border-color: #c0392b;
      animation: newpulse 1s ease-in-out 3;
    }
    @keyframes newpulse {
      0% { box-shadow: 0 0 0 0 rgba(192,57,43,0.7); }
      70% { box-shadow: 0 0 0 10px rgba(192,57,43,0); }
      100% { box-shadow: 0 0 0 0 rgba(192,57,43,0); }
    }

    .table-num {
      color: #c9a84c; font-size: 1.3rem;
      font-weight: bold; margin-bottom: 8px;
    }
    .items {
      color: #eee; font-size: 0.9rem;
      margin-bottom: 8px; line-height: 1.6;
    }
    .total { color: #fff; font-weight: bold; margin-bottom: 4px; }
    .time { color: #777; font-size: 0.75rem; margin-bottom: 10px; }
    .status-pending { color: orange; font-weight: bold; }
    .status-done { color: #2d6a4f; font-weight: bold; }

    .done-btn {
      width: 100%;
      background: #c9a84c; color: #111;
      border: none; padding: 10px;
      border-radius: 8px; font-weight: bold;
      cursor: pointer; font-size: 0.9rem;
      margin-top: 8px;
    }
    .done-btn:hover { opacity: 0.85; }

    /* FULLSCREEN BTN */
    .top-bar {
      display: flex; justify-content: space-between;
      align-items: center; margin-bottom: 16px;
    }
    .fullscreen-btn {
      background: #333; color: #c9a84c;
      border: 1px solid #c9a84c;
      padding: 6px 14px; border-radius: 8px;
      cursor: pointer; font-size: 0.8rem;
    }

    /* STATS */
    .stats {
      display: flex; gap: 16px; margin-bottom: 16px;
    }
    .stat-box {
      background: #1a1a1a; border: 1px solid #333;
      border-radius: 8px; padding: 10px 20px;
      text-align: center;
    }
    .stat-num { font-size: 1.5rem; font-weight: bold; color: #c9a84c; }
    .stat-label { font-size: 0.75rem; color: #777; }

    .no-orders { color: #777; text-align: center; padding: 40px; }
  </style>
</head>
<body>

<div class="top-bar">
  <div>
    <h1>🍽️ Kitchen Display — Priyanka Hotel</h1>
    <div class="subtitle" id="lastUpdated">Checking for orders...</div>
  </div>
  <button class="fullscreen-btn" onclick="toggleFullscreen()">⛶ Fullscreen</button>
</div>

<!-- NEW ORDER BANNER -->
<div id="startOverlay" style="
  position:fixed; inset:0; background:rgba(0,0,0,0.9);
  display:flex; align-items:center; justify-content:center;
  z-index:999; flex-direction:column; gap:16px;">
  <div style="font-size:3rem;">🍽️</div>
  <div style="color:#c9a84c; font-size:1.5rem; font-weight:bold;">Priyanka Hotel Kitchen</div>
  <div style="color:#777; font-size:0.9rem;">Tap to start kitchen display with sound alerts</div>
  <button onclick="startKitchen()" style="
    background:#c9a84c; color:#111; border:none;
    padding:14px 40px; border-radius:10px;
    font-size:1.1rem; font-weight:bold; cursor:pointer;">
    🔔 Start Kitchen Display
  </button>
</div>

<!-- STATS -->
<div class="stats">
  <div class="stat-box">
    <div class="stat-num" id="pendingCount">0</div>
    <div class="stat-label">⏳ Pending</div>
  </div>
  <div class="stat-box">
    <div class="stat-num" id="doneCount">0</div>
    <div class="stat-label">✅ Done</div>
  </div>
  <div class="stat-box">
    <div class="stat-num" id="totalCount">0</div>
    <div class="stat-label">📋 Total</div>
  </div>
</div>

<!-- STATUS FILTER -->
<div class="filter-bar">
  <strong style="color:#c9a84c; margin-right:4px;">Status:</strong>
  <button class="filter-btn active" onclick="filterOrders('all', this)">All</button>
  <button class="filter-btn" onclick="filterOrders('pending', this)">⏳ Pending</button>
  <button class="filter-btn" onclick="filterOrders('done', this)">✅ Done</button>
</div>

<!-- TABLE FILTER -->
<div class="filter-bar" id="tableFilter">
  <strong style="color:#c9a84c; margin-right:4px;">Table:</strong>
  <button class="filter-btn active" onclick="filterTable('all', this)">All Tables</button>
</div>

<!-- ORDERS -->
<div class="orders-grid" id="ordersGrid"></div>

<!-- AUDIO ALERT -->
<audio id="alertSound"></audio>

<script>
let currentStatus = 'all';
let currentTable = 'all';
let knownOrderIds = new Set();
let isFirstLoad = true;

function fetchOrders() {
  fetch('get_orders.php')
    .then(res => res.json())
    .then(orders => {
      updateStats(orders);
      updateTableFilter(orders);
      renderOrders(orders);
      checkNewOrders(orders);
      document.getElementById('lastUpdated').textContent =
        'Last updated: ' + new Date().toLocaleTimeString();
    });
}

function checkNewOrders(orders) {
  if (isFirstLoad) {
    orders.forEach(o => knownOrderIds.add(o.id));
    isFirstLoad = false;
    return;
  }
  let hasNew = false;
  orders.forEach(o => {
    if (!knownOrderIds.has(o.id)) {
      knownOrderIds.add(o.id);
      hasNew = true;
    }
  });
  if (hasNew) {
    playAlert();
    showBanner();
  }
}

function playAlert() {
  const ctx = new (window.AudioContext || window.webkitAudioContext)();
  
  // First beep
  const o1 = ctx.createOscillator();
  const g1 = ctx.createGain();
  o1.connect(g1);
  g1.connect(ctx.destination);
  o1.frequency.value = 880;
  g1.gain.setValueAtTime(1, ctx.currentTime);
  g1.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.3);
  o1.start(ctx.currentTime);
  o1.stop(ctx.currentTime + 0.3);

  // Second beep
  const o2 = ctx.createOscillator();
  const g2 = ctx.createGain();
  o2.connect(g2);
  g2.connect(ctx.destination);
  o2.frequency.value = 1100;
  g2.gain.setValueAtTime(1, ctx.currentTime + 0.4);
  g2.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.7);
  o2.start(ctx.currentTime + 0.4);
  o2.stop(ctx.currentTime + 0.7);
}

function showBanner() {
  const banner = document.getElementById('newOrderBanner');
  banner.style.display = 'block';
  setTimeout(() => { banner.style.display = 'none'; }, 5000);
}

function updateStats(orders) {
  const pending = orders.filter(o => o.status === 'pending').length;
  const done = orders.filter(o => o.status === 'done').length;
  document.getElementById('pendingCount').textContent = pending;
  document.getElementById('doneCount').textContent = done;
  document.getElementById('totalCount').textContent = orders.length;
}

function updateTableFilter(orders) {
  const tables = [...new Set(orders.map(o => o.table_number))];
  const bar = document.getElementById('tableFilter');
  const existing = bar.querySelectorAll('.filter-btn:not(:first-of-type)');
  existing.forEach(b => b.remove());
  tables.forEach(t => {
    const btn = document.createElement('button');
    btn.className = 'filter-btn';
    btn.textContent = t;
    btn.onclick = () => filterTable(t, btn);
    bar.appendChild(btn);
  });
}

function renderOrders(orders) {
  const grid = document.getElementById('ordersGrid');
  if (orders.length === 0) {
    grid.innerHTML = "<div class='no-orders'>No orders yet... waiting 🍽️</div>";
    return;
  }
  grid.innerHTML = '';
  orders.forEach(order => {
    const isDone = order.status === 'done';
    const isNew = !knownOrderIds.has(order.id) || false;
    const card = document.createElement('div');
    card.className = 'order-card' + (isDone ? ' done' : '') + (isNew ? ' new-card' : '');
    card.dataset.status = order.status;
    card.dataset.table = order.table_number;
    let courseHtml = '';
    if (order.course && typeof order.course === 'object') {
      courseHtml = '<div style="margin:8px 0;border-top:1px solid #333;padding-top:8px;">';
      for (const [course, items] of Object.entries(order.course)) {
        courseHtml += `
          <div style="margin-bottom:8px;">
            <div style="color:#c9a84c;font-weight:bold;font-size:0.85rem;">${course}</div>
            <div style="color:#eee;font-size:0.82rem;">${items.join(', ')}</div>
          </div>`;
      }
      courseHtml += '</div>';
    }

    card.innerHTML = `
      <div class="table-num">📍 ${order.table_number} ${order.payment_status === 'paid' ? '<span style="background:#2d6a4f;color:#fff;font-size:0.65rem;padding:2px 8px;border-radius:10px;margin-left:8px;">💳 PAID</span>' : '<span style="background:#c0392b;color:#fff;font-size:0.65rem;padding:2px 8px;border-radius:10px;margin-left:8px;">⚠️ UNPAID</span>'}</div>
      <div class="items">🛒 ${order.items}</div>
      ${courseHtml}
      <div class="total">💰 Total: ₹${order.total}</div>
      <div class="time">🕐 ${order.created_at}</div>
      <div class="${isDone ? 'status-done' : 'status-pending'}">${isDone ? '✅ Done' : '⏳ Pending'}</div>
      ${!isDone ? `
  <button class="done-btn" style="background:#c9a84c;margin-bottom:6px;" onclick="markStarterDone(${order.id}, this)">🥗 Starters Ready</button>
  <button class="done-btn" onclick="markDone(${order.id}, this)">✅ Mark All Done</button>
` : ''}
    `;
    grid.appendChild(card);
  });
  applyFilters();
}
function markStarterDone(id, btn) {
  const formData = new FormData();
  formData.append('id', id);
  formData.append('status', 'starter_done');

  fetch('update_order.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(response => {
    if (response.includes('success')) {
      btn.textContent = '✅ Starters Notified!';
      btn.style.background = '#2d6a4f';
      btn.style.color = '#fff';
      btn.disabled = true;
    }
  });
}
function markDone(id, btn) {
  const formData = new FormData();
  formData.append('id', id);
  fetch('update_order.php', { method: 'POST', body: formData })
    .then(res => res.text())
    .then(response => {
      if (response.includes('success')) {
        const card = btn.closest('.order-card');
        card.classList.add('done');
        card.dataset.status = 'done';
        card.querySelector('[class^="status"]').textContent = '✅ Done';
        card.querySelector('[class^="status"]').className = 'status-done';
        btn.remove();
        updateStats([...document.querySelectorAll('.order-card')].map(c => ({ status: c.dataset.status })));
      }
    });
}

function filterOrders(status, btn) {
  document.querySelectorAll('.filter-bar:first-of-type .filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  currentStatus = status;
  applyFilters();
}

function filterTable(table, btn) {
  document.querySelectorAll('#tableFilter .filter-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  currentTable = table;
  applyFilters();
}

function applyFilters() {
  document.querySelectorAll('.order-card').forEach(card => {
    const statusMatch = currentStatus === 'all' || card.dataset.status === currentStatus;
    const tableMatch = currentTable === 'all' || card.dataset.table === currentTable;
    card.style.display = (statusMatch && tableMatch) ? 'block' : 'none';
  });
}

function toggleFullscreen() {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen();
  } else {
    document.exitFullscreen();
  }
}

function startKitchen() {
  // Unlock audio by playing silence
  const ctx = new (window.AudioContext || window.webkitAudioContext)();
  const o = ctx.createOscillator();
  o.connect(ctx.destination);
  o.start();
  o.stop(ctx.currentTime + 0.001);

  document.getElementById('startOverlay').style.display = 'none';
  fetchOrders();
  setInterval(fetchOrders, 5000);
}
</script>
</body>
</html>