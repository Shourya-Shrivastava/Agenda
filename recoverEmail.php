<?php 

session_start();
$error = "";
$successAlert ="";
$db = mysqli_connect('localhost', 'root', '', 'agenda')  or die("Could not connect to the database");
if(isset($_POST['send'])){
    $recoverEmail = mysqli_real_escape_string($db, $_POST['email']);

    $checkQuery = "SELECT * FROM user where email='$recoverEmail'";
    $query = mysqli_query($db, $checkQuery);
    $row = mysqli_num_rows($query);
    if($row){
        $userData = mysqli_fetch_assoc($query);
        $firstName = $userData['firstName'];
        $id = $userData['id'];
        $subject = "Reset Password";
        $body = "Hi, $firstName. Click on the following link to reset your password. 
        http://localhost/Agenda/resetPassword.php?id=$id";
        $sender = "From: nirajnknair@gmail.com";
        if(mail($recoverEmail, $subject, $body, $sender)){
            $successAlert ="<div class='alert alert-success'>Please check your inbox.</div>";
            header('location: login.php?msg=Password updated. Please check your inbox.');
        }else{
            $error.="<div class='alert alert-danger'>There is some error. Please try again later.</div>";
        }
    }
    else{
        $error.="<div class='alert alert-danger'>Account does not exist. Please Register to continue.</div>";
    }
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
    <link rel="stylesheet" href="style.css">
    
</head>
<body> 
    <div>
        <div class="container">
            <header>
                <div class="container" id="title-div">
                    <h4 style="padding-top: 30px" >Recover Your Account</h4>
                    <h6 style="padding-top: 20px">Enter correct email id</h6>
                </div>
            </header>
        <div class="confirmForm">
            <form method="post" style="width: 50%; margin:auto; padding-top: 30px" >
                <?php echo $error;
                echo $successAlert;?>
                <div class="form-group">
                    <input type="email" class="form-control" id="exampleInputEmail" placeholder="Email Id" name="email"  required>
                </div>
                <button class="btn btn-secondary" type="submit" name="send">Send</button>
            </form>
        </div>
        
            
    
        </div>

    </div>
    

    

    <script src="https://use.fontawesome.com/07d234760a.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>