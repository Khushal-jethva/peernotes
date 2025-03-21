<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Scholar - Online School HTML5 Template</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-scholar.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
</head>
<body>
  <!-- Preloader -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <?php session_start()?>
  <!-- Header -->
  <header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <a href="index.html" class="logo"><h1>Scholar</h1></a>
                    <div class="search-input">
                      <form id="search" action="#">
                        <input type="text" placeholder="Type Something" id='searchText' name="searchKeyword">
                        <i class="fa fa-search"></i>
                      </form>
                    </div>
                    <ul class="nav">
                      <li class="scroll-to-section"><a href="index.php" class="active">Home</a></li>
                      <li class="scroll-to-section"><a href="#services">Services</a></li>
                      
                      <li class="scroll-to-section"><a href="#courses">Courses</a></li>
                      <li class="scroll-to-section"><a href="#team">Team</a></li>
                      <!-- <li class="scroll-to-section"><a href="#events">Events</a></li> -->
                      <li class="scroll-to-section"><a href="#contact">Register Now!</a></li>
                      <?php if(!isset($_SESSION['user_id'])){?>
                      <li class="scroll-to-section"><a href="login.php">Login</a></li>
                      <li class="scroll-to-section"><a href="register.php">SignUp</a></li>
                      <?php }?>

                      <?php if(isset($_SESSION['user_id'])){?>
                      <li class="scroll-to-section"><a href="logout.php">Logout</a></li>
                      <?php }?>
                  </ul>   
                    <a class='menu-trigger'><span>Menu</span></a>
                </nav>
            </div>
        </div>
    </div>
  </header>