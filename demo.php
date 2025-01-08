<?php 
$payload = json_encode([
    "date" => "2025-01-09",
    "time" => "09:00",
    "summary" => "Client Meeting",
    "description" => "Meeting to discuss project."
]);

$ch = curl_init("http://localhost/ExpTreasure/SmallAdmin/calendar.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$response = curl_exec($ch);
curl_close($ch);

echo $response;

?>