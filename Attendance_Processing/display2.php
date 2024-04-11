<?php
if(isset($_POST['month']) && isset($_POST['year']) && isset($_POST['employee_name'])) {
    $month = $_POST['month'];
    $year = $_POST['year'];
    $employeeName = $_POST['employee_name'];
    // Connect to your database
    $host = 'localhost';
    $username = 'root'; // Your database username
    $password = ''; // Your database password
    $database = 'reattendance'; // Your database name
    $conn = new mysqli($host, $username, $password, $database);
    $table_name = strtolower($month) . $year;

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch attendance records based on the provided parameters
    $sql = "SELECT * FROM $table_name WHERE `user` = '$employeeName' ORDER BY `id` ASC";
    $result = $conn->query($sql);

    // Display the attendance records
    if ($result->num_rows > 0) {
        // Start building the table HTML
        $tableHtml = '<div class="table-responsive">';
        $tableHtml .= '<table class="table table-bordered">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th colspan="2" style="text-align:center;">Month: ' . $month . '</th>';
        $tableHtml .= '<th colspan="2" style="text-align:center;">Year: ' . $year . '</th>';
        $tableHtml .= '<th colspan="2" style="text-align:center;">Employee Name: ' . $employeeName . '</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>Id</th>';
        $tableHtml .= '<th>Date</th>';
        $tableHtml .= '<th>Time_In</th>';
        $tableHtml .= '<th>Time_Out</th>';
        $tableHtml .= '<th>Worked_Hours</th>';
        $tableHtml .= '<th>Late_Hours</th>';
        $tableHtml .= '<th>Stipulated_time</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody>';

        // Fetch and display each row of data
        while ($row = $result->fetch_assoc()) {
            $tableHtml .= '<tr>';
            $tableHtml .= '<td>' . $row['id'] . '</td>';
            $tableHtml .= '<td>' . $row['date'] . '</td>';
            $tableHtml .= '<td>' . $row['time_in'] . '</td>';
            $tableHtml .= '<td>' . $row['time_out'] . '</td>';
            $tableHtml .= '<td>' . $row['worked_hours'] . '</td>';
            $tableHtml .= '<td>' . $row['late_hours'] . '</td>';
            $tableHtml .= '<td>' . $row['stipulated_time'] . '</td>';
            $tableHtml .= '</tr>';
        }

        // Close the table
        $tableHtml .= '</tbody>';
        $tableHtml .= '</table>';
        $tableHtml .= '</div>';

        // Output the table HTML
        echo $tableHtml;
    } else {
        // If no rows are found, display a message
        echo '<div class="alert alert-warning" role="alert">No attendance records found for the specified month and year.</div>';
    }

    // Close the database connection
    $conn->close();
} else {
    // If the parameters are not set, display an error message
    echo "<h2>Error: Parameters not set</h2>";
    echo "<p>Month and year must be provided.</p>";
}
?>
