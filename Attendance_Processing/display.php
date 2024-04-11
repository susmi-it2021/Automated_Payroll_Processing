<?php
if(isset($_POST['month']) && isset($_POST['year'])) {
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Connect to your database
    $host = 'localhost';
    $username = 'root'; // Your database username
    $password = ''; // Your database password
    $database = 'attendance'; // Your database name
    $conn = new mysqli($host, $username, $password, $database);
    $table_name = strtolower($month) . $year;

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch attendance records based on the provided parameters
    $sql = "SELECT * FROM $table_name WHERE break != 0 ORDER BY `id` ASC";
    $result = $conn->query($sql);

    // Display the attendance records
    if ($result->num_rows > 0) {
        // Start building the table HTML
        $tableHtml = '<div class="table-responsive">';
        $tableHtml .= '<table class="table table-bordered">';
        $tableHtml .= '<thead>';
        $tableHtml .= '<tr>';
        $tableHtml .= '<th>Id</th>';
        $tableHtml .= '<th>User</th>';
        $tableHtml .= '<th>Date</th>';
        $tableHtml .= '<th>Time In</th>';
        $tableHtml .= '<th>Time Out</th>';
        $tableHtml .= '<th>Break</th>';
        $tableHtml .= '</tr>';
        $tableHtml .= '</thead>';
        $tableHtml .= '<tbody>';

        // Fetch and display each row of data
        while ($row = $result->fetch_assoc()) {
            $tableHtml .= '<tr>';
            $tableHtml .= '<td>' . $row['id'] . '</td>';
            $tableHtml .= '<td>' . $row['user'] . '</td>';
            $tableHtml .= '<td>' . $row['date'] . '</td>';
            $tableHtml .= '<td>' . $row['time_in'] . '</td>';
            $tableHtml .= '<td>' . $row['time_out'] . '</td>';
            $tableHtml .= '<td>' . $row['break'] . '</td>';
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
