<?php
// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'attendance';

// Create database connection
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = ""; // Initialize message variable

// Check if file is uploaded
if (isset($_FILES['fileToUpload'])) {
    $filename = $_FILES['fileToUpload']['name'];
    $fileTmpName = $_FILES['fileToUpload']['tmp_name'];

    // Open the file in read mode
    if (($handle = fopen($fileTmpName, "r")) !== FALSE) {
        $firstRowSkipped = false; // Flag to skip the first row
        $dataByUserDate = array(); // Store data by user and date
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (!$firstRowSkipped) {
                $firstRowSkipped = true;
                continue; // Skip the first row (headers)
            }

            // Check if User, Date, and Time are not empty
            if (!empty($data[0]) && !empty($data[3]) && !empty($data[4])) {
                $user = ltrim($data[0], "'\\");
                $dateDMY = $data[3];
                $dateParts = explode("-", $dateDMY);
                if (count($dateParts) == 3) {
                    $dateYMD = $dateParts[2] . "-" . $dateParts[1] . "-" . $dateParts[0];
                } else {
                    continue; // Invalid date format, skip this row or handle error
                }

                $time = $data[4];

                // Store data by user and date
                $dataByUserDate["$user|$dateYMD"][] = $time;
            }
        }
        fclose($handle);

        // Process and insert data into the database
        foreach ($dataByUserDate as $userDate => $times) {
            list($user, $dateYMD) = explode("|", $userDate);
            sort($times); // Sort times chronologically
            $timeIn = $times[0]; // Minimum time (in)
            $timeOut = end($times); // Maximum time (out)
            $breakTimes = array_slice($times, 1, -1); // All times except the first and last (break times)
            $breakTimesStr = implode(",", $breakTimes);

            // Calculate total late time in seconds
            $normalTimeIn = strtotime('10:00:00');
            $normalTimeOut = strtotime('19:00:00');
            $timeInTimestamp = strtotime($timeIn);
            $timeOutTimestamp = strtotime($timeOut);
            $lateIn = max(0, $timeInTimestamp - $normalTimeIn);
            $lateOut = max(0, $normalTimeOut - $timeOutTimestamp);
            $totalLate = $lateIn + $lateOut;

            // Calculate total late time in hours and minutes
            $totalLateHours = floor($totalLate / 3600); // 3600 seconds in an hour
            $totalLateMinutes = floor(($totalLate % 3600) / 60); // Remaining seconds converted to minutes

            // Format total late time
            $late = $totalLateHours . "hr " . $totalLateMinutes . "min";

            // Insert data into the corresponding table
            $yearMonth = date('F', strtotime($dateYMD)) . date('Y', strtotime($dateYMD)); // Format month and year
            $tableName = strtolower($yearMonth); // Lowercase table name
            $createTableSQL = "CREATE TABLE IF NOT EXISTS $tableName (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user VARCHAR(255) NOT NULL,
                date DATE NOT NULL,
                time_in TIME NOT NULL,
                time_out TIME NOT NULL,
                late VARCHAR(30),
                break TEXT
            )";
            $conn->query($createTableSQL);

            $insertSQL = "INSERT INTO $tableName (user, date, time_in, time_out, late, break) VALUES ('$user', '$dateYMD', '$timeIn', '$timeOut', '$late', '$breakTimesStr')";
            if (!$conn->query($insertSQL)) {
                $message .= "Error: " . $insertSQL . "<br>" . $conn->error . "<br>";
            }
        }
        $message .= "Attendance data has been imported!";
    } else {
        $message .= "Error opening uploaded file.";
    }
} else {
    $message .= "No file uploaded.";
}

// Close the database connection
$conn->close();

// Return message
echo $message;
?>
