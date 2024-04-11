<?php
// Connect to the database
$link = mysqli_connect("localhost", "root", "", "attendance");
if ($link === false) {
    die("ERROR: Could not connect" . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'tablename' field is set and not empty
    if (isset($_POST["tablename"]) && !empty($_POST["tablename"])) {
        // Sanitize the input to prevent SQL injection
        $tableName = mysqli_real_escape_string($link, $_POST["tablename"]);
        
        // Drop the table
        $sql = "DROP TABLE IF EXISTS `$tableName`";
        if (mysqli_query($link, $sql)) {
            echo "'$tableName' deleted successfully.";
        } else {
            echo "Error dropping table: " . mysqli_error($link);
        }
    } else {
        echo "No table selected.";
    }
}

// Close the database connection
mysqli_close($link);
?>
