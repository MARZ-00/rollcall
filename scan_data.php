<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "rollcall";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $data = json_decode(file_get_contents('php://input'), true);
    $nama = $conn->real_escape_string($data['nama'] ?? '');
    $status = $conn->real_escape_string($data['status'] ?? '');
    $kelas = $conn->real_escape_string($data['kelas'] ?? '');
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $masa = date("H:i:s");
    $tarikh = date("d.m.Y");
    $image = $data['image'] ?? '';

    $nama = $_POST['nama'];
    $status = $_POST['status'];
    $kelas = $_POST['kelas'];
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $masa = date("H:i:s");
    $tarikh = date("d.m.Y");

    //insert data into database
    if (!empty($kelas)) {
    // Student
    $parts = explode(',', $image);
    $image_binary = base64_decode($parts[count($parts)-1]);

    $stmt = $conn->prepare("INSERT INTO checklistpelajar (namaPelajar, status, kelas, masa, tarikh, photo) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) { echo "Prepare failed: " . $conn->error; exit; }
    $null = NULL;
    $stmt->bind_param("sssssb", $nama, $status, $kelas, $masa, $tarikh, $null);
    $stmt->send_long_data(5, $image_binary);
    $ok = $stmt->execute();


    } else {
    // Staff
    $parts = explode(',', $image);
    $image_binary = base64_decode($parts[count($parts)-1]);

    $stmt = $conn->prepare("INSERT INTO checkliststaf (namaStaf, status, masa, tarikh, photo) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) { echo "Prepare failed: " . $conn->error; exit; }
    $null = NULL;
    $stmt->bind_param("ssssb", $nama, $status, $masa, $tarikh, $null);
    $stmt->send_long_data(4, $image_binary);
    $ok = $stmt->execute();
    $stmt->close();
    }   

    if ($ok) {

        echo "<script>alert('Attendance have been filled');</script>";

        echo "<script>window.setTimeout(function(){ window.location.href = 'index.html'; }, 1000);</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>