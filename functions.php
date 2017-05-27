<?php

require_once 'vendor/autoload.php';

/**
 * validation of registration information
 * @return bool
 */
// function validateInput($username, $password, $email) 
// {
//     //empty username
//     if (empty($username)) 
//     {
//         return "Please enter a Username!";
//         //return a string of error message
        
//     }
    
//     //empty email
//     if (empty($email)) 
//     {
//         return "Please enter an email!";
//         //return a string of error message
        
//     }
        
//     //regex for checking it contains lowercase, uppercase, a number & min 8 chars
//     //if it doesn't then it displays an error
//     if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/', $password))
//     {
//         return 'Please enter a valid password';
//         //return a string of error message
//     } 
    
//     return true;
// }


function usernameIsValid($username)
{
   //empty username
    if (empty($username)) 
    {
        return "Please enter a username!";
        
        //return a string of error message
    } else {
    
        return true;
    }
}

function emailIsValid($email)
{
   //empty email
    if (empty($email)) 
    {
        return "Please enter an email!";
        //return a string of error message
    } else {
    
        return true;
    }
}

function passwordIsValid($password)
{
   //regex for checking it contains lowercase, uppercase, a number & min 8 chars
   //if it doesn't then it displays an error
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/', $password))
    {
        return 'Please enter a valid password!';
        //return a string of error message
    } else {
    
        return true;
    }
}

/**
 * PDO connection for database
 * @return PDO
 */
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



/**
 * check if username already exists in db - use $lowerUsername var
 */
function usernameExists($lowerUsername) 
{
    
    //need to set up the pdo connection again
    $pdo = getDatabase();
   
    //preparing stmt here that selects number of rows (count(id)) where the 
    //username is equal to the lowerUsername var (done with binding to avoid
    //sql injection).
    $stmt = $pdo->prepare('SELECT count(id) AS userExists FROM users WHERE username = :username');
    $stmt->bindParam(':username', $lowerUsername);
    
   // when pdo stmt is executed I fetch the result of the SQL query
   // this should be either 1 or 0 because username column is set to unique in db
   // I then convert this to a boolean so it returns true (if 1) or false (if 0)
   // If true and username does exist already then I echo error code
   // I need to then return the $userExists variable
    if ($stmt->execute()) {
        // success
       $userExists = (bool) $stmt->fetch()['userExists'];
       
       return $userExists;
       
    } else {
        // failure - throw an exception?
    }
}



/**
 * write to DB if all ok and not empty
 */
function registerUser($lowerUsername, $passwordHash, $email) 
{
    if (!empty($lowerUsername) && !empty($passwordHash) && !empty($email)) 
    {
        $pdo = getDatabase();
    
        //pdo prepare, bindParam & execute
        //this is inserting the submitted username, password & email into the login DB
        $stmt = $pdo->prepare('INSERT INTO users (username, password, email) VALUES (:username, :password, :email)');
        $stmt->bindParam(':username', $lowerUsername);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':email', $email);
        
        
        if ($stmt->execute()) 
        {
            // success
        } else {
            // failure
        }
    }
}



function checkCredentials($username, $password) 
{
    $pdo = getDatabase();
    
    //pdo prepare, bindParam & execute
    //this is selecting the entered username from the db
    $stmt = $pdo->prepare('SELECT username, password FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
      
    if (!$stmt->execute()) 
    {
        // failure - throw exception?
        return;
    }
    
    //fetch the result
    $result = $stmt->fetch();
    
    //Returns TRUE if the password and hash match, or FALSE otherwise.
    return password_verify($password, $result['password']);
}    


//this is the stuff needed to get Twig
function getTwig()
{
   $loader = new Twig_Loader_Filesystem(__DIR__ . '/view');
   $twig = new Twig_Environment($loader, [
    //'cache' => __DIR__ . '/cache',
    ]);
    
    return $twig;
}
