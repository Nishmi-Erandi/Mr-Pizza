<?php
include("db.php");

if (isset($_GET['ItemID'])) {
    $itemId = intval($_GET['ItemID']);

    $imgQuery = mysqli_query($con, "SELECT image FROM menuitems WHERE itemID = $itemId");
    if ($imgQuery && mysqli_num_rows($imgQuery) > 0) {
        $imgData = mysqli_fetch_assoc($imgQuery);
        $imgPath = "uploads/" . $imgData['image'];
        if (file_exists($imgPath)) {
            unlink($imgPath);
        }
    }

    $del = mysqli_query($con, "DELETE FROM menuitems WHERE itemID = $itemId");
    header("Location: adMenu.php");
    exit();
} else {
    echo "Invalid item ID.";
}
?>
