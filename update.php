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

// Fetch data from the database
$sql = "SELECT * FROM metrics WHERE id = 1"; // Assuming you want to retrieve data for ID 1
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Assign retrieved values to variables for use in HTML input fields
    $total_working_hours = $row['total_working_hours'];
    $average_producer_earning = $row['average_producer_earning'];
    $time_in = $row['time_in'];
    $time_out = $row['time_out'];
    $sunday_wage_per_hour = $row['sunday_wage_per_hour'];
    $lunch_break_time = $row['lunch_break_time'];
    $lunch_break_in = $row['lunch_break_in'];
    $lunch_break_out = $row['lunch_break_out'];
    $morning_slot_1_time = $row['morning_slot_1_time'];
    $morning_slot_1_overtime_wage = $row['morning_slot_1_overtime_wage'];
    $morning_slot_2_time = $row['morning_slot_2_time'];
    $morning_slot_2_overtime_wage = $row['morning_slot_2_overtime_wage'];
    $morning_slot_3_time = $row['morning_slot_3_time'];
    $morning_slot_3_overtime_wage = $row['morning_slot_3_overtime_wage'];
    $morning_slot_4_overtime_wage = $row['morning_slot_4_overtime_wage'];
    $evening_slot_1_overtime_wage = $row['evening_slot_1_overtime_wage'];
    $evening_slot_2_time = $row['evening_slot_2_time'];
    $evening_slot_2_overtime_wage = $row['evening_slot_2_overtime_wage'];
    $evening_slot_3_time = $row['evening_slot_3_time'];
    $evening_slot_3_overtime_wage = $row['evening_slot_3_overtime_wage'];
    $evening_slot_4_time = $row['evening_slot_4_time'];
    $evening_slot_4_overtime_wage = $row['evening_slot_4_overtime_wage'];
} else {
    echo "0 results";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>YellowBag Foundation</title>
  <link rel="stylesheet" href="./style.css">
  <link rel="icon" type="image/x-icon" href="yellowbagside-svg.svg" />
<meta name='viewport' content='width=device-width, initial-scale=1'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
  <style>
    /* Style for success message */
    #success-message {
      background-color: #d4edda;
      color: #155724;
      padding: 10px;
      margin-bottom: 10px;
      border-radius: 5px;
    }
  </style>
</head>
<body>
<div class="wrapper">
    <div class="title">
      YellowBag Foundation's Metrics
    </div>
	<?php
// Check for success or error message in the URL
if (isset($_GET['success'])) {
    $message = $_GET['success'];
    echo "<div id='success-message'>$message</div>";
} elseif (isset($_GET['error'])) {
    $message = $_GET['error'];
    echo "<div id='error-message'>$message</div>";
}?>
	<form method="post" action="update_metrics.php"> <!-- Assuming you want to update the metrics -->
    <div class="form">
       <div class="inputfield">
          <label>Total Working Hours</label>
          <input type="time" class="input" name="total_working_hours" value="<?php echo $total_working_hours; ?>">
       </div> 
        <div class="inputfield">
          <label>Average Producer Earning (Per day workers)</label>
          <input type="number" class="input" name="average_producer_earning" value="<?php echo $average_producer_earning; ?>">
       </div>	      
        <div class="inputfield">
          <label>Time-In</label>
          <input type="time" class="input" name="time_in" value="<?php echo $time_in; ?>">
       </div>  
       <div class="inputfield">
          <label>Time Out</label>
          <input type="time" class="input" name="time_out" value="<?php echo $time_out; ?>">
       </div> 
	    <div class="inputfield">
          <label>Sunday Wage Per Hour</label>
          <input type="number" class="input" name="sunday_wage_per_hour" value="<?php echo $sunday_wage_per_hour; ?>">
       </div> 
	   <div class="inputfield">
          <label>Lunch Break Time</label>
          <input type="time" class="input" name="lunch_break_time" value="<?php echo $lunch_break_time; ?>">
       </div> 
       <div class="inputfield">
          <label>Lunch Break In</label>
          <input type="time" class="input" name="lunch_break_in" value="<?php echo $lunch_break_in; ?>">
       </div> 
       <div class="inputfield">
          <label>Lunch Break Out</label>
          <input type="time" class="input" name="lunch_break_out" value="<?php echo $lunch_break_out; ?>">
       </div> 
       <div class="inputfield">
          <label>Morning Slot 1 Time</label>
          <input type="time" class="input" name="morning_slot_1_time" value="<?php echo $morning_slot_1_time; ?>">
       </div> 
       <div class="inputfield">
          <label>Morning Slot 1 Overtime Wage</label>
          <input type="number" class="input" name="morning_slot_1_overtime_wage" value="<?php echo $morning_slot_1_overtime_wage; ?>">
       </div> 
       <div class="inputfield">
          <label>Morning Slot 2 Time</label>
          <input type="time" class="input" name="morning_slot_2_time" value="<?php echo $morning_slot_2_time; ?>">
       </div> 
       <div class="inputfield">
          <label>Morning Slot 2 Overtime Wage</label>
          <input type="number" class="input" name="morning_slot_2_overtime_wage" value="<?php echo $morning_slot_2_overtime_wage; ?>">
       </div> 
       <div class="inputfield">
          <label>Morning Slot 3 Time</label>
          <input type="time" class="input" name="morning_slot_3_time" value="<?php echo $morning_slot_3_time; ?>">
       </div> 
       <div class="inputfield">
          <label>Morning Slot 3 Overtime Wage</label>
          <input type="number" class="input" name="morning_slot_3_overtime_wage" value="<?php echo $morning_slot_3_overtime_wage; ?>">
       </div> 
       <div class="inputfield">
          <label>Morning Slot 4 (Time-In)</label>
       </div> 
       <div class="inputfield">
          <label>Morning Slot 4 Overtime Wage</label>
          <input type="number" class="input" name="morning_slot_4_overtime_wage" value="<?php echo $morning_slot_4_overtime_wage; ?>">
       </div> 
       <div class="inputfield">
          <label>Evening Slot 1 (Time-Out)</label>
 
       </div> 
       <div class="inputfield">
          <label>Evening Slot 1 Overtime Wage</label>
          <input type="number" class="input" name="evening_slot_1_overtime_wage" value="<?php echo $evening_slot_1_overtime_wage; ?>">
       </div> 
       <div class="inputfield">
          <label>Evening Slot 2 Time</label>
          <input type="time" class="input" name="evening_slot_2_time" value="<?php echo $evening_slot_2_time; ?>">
       </div> 
       <div class="inputfield">
          <label>Evening Slot 2 Overtime Wage</label>
          <input type="number" class="input" name="evening_slot_2_overtime_wage" value="<?php echo $evening_slot_2_overtime_wage; ?>">
       </div> 
       <div class="inputfield">
          <label>Evening Slot 3 Time</label>
          <input type="time" class="input" name="evening_slot_3_time" value="<?php echo $evening_slot_3_time; ?>">
       </div> 
       <div class="inputfield">
          <label>Evening Slot 3 Overtime Wage</label>
          <input type="number" class="input" name="evening_slot_3_overtime_wage" value="<?php echo $evening_slot_3_overtime_wage; ?>">
       </div> 
       <div class="inputfield">
          <label>Evening Slot 4 Time</label>
          <input type="time" class="input" name="evening_slot_4_time" value="<?php echo $evening_slot_4_time; ?>">
       </div> 
       <div class="inputfield">
          <label>Evening Slot 4 Overtime Wage</label>
          <input type="number" class="input" name="evening_slot_4_overtime_wage" value="<?php echo $evening_slot_4_overtime_wage; ?>">
       </div> 
       <div class="inputfield" style="grid-column: span 2;">
          <input type="submit" value="Update" class="btn">
       </div>
    </div>
	</form>
</div>  

</body>
</html>
