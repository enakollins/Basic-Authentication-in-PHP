<?php
    include 'validation.php';

    // define variables and set to empty values
    $email = $password = $confirmpassword = '';
    $emailErr = $passwordErr = $confirmpasswordErr ='';


    if (isset($_POST['submitted']))
    {
        $email = test_input($_POST["email"]);

        if (empty($_POST["email"])) {
            $emailErr = "* Email is required";
        } else {
        $email = test_input($_POST["email"]);
        }
        
        if (empty($_POST["password"])) {
        $passwordErr = "* Password is required";
        } else {
        $password = test_input($_POST["password"]);
        }

        if (empty($_POST["confirmpassword"])) {
            $confirmpasswordErr = "* Password confirmation is required";
        } else {
            $confirmpassword = test_input($_POST["confirmpassword"]);
        }
        /* if ($password !== $confirmpassword){
           echo "Passwords did not match"; 
        } else{
            echo "well done";
            exit();
        } */

        // Check is the user details passes validation
        if ($email && $password ) {
            $fileName = 'database/' . $email . ".json";

            // Checks if the user exists
            if (!file_exists($fileName)){
                echo "User doesn't exist";
            } else {
                //Opens the user file
                $myFile = fopen($fileName, "r+") or die("Unable to open file!");
                $userData = fread($myFile, filesize($fileName));
                $userArray = json_decode($userData, true);
                $newUserData = [
                    'firstName' => strtolower($userArray['firstName']),
                    'lastName' => strtolower($userArray['lastName']),
                    'username' => strtolower($userArray['username']),
                    'email' => strtolower($userArray['email']),
                    'password' => $password
                ];
                fclose($myFile);

                file_put_contents('database/' . $newUserData['email'] . ".json", json_encode($newUserData));

                echo "Password changed successfully"; 
            }
        }
    }
?>

<html>
    <body>
        <h2>Password Reset</h2>
        <p><a href="index.php">Home</a></p>
       <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>" method="POST" >
        Email<input type="email" name="email" id="email" > <?php echo $emailErr;?><br/><br/>
        New password: <input type="password" name="password" id="password" ><?php echo $passwordErr;?><br/><br/>
        <!-- Confirm password: <input type="password" name="confirm password" id="password" > <?php echo $confirmpasswordErr;?><br/><br/> -->
      <button type="submit" class="btn btn-danger" name="submitted">Reset</button>
      </form>
      <p>Don't have an account? <a href="index.php">Register</a></p>
       </body>
</html>