<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "rollcall";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $reason = $_POST['reason'];


    // Insert data into database
    $sql = "INSERT INTO feedback (email, reason)
    VALUES ('$email', '$reason')";

    if ($conn->query($sql) === TRUE) {

        echo "<script>alert('Thank you for your feedback');</script>";

        echo "<script>window.setTimeout(function(){ window.location.href = 'support.html'; }, 1000);</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>