<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>YellowBag - Attendance</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts - Open Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../yellowbagside-svg.svg" />
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Open Sans', sans-serif;
        }
        .book-container {
            margin-top: 50px;
            padding:20px;
        }
        .book {
            display: flex;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
        .btn-search {
            background-color: #0056b3;
            border-color: #0056b3;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .btn-search:hover {
            background-color: #003d7a;
            border-color: #003d7a;
        }
        .list-group-item {
            cursor: pointer;
        }
        .list-group-item.active {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container book-container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="book">
                    <!-- Right Page for Search Form and Results -->
                    <div class="right-page">
                        <h2 class="text-center">Step -3 Inconsistency Spotlight</h2><br><center>
                        <p>Solve the inconsistency by refering the ID displayed in the exported file.</p></center><br>
                        <div id="message" class="alert alert-warning alert-dismissible fade show" role="alert" style="display: none;">
                            <strong>Hey!</strong> <!-- Message will be filled dynamically -->
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Search Form -->
                        <form id="searchForm">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="month">Month</label>
                                        <input list="months" class="form-control" name="month" id="month" placeholder="Enter month (e.g., january)">
                                        <datalist id="months">
                                            <option value="January">
                                            <option value="February">
                                            <option value="March">
                                            <option value="April">
                                            <option value="May">
                                            <option value="June">
                                            <option value="July">
                                            <option value="August">
                                            <option value="September">
                                            <option value="October">
                                            <option value="November">
                                            <option value="December">
                                        </datalist>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="year">Year</label>
                                        <input type="text" class="form-control" name="year" id="year" placeholder="Enter year (e.g., 2024)">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-primary btn-search" id="searchButton">Search</button>
                            </div>
                        </form>
                        <!-- Table to Display Attendance Data -->
                        <div id="attendanceTable"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
       $(document).ready(function(){
    // Function to fetch and display the table based on selected month and year
    $("#searchButton").click(function(){
        var month = $("#month").val(); // Get the value of the month input field
        var year = $("#year").val(); // Get the value of the year input field
        var formData = { month: month, year: year }; // Prepare data to be sent in AJAX request

        // AJAX request to fetch table data
        $.ajax({
            url: "display.php", // Change this URL to the PHP script that fetches the table data
            type: "POST",
            data: formData, // Send the month and year parameters
            success: function(data){
                $("#attendanceTable").html(data);
            },
            error: function(xhr, status, error){
                console.error(xhr.responseText);
                $("#message").html("Error: " + xhr.responseText).show();
            }
        });
    });
});

    </script>
</body>
</html>
