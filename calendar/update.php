<?php 

session_start();

$db = mysqli_connect('localhost', 'root', '', 'agenda')  or die("Could not connect to the database");

if(!empty($_POST)){

    $title = mysqli_real_escape_string($db, $_POST['editTitle']);
    $ttCalendar = mysqli_real_escape_string($db, $_POST['editCalendar']);
    $group = mysqli_real_escape_string($db, $_POST['editGroup']);
    $color = mysqli_real_escape_string($db, $_POST['editColor']);
    $fromTime = mysqli_real_escape_string($db, $_POST['editFromTime']);
    $toTime = mysqli_real_escape_string($db, $_POST['editToTime']);
    $ttDesc = mysqli_real_escape_string($db, $_POST['editDesc']);
    $eventId = mysqli_real_escape_string($db, $_POST['eventId']);   


    $tableName = $_SESSION['tableName'];

    $query = "UPDATE $tableName SET title='$title' , calendar='$ttCalendar', groups='$group', color='$color' ,
                start_event='$fromTime', end_event='$toTime', descs='$ttDesc'
            WHERE event_id='$eventId'";

    mysqli_query($db, $query);

}
?>