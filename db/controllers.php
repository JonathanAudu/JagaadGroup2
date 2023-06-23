<?php
function fetchSlots($conn){
    // Fetch slots from the database
$sql = "SELECT * FROM slots";
$result = $conn->query($sql);
$slots = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $slots[] = $row;
    }
}
}