<?php 

session_start();
$error = "";
$password ="";
$db = mysqli_connect('localhost', 'root', '', 'agenda')  or die("Could not connect to the database");
if(isset($_POST['submit'])){
    if(isset($_GET['id'])){
        $password1 = mysqli_real_escape_string($db, $_POST['pass1']);
        $password2 = mysqli_real_escape_string($db, $_POST['pass2']);
        $id = $_GET['id'];

        if($password1 == $password2){
            $password = md5($password1);
            $updateQuery = "UPDATE user SET passwd='$password' WHERE id='$id'";
            mysqli_query($db, $updateQuery);
            header('location: login.php?msg=Password updated');
        }else{
            $error.="<div class='alert alert-danger'>Password does not match.</div>";
        }

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
<body id="notIndexBody"> 
    <div>
        <div class="container">
            <header>
                <div class="container" id="title-div">
                    <h4>Change Password</h4>
                </div>
            </header>
            <!-- <div class="confirmForm" style="margin-top: 30px; margin-bottom: 20px;">
                <form method="post" >   
                    <?php echo $error;?>
                    <div class="form-group">
                        <input type="password" class="form-control" id="confirmInput" placeholder="New Password" name="pass1" required>
                        <input type="checkbox" onclick="myFunction()">Show Password</input>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="confirmInput" placeholder="Confirm Password" name="pass2"  required>
                    </div>
                    <div id="message">
                            <h6 id="checkPass" class="invalid" style=" font-size: 15px;">Password must contain a <b>lowercase</b>, an <b>uppercase</b>, a <b>number</b> and total <b>8 characters</b>.</h6>                       
                    </div>
                    <button class="btn btn-secondary" type="submit" name="submit">submit</button>
                </form>
            </div> -->

            <div class="row">
            <div class="col-xl-6 col-lg-7 col-md-8" style="margin: 30px auto;">
                <form method="post">
                    <div class="form-group">
                        <input type="password" class="form-control" id="confirmInput" placeholder="New Password" name="pass1" required>
                        <input type="checkbox" onclick="myFunction()">Show Password</input>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="confirmInput" placeholder="Confirm Password" name="pass2"  required>
                    </div>
                    <button type="submit" name="submit" class="btn">Submit</button>
                </form>
                <hr style="border: 0.5px white solid">
                
            </div>
        </div>
            <footer style="background-color: transparent; padding-top: 450px;">
                <div class="container" style="text-align: center; padding-top: 20px;">
                    <h5>Made By</h5>
                </div>
                <div class="container" style="margin-top: 30px;">
                    <div class="row">
                        <div class="col-sm" style="text-align: end; padding-right: 50px">
                            <i><a href="#" >Niraj Nair</a></i>
                        </div>
                        <div class="col-sm" style="text-align: start">
                            <i><a href="#">Shourya Shrivastava</a></i>
                        </div>
                    </div>      
                </div>
            </footer>
    
        </div>

    </div>
    

    <script type="text/javascript">

        function myFunction() {
            var x = document.getElementById("confirmInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        var checkPass = document.getElementById("checkPass");
    
        var myInput = document.getElementById("confirmInput");

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