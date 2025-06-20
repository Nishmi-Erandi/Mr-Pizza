<?php
include("db.php");
include("sideBar.php");

if (isset($_GET['ItemID'])) {
    $id = intval($_GET['ItemID']);
    $res = mysqli_query($con, "SELECT * FROM menuitems WHERE itemID = $id");
    $row = mysqli_fetch_assoc($res);
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "uploads/$image");
        $query = "UPDATE menuitems SET name='$name', description='$desc', price='$price', category='$category', image='$image' WHERE itemID=$id";
    } else {
        $query = "UPDATE menuitems SET name='$name', description='$desc', price='$price', category='$category' WHERE itemID=$id";
    }

    if (mysqli_query($con, $query)) {
        header("Location: adMenu.php");
    } else {
        echo "Failed to update.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title>
     <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        body {
            
            background: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form input[type="text"],
        form input[type="number"],
        form textarea,
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            resize: vertical;
            height: 80px;
        }

        form img {
            margin-bottom: 15px;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Menu Item</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $row['itemID'] ?>">
            <input type="text" name="name" value="<?= $row['name'] ?>" placeholder="Item Name" required>
            <textarea name="desc" placeholder="Description" required><?= $row['description'] ?></textarea>
            <input type="number" step="1" name="price" value="<?= $row['price'] ?>" placeholder="Price" required>
            <input type="text" name="category" value="<?= $row['category'] ?>" placeholder="Category" required>
            <img src="uploads/<?= $row['image'] ?>" width="80">
            <input type="file" name="image">
            <input type="submit" name="update" value="Update">
        </form>
    </div>
</body>
</html>

