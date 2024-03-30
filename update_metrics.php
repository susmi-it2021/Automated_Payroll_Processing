<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "yellowbags";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you are updating the metrics for ID 1
$id = 1;

// Retrieve form data
$total_working_hours = $_POST['total_working_hours'];
$average_producer_earning = $_POST['average_producer_earning'];
$time_in = $_POST['time_in'];
$time_out = $_POST['time_out'];
$sunday_wage_per_hour = $_POST['sunday_wage_per_hour'];
$lunch_break_time = $_POST['lunch_break_time'];
$lunch_break_in = $_POST['lunch_break_in'];
$lunch_break_out = $_POST['lunch_break_out'];
$morning_slot_1_time = $_POST['morning_slot_1_time'];
$morning_slot_1_overtime_wage = $_POST['morning_slot_1_overtime_wage'];
$morning_slot_2_time = $_POST['morning_slot_2_time'];
$morning_slot_2_overtime_wage = $_POST['morning_slot_2_overtime_wage'];
$morning_slot_3_time = $_POST['morning_slot_3_time'];
$morning_slot_3_overtime_wage = $_POST['morning_slot_3_overtime_wage'];
$morning_slot_4_overtime_wage = $_POST['morning_slot_4_overtime_wage'];
$evening_slot_1_overtime_wage = $_POST['evening_slot_1_overtime_wage'];
$evening_slot_2_time = $_POST['evening_slot_2_time'];
$evening_slot_2_overtime_wage = $_POST['evening_slot_2_overtime_wage'];
$evening_slot_3_time = $_POST['evening_slot_3_time'];
$evening_slot_3_overtime_wage = $_POST['evening_slot_3_overtime_wage'];
$evening_slot_4_time = $_POST['evening_slot_4_time'];
$evening_slot_4_overtime_wage = $_POST['evening_slot_4_overtime_wage'];

// Prepare update query
$sql = "UPDATE metrics SET 
        total_working_hours = '$total_working_hours', 
        average_producer_earning = '$average_producer_earning', 
        time_in = '$time_in', 
        time_out = '$time_out', 
        sunday_wage_per_hour = '$sunday_wage_per_hour', 
        lunch_break_time = '$lunch_break_time', 
        lunch_break_in = '$lunch_break_in', 
        lunch_break_out = '$lunch_break_out', 
        morning_slot_1_time = '$morning_slot_1_time', 
        morning_slot_1_overtime_wage = '$morning_slot_1_overtime_wage', 
        morning_slot_2_time = '$morning_slot_2_time', 
        morning_slot_2_overtime_wage = '$morning_slot_2_overtime_wage', 
        morning_slot_3_time = '$morning_slot_3_time', 
        morning_slot_3_overtime_wage = '$morning_slot_3_overtime_wage', 
        morning_slot_4_overtime_wage = '$morning_slot_4_overtime_wage', 
        evening_slot_1_overtime_wage = '$evening_slot_1_overtime_wage', 
        evening_slot_2_time = '$evening_slot_2_time', 
        evening_slot_2_overtime_wage = '$evening_slot_2_overtime_wage', 
        evening_slot_3_time = '$evening_slot_3_time', 
        evening_slot_3_overtime_wage = '$evening_slot_3_overtime_wage', 
        evening_slot_4_time = '$evening_slot_4_time', 
        evening_slot_4_overtime_wage = '$evening_slot_4_overtime_wage' 
        WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    // Redirect back to the original page with a success message
    header("Location: update.php?success=Metrics updated successfully");
} else {
    // Redirect back to the original page with an error message
    header("Location: update.php?error=Error updating metrics: " . $conn->error);
}

$conn->close();
?>
