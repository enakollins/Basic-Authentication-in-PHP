<?php
    session_start();
    if (! isset($_SESSION['isLogged']) || "1" != $_SESSION['isLogged']){
        header('Location:login.php');
    }
    if($_SESSION['email']) {
      echo "Welcome " . $_SESSION['email'];
    }
?>  

<!doctype html>
    <html >
    <head>
      <title>Home Page</title>  
    </head>
    <body>
        <form action="<?php echo htmlspecialchars("logout.php");?>" method="POST">
        <button type="submit"  name="signout">Sign out</button>
        </form>
                            
    </body>
    </html>`
