<?php
session_start();

$db = mysqli_connect('localhost', 'root', '', 'agenda')  or die("Could not connect to the database");

if(!empty($_POST)){
    
    // $calArray = array();
    // $groupArray = array();
    
    // $checkCalendar = "SELECT DISTINCT calendar FROM $tableName ORDER BY event_id";
    // $checkGroup = "SELECT DISTINCT groups FROM $tableName ORDER BY event_id";
    
    // $qc = mysqli_query($db, $checkCalendar);
    // $qg = mysqli_query($db, $checkGroup);
    
    $calendarRows = mysqli_fetch_all($qc, MYSQLI_ASSOC);
    $groupRows = mysqli_fetch_all($qg, MYSQLI_ASSOC);
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $ttCalendar = mysqli_real_escape_string($db, $_POST['ttCalendar']);
    $group = mysqli_real_escape_string($db, $_POST['group']);
    $color = mysqli_real_escape_string($db, $_POST['color']);
    $fromtime = mysqli_real_escape_string($db, $_POST['fromTime']);
    $totime = mysqli_real_escape_string($db, $_POST['toTime']);
    $ttDesc = mysqli_real_escape_string($db, $_POST['ttDesc']);

    $tableName = $_SESSION['tableName'];

    
    $query = "INSERT INTO $tableName (title , calendar, groups, color, start_event, end_event, descs)
    VALUES ('$title', '$ttCalendar', '$group', '$color', '$fromtime', '$totime', '$ttDesc')";

    mysqli_query($db, $query);

    if(!in_array($ttCalendar, $_SESSION['calendar_arr'])){
        array_push($_SESSION['calendar_arr'], $ttCalendar);
    }

    echo json_encode();
}

?>

