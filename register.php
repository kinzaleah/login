<?php




function registerUser($username, $password, $email) {


  //empty username
   if (empty($username)) {
      $usernameErr = "Please enter a Username!";
      echo $usernameErr;
   }


  //empty password
   if (empty($password)) {
      $passwordErr = "Please enter a password!";
      echo $passwordErr;
   }

   //empty email
    if (empty($email)) {
       $emailErr = "Please enter an email!";
       echo $emailErr;
    }


  //filter_var here for email address VALIDATION

  // Remove all illegal characters from email
  //$email = filter_var($email, FILTER_SANITIZE_EMAIL);

  // Validate e-mail
  // if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
  //     echo("$email is a valid email address");
  // } else {
  //     echo("$email is not a valid email address");
  // }



  //regex for checking it contains lowercase, uppercase, a number & min 8 chars
  if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/', $password))
  {
    echo 'Please enter a valid password';

  } else {

    //pdo connection stuff
    $host = 'localhost:3306';
    $db   = 'login';
    $user = 'root';
    $pass = 'root';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    //i'm not entirely sure what this is
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);

    //pdo prepare, bindParam & execute
    //this is inserting the submitted username and password into the login DB
    //only if it's a valid password
    $stmt = $pdo->prepare('INSERT INTO users (username, password, email) VALUES (:username, :password, :email)');
    $stmt->bindParam(':username',$username);
    $stmt->bindParam(':password',$password);
    $stmt->bindParam(':email',$email);
    $stmt->execute();

  }

}

if($_SERVER['REQUEST_METHOD']== "POST")

  {
    registerUser($_POST['username'], $_POST['password'], $_POST['email']);
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
