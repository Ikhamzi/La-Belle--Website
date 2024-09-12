<?php
// Get data from
$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["message"];

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
else{
  // Insert data into database
  $stmt = $conn->prepare("INSERT INTO contact_info (name, email, message) VALUES (?,?,?)");
  $stmt->bind_param("sss", $name, $email, $message);
  $stmt->execute();
  
  // Display a success message in a popup window
  echo "<script>
        alert('Enquiry Registration Successfully!');
        window.location.href = 'wedding planner.html'; // redirect to start page
    </script>";
  exit;
  
  $stmt->close();
  $conn->close();
}
?>