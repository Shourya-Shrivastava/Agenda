<?php 
session_start();

$password = "";
$modalshow= "";
$errors1 = "";
$errors3="";
$db = mysqli_connect('localhost', 'root', '', 'agenda')  or die("Could not connect to the database");

if (isset($_POST['signup'])){
    $modalshow = "<script type='text/javascript'>
                $(document).ready(function(){
                    $(window).on('load',function(){
                        $('#ModalCenter').modal('show');
                    });
                });
            </script>"; 
            
    $firstName = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastName = mysqli_real_escape_string($db, $_POST['lastname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['pass1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['pass2']);


    if(empty($email)){ $errors1 .="<div class='alert alert-danger'>Enter email</div>";}
    if(empty($firstName)){ $errors1 .="<div class='alert alert-danger'>Enter first name.</div>";}
    if(empty($lastName)){ $errors1 .="<div class='alert alert-danger'>Enter last name.</div>";}
    if(empty($password_1)){ $errors1 .="<div class='alert alert-danger'>Enter password.</div>";}
    if(empty($password_2)){ $errors1 .="<div class='alert alert-danger'>Enter password twice.</div>";}
    if($password_1 != $password_2){ $errors1 .="<div class='alert alert-danger'>Entered passwords doesn't match each other.</div>";} 
    
    $user_check_query = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
    
    $results = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($results);
    
    if($user){
        if($user['email'] === $email) { 
            $errors1 .="<div class='alert alert-danger'>User Exists</div>"; 
        }
        
    }
    
    if($errors1 == ""){
        $password = md5($password_1);
        $table_name = $firstName.'_'.$lastName;
        $query = "INSERT INTO user (firstName, lastName, email, passwd, table_name)
                VALUES ('$firstName', '$lastName', '$email', '$password', '$table_name')";
        mysqli_query($db, $query);

          
        // $insert_table_name = "INSERT INTO user () VALUES '$table_name')";
        // mysqli_query($db,$insert_table_name);
        
        // $creating_table = "CREATE TABLE kabirbehenkaloda (
                        //   id INT(100) AUTO_INCREMENT PRIMARY KEY,
                        //   title VARCHAR(100) NOT NULL,
                        //   calendar VARCHAR(100) NOT NULL,
                        //   group VARCHAR(100) NOT NULL,
                        //   color VARCHAR(100) NOT NULL,
                        //   start_event DATETIME NOT NULL,
                        //   end_event DATETIME NOT NULL,
                        //   descs VARCHAR(100) NOT NULL
        //                   )";

        $creating_table = "CREATE TABLE $table_name (
            event_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            calendar VARCHAR(100) NOT NULL,
            groups VARCHAR(100) NOT NULL,
            color VARCHAR(100) NOT NULL,
            start_event DATETIME,
            end_event DATETIME,
            descs VARCHAR(100) NOT NULL
            )";
            // $creating_table = "CREATE TABLE $table_name (
            //     event_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            //     title VARCHAR(100) NOT NULL,
            //     calendar VARCHAR(100) NOT NULL,
            //     group VARCHAR(100) NOT NULL,
            //      TEXT NULL,
            //     date DATE NOT NULL
            //     )";
        
        mysqli_query($db, $creating_table);

        
        $_SESSION['email'] = $email;
        $_SESSION['tableName'] = strtolower($table_name);
        $_SESSION['firstName'] = $firstName;

        // $_SESSION(['success']) = "You are successfully logged in.";
        echo(mysqli_error($db));
        mysqli_close($db);
        header('Location: tt.php');
    }
}

$errors2 = "";
if (isset($_POST['login'])) {
    $loginemail = mysqli_real_escape_string($db, $_POST['loginemail']);
    $loginpasstext = mysqli_real_escape_string($db, $_POST['loginpass']);
  
    if ($errors2 == "") {
        $loginpass = md5($loginpasstext);
        $query = "SELECT id, table_name, firstName FROM user WHERE email='$loginemail' AND passwd='$loginpass'";
        $results = mysqli_query($db, $query);
        $rs = mysqli_fetch_array($results);
        
        if(mysqli_num_rows($results) == 1) {
            $_SESSION['email'] = $loginemail;
            $_SESSION['tableName'] = strtolower($rs['table_name']);
            $_SESSION['firstName'] = $rs['firstName'];    

        //   $_SESSION['success'] = "You are now logged in";
             mysqli_close($db);
           
            header('Location: tt.php');
        } else {
            $errors2 .="<div class='alert alert-danger'>Wrong Email id or Password.</div>".mysqli_error($db);
        }
    }
    echo mysqli_error($db);
  }
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
<body id="notIndexBody">
    <header>
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
                          <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="tt.php">Time Table</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="#"></a>
                        </li>
                      </ul>
                </div> 
            </nav>
        </div>
    </header>
    
    <div id="" class="container" style="margin-top: 30px; margin-bottom: 20px;">
        <div class="row">
            <div class="col-xl-6 col-lg-7 col-md-8" style="margin: auto;">
                <?php echo($errors2); ?>
                <form method="post">
                    <div class="form-group">
                        <input type="email" name="loginemail" class="form-control" id="exampleInputEmail1" placeholder="Enter email" auofocus required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="loginpass" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                    </div>
                    <button type="submit" name="login" class="btn">Log In</button>
                </form>
                <hr style="border: 0.5px white solid">
                <a href="#" data-toggle="modal" data-target="#ModalCenter">Create an Account</a>
                <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                            <h6 style="color: black; font-size: larger;">Sign Up</h6>
                            <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php echo($errors1); ?>
                            
                            <form method="post">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control" id="exampleFirstName" placeholder="First name" name="firstname" required>
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control" id="exampleLastName" placeholder="Last Name" name="lastname"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="exampleInputEmail" placeholder="Email Id" name="email"  required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password" name="pass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="exampleConfirmInputPassword" placeholder="Confirm Password" name="pass2"  required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="signup" class="btn btn-secondary">Sign Up</button>
                                </div>
                            </form>
                            <div id="message">
                                    <h6 style="color: black; font-size: larger;">Password must contain the following:</h6>
                                    <p id="letter" class="invalid">A <b> lowercase</b> letter</p>
                                    <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                    <p id="number" class="invalid">A <b>number</b></p>
                                    <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                                </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="fixed-bottom" style="background-color: #1A1C1C; padding-bottom: 30px;">
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
















    <?php echo($modalshow); ?>
    
    <script type="text/javascript">

        if (window.history.replaceState) {
             window.history.replaceState(null, null, window.location.href);
        } 
        
        var modal = document.getElementById("ModalCenter");
    
        var myInput = document.getElementById("exampleInputPassword");
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");


        document.getElementById("message").style.display = "none";

        myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
        }
        myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
            }
        myInput.onkeyup = function() {

            var lowerCaseLetters = /[a-z]/g;
        if(myInput.value.match(lowerCaseLetters)) {  
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        var upperCaseLetters = /[A-Z]/g;
        if(myInput.value.match(upperCaseLetters)) {  
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        var numbers = /[0-9]/g;
        if(myInput.value.match(numbers)) {  
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        if(myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
        }

 </script>

    <script src="https://use.fontawesome.com/07d234760a.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
     integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>