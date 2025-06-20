<?php
session_start();
include 'nav.php';
include 'db.php';

$orders = [];
$customerInfo = null;
$searchPerformed = false;
$phoneNumber = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phoneNumber = trim($_POST['phone_number']);
    $searchPerformed = true;

    if (empty($phoneNumber)) {
        $error = "Please enter your phone number.";
    } else {
        $stmt = mysqli_prepare($con, "SELECT * FROM orderss WHERE customer_phone = ? ORDER BY order_date DESC");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $phoneNumber);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $orders[] = $row;
                }
                $customerInfo = $orders[0];
            } else {
                $error = "No orders found for this phone number.";
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Database query failed.";
        }
    }
}

function getStatusColor($status) {
    return match (strtolower($status)) {
        'pending' => '#ffc107',
        'confirmed' => '#17a2b8',
        'processing' => '#6f42c1',
        'shipped' => '#fd7e14',
        'delivered' => '#28a745',
        'cancelled' => '#dc3545',
        default => '#6c757d',
    };
}

function getStatusIcon($status) {
    return match (strtolower($status)) {
        'pending' => '⏳',
        'confirmed' => '✅',
        'processing' => '⚙️',
        'shipped' => '🚚',
        'delivered' => '📦',
        'cancelled' => '❌',
        default => '📋',
    };
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track My Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }
        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            font-weight: 500;
            margin-right: 10px;
        }
        input[type="tel"] {
            padding: 12px 14px;
            width: 240px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: 0.3s;
        }
        input[type="tel"]:focus {
            border-color: #007bff;
            outline: none;
        }
        button {
            padding: 12px 20px;
            background-color:rgb(255, 166, 2);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-left: 10px;
        }
        button:hover {
            background-color:rgb(179, 84, 0);
        }
        .success, .error {
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
            font-size: 16px;
            line-height: 1.5;
        }
        .success {
            background-color: #e6ffed;
            color: #256029;
            border: 1px solid #a5d6a7;
        }
        .error {
            background-color: #ffe6e6;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .order {
            border: 1px solid #e0e0e0;
            background-color: #fafafa;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }
        .order h3 {
            margin-bottom: 10px;
            color: #222;
        }
        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 30px;
            color: white;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 12px;
        }
        .summary {
            margin-top: 20px;
            font-weight: 500;
            color: #444;
        }
        .product {
            display: flex;
            gap: 20px;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .product:last-child {
            border-bottom: none;
        }
        .product .emoji {
            font-size: 48px;
            width: 80px;
            text-align: center;
        }
        .product p {
            margin: 4px 0;
            font-size: 15px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📦 Track Your Orders</h2>
    <form method="POST">
        <label>Phone Number:</label>
        <input type="tel" name="phone_number" value="<?= htmlspecialchars($phoneNumber) ?>" required>
        <button type="submit">Search</button>
    </form>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($customerInfo): ?>
        <div class="success">
            <p><strong>Name:</strong> <?= htmlspecialchars($customerInfo['customer_name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($customerInfo['customer_email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($customerInfo['customer_phone']) ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($customerInfo['customer_address']) ?></p>
        </div>
    <?php endif; ?>

    <?php
    if ($searchPerformed && $orders):
        $groupedOrders = [];
        foreach ($orders as $o) {
            $key = $o['customer_id'] . '_' . date('Y-m-d H:i:s', strtotime($o['order_date']));
            $groupedOrders[$key][] = $o;
        }

        foreach ($groupedOrders as $key => $group):
            $first = $group[0];
            $subtotal = 0;
            ?>
            <div class="order">
                <h3>Order #<?= $first['customer_id'] ?> — <?= date('F j, Y H:i A', strtotime($first['order_date'])) ?></h3>
                <div class="badge" style="background: <?= getStatusColor($first['order_status']) ?>">
                    <?= getStatusIcon($first['order_status']) ?> <?= ucfirst($first['order_status']) ?>
                </div>
                <div>
                    <?php foreach ($group as $item): 
                        $subtotal += $item['item_total'];
                    ?>
                        <div class="product">
                            <div class="emoji">📦</div>
                            <div>
                                <p><strong><?= htmlspecialchars($item['product_title']) ?></strong></p>
                                <p>Price: Rs. <?= number_format($item['product_price'], 2) ?> | Qty: <?= $item['quantity'] ?></p>
                                <p>Total: Rs. <?= number_format($item['item_total'], 2) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="summary">
                    Subtotal: Rs. <?= number_format($subtotal, 2) ?><br>
                    Delivery Fee: Rs. <?= number_format($first['delivery_fee'], 2) ?><br>
                    <strong>Grand Total: Rs. <?= number_format($subtotal + $first['delivery_fee'], 2) ?></strong>
                </div>
            </div>
        <?php endforeach;
    endif;
    ?>
</div>
</body>
</html>
