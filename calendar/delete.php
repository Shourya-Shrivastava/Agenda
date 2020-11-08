<?php
session_start();
if(isset($_POST['id'])){

    $db = mysqli_connect('localhost', 'root', '', 'agenda')  or die("Could not connect to the database");

    $id = $_POST['id'];
    $calendar = $_POST['calendar'];
    $group = $_POST['group'];

    $groupState= 0;
    $calendarState = 0;

    // $connect = new PDO('mysql:host=localhost;dbname=agenda', 'root', '');

    $tableName = $_SESSION['tableName'];
    $query = "DELETE FROM $tableName WHERE event_id='$id'";

    mysqli_query($db, $query);

    $checkCalendar = "SELECT DISTINCT calendar FROM $tableName ORDER BY event_id";
    $checkGroup = "SELECT DISTINCT groups FROM $tableName ORDER BY event_id";


    $qc = mysqli_query($db, $checkCalendar);
    $qg = mysqli_query($db, $checkGroup);

    $calendarRows = mysqli_fetch_all($qc, MYSQLI_ASSOC);
    $groupRows = mysqli_fetch_all($qg, MYSQLI_ASSOC);

    foreach ($groupRows as $grow) {
        if(grow['groups'] == $group){
            $groupState = 1;
            $calendarState = 1;
        }else{
            $groupState = 0;
            foreach($calendarRows as $crow)
            if(crow['calendar'] == $calendar){
                $calendarState = 1;
            }else{
                $calendarState = 0;
            }
        }
    }

    echo json_encode(array($groupState, $calendarState));
}

?>