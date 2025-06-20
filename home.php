<?php include 'nav.php';?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <title>Mr. Pizza - Fresh & Delicious</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    
}
body{
    background-color: #FBFBFB;
}

 .hero{
    background-image: url(images/hero.png);
    height: 80vh;
    background-repeat: no-repeat;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    padding: 5rem;
    overflow: hidden;
   
} 

.hero h2{
    color: rgb(255, 255, 247);
    font-size: 3rem;
    font-family: "Roboto", sans-serif;
}
.hero span{
    color: #FFC107;
   
}
.hero p{
    color: azure;
    width: 45%;
    font-size: 1.2rem;
    padding: 2rem 0rem;
    line-height: 2rem;
}
.hero button{
    background-color: #d55d07;
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
.hero button:hover {
    background-color: #c0642b;
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}
.how-it-works .works-content{
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
}
.how-it-works h1, .about-us h1, .popular-item  h1{
    text-align: center;
   padding-top: 2.5rem;
    padding-bottom: 0.5rem;
    color: #3c3939;

}
.works-content .sign-up, .order, .delivery{
    background-color:#FFFFFF;
    margin: 1rem 4rem;
    text-align: center;
    border: 0.5px solid black;
    border-radius: 30px;
    padding: 1.5rem 2.5rem;
    font-size: 1.2rem;
    box-shadow: 2px 2px 8px rgb(0, 0, 0);
}
.works-content .sign-up img, .order img, .delivery img{
    width: 40%;
    height: auto;
    
}
.how-it-works hr, .about-us hr, .popular-item hr{
    width: 80px;
    height: 4px;
    background-color: rgb(255, 115, 0);
    border: none;
    margin: 8px auto 40px;
      
}

.about-us .text {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    margin: 0 2rem;
    max-width: 1200px;
    margin: 0 auto;
}
.about-us .text p {
    width: 50%;
    font-size: 1.2rem;
}
.about-us img {
    width: 45%;
    height: auto;
}

.popular-item {
     background-color: #E6E1E1;;
    padding: 2rem 0;
    margin: 2rem 0rem;
}
.popular-item .foods{
    display: flex;
    justify-content: center;
    flex-direction: row;
    gap: 30px;
}
.foods .pizza img, .burger img, .biriyani img{
    max-width: 200px;
    height: auto;

}
.foods .pizza,
.foods .burger,
.foods .biriyani {
    padding: 1rem 3rem;
    background-color: white;
    font-size: 1.2rem;
    text-align: center;
    border-radius: 20px;
    width: 25%;
    
    transition: all 0.3s;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.foods .pizza:hover,
.foods .burger:hover,
.foods .biriyani:hover{
transform: translateY(-10px);
box-shadow: 2px 2px 8px rgb(0, 0, 0);

}
.popular-item button{
    background-color: #E95D00;
    color: #ffffff;
    margin:  1rem 0rem;
    font-size: 1.2rem;
    padding: 1rem 2rem;
    border-radius: 20px;
    border-style: none;
}
.popular-item button:hover{
    background-color: #fd7628;
    cursor: pointer;
    
    
}
 
/* Desktop - default styles already apply */

/* Tablet (768px and below) */
@media (max-width: 768px) {
    .header, .nav, .btn-group {
      flex-direction: column;
      align-items: center;
      gap: 15px;
    }
  
    .hero {
      height: auto;
      padding: 2rem 1rem;
      text-align: center;
    }
  
    .hero p {
      width: 100%;
    }
  
    .about-us .text {
      flex-direction: column;
      text-align: center;
      padding: 0 1rem;
    }
  
    .about-us .text-content,
    .about-us img {
      width: 100%;
    }
  
    .how-it-works .works-content {
      flex-direction: column;
      align-items: center;
    }
  
    .works-content .sign-up, .order, .delivery {
      margin: 1rem;
      width: 90%;
    }
  
    .popular-item .foods {
      flex-direction: column;
      align-items: center;
    }
  
    .foods .pizza,
    .foods .burger,
    .foods .biriyani {
      width: 80%;
    }
  }
  
  /* Mobile (480px and below) */
  @media (max-width: 480px) {
    .nav a {
      font-size: 1rem;
      margin: 5px 0;
    }
  
    .btn-group .btn {
      font-size: 0.9rem;
      padding: 0.4rem 1.5rem;
    }
  
    .hero h2 {
      font-size: 2rem;
    }
  
    .hero p {
      font-size: 1rem;
    }
  
    .about-us .text p {
      font-size: 1rem;
      line-height: 1.6rem;
    }
  
    .popular-item button {
      width: 80%;
      font-size: 1rem;
    }
  
    .works-content .sign-up,
    .order,
    .delivery {
      font-size: 1rem;
      padding: 1rem;
    }
  }
  
    </style>
</head>
<body>
   
    <!-- hero section -->
     <div class="hero">
        
        
        <h2>Your Favorite Flavors <span>All in One Place</span> </h2>
        <p>At MR. Pizza, we offer more than just great pizza. From freshly baked, cheesy slices to juicy burgers and refreshing beverages — there's something delicious here for everyone.</p>
        <a href="menu.php"><button>View menu</button></a>
     </div>
   
    <!--  how it works -->
     <div class="how-it-works">
        <h1>How It Works</h1>
        <hr>

        <div class="works-content">
            <div class="sign-up">
                <img src="images/signup (1).png" alt="signup-icon">
                <h3>Sign Up</h3>
                <p>Create an account to get started with ordering your favorite foods.</p>
            </div>
           
            <div class="order">
                <img src="images/order-now.png" alt="order-now-icon">
                <h3>Place Your Order</h3>
                <p>Browse our menu and select the items you'd like to enjoy.</p>
                </div>
            
            <div class="delivery">
                <img src="images/delivery-bike.png" alt="delivery-bike-icon">
                <h3>Fast Delivery</h3>
                <p>Sit back and relax as we prepare and deliver your food in hurry</p>
            </div>

        </div>

     </div>
        <!-- abot us -->
       
     <div class="about-us">
        <h1>About us</h1><hr>

        <div class="text">
            <p> At MR. Pizza, we believe great food brings people together. Our journey started with a passion for creating delicious, high-quality meals made from the freshest ingredients. <br><br>
            Whether you’re dining in or ordering for delivery, we promise hot, fresh, and satisfying flavors in every bite. Join us and experience the taste of real, handcrafted goodness!</p>

            
                <img src="images/about-us.jpg" alt="foods-image">
            
        </div>
     </div>

     <div class="popular-item">
        <h1>Popular Food Items</h1><hr>

        <div class="foods">
            <div class="pizza">
                <img src="images/pizza-hero.png" alt="pizza">
                <h2>Pizza</h2>
                <p>Cheesy, crispy, and loaded with flavor</p>
                
            </div>

            <div class="burger">
                <img src="images/burgers.png" alt="burger">
            <h2>Burger</h2>
            <p>Juicy, bold, and built to satisfy.</p>
            
            </div>

            <div class="biriyani">
                <img src="images/biriya.png" alt="biriyani">
                <h2>Biriyani</h2>
                <p>Fragrant rice, tender meat in every bite</p>
                
            </div>
        </div>

     </div>

    
          
</body>
</html>
 <?php include 'footer.php';?>