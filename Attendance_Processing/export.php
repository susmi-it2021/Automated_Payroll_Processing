<?php
// Connect to the database
$link = mysqli_connect("localhost", "root", "", "attendance");
if ($link === false) {
    die("ERROR: Could not connect" . mysqli_connect_error());
}

// Check if tablename is provided in the URL
if (isset($_GET['tablename']) && !empty($_GET['tablename'])) {
    // Sanitize the input to prevent SQL injection
    $tablename = mysqli_real_escape_string($link, $_GET['tablename']);

    // Fetch field names
    $fields = array();
    $result = mysqli_query($link, "SHOW COLUMNS FROM `$tablename`");
    while ($row = mysqli_fetch_assoc($result)) {
        $fields[] = $row['Field'];
    }
    mysqli_free_result($result);

    // Fetch data from the table
    $sql = "SELECT * FROM `$tablename`";
    $result = mysqli_query($link, $sql);

    // Prepare CSV file
    $filename = $tablename . '.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Output CSV content with field names as header
    $output = fopen('php://output', 'w');
    fputcsv($output, $fields); // Write column headers
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, $row);
    }
    fclose($output);

    // Free result set
    mysqli_free_result($result);
} else {
    echo "No table selected.";
}

// Close the database connection
mysqli_close($link);
?>