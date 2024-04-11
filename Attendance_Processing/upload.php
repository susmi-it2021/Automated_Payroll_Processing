<?php
// Connect to the database
$link = mysqli_connect("localhost", "root", "", "attendance");
if ($link === false) {
    die("ERROR: Could not connect" . mysqli_connect_error());
}

// Query to fetch tables from the database
$sql = "SHOW TABLES FROM attendance";
$result = mysqli_query($link, $sql);

// Array to store table names with formatted 'Month Year'
$tableNames = array();

// Loop through the result set to generate table names with formatted 'Month Year'
while ($row = mysqli_fetch_array($result)) {
    $tableName = $row[0];
    // Extract month and year from the table name
    preg_match('/([a-z]+)(\d+)/i', $tableName, $matches);
    $month = ucfirst($matches[1]);
    $year = $matches[2];
    // Format the table name as 'Month Year'
    $formattedTableName = $month . ' ' . $year;
    // Add the formatted table name to the array
    $tableNames[] = array('name' => $formattedTableName, 'table' => $tableName);
}

// Sort the table names in descending order
rsort($tableNames);

// Close the database connection
mysqli_close($link);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Yellow Bag</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts - Open Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Open Sans', sans-serif;
        }
        .book-container {
            margin-top: 50px;
            padding: 20px;
        }
        .book {
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .left-page {
            flex: 1;
            background-color: #007bff;
            color: #fff;
            padding: 20px;
        }
        .right-page {
            flex: 1;
            background-color: #fff;
            color: #000;
            padding: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-upload {
            background-color: #0056b3;
            border-color: #0056b3;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .btn-upload:hover {
            background-color: #003d7a;
            border-color: #003d7a;
        }
        input[type="file"] {
            display: none;
        }
    .custom-file-label {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 8px 12px;
    cursor: pointer;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    max-width: calc(100% - 3px); /* Adjust as needed */
}

        /* Custom CSS for responsiveness */
        @media (max-width: 768px) {
            .book-container {
                margin-top: 20px;
                padding: 10px;
            }
            .book {
                flex-direction: column;
            }
            .left-page,
            .right-page {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container book-container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="book">
                    <!-- Left Page for Instructions -->
                    <div class="left-page">
                        <h2 class="text-center mb-4">Step -1 Importing with Inconsistencies</h2>
                        <ul>
                            <li>Upload attendance data once per month.</li>
                            <li>Ensure data is filtered for a single month.</li>
                            <li>Limit uploads to CSV files only.</li>
                            <li>One upload per month is sufficient.</li>
                            <li>Thank you for your cooperation!</li>
                        </ul>
                    </div>
                    <!-- Right Page for File Upload -->
                    <div class="right-page">
                        <h2 class="text-center">Upload Attendance Records</h2><br>
                        <!-- Alert Message Container -->
                        <div id="message" class="alert alert-warning alert-dismissible fade show" role="alert" style="display: none;">
                            <strong>Hey!</strong> <!-- Message will be filled dynamically -->
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- File Upload Form -->
            <form id="uploadForm" enctype="multipart/form-data">
    <div class="form-group">
        <label for="fileToUpload">&nbsp;&nbsp;Select CSV File</label><br><br>
        <!-- Display the chosen file name -->
        <div class="custom-file">
            <input type="file" class="custom-file-input" name="fileToUpload" id="fileToUpload" accept=".csv">
            <label class="custom-file-label" for="fileToUpload">Choose file</label>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-primary btn-upload">Upload File</button>
    </div>
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container book-container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="book">
                    <!-- Left Page for Instructions -->
                    <div class="left-page">
                        <h2 class="text-center mb-4">Step -2 Export and Delete the inconsistent records</h2>
                        <ul>
                            <li>Ensure break data is filtered for a single month.</li>
                            <li>Thank you for your cooperation!</li>
                        </ul>
                    </div>
                    <!-- Right Page for File Upload -->
                    <div class="right-page">
                        <h2 class="text-center">Export Attendance Records</h2><br>
                        <form id="deleteForm">
                            <?php
                            // Check if $tableNames is an array and not empty
                            if(is_array($tableNames) && !empty($tableNames)) {
                                // Loop through the sorted table names and display radio buttons
                                foreach ($tableNames as $table) {
                                    echo '<div class="form-check">';
                                    echo '<input class="form-check-input" type="radio" name="tablename" id="' . $table['table'] . '" value="' . $table['table'] . '">&nbsp;&nbsp;';
                                    echo '<label class="form-check-label" for="' . $table['table'] . '">' . $table['name'] . '</label>';
                                    echo '<br></div>';
                                }
                            } else {
                                echo "No tables found.";
                            }
                            ?>
                            <br>
                            <button type="button" id="exportBtn" class="btn btn-primary" style="background-color: orange; border-color: orange;">Export</button>
                            <button type="button" id="deleteBtn" class="btn btn-primary" style="background-color: red; border-color: red;">Delete</button>
                        </form>
            

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
// Connect to the database
$link = mysqli_connect("localhost", "root", "", "attendance");
if ($link === false) {
    die("ERROR: Could not connect" . mysqli_connect_error());
}

// Query to fetch tables from the database
$sql = "SHOW TABLES FROM attendance";
$result = mysqli_query($link, $sql);

// Array to store table names with formatted 'Month Year'
$tableNames = array();

// Loop through the result set to generate table names with formatted 'Month Year'
while ($row = mysqli_fetch_array($result)) {
    $tableName = $row[0];
    // Extract month and year from the table name
    preg_match('/([a-z]+)(\d+)/i', $tableName, $matches);
    $month = ucfirst($matches[1]);
    $year = $matches[2];
    // Format the table name as 'Month Year'
    $formattedTableName = $month . ' ' . $year;
    // Add the formatted table name to the array
    $tableNames[] = $formattedTableName;
}

// Sort the table names in descending order
rsort($tableNames);

// Close the database connection
mysqli_close($link);
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
              <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Recent Attendance Records</h4>
            </div>
            <ul class="list-group">
                <?php
                // Loop through the sorted table names and display them
                foreach ($tableNames as $tableName) {
                    echo '<li class="list-group-item">' . $tableName . '</li>';
                }
                ?>
            </ul>
			</div>
        </div>
    </div>
</div>


    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom Script -->
    <script>
        $(document).ready(function(){
            $('#uploadForm').on('submit', function(e){
                e.preventDefault(); // Prevent form submission

                var formData = new FormData($(this)[0]); // Get form data

                $.ajax({
                    url: 'import.php', // PHP script to handle file upload
                    type: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        // Display response message
                        $('#message').html('<strong>Success!</strong> ' + response).show();
                    }
                });
            });
        });
        // Update the label text with the chosen file name
        $('#fileToUpload').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $('.custom-file-label').html(fileName);
        });

    </script>
     <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#deleteBtn').click(function(){
                var tablename = $("input[name='tablename']:checked").val();
                if(tablename) {
                    if(confirm("Are you sure you want to delete the selected table?")) {
                        $.ajax({
                            type: 'POST',
                            url: 'delete.php',
                            data: { tablename: tablename },
                            success: function(response){
                                alert(response);
                                location.reload();
                            },
                            error: function(xhr, status, error) {
                                alert(xhr.responseText);
                            }
                        });
                    }
                } else {
                    alert('Please select a table to delete.');
                }
            });

            // Export button click event
            $('#exportBtn').click(function(){
                var tablename = $("input[name='tablename']:checked").val();
                if(tablename) {
                    window.location = 'export.php?tablename=' + tablename;
                } else {
                    alert('Please select a table to export.');
                }
            });
        });
    </script>
</body>
</html>
