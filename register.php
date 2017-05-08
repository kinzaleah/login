<?php

function validateInput($username, $password, $email) 
{
    //empty username
    if (empty($username)) 
    {
        $usernameErr = "Please enter a Username!";
        echo $usernameErr;
        return false;
    }
        //empty email
    if (empty($email)) 
    {
        $emailErr = "Please enter an email!";
        echo $emailErr;
        return false;
    }
        
    //regex for checking it contains lowercase, uppercase, a number & min 8 chars
    //if it doesn't then it displays an error
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/', $password))
    {
        echo 'Please enter a valid password';
        return false;
    } 
    
    return true;
}

function getDatabase() {
    //pdo connection stuff in its own function
        $host = getenv('IP') . ':3306';
        $db   = 'c9';
        $user = getenv('C9_USER');
        $pass = '';
        $charset = 'utf8';
    
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    
        //i'm not entirely sure what this is
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        return new PDO($dsn, $user, $pass, $opt);
}

//separate code into different function for it to write to DB if all ok and not empty

function registerUser($username, $passwordHash, $email) 
{
    if (!empty($username) && !empty($passwordHash) && !empty($email)) 
    {
        $pdo = getDatabase();
    
        //pdo prepare, bindParam & execute
        //this is inserting the submitted username, password & email into the login DB
        $stmt = $pdo->prepare('INSERT INTO users (username, password, email) VALUES (:username, :password, :email)');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':email', $email);
        
        
        if ($stmt->execute()) {
            // success
        } else {
            // failure
        }
    }
}

//run the functions if someone posts - validateInput first then if all ok registerUSer

if($_SERVER['REQUEST_METHOD']== "POST")
{
    if(validateInput($_POST['username'], $_POST['password'], $_POST['email'])) 
    {
        $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
        registerUser($_POST['username'], $passwordHash, $_POST['email']);
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
        <p>Email: <input type="email" name="email" required /></p>
        <p><input type="submit" value="Register" /></p>
      </form>
    </body>
</html>
