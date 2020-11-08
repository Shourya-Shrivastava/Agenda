<?php 

session_start();

if(isset($_POST['val'])){

    unset($_SESSION['group_arr']);

    $_SESSION['group_arr'] = array();

    $val = $_POST['val'];

    $db = mysqli_connect('localhost', 'root', '', 'agenda')  or die("Could not connect to the database");
    
    $tableName = $_SESSION['tableName'];
    
    $query = "SELECT DISTINCT groups FROM $tableName WHERE calendar = '$val'";

    $q = mysqli_query($db, $query);

    $rows = mysqli_fetch_all($q, MYSQLI_ASSOC);

    $_SESSION['group_arr'] = array("All");

    foreach($rows as $r){
        array_push($_SESSION['group_arr'], $r['groups']);
    }
    

    echo json_encode($_SESSION['group_arr']);
}

?>