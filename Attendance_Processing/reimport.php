<?php
if(isset($_FILES['fileToUpload'])) {
    $file = $_FILES['fileToUpload'];

    // Check if file is uploaded without errors
    if($file['error'] == UPLOAD_ERR_OK) {
        // Get file extension
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Check if the uploaded file is a CSV
        if($fileExt == 'csv') {
            // Read the CSV file
            $csvData = array_map('str_getcsv', file($file['tmp_name']));

            // Remove the first row (header)
            array_shift($csvData);

            // Connect to the database
            $host = 'localhost';
            $username = 'root'; // Your database username
            $password = ''; // Your database password
            $database = 'reattendance'; // Your database name
            $conn = new mysqli($host, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Loop through each row in the CSV data
            foreach($csvData as $row) {
                // Extract data from the row
                $id = $row[0];
                $user = $row[1];
                $date = date('Y-m-d', strtotime($row[2])); // Convert date to proper format
                $timeIn = $row[3];
                $timeOut = $row[4];
                $late = $row[5];
                $break = isset($row[6]) ? $row[6] : '';

                // Calculate break_late
                $breakValues = explode(',', $break);
                if(count($breakValues) == 2) {
                    // Calculate break_late as difference between actual break and 45 minutes
                    $breakTime1 = strtotime($breakValues[0]);
                    $breakTime2 = strtotime($breakValues[1]);
                    $breakDifference = abs($breakTime2 - $breakTime1);
                    $breakDifferenceTotalMinutes = floor($breakDifference / 60);
                    $breakLateMinutes = max(0, $breakDifferenceTotalMinutes - 45);
                    $breakLateHours = floor($breakLateMinutes / 60);
                    $breakLateMinutes = $breakLateMinutes % 60;
                    $breakLateSeconds = $breakDifference % 60;
                    $breakLate = sprintf('%02d:%02d:%02d', $breakLateHours, $breakLateMinutes, $breakLateSeconds);
                } else {
                    $breakLate = '';
                }
                $timeInTimestamp = strtotime($timeIn);
                $timeOutTimestamp = strtotime($timeOut);
                $workedSeconds = $timeOutTimestamp - $timeInTimestamp;

                // Convert worked seconds to hours:minutes:seconds format
                $workedHours = floor($workedSeconds / 3600); // 3600 seconds in an hour
                $workedMinutes = floor(($workedSeconds % 3600) / 60); // Remaining seconds after hours converted to minutes
                $workedSeconds = $workedSeconds % 60; // Remaining seconds

                // Format worked hours
                $workedHours = sprintf('%02d:%02d:%02d', $workedHours, $workedMinutes, $workedSeconds);

                // Calculate Late Hours
                preg_match('/(\d+)hr (\d+)min/', $late, $lateMatches);
                $lateHours = isset($lateMatches[1]) ? intval($lateMatches[1]) : 0;
                $lateMinutes = isset($lateMatches[2]) ? intval($lateMatches[2]) : 0;
                $lateSeconds = ($lateHours * 3600) + ($lateMinutes * 60);
                
                // Convert break_late to seconds
                $breakLateParts = explode(':', $breakLate);
                $breakLateHours = isset($breakLateParts[0]) ? intval($breakLateParts[0]) : 0;
                $breakLateMinutes = isset($breakLateParts[1]) ? intval($breakLateParts[1]) : 0;
                $breakLateSeconds = isset($breakLateParts[2]) ? intval($breakLateParts[2]) : 0;
                $breakLateTotalSeconds = ($breakLateHours * 3600) + ($breakLateMinutes * 60) + $breakLateSeconds;

                // Calculate total late hours in seconds
                $totalLateSeconds = $lateSeconds + $breakLateTotalSeconds;
                
                // Convert total late hours back to hh:mm:ss format
                $totalLateHours = floor($totalLateSeconds / 3600);
                $totalLateMinutes = floor(($totalLateSeconds % 3600) / 60);
                $totalLateSeconds = $totalLateSeconds % 60;
                $totalLateFormatted = sprintf('%02d:%02d:%02d', $totalLateHours, $totalLateMinutes, $totalLateSeconds);
                
                // Calculate stipulated time in seconds (worked hours - total late hours - 30 minutes)
                // Calculate stipulated time
                // Calculate stipulated time
// Calculate stipulated time
// Calculate stipulated time
// Calculate stipulated time in seconds (worked hours - late hours - 30 minutes)
$workedSeconds = strtotime($timeOut) - strtotime($timeIn);

// Calculate late seconds
$lateSeconds = ($lateHours * 3600) + ($lateMinutes * 60);

// Subtract 30 minutes for break
$workedSeconds -= 30 * 60; // Subtract 30 minutes in seconds

// Calculate stipulated seconds
$stipulatedSeconds = $workedSeconds - $lateSeconds;

// Convert negative stipulated seconds to positive
if ($stipulatedSeconds < 0) {
    $stipulatedSeconds = abs($stipulatedSeconds);
}

// Convert stipulated seconds to hours:minutes:seconds format
$stipulatedHours = floor($stipulatedSeconds / 3600);
$stipulatedMinutes = floor(($stipulatedSeconds % 3600) / 60);
$stipulatedSeconds = $stipulatedSeconds % 60;

// Format stipulated time
$stipulatedTime = sprintf('%02d:%02d:%02d', $stipulatedHours, $stipulatedMinutes, $stipulatedSeconds);


                // Create table name based on date
                $tableName = date('FY', strtotime($date));

                // Create table if not exists
                $sql = "CREATE TABLE IF NOT EXISTS $tableName (
                            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                            user VARCHAR(255) NOT NULL,
                            date DATE NOT NULL,
                            time_in TIME NOT NULL,
                            time_out TIME NOT NULL,
                            late VARCHAR(255) NOT NULL,
                            break VARCHAR(255),
                            break_late VARCHAR(255),
                            worked_hours VARCHAR(255),
                            late_hours VARCHAR(255),
                            stipulated_time VARCHAR(255)
                        )";

                if ($conn->query($sql) === TRUE) {
                    // Insert data into the table
                    $sql = "INSERT INTO $tableName (user, date, time_in, time_out, late, break, break_late, worked_hours, late_hours,stipulated_time)
                            VALUES ('$user', '$date', '$timeIn', '$timeOut', '$late', '$break', '$breakLate', '$workedHours', '$totalLateFormatted','$stipulatedTime')";

                    if ($conn->query($sql) === FALSE) {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                    echo "Error creating table: " . $conn->error;
                }
            }

            // Close the database connection
            $conn->close();

            // Display success message
            echo "All records imported successfully.";
        } else {
            echo "Only CSV files are allowed.";
        }
    } else {
        echo "File upload error.";
    }
} else {
    echo "No file uploaded.";
}
?>
