<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "rollcall";
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form values
$email = $_POST['email'];
$password = $_POST['password'];

// Authenticate user
$sql = "SELECT password FROM admin WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        echo "Login successful. Welcome!";
        header("Location: index.html");
        exit();
    } else {
        echo "Invalid email or password.";
    }
} else {
    echo "Invalid email or password.";
}

$conn->close();
?>
