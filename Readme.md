\# 🍽️ Hotel Priyanka – QR Code Ordering System



A full-stack web-based restaurant ordering system built with PHP, MySQL, and JavaScript. Customers scan a QR code at their table, browse the menu, and place orders directly from their phone. The kitchen receives live notifications and manages orders in real time.



\-----



\## 🌐 Live Demo



👉 <http://priyankahotel.wuaze.com>



\-----



\## 📸 Screenshots



> Menu Page · Kitchen Display · Owner Dashboard · QR Code Generator



\-----



\## ✨ Features



\### 👨‍💼 Customer Side



\- 📱 Mobile-friendly menu page

\- 🍽️ Full restaurant menu with Veg/Non-Veg indicators

\- 🛒 Cart system with add/remove items

\- 💳 Online payment via Razorpay (UPI, Card, Net Banking)

\- 🔔 Real-time notification when food is ready

\- 🥗 Course-wise order tracking (Starters → Main Course)



\### 👨‍🍳 Kitchen Side



\- 🖥️ Live Kitchen Display System (KDS)

\- 🔔 Sound alert when new order arrives

\- 📢 “NEW ORDER RECEIVED!” banner

\- ✅ Mark Starters Ready → customer notified instantly

\- ✅ Mark All Done → customer notified

\- 🔍 Filter orders by Status \& Table number

\- ⛶ Fullscreen mode for kitchen screen

\- 📊 Live stats (Pending/Done/Total)

\- 💳 PAID/UNPAID badge on each order



\### 👨‍💼 Owner Side



\- 📊 Daily Revenue Dashboard

\- 💰 Today’s total revenue \& order count

\- 📅 Day-by-day order history

\- 💳 Paid vs Unpaid order tracking

\- 🔍 Filter orders by date



\### 🔧 System



\- 📱 QR Code Generator (one per table)

\- 🗄️ MySQL database for order management

\- ⚡ Auto-refresh every 5 seconds

\- 🌐 Hosted live on the internet



\-----



\## 🛠️ Tech Stack



|Technology         |Usage               |

|-------------------|--------------------|

|HTML/CSS/JavaScript|Frontend menu \& cart|

|PHP                |Backend server      |

|MySQL              |Database            |

|XAMPP              |Local development   |

|Razorpay           |Payment gateway     |

|InfinityFree       |Web hosting         |



\-----



\## 📁 File Structure



```

priyanka-hotel/

├── index.html          # Customer menu page

├── db.php              # Database connection

├── order.php           # Save orders to DB

├── kitchen.php         # Kitchen display system

├── update\_order.php    # Mark orders as done

├── get\_orders.php      # Fetch today's orders (JSON)

├── check\_status.php    # Customer notification check

├── payment.php         # Razorpay payment verification

├── qr.php              # QR code generator

├── owner.php           # Owner daily dashboard

├── history.php         # Order history by date

└── assets/

&#x20;   └── logo.png        # Restaurant logo

```



\-----



\## 🚀 Getting Started (Local Setup)



\### Prerequisites



\- XAMPP (Apache + MySQL)

\- Web browser



\### Steps



1\. \*\*Clone the repository\*\*



```bash

git clone https://github.com/vedant01-code/priyanka-hotel.git



1\. \*\*Move to XAMPP folder\*\*



```

Copy the folder to: C:\\xampp\\htdocs\\priyanka-hotel\\

```



1\. \*\*Start XAMPP\*\*



\- Start Apache

\- Start MySQL



1\. \*\*Create Database\*\*



\- Open `http://localhost/phpmyadmin`

\- Create database: `priyanka\_hotel`

\- Run this SQL:



```sql

CREATE TABLE orders (

&#x20; id INT AUTO\_INCREMENT PRIMARY KEY,

&#x20; table\_number VARCHAR(20),

&#x20; items TEXT,

&#x20; total INT,

&#x20; course TEXT,

&#x20; status VARCHAR(20) DEFAULT 'pending',

&#x20; payment\_status VARCHAR(20) DEFAULT 'unpaid',

&#x20; payment\_id VARCHAR(100) DEFAULT '',

&#x20; created\_at TIMESTAMP DEFAULT CURRENT\_TIMESTAMP

);

```



1\. \*\*Update db.php\*\*



```php

$host = "localhost";

$user = "root";

$password = "";

$database = "priyanka\_hotel";

```



1\. \*\*Open in browser\*\*



```

http://localhost/priyanka-hotel/

```



\-----



\## 💳 Payment Setup (Razorpay)



1\. Create account at \[razorpay.com](https://razorpay.com)

1\. Get Test API Keys from Dashboard → Settings → API Keys

1\. Add your Key ID in `index.html`:



```javascript

key: 'YOUR\_RAZORPAY\_KEY\_ID'

```



1\. Add your Key Secret in `payment.php`



\-----



\## 📱 QR Code Setup



1\. Go to `http://localhost/priyanka-hotel/qr.php`

1\. Print QR codes for each table

1\. Customers scan → menu opens directly!



\-----



\## 🔗 Important URLs



|Page           |URL           |

|---------------|--------------|

|Menu           |`/index.html` |

|Kitchen        |`/kitchen.php`|

|Owner Dashboard|`/owner.php`  |

|Order History  |`/history.php`|

|QR Codes       |`/qr.php`     |



\-----



\## 👨‍💻 Developer



\*\*Vedant\*\* — Built from scratch as a real-world project



\-----



\## 🏨 About Hotel Priyanka



\*\*Hotel Priyanka \& Family Restaurant\*\*

Mahad-Bhor, Pune Highway, Mu. Pimpaldari, Post Bhave



Owners:



\- Ravindra (John) Mhaske — 9209693603

\- Mahesh Mhaske — 9822808883



\-----



\## 📄 License



This project is built for Hotel Priyanka. Feel free to use it as a reference for learning!
