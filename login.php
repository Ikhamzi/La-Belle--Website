<?php
// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = "contact_db";

// Connect to database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Login form submission
if (isset($_POST['submit'])) {
    $input_username = $_POST['Username'];
    $input_password = $_POST['Password'];

    // Query to retrieve admin credentials
    $query = "SELECT * FROM admin WHERE Username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['Password'];

        // Verify password
        if ($input_password === $stored_password) {
            // Login successful, redirect to contact_info.php
            header('Location: contact_info.php');
            exit;
        } else {
            $error = 'Invalid password';
        }
    } else {
        $error = 'Invalid username';
    }
}

// Display login form
?>
<style>
  /* Make the form box visually appealing and center it */
  form {
    width: 480px; /* Make the form box 480px wide */
    margin: 40px auto; /* Center the form box */
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9; /* Add a light gray background color */
    font-size: 18px; /* Increase the font size */
    text-align: center; /* Center the text */
  }

  /* Add animations to the username and password input fields */
  input[type="text"], input[type="password"] {
    width: 100%; /* Make the input fields full-width */
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s ease;
    animation: pulse 1s ease; /* Add a pulse animation to the input fields */
  }

  input[type="text"]:focus, input[type="password"]:focus {
    border-color: #aaa;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    animation: glow 1s ease; /* Add a glow animation to the focused input fields */
  }

  /* Add animation to the submit button */
  input[type="submit"] {
    background-color: #4CAF50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    animation: bounce 1s ease; /* Add a bounce animation to the submit button */
  }

  input[type="submit"]:hover {
    background-color: #3e8e41;
  }

  /* Add animation to the error message */
  .error {
    color: #red;
    animation: shake 0.5s ease;
  }

  /* Define the animations */
  @keyframes pulse {
    0% {
      transform: scale(0.9);
    }
    100% {
      transform: scale(1);
    }
  }

  @keyframes glow {
    0% {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    100% {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }
  }

  @keyframes bounce {
    0% {
      transform: translateY(0);
    }
    50% {
      transform: translateY(-10px);
    }
    100% {
      transform: translateY(0);
    }
  }

  @keyframes shake {
    0% {
      transform: translateX(0);
    }
    25% {
      transform: translateX(-5px);
    }
    50% {
      transform: translateX(5px);
    }
    75% {
      transform: translateX(-5px);
    }
    100% {
      transform: translateX(0);
    }
  }
</style>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <label for="Username">Username:</label>
  <input type="text" id="Username" name="Username"><br><br>
  <label for="Password">Password:</label>
  <input type="password" id="Password" name="Password"><br><br>
  <input type="submit" name="submit" value="Login">
  <?php if (isset($error)) { echo '<p class="error">' . $error . '</p>'; } ?>
</form>