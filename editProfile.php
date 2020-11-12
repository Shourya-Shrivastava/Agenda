<?php 
session_start();

$password = "";

$errors1 = "";
$db = mysqli_connect('localhost', 'root', '', 'agenda')  or die("Could not connect to the database");

$checkEmail = $_SESSION['email'];

if(isset($checkEmail)){
    $user_check_query = "SELECT * FROM user WHERE email = '$checkEmail' LIMIT 1"; 
    $fetchedUser = mysqli_query($db, $user_check_query);
    $userDetails = mysqli_fetch_assoc($fetchedUser);
    $user_id = $userDetails['id'];
    // echo $checkEmail;
    $old_table_name = $userDetails['table_name'];
    $old_password = $userDetails['passwd'];
}


if (isset($_POST['saveProfile'])){       
    $firstName = mysqli_real_escape_string($db, $_POST['firstname']);
    $lastName = mysqli_real_escape_string($db, $_POST['lastname']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['pass1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['pass2']);


    if(empty($email)){ $errors1 .="<div class='alert alert-danger'>Enter email</div>";}
    if(empty($firstName)){ $errors1 .="<div class='alert alert-danger'>Enter first name.</div>";}
    if(empty($lastName)){ $errors1 .="<div class='alert alert-danger'>Enter last name.</div>";}
    if(empty($password_1) || empty($password_2)){ $password = $old_password;}
    if(empty($password_2) || $password_1 != $password_2){ $errors1 .="<div class='alert alert-danger'>Enter password twice
         or Entered passwords doesn't match each other.</div>";} 
    if($errors1 == ""){
        $password = md5($password_1);
        $table_name = strtolower($firstName).'_'.strtolower($lastName);
        $query = "UPDATE user SET firstName = '$firstName', lastName = '$lastName', email = '$email', passwd = '$password', table_name = '$table_name'
         WHERE id = '$user_id'";
        $change_table_name = "ALTER TABLE $old_table_name RENAME TO $table_name";
        mysqli_query($db, $query);
        mysqli_query($db, $change_table_name);
        $_SESSION['email'] = $email;
        $_SESSION['tableName'] = $table_name;
        $_SESSION['firstName'] = $firstName;
        
        echo(mysqli_error($db));
        mysqli_close($db);
        header('Location: editProfile.php');
    }
}
    
if(isset($_POST['deleteProfile'])){
    $delete_query = "DELETE FROM user where email='$checkEmail'";
    $delete_table = "DROP TABLE $old_table_name";
    mysqli_query($db, $delete_query);
    mysqli_query($db, $delete_table);
    
    header('Location: logout.php');
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
                        <?php if($_SESSION['email']): ?>
                            <!-- show HTML logout button -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Hi, <?php echo($_SESSION['firstName']); ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="nav-link" href="editProfile.php" style="color: black"><img src="https://img.icons8.com/ios/21/000000/gender-neutral-user.png" style="padding-right: 10px"/>Profile</a>
                                <a class="nav-link" href="logout.php" style="color: black"><img src="https://img.icons8.com/ios/18/000000/export.png" style="padding-right: 10px">Log Out</a>
                                </div>
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
    
    <div class="container" style="margin-top: 30px; margin-bottom: 20px; ">
        <h4 style="text-align: center; padding-bottom: 30px ">Edit Profile</h4>
        <div class="row">
            <div class="col-xl-6 col-lg-7 col-md-8" style="margin: auto;">
                <?php echo $errors1;?>
                <form method="post">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <input value="<?php echo $userDetails['firstName']; ?>" type="text" class="form-control" id="exampleFirstName" placeholder="First name" name="firstname" required>
                            </div>
                            <div class="col-6">
                                <input value="<?php echo $userDetails['lastName']; ?>" type="text" class="form-control" id="exampleLastName" placeholder="Last Name" name="lastname"  required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input value="<?php echo $userDetails['email']; ?>" type="email" class="form-control" id="exampleInputEmail" placeholder="Email Id" name="email"  required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="exampleInputPassword" placeholder="New Password" name="pass1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" >
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="exampleConfirmInputPassword" placeholder="Confirm Password" name="pass2">
                    </div>
                    <div id="message">
                        <h6 id="checkPass" class="invalid" style=" font-size: 15px;">Password must contain a <b>lowercase</b>, an <b>uppercase</b>, a <b>number</b> and total <b>8 characters</b>.</h6>                       
                    </div>
                    
                        <!-- <button type="submit" name="saveProfile" class="btn btn-secondary">Save</button> -->
                        <div class="row">
                            <div class="col-6" >
                                <button type="submit" id="saveButton" name="saveProfile" class="btn btn-secondary" style="float: right;">Save Changes</button> 
                            </div>
                            <div class="col-6" >
                                <button type="submit" id="deleteButton" name="deleteProfile" class="btn btn-danger" style="float: left;">Delete Profile</button>  
                            </div>
                        </div>
                    
                </form>
                 </div>
            </div>
        </div>
    </div>


    <div style="padding-top: 155px; ">
         <hr style="height:2px; width:75%;color:white;background-color:white">
        <footer style="background-color: rgb(0,0,0,0.1); padding-bottom: 30px; padding-top: 30px; ">
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
    </div>


    
    <script type="text/javascript"> 
        
        var modal = document.getElementById("ModalCenter");
        var checkPass = document.getElementById("checkPass");
    
        var myInput = document.getElementById("exampleInputPassword");

        document.getElementById("message").style.display = "none";

        myInput.onblur = function() {
        document.getElementById("message").style.display = "none";
        }
        myInput.onfocus = function() {
        document.getElementById("message").style.display = "block";
            }
        myInput.onkeyup = function() {

            var lowerCaseLetters = /[a-z]/g;
            var upperCaseLetters = /[A-Z]/g;
            var numbers = /[0-9]/g;

            if(myInput.value.match(lowerCaseLetters) && myInput.value.match(upperCaseLetters)
            && myInput.value.match(numbers) && myInput.value.length >= 8) {  
                checkPass.classList.remove("invalid");
                checkPass.classList.add("valid");
            } else {
                checkPass.classList.remove("valid");
                checkPass.classList.add("invalid");
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