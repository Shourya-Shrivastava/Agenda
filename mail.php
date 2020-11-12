<?php

$f = fopen('myCsv.csv', 'a'); 

// Write to the csv
fputcsv($f, ["sklfhskd", "edfks"]);

// Close the file
fclose($f);

$to_email = "nirajnknair2@outlook.com";
$subject = "Simple Email Test via PHP";
$body = "Hi, This is test email send by PHP Script";
$headers = "From: nirajnknair@gmail.com";

// if (mail($to_email, $subject, $body, $headers)) {
//     echo "Email successfully sent to $to_email...";
// } else {
//     echo "Email sending failed...";
// }
?>