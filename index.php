<?php
session_start();

// if(isset($_SESSION['email'])){

//     $_SESSION['msg'] = "You must login first to view this page.";
//     header('location: login.php');

// }

// if(isset($_GET(['logout']))){

//     session_destroy();
//     unset($_SESSION['email']);
//     header('location login.php');
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Old+Standard+TT:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    <header >
        <div class="container" id="title-div">
            <h2 class="display-3">Agenda</h2>
            <!-- <button class="btn btn-primary">Log In</button> -->
            <nav class="navbar justify-content-center navbar-expand-lg" style="margin-top: 10px;">
                <!-- <button class="" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                </button> -->
                <i class="fa fa-lg fa-arrow-circle-down navbar-toggler" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"></i>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="tt.php">Time Table</a>
                        </li>
                        <?php if( isset($_SESSION['email'])): ?>
                            <!-- show HTML logout button -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                                Hi, <?php echo($_SESSION['firstName']); ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="nav-link" href="editProfile.php" style="color: black">Profile</a>
                                    <a class="nav-link" href="logout.php" style="color: black">Log Out</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Log In</a>
                            </li>
                        <?php endif; ?>
                        
                      </ul>
                </div> 
            </nav>
        </div>
    </header>
    <div class="container" id="imgContainer" style="margin-top: 30px;">
        <div class="row">
            <div class="col-sm" style="margin-bottom: 15px; padding-bottom: 15px; background-color: rgb(0,0,0,0.9); text-align: center ">
                <h3 class="display-4">Welcome To Agenda</h3> 
                <h6 style="padding-top: 20px; font-size: 20px">A secret of getting ahead is just getting started!</h6>
                <?php if( isset($_SESSION['email'])): ?>
                    <button class="btn"><a class="light" href="tt.php">Schedule Now</a></button>
                <?php else: ?>
                    <button onClick="location.href='login.php';" class="btn">Get Started</button>
                <?php endif; ?>
                
            </div>
            <div class="col-sm" id="img1">
                <img  src="images/tt1.jpg" alt="" height="95.5%" width="100%" style="display: inline;">
            </div>
        </div>      
    </div>

    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <div class="col-sm pull-right" id="img2">
                <img src="images/tt2.jpg" alt="" height="95.5%" width="100%" style="display: inline;">
            </div>
            <div class="col-sm" style="margin-bottom: 15px; padding-bottom: 15px; background-color: rgb(0,0,0,0.9); text-align: center">
                <h3 class="display-4">More About Agenda</h3> 
                <h6 style="padding-top: 20px; font-size: 20px">Agenda is created with this new age of digital learning in mind! we are here to help you keep all
                 of your tasks and activities in one organized space.</h6>
                <button id="knowmore" class="btn">Know More</button>
            </div>
        </div>      
    </div>

    <div class="container" id="about" style="text-align: center; margin-top: 80px; margin-bottom: 80px">
        <h3 class="display-4">About Us</h3> 
        <h6 style="padding-top: 20px; font-size: 20px">Our mission is to empower our fellow peers and students to achieve their daily goals ranging from classes,
         seminars, exercise and personal hobbies. Through Agenda you can organize your daily activities in your own personal space and be alerted beforehand so that
          you are well prepared. In this growing world of online education and work, be productive with Agenda.</h6>
        <h4 style="padding-top: 20px"> Try us out today!</h4>
    </div>

    <hr style="height:2px; width:75%;color:white;background-color:white">

    
    <footer style="background-color: rgb(0,0,0, .08); padding-bottom: 30px;">
        <div class="container" style="text-align: center; padding-top: 20px;">
            <h5>Made By</h5>
        </div>
        <div class="container" style="margin-top: 30px;">
            <div class="row">
                <div class="col-sm" style="text-align: end; padding-right: 50px">
                    <i><a href="#" ">Niraj Nair</a></i>
                </div>
                <div class="col-sm" style="text-align: start">
                    <i><a href="#">Shourya Shrivastava</a></i>
                </div>
            </div>      
        </div>
    </footer>




















    <script type="text/javascript">
        $("#knowmore").on('click', function() {
            $('html,body').animate({
                scrollTop: $("#about").offset().top},
                'slow');
        });
    </script>

    <script src="https://use.fontawesome.com/07d234760a.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
     integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>