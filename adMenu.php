<?php
include("db.php");
include("sideBar.php");

// Insert new item
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $folder = "uploads/" . $image;

    if (move_uploaded_file($tmp_name, $folder)) {
        mysqli_query($con, "INSERT INTO menuitems (name, description, price, category, image) VALUES ('$name', '$desc', '$price', '$category', '$image')");
    }
}

// Fetch items
$items = mysqli_query($con, "SELECT * FROM menuitems");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Menu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f6f6f6;
            display: flex;
            flex-direction: row;
        }

        /* Assume sideBar.php outputs .sidebar */
        .main-content {
            padding: 30px;
            flex-grow: 1;
            width: 100%;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin: auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form input[type="text"],
        form input[type="number"],
        form textarea,
        form select {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
            width: 100%;
        }

        form textarea {
            resize: vertical;
            height: 100px;
        }

        form input[type="file"] {
            margin-bottom: 15px;
        }

        form input[type="submit"] {
            background-color: #00c000;
            color: white;
            padding: 10px;
            border: none;
            font-weight: bold;
            border-radius: 20px;
            cursor: pointer;
            width: 120px;
            transition: 0.3s;
        }

        form input[type="submit"]:hover {
            background-color: #009900;
        }

        .table-container {
            overflow-x: auto;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
            background-color: #fff;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            font-size: 14px;
        }

        table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        img.menu-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }

            .container {
                padding: 15px;
            }

            form input[type="submit"] {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            body {
                flex-direction: column;
            }

            .main-content {
                width: 100%;
            }

            table th, table td {
                font-size: 12px;
                padding: 8px;
            }

            img.menu-image {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar loaded from sideBar.php -->

    <div class="main-content">
        <div class="container">
            <h2>Manage Menu</h2>

            <!-- Add Item Form -->
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Name" required>
                <textarea name="desc" placeholder="Description" required></textarea>
                <input type="number" step="0.01" name="price" placeholder="Price" required>
                <input type="text" name="category" placeholder="Category" required>
                <input type="file" name="image" required>
                <input type="submit" name="submit" value="Add Item">
            </form>

            <!-- Items Table -->
            <div class="table-container">
                <table>
                    <tr>
                        <th>Name</th><th>Description</th><th>Price</th><th>Category</th><th>Image</th><th>Action</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($items)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td>Rs.<?= number_format($row['price'], 2) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><img src="uploads/<?= htmlspecialchars($row['image']) ?>" class="menu-image"></td>
                        <td>
                            <a href="edit.php?ItemID=<?= $row['itemID'] ?>">Edit</a> |
                            <a href="delete.php?ItemID=<?= $row['itemID'] ?>" onclick="return confirm('Delete this item?')">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
