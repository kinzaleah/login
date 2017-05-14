<?php

include 'functions.php';

//run the functions if someone posts - validateInput first then if all ok registerUSer

if($_SERVER['REQUEST_METHOD']== "POST")
{
    if(validateInput($_POST['username'], $_POST['password'], $_POST['email'])) 
    {
        
        //hash the password & pass the new var into registerUser
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        //convert username to lowercase before adding to db
        $lowerUsername = strtolower($_POST['username']);
        
        
        //IF username doesn't already exist then it can all be written to db
        if(!usernameExists($lowerUsername)) 
        {
            
        
        
        registerUser($lowerUsername, $passwordHash, $_POST['email']);
        }
    }
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>My first PHP Website</title>
    </head>

    <body>
      <h2>Registration Page</h2>

      <a href ="index.php">Click here to go back</a>

      <form action="register.php" method="POST">
        <p>Username: <input type="text" name="username" required /></p>
        <p>Password: <input type="password" name="password" required /></p>
        <p>Min 8 characters. Must contain one number, and one upper and lower case letter.</p>
        <p>Email: <input type="email" name="email" required /></p>
        <p><input type="submit" value="Register" /></p>
      </form>
    </body>
</html>
