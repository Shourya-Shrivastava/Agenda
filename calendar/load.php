<?php
session_start();
$connect = new PDO('mysql:host=localhost;dbname=agenda', 'root', '');

$data = array();

$tableName = $_SESSION['tableName'];

$query = "SELECT * FROM $tableName ORDER BY event_id";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row){
    $data[] = array(
        'id'   => $row["event_id"],
        'title'   => $row["title"],
        'calendar' => $row["calendar"],
        'group' => $row["groups"],
        'backgroundColor' => $row['color'],
        'start'   => $row["start_event"],
        'end'   => $row["end_event"],
        'descs' => $row["descs"],
        'allDay' => false,
 );
}

echo json_encode($data);

?>