<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "rollcall";
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) { http_response_code(500); echo "DB connect error"; exit; }

    $data = json_decode(file_get_contents('php://input'), true);
    $nama = $conn->real_escape_string($data['nama'] ?? '');
    $status = $conn->real_escape_string($data['status'] ?? '');
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $masa = date("H:i:s");
    $tarikh = date("d.m.Y");
    $image = $data['image'] ?? '';

    if (!$nama || !$status || !$image) {
        http_response_code(400);
        echo "Missing fields";
        exit;
    }

    $parts = explode(',', $image);
    $image_binary = base64_decode($parts[count($parts)-1]);

    $stmt = $conn->prepare("INSERT INTO checkliststaf (namaStaf, status, masa, tarikh, photo) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) { echo "Prepare failed: " . $conn->error; exit; }
    $null = NULL;
    $stmt->bind_param("ssssb", $nama, $status, $masa, $tarikh, $null);
    $stmt->send_long_data(4, $image_binary);
    $ok = $stmt->execute();
    $stmt->close();
    if ($ok) {
        echo "Attendance has been filled.";
    } else {
        http_response_code(500);
        echo "Insert error: " . $conn->error;
    }
    $conn->close();
?>