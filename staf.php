<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kehadiran Pelajar</title>
    <link rel="stylesheet" href="dataKehadiran.css">

      <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  
  </head>
  <body>
    <div class="navTop">
        <img src="./img/logo/logo1.png" width="30px" height="30px" alt="">
        <ul class="navList">
          <li><a href="index.html">Home</a></li>
          <li><a href="aboutUs.html">About Us</a></li>
          <li><a href="support.html">Support</a></li>
        </ul>
        <span class="admin" onclick="location.href='admin.html';" style="cursor: pointer;">Admin</span>
    </div>
    <h2>Staf</h2>
    <table>
        <tr>
          <th colspan="6" class="title" >Data Kehadiran</th>
        </tr>
        <tr>
            <th>No.</th>
            <th>Nama Staf</th>
            <th>Status</th>
            <th>Masa</th>
            <th>Tarikh</th>
            <th>Gambar</th>
        </tr>

      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "rollcall";

      // Create connection
      $conn = new mysqli($servername, $username, $password, $dbname);


      
      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }


      
      $sql = "SELECT namaStaf, status, masa, tarikh, photo FROM checkliststaf";
      $result = $conn->query($sql);

      $serialNumber = 1;

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $serialNumber . "</td>";
              echo "<td>" . $row["namaStaf"] . "</td>";
              echo "<td>" . $row["status"] . "</td>";
              echo "<td>" . $row["masa"] . "</td>";
              echo "<td>" . $row["tarikh"] . "</td>";
              echo "<td><img src='data:image/png;base64," . base64_encode($row['photo']) . "' width='130' height='100' /></td>";
              echo "</tr>";
              $serialNumber++;
          }
      } else {
          echo "<tr><td colspan='8'>No data found</td></tr>";
      }

      $conn->close();
      ?>
    </table>
  </body>
</html>