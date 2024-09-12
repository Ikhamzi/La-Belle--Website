<?php

// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contact_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: ". $conn->connect_error);
}

// Create a date column in the contact_info table if it doesn't exist
$sql = "ALTER TABLE contact_info ADD COLUMN date TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$conn->query($sql);

// Retrieve data from database
$sql = "SELECT * FROM contact_info";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
 ?>
  <html>
  <head>
    <title>Contact Information</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0; /* light gray background */
      }
     .container {
        max-width: 800px;
        margin: 40px auto; /* center the container */
        padding: 20px;
        background-color: #fff; /* white background */
        border: 1px solid #ddd; /* light gray border */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* subtle shadow */
      }
      table {
        width: 100%;
        border-collapse: collapse;
      }
      th, td {
        border: 1px solid #ddd; /* light gray border */
        padding: 10px;
        text-align: left;
      }
      th {
        background-color: #333; /* dark gray background */
        color: #fff; /* white text */
      }
      td {
        background-color: #f9f9f9; /* light gray background */
      }
     .header {
        font-size: 24px;
        font-weight: bold;
        color: #333; /* dark gray text */
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h2 class="header">Contact Information</h2>
      <table>
        <tr>
          <th>S.No</th>
          <th>Date</th>
          <th>Name</th>
          <th>Email</th>
          <th>Message</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) {?>
        <tr>
          <td><?php echo $row["Id"];?></td>
          <td><?php echo $row["Date"];?></td>
          <td><?php echo $row["Name"];?></td>
          <td><?php echo $row["Email"];?></td>
          <td><?php echo $row["Message"];?></td>
        </tr>
        <?php }?>
      </table>
    </div>
  </body>
  </html>
  <?php
} else {
  echo "<p>0 results</p>";
}
$conn->close();
?>