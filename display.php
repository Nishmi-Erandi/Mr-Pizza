<?php
session_start();
include 'db.php';
include 'sideBar.php';

// Handle status update
if ($_POST && isset($_POST['update_status'])) {
    $customer_id = $_POST['customer_id'];
    $order_date = $_POST['order_date'];
    $new_status = $_POST['new_status'];
    
    $updateQuery = "UPDATE orderss SET order_status = ? WHERE customer_id = ? AND DATE_FORMAT(order_date, '%Y-%m-%d %H:%i') = ?";
    $stmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($stmt, "sis", $new_status, $customer_id, $order_date);
    
    if (mysqli_stmt_execute($stmt)) {
        $success_message = "Order status updated successfully!";
    } else {
        $error_message = "Error updating order status.";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color:rgb(67, 32, 3);
            color: white;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        .header p {
            margin: 0.5rem 0 0 0;
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c2c7;
        }

        .order-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .order-header {
            background:rgb(122, 58, 2);
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .order-info {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .order-body {
            padding: 1.5rem;
        }

        .customer-details {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .customer-details h4 {
            margin: 0 0 0.5rem 0;
            color:rgb(109, 55, 8);
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .items-table th,
        .items-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .items-table th {
            background-color: #f2f2f2;
            font-weight: 600;
        }

        .items-table img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
        }

        .status-badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-preparing {
            background-color: #d4edda;
            color: #155724;
        }

        .status-delivery {
            background-color: #cce5ff;
            color: #004085;
        }

        .status-delivered {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .status-update-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 1rem;
            border-left: 4px solidrgb(114, 59, 11);
        }

        .status-update-section h4 {
            color:rgb(122, 59, 4);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-form {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .status-select {
            padding: 0.6rem 1rem;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            min-width: 200px;
        }

        .status-select:focus {
            outline: none;
            border-color:rgb(115, 59, 9);
        }

        .update-btn {
            padding: 0.6rem 1.5rem;
            background-color:rgb(115, 59, 9);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .update-btn:hover {
            background-color: #d35400;
        }

        .total-section {
            text-align: right;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 2px solid rgb(115, 59, 9);
        }

        .total-amount {
            font-size: 1.2rem;
            font-weight: bold;
            color: #e67e22;
        }

        .no-orders {
            text-align: center;
            padding: 3rem;
            color: #666;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .order-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .order-info {
                flex-direction: column;
                gap: 0.5rem;
            }

            .status-form {
                flex-direction: column;
                align-items: stretch;
            }

            .status-select {
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    

    <div class="container">
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-check-circle"></i> <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-exclamation-circle"></i> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <?php
        // Get all orders grouped by customer and order date
        $ordersQuery = "SELECT * FROM orderss ORDER BY order_date DESC, customer_id";
        $result = mysqli_query($con, $ordersQuery);

        if (mysqli_num_rows($result) > 0) {
            $currentCustomerId = null;
            $currentOrderDate = null;
            $orderItems = [];
            
            while ($row = mysqli_fetch_assoc($result)) {
                // If this is a new customer order, display the previous one
                if ($currentCustomerId != $row['customer_id'] || $currentOrderDate != date('Y-m-d H:i', strtotime($row['order_date']))) {
                    if (!empty($orderItems)) {
                        displayOrderCard($orderItems);
                    }
                    $orderItems = [];
                }
                
                $orderItems[] = $row;
                $currentCustomerId = $row['customer_id'];
                $currentOrderDate = date('Y-m-d H:i', strtotime($row['order_date']));
            }
            
            // Display the last order
            if (!empty($orderItems)) {
                displayOrderCard($orderItems);
            }
        } else {
            echo '<div class="no-orders">';
            echo '<i class="fa-solid fa-cart-shopping" style="font-size: 4rem; color: #ddd; margin-bottom: 1rem;"></i>';
            echo '<h3>No Orders Found</h3>';
            echo '<p>No orders have been placed yet.</p>';
            echo '</div>';
        }

        function displayOrderCard($orderItems) {
            if (empty($orderItems)) return;
            
            $firstItem = $orderItems[0];
            $orderTotal = $firstItem['grand_total'];
            $orderDateFormatted = date('Y-m-d H:i', strtotime($firstItem['order_date']));
            ?>
            <div class="order-card">
                <div class="order-header">
                    <div class="order-info">
                        <div><strong>Order Date:</strong> <?php echo date('M d, Y - H:i', strtotime($firstItem['order_date'])); ?></div>
                        <div><strong>Customer ID:</strong> #<?php echo $firstItem['customer_id']; ?></div>
                        <div><strong>Items:</strong> <?php echo count($orderItems); ?></div>
                    </div>
                    <div class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $firstItem['order_status'])); ?>">
                        <?php echo $firstItem['order_status']; ?>
                    </div>
                </div>
                
                <div class="order-body">
                    <div class="customer-details">
                        <h4>Customer Details</h4>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($firstItem['customer_name']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($firstItem['customer_email']); ?></p>
                        <p><strong>Phone:</strong> <?php echo htmlspecialchars($firstItem['customer_phone']); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($firstItem['customer_address']); ?></p>
                    </div>

                    <h4>Order Items</h4>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $subtotal = 0;
                            foreach ($orderItems as $item): 
                                $subtotal += $item['item_total'];
                            ?>
                                <tr>
                                    <td><img src="uploads/<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_title']); ?>"></td>
                                    <td><?php echo htmlspecialchars($item['product_title']); ?></td>
                                    <td>Rs. <?php echo number_format($item['product_price'], 2); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td>Rs. <?php echo number_format($item['item_total'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="total-section">
                        <p>Subtotal: Rs. <?php echo number_format($subtotal, 2); ?></p>
                        <p>Delivery Fee: Rs. <?php echo number_format($firstItem['delivery_fee'], 2); ?></p>
                        <p class="total-amount">Total: Rs. <?php echo number_format($orderTotal, 2); ?></p>
                    </div>

                    <!-- Status Update Section -->
                    <div class="status-update-section">
                        <h4><i class="fa-solid fa-truck"></i> Update Order Status</h4>
                        <form method="POST" class="status-form">
                            <input type="hidden" name="customer_id" value="<?php echo $firstItem['customer_id']; ?>">
                            <input type="hidden" name="order_date" value="<?php echo $orderDateFormatted; ?>">
                            
                            <select name="new_status" class="status-select" required>
                                <option value="pending" <?php echo ($firstItem['order_status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="preparing" <?php echo ($firstItem['order_status'] == 'preparing') ? 'selected' : ''; ?>>Preparing</option>
                                <option value="out for delivery" <?php echo ($firstItem['order_status'] == 'out for delivery') ? 'selected' : ''; ?>>Out for Delivery</option>
                                <option value="delivered" <?php echo ($firstItem['order_status'] == 'delivered') ? 'selected' : ''; ?>>Delivered</option>
                            </select>
                            
                            <button type="submit" name="update_status" class="update-btn">
                                <i class="fa-solid fa-sync-alt"></i> Update Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</body>
</html>