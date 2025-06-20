


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .header {
    display: flex;
    justify-content: space-between; 
    gap: 30px; 
    flex-direction: row;
    flex-wrap: wrap;
    width: 100%;
    align-items: center;
    background-color: rgb(0, 0, 0);
}
.header img{
    width: 70px;
}
.header .nav img{
    width: 30px;
    padding-left: 1rem;
   
}
.nav {
    flex-basis: auto;
    display: flex;
    align-items: center;
    gap: 20px; 
  
}

.nav a {
    flex-grow: 0; 
    font-size: 1.1rem;
    margin: 0 10px; 
    color: aliceblue;
    font-weight: 600;
    text-decoration: none;
    
}
.nav a:hover{
    color: rgb(242, 249, 163);
}
.btn-group {
    display: flex;
    gap: 30px;
    margin: 0rem 3rem; 
}
.btn-group .btn{
    background: #f17b2d;
    color: white;
    border: none;
    padding: 0.8rem 2rem;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-block;
    text-decoration: none;

}
.btn-group .btn:hover{
    background: #ff6600;
    transform: translateY(-3px);
   
}



    </style>
    <title>Mr. Pizza - Fresh & Delicious</title>
</head>
<body>
     <!-- navigation bar -->

    <div class="header">
        <img src="images/logo.png" alt="mr.pizz_logo">
        <div class="nav">
            <a href="home.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="login.php">My Order</a>
            <a href="cart.php">Cart<img src="images/shopping-cart (1).png" alt=""></a>
        </div>
        <div class="btn-group">
             <a href="login.php"><button class="btn">Log in</button></a>
             <a href="signup.php"><button class="btn">Sign up</button></a>
        </div>   
    </div>

</body>
</html>