<?php
include 'validation.php';

// define variables and set to empty values
$firstName = $lastName =$username = $email = $password = "";
$firstNameErr = $lastNameErr =$usernameErr = $emailErr = $passwordErr = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $email = test_input($_POST["email"]);
  
  if (empty($_POST["firstName"])) {
    $firstNameErr = "* First name is required";
  } elseif (!preg_match("/^[a-zA-Z ]*$/", $firstName)) {
    $firstNameErr = "Only letters and white space allowed";
  }
  else {
    $firstName = test_input($_POST["firstName"]);
  }

  if (empty($_POST["lastName"])) {
    $lastNameErr = "* Last name is required";
  } elseif (!preg_match("/^[a-zA-Z ]*$/", $lastName)) {
    $lastNameErr = "Only letters and white space allowed";
  }
  else {
    $lastName = test_input($_POST["lastName"]);
  }
  if (empty($_POST["username"])) {
    $usernameErr = "* Last name is required";
  } elseif (!preg_match("/^[a-zA-Z ]*$/", $username)) {
    $usernameErr = "Only letters and white space allowed";
  }
  else {
    $username = test_input($_POST["username"]);
  }
  if (empty($_POST["email"])) {
    $emailErr = "* Email is required";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailErr = "Invalid email format";
  }
  else {
    $email = test_input($_POST["email"]);
  }
  if (empty($_POST["password"])) {
    $passwordErr = "* Password is required";
  } else {
    $password = test_input($_POST["password"]);
  }

  // Check if validation is passed and user doesn't exist
  if ($firstName && $lastName && $username && $email && $password){
    if(!file_exists('database/' . $firstName . $lastName)){

      $firstName = strtolower($_POST['firstName']);
      $lastName = strtolower($_POST['lastName']);
      $username = strtolower($_POST['username']);
      $email = strtolower($_POST['email']);
      $password = $_POST['password'];

      $arrayData = [
          'firstName' => $firstName,
          'lastName' => $lastName,
          'username' => $username,
          'email' => $email,
          'password' => $password,
      ];

      file_put_contents('database/' . $arrayData['email'] . ".json", json_encode($arrayData));

      echo "Congratulations $firstName!, your account has been created successfully";
      
    } else {
      echo "<h3>Sorry, the username/ email address is already in use<h3>";
    }
  }
}
?>
<!DOCTYPE html>
<html>
  <body>
<p> <h1>Registration Form</h1></p> 
  <a href="index.php" role="button" class="btn btn-info">Home</a>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
  First name:  <input type="text" id="firstName" name="firstName" placeholder="First name"><?php echo $firstNameErr;?><br/><br/>
  Last name:  <input type="text"  id="lastName" name="lastName" placeholder="Last name"> <?php echo $lastNameErr;?><br/><br/> 
  Username: <input type="text"  id="username" name="username" placeholder="username"> <?php echo $usernameErr;?><br/><br/> 
  Email address:    <input type="email" id="email" name="email" placeholder="Email"> <?php echo $emailErr;?><br/><br/>
  Password:<input type="password"  id="password" name="password" placeholder="Password"><?php echo $passwordErr;?><br/><br/>
  <button type="submit" name="submit" class="btn btn-primary">Submit</button>
  </form>
  <p>Already have an account? <a href="login.php">Login</a></p>
        <p>Forgot your password? <a href="reset.php">Reset Password</a></p>
  </body>
</html>