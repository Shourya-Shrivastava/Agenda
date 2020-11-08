<?php
session_start();
// include 'insert.php';
 
if(!isset($_SESSION['email'])){
    $error3 = "<div class='alert alert-danger'>Login to Proceed</div>";
    header('Location: login.php?error='.$error3);
    exit;
} else {
    $db = mysqli_connect('localhost', 'root', '', 'agenda')  or die("Could not connect to the database");

    $tableName = $_SESSION['tableName'];

    $query = "SELECT DISTINCT calendar FROM $tableName ORDER BY event_id";

    $q = mysqli_query($db, $query);

    $rows = mysqli_fetch_all($q, MYSQLI_ASSOC);

    // $groupQuery = "SELECT DISTINCT groups FROM $tableName ORDER BY event_id";

    // $qg = mysqli_query($db, $groupQuery);

    // $groupRows = mysqli_fetch_all($qg, MYSQLI_ASSOC);

    $_SESSION['calendar_arr'] = array("All");

    foreach($rows as $r){
        array_push($_SESSION['calendar_arr'], $r['calendar']);
    }

    // $_SESSION['group_arr'] = array("All");

    // foreach($groupRows as $gr){
    //     array_push($_SESSION['group_arr'], $gr['groups']);
    // }

    // $calendarArray = array_unique($rows);

    // $arraySize = sizeof($rows);

    // $allCalArray = array();
    // $allCalArray["calendar"] = "All";

    // // $rows[$arraySize+1] = $allArray;
    // array_unshift($rows, $allCalArray);


    // $groupFilter = "";
    // if(isset($_POST['calendar_filter'])){
    //     $optValue = $_POST['calendar_filter'];
    //     if($optValue != "all"){
    //         $filterQuery = "SELECT DISTINCT groups FROM $tableName WHERE calendar = '$optValue'";
    //         $allGroups = mysqli_query($db, $filterQuery);
    //         $groupRows = mysqli_fetch_all($allGroups, MYSQLI_ASSOC);

    //         $groupFilter .= '<form method="post" id="group_filter_form">';
    //         $groupFilter .= '<select class="form-control" name="gorup_filter" id="group_filter">';
    //         // $groupFilter .= '<?php foreach($groupRows as $grp){';
    //         foreach($groupRows as $grp){
    //             $groupFilter .= '<option name="'.$grp["groups"].'" id="'.$grp["groups"].'">'.$grp["groups"].'</option>';
    //         }
    //         $groupFilter .='</select>
    //                     </form>';  
    //     }else{
    //         $groupFilter = "";
    //     }
    // }
 
    
    // <?php 
    //             // foreach($_SESSION['group_arr'] as $key => $value){
    //             //     echo '<option name="'.$value.'" id="'.$value.'">'.$value.'</option>';
    //             // }
    //             
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Agenda</title>

    
        
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
     integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <link href='https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.1/css/all.css' rel='stylesheet'>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.js"></script> -->


    
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Old+Standard+TT:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css">

    <script type="text/javascript" src="calendar.js"></script>
</head>
<body id="notIndexBody">
    <header >
        <div class="container" id="title-div">
            <h2 class="display-3">Agenda</h2>
            <!-- <button class="btn btn-primary">Log In</button> -->
            <nav class="navbar justify-content-center navbar-expand-lg" style="margin-top: 10px;">
                <!-- <button class="" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                </button> -->
                <i class="fa fa-lg fa-arrow-circle-down navbar-toggler" data-toggle="collapse" data-target="#navbarNavDropdown"
                 aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"></i>
                <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                          <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#">Time Table</a>
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
    
    <div id="addEventModal" class="container" style="text-align: center; padding-top: 30px;">
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                    <h6 style="color: black; font-size: larger;">Add Event</h6>
                    <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="addForm">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control" id="ttTitle" placeholder="Title" name="title" required>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="ttCalendar" placeholder="Calendar" name="ttCalendar"  required>
                                </div>
                            </div> 
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                <input type="text" class="form-control" id="ttGroup" placeholder="Group" name="group"  required>
                                </div>
                                <div class="col-6" style=" padding-top: 5px">
                                    <!-- <label for="color" style="color: black; float: left">Color</label> -->
                                    <input type="color" id="ttColor" name="color" style="width: 100%"  required>
                                </div>
                            </div> 
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label for="fromTime" style="color: black; float: left">From</label>
                                    <input type="datetime-local" id="fromTime" class="form-control" name="fromTime" required> 
                                </div>
                                <div class="col-6">
                                    <label for="toTime" style="color: black; float: left">To</label>
                                    <input type="datetime-local" id="toTime" class="form-control" name="toTime" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea rows="3" col="12" placeholder="Description" id="ttDesc" name="ttDesc" class="form-control"></textarea> 
                        </div>
                        <<button type="submit" id="addButton" name="addButton" value="Add" class="btn btn-secondary">Add</button> 
                    </form>
                </div>
                
              </div>
            </div>
        </div>

    <div id="editEventModal" class="container" style="text-align: center; padding-top: 30px;">
        <div class="modal fade" id="editModalCenter" tabindex="-1" role="dialog" aria-labelledby="editModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                    <h6 style="color: black; font-size: larger;">Edit Event </h6>
                    <button type="submit" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="get" id="editForm">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <input type="text" class="form-control" id="editTitle" placeholder="Title" name="editTitle" required>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" id="editCalendar" placeholder="Calendar" name="editCalendar"  required>
                                </div>
                            </div> 
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                <input type="text" class="form-control" id="editGroup" placeholder="Group" name="editGroup"  required>
                                </div>
                                <div class="col-6" style=" padding-top: 5px">
                                    <!-- <label for="color" style="color: black; float: left">Color</label> -->
                                    <input type="color" id="editColor" name="editColor" style="width: 100%"  required>
                                </div>
                            </div> 
                        </div>
                        
                        <div class="form-group">
                            <div class="row">
                                <div class="col-6">
                                    <label for="fromTime" style="color: black; float: left">From</label>
                                    <input type="datetime-local" id="editFromTime" class="form-control" name="editFromTime" required> 
                                </div>
                                <div class="col-6">
                                    <label for="toTime" style="color: black; float: left">To</label>
                                    <input type="datetime-local" id="editToTime" class="form-control" name="editToTime" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea rows="3" col="12" placeholder="Description" id="editDesc" name="editDesc" class="form-control"></textarea> 
                        </div>
                        <div class="row">
                            <div class="col-6" >
                                <button type="submit" id="saveButton" name="saveButton" class="btn btn-secondary" style="float: right;">Save</button> 
                            </div>
                            <div class="col-6" >
                                <button type="submit" id="deleteButton" name="deleteButton" class="btn btn-danger" style="float: left;">Delete</button>  
                            </div>
                        </div>
                    </form>
                </div>
                
              </div>
            </div>
        </div>
        </div>
                   <!--  <form method="post" id="testForm">
                         <input type="text" id="title" name="title">
                         <input type="text" id="ttCalendar" name="ttCalendar">
                         <input type="text" id="group" name="group">
                         <input type="color" id="color" name="color">       
                         <input type="datetime-local" id="from" name="fromTime">
                         <input type="datetime-local" id="to" name="toTime">
                         <input type="text" id="editDesc" name="editDesc">
                    </form>
                         <button  type="submit" id="testAdd" name="addButton" class="btn btn-secondary">Add</button> -->
    </div>
    <div class="container">
        <div class="col">
            <div class="row-sm">
                <form method="post"  id="calendar_filter_form" enctype="multipart/form-data" autocomplete="off" style="width: 50%" >
                    <label for="calendar_filter" style="color: white;">Filter Calendar</label>               
                    <select class="form-control" name="calendar_filter" id="calendar_filter">
                        <!-- <option value="all">All</option> -->
                        <?php 
                        foreach($_SESSION['calendar_arr'] as $key => $value){
                            echo '<option name="'.$value.'" id="'.$value.'">'.$value.'</option>';
                        }
                        ?>
                    </select>
                </form>                
            </div>
            <div class="row-sm">
                <form method="post"  id="group_filter_form" enctype="multipart/form-data" autocomplete="off" style="width: 30%" >
                    <label for="group_filter" style="color: white;">Filter Group</label>               
                    <select class="form-control" name="group_filter" id="group_filter">
                        <!-- <option value="all">All</option> -->
                        
                    </select>
                </form>           
            </div>
        </div>                    
        
                             

    </div>
    <div style="background-color: whitesmoke; color: black; margin: 20px 30px 20px 30px" >
        <div id="calendar" style="padding: 20px 20px 20px 20px">

        </div>
    </div>
    

    
    <footer  style="background-color: transparent; padding-bottom: 30px; ">
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

    <!-- <script>
        $('#testAdd').on('click', function(){

            var title = $('#title').val();
            var ttCalendar = $('#ttCalendar').val();
            var group = $('#group').val();
            var color = $('#color').val();
            var fromTime = $('#from').val();
            var toTime = $('#to').val();
            var editDesc = $('#editDesc').val();
            console.log(title, ttCalendar, group, color, fromTime, toTime, editDesc);
            $.ajax({
                type: 'POST',
                url: 'insert.php',
                data: {
                    "title": title,
                    "ttCalendar": ttCalendar,
                    "group": group,
                    "color": color,
                    "fromTime": fromTime,
                    "toTime": toTime,
                    "editDesc": editDesc
                },
                success: function(){
                    console.log("added");
                    calendar.fullCalendar('refetchEvents');
                    // $('.modal').modal('hide');
                }
            });
        });
    </script> -->
    

    <script src="https://use.fontawesome.com/07d234760a.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" 
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>