<?php
// Start a session
session_start();

include 'validation.php';

// define variables and set to empty values
$email = $password = "";
$emailErr = $passwordErr = "";

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

    // Check is the user details passes validation
    if ($email && $password)
    {
        $fileName = 'database/' . $email . ".json";

        // Checks if the user exists
        if (!file_exists($fileName)){
            echo "<h3>User doesn't exist!!<h3>";
        } else {
            //Opens the user file
            $myFile = fopen($fileName, "r") or die("Unable to open file!");
            $userData = fread($myFile, filesize($fileName));
            $userArray = json_decode($userData, true);
            fclose($myFile);

            // Check if the input password matches the user password
            if ($password == $userArray['password']){
                $_SESSION['isLogged'] = "1";
                $_SESSION['email'] = $email;
                
                if (isset($_SESSION['email'])){
                    header("Location:home.php");
                }
            } else {
                echo "<h3><p>Password doesn't match!<h3>";
            }
        }         
    }       
}
?>

<html>
    <body>
    <h1>Welcome <?php $firstname ?> </h1>
    <p><h4>Please sign in here </h4></p>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" >
    Email:  <input type="email" name="email"  id="email" placeholder="Email"><?php echo $emailErr;?><br/><br/>
    Password:  <input type="password" name="password"  id="password" placeholder="Password"> <?php echo $passwordErr;?><br/>      
    <button type="submit" name="submitted">Sign in</button><br><br>
       </form>  
       <p>Don't have an account? <a href="index.php">Register</a></p>
        <p>Forgot your password? <a href="reset.php">Reset Password</a></p>                     
    </body>  
</html>