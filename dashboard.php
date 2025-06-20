<?php
session_start();
include 'db.php';
include 'sideBar.php';

// Total orders
$totalQuery = "SELECT COUNT(*) AS total FROM orderss";
$totalResult = mysqli_query($con, $totalQuery);
$total = mysqli_fetch_assoc($totalResult)['total'];    

// New orders
$newQuery = "SELECT COUNT(*) AS new_count FROM orderss WHERE order_status='pending'";
$newResult = mysqli_query($con, $newQuery);
$new = mysqli_fetch_assoc($newResult)['new_count'];    

// Delivered orders
$deliveredQuery = "SELECT COUNT(*) AS delivered_count FROM orderss WHERE order_status='delivered'";
$deliveredResult = mysqli_query($con, $deliveredQuery);
$delivered = mysqli_fetch_assoc($deliveredResult)['delivered_count'];    

// Last 7 days
$trends = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $query = "SELECT COUNT(*) AS count FROM orderss WHERE DATE(order_date) = '$date'";
    $result = mysqli_query($con, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    $trends[] = ['date' => $date, 'count' => $count];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 2rem;
        }

        .content {
            max-width: 1000px;
            margin: 0 auto;
        }

        .stats {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .card {
            flex: 1;
            min-width: 250px;
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #e67e22;
        }

        .card h3 {
            margin-bottom: 0.5rem;
            color: #723b0b;
            font-size: 1.4rem;
        }

        .card p {
            font-size: 1.6rem;
            font-weight: bold;
            color: #555;
        }

        .trends-table {
            background: #fff;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .trends-table h2 {
            margin-bottom: 1rem;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.75rem;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #723b0b;
        }

        @media (max-width: 768px) {
            .stats {
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .card h3 {
                font-size: 1.2rem;
            }

            .card p {
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>

<div class="content">
    <div class="stats">
        <div class="card">
            <i class="fa-solid fa-cart-plus"></i>
            <h3>New Orders</h3>
            <p><?php echo $new; ?></p>
        </div>
        <div class="card">
            <i class="fa-solid fa-motorcycle"></i>
            <h3>Delivered</h3>
            <p><?php echo $delivered; ?></p>
        </div>
        <div class="card">
            <i class="fa-solid fa-list-ul"></i>
            <h3>Total Orders</h3>
            <p><?php echo $total; ?></p>
        </div>
    </div>

    <div class="trends-table">
        <h2>Last 7 Days Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Orders</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trends as $day) { ?>
                <tr>
                    <td><?php echo date('M d, Y', strtotime($day['date'])); ?></td>
                    <td><?php echo $day['count']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
