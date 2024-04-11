<?php

$link = mysqli_connect("localhost", "root", "", "yellowbag");

if ($link == false) {
    die("ERROR: COULD NOT CONNECT" . mysqli_connect_error());
}

$user = mysqli_real_escape_string($link, $_REQUEST['user']);
$password = mysqli_real_escape_string($link, $_REQUEST['pass']);

$sql = "SELECT * FROM admin WHERE user = '$user' AND password = '$password'";
$result = mysqli_query($link, $sql);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
        // Username and password exist, redirect to dashbord.html
        header("Location: dashboard.html");
        exit();
    } else {
        // No matching user and password, show alert and redirect to index.html
        echo "<script>alert('Access Denied!');";
        echo "window.location.href = 'index.html';</script>";
        exit();
    }
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($link);
}

mysqli_close($link);
?>
