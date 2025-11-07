<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
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
          <th colspan="5" class="title" >Checklist</th>
        </tr>
        <tr>
            <th>No.</th>
            <th>Email</th>
            <th>Reason</th>
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

      $sql = "SELECT email, reason FROM feedback";
      $result = $conn->query($sql);

      $serialNumber = 1;

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $serialNumber . "</td>";
              echo "<td>" . $row["email"] . "</td>";
              echo "<td>" . $row["reason"] . "</td>";

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