<?php

require_once 'vendor/autoload.php';

use Kinza\User;




/*
        REGISTER FUNCTIONS
*/


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
 * write to DB if all inputs ok and not empty
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









/*

    LOG IN FUNCTIONS

*/



/*
Used when logging in, checking entered username and password against what is held in db
password verify on hashed password
returns user_id (for session) and username 
*/
function checkCredentials($username, $password) 
{
    $pdo = getDatabase();
    
    //pdo prepare, bindParam & execute
    //this is selecting the entered username from the db
    $stmt = $pdo->prepare('SELECT username, password, id FROM users WHERE username = :username');
    $stmt->bindParam(':username', $username);
      
    if (!$stmt->execute()) 
    {
        // failure - stops function if it can't execute
        return;
    }
    
    //fetch the result - will be an associative array (this is the default) with the column names as keys
    $result = $stmt->fetch();
    
    //Returns TRUE if the password and hash match, or FALSE otherwise.
    $passwordIsCorrect = password_verify($password, $result['password']);
    
    if ($passwordIsCorrect) 
    {
        $user = new User;
        $user->id = $result["id"];
        $user->username = $result["username"];
        return $user;
    }
    
    return false;
}   









/*

BLOG INPUT FUNCTIONS

*/

function titleIsEmpty($blogTitle)
{
   //empty blog title
    if (empty($blogTitle)) 
    {
        return "Please enter a title!";
        //return a string of error message
    } else {
    
        return false;
    }
}

function bodyIsEmpty($blogBody)
{
   //empty blog body
    if (empty($blogBody)) 
    {
        return "Please enter your blog!";
        //return a string of error message
    } else {
    
        return false;
    }
}



/**
 * @return array
 * 
 */

function addBlog($blogTitle, $blogBody, $userId) 
{
    if (!empty($blogTitle) && !empty($blogBody)) 
    {
        $pdo = getDatabase();
    
        //pdo prepare, bindParam & execute
        //this is inserting the submitted blog title & body into DB if not empty
        $stmt = $pdo->prepare('INSERT INTO blog (title, body, user_id ) VALUES (:title, :body, :user_id)');
        $stmt->bindParam(':title', $blogTitle);
        $stmt->bindParam(':body', $blogBody);
        $stmt->bindParam(':user_id', $userId);
        
        
        
        if ($stmt->execute()) 
        {
            // success
        } else {
            // failure
        }
    }
}



function displayBlogs($author = null) 
{
    $pdo = getDatabase();
    
    if($author === null){
        $whereClause = '';
    } else {
        $whereClause = 'WHERE username = :author';
    }
    
    
    $query = 
<<<SQL
    SELECT title, body, username AS author 
    FROM blog LEFT JOIN users ON blog.user_id = users.id
    $whereClause
    ORDER BY created_at DESC
SQL;

    //pdo prepare, bindParam & execute
    //this is selecting the blogs from the db in order of created at
    $stmt = $pdo->prepare($query);
    
    if($author !== null){
        $stmt->bindParam(':author', $author);
    }
    
      
    if (!$stmt->execute()) 
    {
        // failure - throw exception at later date maybe
        return;
    }
    
    //fetch the results - will be an associative array with the column names as keys
    //fetch all returns all the rows i.e. all the blog posts
    $result = $stmt->fetchAll();
    
    return $result;
}


function getAuthors($hasPosts = true) 
{
    $pdo = getDatabase();
    
    $query = 
<<<SQL
    SELECT distinct username AS author 
    FROM users LEFT JOIN blog ON blog.user_id = users.id
    WHERE blog.blog_id is not null
SQL;

    //pdo prepare & execute - no binding as no variables used
    //this is selecting the usernames that have blog posts from the db in order of created at
    $stmt = $pdo->prepare($query);
    
   
    if (!$stmt->execute()) 
    {
        // failure - throw exception at later date maybe
        return;
    }
    
    //fetch the results - will be an associative array with the column names as keys
    //fetch all returns all the rows i.e. all the usernames that have blog posts
    $result = $stmt->fetchAll();
    
    return $result;
    
    
}



/*

    TV FUNCTIONS

*/


   

function addShow($title, $genre, $season, $platform, $notes) {
    
    
    
    
    if (!empty($title) && !empty($genre) && !empty($season) && !empty($platform)) 
    {
        $pdo = getDatabase();
    
        //pdo prepare, bindParam & execute
        //this is inserting the submitted title, season, genre, platform & notes into the tv DB
        $stmt = $pdo->prepare('INSERT INTO tv (title, season, genre, platform, notes) VALUES (:title, :season, :genre, :platform, :notes)');
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':season', $season);
        $stmt->bindParam(':platform', $platform);
        $stmt->bindParam(':notes', $notes);
        
        
        if ($stmt->execute()) 
        {
            // success
        } else {
            // failure
        }
    }
}



/*

GENERAL FUNCTIONS

*/

//this is the stuff needed to get Twig
function getTwig()
{
   $loader = new Twig_Loader_Filesystem(__DIR__ . '/view');
   $twig = new Twig_Environment($loader, [
    //'cache' => __DIR__ . '/cache',
    ]);
    
    return $twig;
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

